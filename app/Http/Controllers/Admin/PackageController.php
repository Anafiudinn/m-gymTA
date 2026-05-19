<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\WhatsappMessage;
use App\Helpers\WhatsappFormat; // Panggil helper barumu di sini
use App\Models\Membership;
use App\Models\PtMembership;
use App\Models\PtPackage;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $tab = $request->tab ?? 'aktivasi';
        $hasMonthlyPackage = false;

        if ($request->filled('search')) {
            // Bersihkan query pencarian jika kasir mengetik nomor WA dengan format berantakan
            $searchKey = WhatsappFormat::formatNumber($request->search) ?? $request->search;

            $user = User::where('whatsapp', $searchKey)
                ->orWhere('member_code', $request->search)
                ->first();

            if (! $user) {
                return redirect()->route('admin.package.index', ['tab' => $tab])
                    ->with('error', 'Data member "'.$request->search.'" tidak ditemukan!');
            }

            $hasMonthlyPackage = Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->exists();
        }

        $bulananMember = Setting::where('key', 'bulanan_member')->value('value') ?? 110000;
        $bulananTamu = Setting::where('key', 'bulanan_tamu')->value('value') ?? 200000;
        $ptPackages = PtPackage::all();

        $transactions = Transaction::with(['user', 'admin'])
            ->whereIn('category', ['activation', 'monthly', 'pt'])
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        $totalToday = $transactions->sum('amount');

        return view('admin.package.index', compact(
            'user', 'tab', 'bulananMember', 'bulananTamu',
            'ptPackages', 'transactions', 'totalToday', 'hasMonthlyPackage'
        ));
    }

    public function activateMember(Request $request)
    {
      $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => [
                'required',
                'string',
                'max:30',
                function ($attribute, $value, $fail) {
                    // Bersihkan nomor terlebih dahulu untuk tes isi aslinya
                    $cleaned = preg_replace('/[^0-9]/', '', $value);
                    
                    // Cek apakah polanya valid diawali 08, 628, atau 8
                    if (!preg_match('/^(08|628|8)\d{7,13}$/', $cleaned)) {
                        $fail('Nomor WhatsApp yang dimasukkan tidak valid untuk operator Indonesia (harus diawali 08, 628, atau 8).');
                    }
                },
            ],
            'payment_method' => 'required|in:cash,transfer',
        ]);

        try {
            $isNewUser = false;
            $user = null;

            // Bersihkan nomor WhatsApp dari spasi, strip, +62 sebelum masuk logika DB
            $cleanWhatsapp = WhatsappFormat::formatNumber($request->whatsapp);

            if (!$cleanWhatsapp) {
                throw new \Exception('Format nomor WhatsApp tidak valid atau kosong.');
            }

            DB::transaction(function () use ($request, $cleanWhatsapp, &$user, &$isNewUser) {
                $existingUser = User::where('whatsapp', $cleanWhatsapp)->first();

                if ($existingUser) {
                    if ($existingUser->is_active_member) {
                        throw new \Exception('User ini sudah menjadi member aktif!');
                    }
                    $existingUser->update(['is_active_member' => true]);
                    $user = $existingUser;
                } else {
                    $isNewUser = true;
                    do {
                        $memberCode = 'GYM-'.strtoupper(Str::random(5));
                    } while (User::where('member_code', $memberCode)->exists());

                    $user = User::create([
                        'name' => $request->name,
                        'whatsapp' => $cleanWhatsapp, // Simpan dalam kondisi rapi (contoh: 62882...)
                        'password' => bcrypt('12345678'),
                        'role' => 'member',
                        'is_active_member' => true,
                        'member_code' => $memberCode,
                    ]);
                }

                Transaction::create([
                    'invoice_code' => 'ACT-'.strtoupper(Str::random(8)),
                    'user_id' => $user->id,
                    'admin_id' => auth()->id(),
                    'category' => 'activation',
                    'amount' => 80000,
                    'payment_method' => $request->payment_method,
                    'status' => 'success',
                    'source' => 'onsite',
                ]);
            });

            // Kirim pesan WA sesuai kondisi (User baru vs Aktivasi ulang)
            if ($isNewUser) {
                $waMessage = WhatsappMessage::newMemberAccount($user);
            } else {
                $waMessage = WhatsappMessage::activation($user);
            }

            // Pastikan menggunakan nomor terformat untuk pengiriman API Fonnte
            FonnteService::send($user->whatsapp, $waMessage);

            return redirect()->route('admin.package.index', ['tab' => 'aktivasi'])
                ->with('success', $user->name.' berhasil diaktivasi menjadi member!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function buyPackage(Request $request)
    {
        try {
            $isNewUser = false;
            $user = null;
            $packageName = '';
            $latestMembership = null;

            // 1. PROSES VALIDASI INPUT
            if ($request->filled('user_id')) {
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'payment_method' => 'required|in:cash,transfer',
                ]);
            } else {
               $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_whatsapp' => [
                    'required',
                    'string',
                    'max:30',
                    function ($attribute, $value, $fail) {
                        $cleaned = preg_replace('/[^0-9]/', '', $value);
                        if (!preg_match('/^(08|628|8)\d{7,13}$/', $cleaned)) {
                            $fail('Nomor WhatsApp tamu tidak valid untuk operator Indonesia.');
                        }
                    },
                ],
                'payment_method' => 'required|in:cash,transfer',
            ]);
            }

            DB::transaction(function () use ($request, &$user, &$packageName, &$isNewUser, &$latestMembership) {
                if ($request->filled('user_id')) {
                    $user = User::findOrFail($request->user_id);
                } else {
                    // Bersihkan nomor WhatsApp guest inputan kasir
                    $cleanWhatsapp = WhatsappFormat::formatNumber($request->guest_whatsapp);

                    if (!$cleanWhatsapp) {
                        throw new \Exception('Format nomor WhatsApp tamu tidak valid.');
                    }

                    $existingUser = User::where('whatsapp', $cleanWhatsapp)->first();
                    if ($existingUser) {
                        $user = $existingUser;
                    } else {
                        $isNewUser = true;
                        
                        do {
                            $memberCode = 'GYM-'.strtoupper(Str::random(5));
                        } while (User::where('member_code', $memberCode)->exists());

                        $user = User::create([
                            'name' => $request->guest_name,
                            'whatsapp' => $cleanWhatsapp, // Tersimpan rapi
                            'password' => bcrypt('12345678'),
                            'role' => 'member',
                            'is_active_member' => false,
                            'member_code' => $memberCode,
                        ]);
                    }
                }

                // 2. TENTUKAN JENIS & HARGA PAKET
                $isActiveMember = $user->is_active_member;
                if ($isActiveMember) {
                    $packageName = 'Bulanan Member';
                    $packagePrice = Setting::where('key', 'bulanan_member')->value('value') ?? 110000;
                } else {
                    $packageName = 'Bulanan Tamu';
                    $packagePrice = Setting::where('key', 'bulanan_tamu')->value('value') ?? 200000;
                }

                // 3. HITUNG TANGGAL (Stacking Paket Beruntun)
                $lastMembership = Membership::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->latest('end_date')
                    ->first();

                $startDate = $lastMembership
                    ? Carbon::parse($lastMembership->end_date)->addDay()
                    : now();
                $endDate = Carbon::parse($startDate)->addDays(30);

                $currentTimestamp = now();

                // 4. SIMPAN DATA MEMBERSHIP BARU
                $latestMembership = Membership::create([
                    'user_id' => $user->id,
                    'package_name' => $packageName,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'created_at' => $currentTimestamp,
                ]);

                // 5. SIMPAN DATA TRANSAKSI
                Transaction::create([
                    'invoice_code' => 'PKG-'.strtoupper(Str::random(8)),
                    'user_id' => $user->id,
                    'admin_id' => Auth::id(),
                    'category' => 'monthly',
                    'amount' => $packagePrice,
                    'payment_method' => $request->payment_method,
                    'status' => 'success',
                    'source' => 'onsite',
                    'created_at' => $currentTimestamp,
                ]);
            });

            // Kirim pesan WA berdasarkan status user
            if ($isNewUser) {
                $waMessage = WhatsappMessage::newMemberWithPackage($user, $latestMembership, $packageName);
            } else {
                $waMessage = WhatsappMessage::monthly($user, $latestMembership, $packageName);
            }

            // Target pengiriman dijamin bersih hasil konversi database atau pembersihan di atas
            FonnteService::send($user->whatsapp, $waMessage);

            return redirect()->route('admin.package.index', [
                'tab' => 'bulanan',
                'search' => $user->member_code ?? $user->whatsapp,
            ])->with('success', $packageName.' berhasil dibeli!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function buyPT(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pt_package_id' => 'required|exists:pt_packages,id',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);

            $hasMonthlyPackage = Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->exists();

            if (! $user->is_active_member && ! $hasMonthlyPackage) {
                return redirect()->back()
                    ->with('error', 'PT hanya untuk member aktif atau pemilik paket bulanan!');
            }

            $package = PtPackage::findOrFail($request->pt_package_id);
            $currentTimestamp = now();

            Transaction::create([
                'invoice_code' => 'PT-'.strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'admin_id' => Auth::id(),
                'category' => 'pt',
                'package_id' => $package->id,
                'amount' => $package->harga,
                'payment_method' => $request->payment_method,
                'status' => 'success',
                'source' => 'onsite',
                'created_at' => $currentTimestamp,
            ]);

            PtMembership::create([
                'user_id' => $user->id,
                'pt_package_id' => $package->id,
                'total_sessions' => $package->jumlah_sesi,
                'remaining_sessions' => $package->jumlah_sesi,
                'status' => 'active',
                'created_at' => $currentTimestamp,
            ]);

            DB::commit();

            $waMessage = WhatsappMessage::pt($user, $package);
            FonnteService::send($user->whatsapp, $waMessage);

            return redirect()->route('admin.package.index', [
                'tab' => 'pt',
                'search' => $user->member_code ?? $user->whatsapp,
            ])->with('success', 'Paket PT '.$package->nama_paket.' berhasil ditambahkan!');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membeli paket PT.');
        }
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        if (! $transaction->created_at->isToday()) {
            return redirect()->back()->with('error', 'Transaksi lama tidak bisa dibatalkan!');
        }

        if ($transaction->status === 'cancelled') {
            return redirect()->back()->with('error', 'Transaksi sudah dibatalkan.');
        }

        $user = $transaction->user;

        DB::beginTransaction();
        try {
            $transaction->update(['status' => 'cancelled']);

            if ($transaction->category === 'activation') {
                if ($user) {
                    $user->update(['is_active_member' => false]);
                }

            } elseif ($transaction->category === 'monthly') {
                $membershipToCancel = Membership::where('user_id', $transaction->user_id)
                    ->whereBetween('created_at', [
                        $transaction->created_at->copy()->subSeconds(5),
                        $transaction->created_at->copy()->addSeconds(5),
                    ])
                    ->first();

                if ($membershipToCancel) {
                    $membershipToCancel->delete();
                }

            } elseif ($transaction->category === 'pt') {
                $ptToCancel = PtMembership::where('user_id', $transaction->user_id)
                    ->whereBetween('created_at', [
                        $transaction->created_at->copy()->subSeconds(5),
                        $transaction->created_at->copy()->addSeconds(5),
                    ])
                    ->first();

                if ($ptToCancel) {
                    $ptToCancel->delete();
                }
            }

            DB::commit();

            if ($user && $user->whatsapp) {
                // Amankan nomor WhatsApp yang barangkali di DB lama belum dibersihkan sebelum dikirim
                $targetWhatsapp = WhatsappFormat::formatNumber($user->whatsapp);
                
                if ($targetWhatsapp) {
                    $waMessage = WhatsappMessage::transactionCancelled($user, $transaction);
                    FonnteService::send($targetWhatsapp, $waMessage);
                }
            }

            return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan dan notifikasi WA telah dikirim!');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan transaksi: '.$th->getMessage());
        }
    }
}