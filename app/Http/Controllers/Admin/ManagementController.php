<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\MembersExport;
use App\Helpers\WhatsappFormat;
use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Product;
use App\Models\PtMembership;
use App\Models\PtPackage;
use App\Models\Setting;
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ManagementController extends Controller
{
    // ==========================================
    // KELOLA DATA MEMBER UB GYM
    // ==========================================
    public function members(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $package_filter = $request->package_filter; 

        $query = User::with([
            'activeMembership' => function ($q) {
                $q->where('status', 'active');
            },
            'ptMemberships' => function ($q) {
                $q->where('status', 'active')->with('ptPackage');
            },
        ])
        ->where('role', 'member')
        ->whereNotNull('member_code');

        // 1. Filter Pencarian Teks (Sudah disinkronkan dengan Helper WA)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($search) {
                // 🌟 Trik: Ikut bersihkan kata kunci pencarian jika kasir mengetik nomor WA acak-acakan
                $searchKey = WhatsappFormat::formatNumber($search) ?? $search;

                $q->where('name', 'like', '%'.$search.'%')
                  ->orWhere('whatsapp', 'like', '%'.$searchKey.'%') // Mencari format bersih 628...
                  ->orWhere('member_code', 'like', '%'.$search.'%');
            });
        }

        // 2. Filter Status Registrasi (Member Aktif vs Tamu/Non-Aktif)
        if ($status !== null && $status !== '') {
            $query->where('is_active_member', $status);
        }

        // 3. Filter Kategori Paket
        if ($request->filled('package_filter')) {
            if ($package_filter == 'active_monthly') {
                $query->whereHas('activeMembership', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($package_filter == 'active_pt') {
                $query->whereHas('ptMemberships', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($package_filter == 'both') {
                $query->whereHas('activeMembership', function ($q) {
                    $q->where('status', 'active');
                })->whereHas('ptMemberships', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($package_filter == 'no_package') {
                $query->whereDoesntHave('activeMembership', function ($q) {
                    $q->where('status', 'active');
                })->whereDoesntHave('ptMemberships', function ($q) {
                    $q->where('status', 'active');
                });
            }
        }

        $members = $query->latest()->paginate(10);
        $settings = Setting::pluck('value', 'key')->toArray();

        /* --- Hitungan Statistik --- */
        $totalMembers = User::where('role', 'member')->whereNotNull('member_code')->count();
        $activeMembers = User::where('role', 'member')->whereNotNull('member_code')->where('is_active_member', true)->count();
        
        $expiredPackages = Membership::whereHas('user', function ($q) { $q->whereNotNull('member_code'); })
            ->where(function ($q) { $q->where('status', 'expired')->orWhere('end_date', '<', now()); })
            ->distinct('user_id')->count();
            
        $ptActive = PtMembership::whereHas('user', function ($q) { $q->whereNotNull('member_code'); })->where('status', 'active')->count();

        return view('admin.management.members', compact(
            'members', 'search', 'status', 'package_filter',
            'totalMembers', 'activeMembers', 'expiredPackages', 'ptActive', 'settings'
        ));
    }

    public function updateMember(Request $request, $id)
    {
        if ($request->filled('whatsapp')) {
            $cleanedInput = WhatsappFormat::formatNumber($request->whatsapp);
            if ($cleanedInput) {
                $request->merge(['whatsapp' => $cleanedInput]);
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => [
                'required',
                'string',
                'max:30',
                'unique:users,whatsapp,'.$id, 
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(628|8)\d{7,13}$/', $value)) {
                        $fail('Format nomor WhatsApp tidak dikenali sebagai nomor seluler Indonesia yang valid.');
                    }
                },
            ],
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
        ]);

        return redirect()->back()->with('success', 'Data '.$user->name.' berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
      $user = User::findOrFail($id);

    // 1. Balikkan status (True jadi False, atau sebaliknya)
    $user->is_active_member = !$user->is_active_member;
    $user->save();

    // 2. KIRIM NOTIFIKASI WHATSAPP SECARA OTOMATIS
    if ($user->whatsapp) {
        try {
            // Panggil format pesan berdasarkan status terbarunya
            $waMessage = WhatsappMessage::memberStatusToggled($user->name, $user->is_active_member);
            
            // Kirim via Fonnte
            FonnteService::send($user->whatsapp, $waMessage);
        } catch (\Throwable $th) {
            // Gunakan try-catch agar jika Fonnte error/kuota habis, 
            // halaman web kasir tidak ikut crash dan status di DB tetap sukses berubah.
            Log::error('Gagal kirim WA Toggle Status: ' . $th->getMessage());
        }
    }

    $status = $user->is_active_member ? 'diaktifkan' : 'dinonaktifkan';

    return redirect()->back()->with(
        'success',
        'Member ' . $user->name . ' berhasil ' . $status . ' dan notifikasi telah dikirim!'
    );
    }

    public function exportMembers()
    {
        $fileName = 'DATA_MEMBER_'.now()->format('Ymd_His').'.xlsx';
        return Excel::download(new MembersExport, $fileName);
    }

    // ==========================================
    // KELOLA DATA PRODUK (SIMPLE POS UB GYM)
    // ==========================================
    public function products(Request $request)
    {
        $query = Product::query();
        
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        return view('admin.management.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
        ]);

        Product::create([
            'nama_produk' => $request->name_produk ?? $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'is_active'   => true, 
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only(['nama_produk', 'harga', 'stok']));

        return redirect()->back()->with('success', 'Data produk diperbarui!');
    }

    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        
        // Membalikkan status keaktifan (True -> False / False -> True)
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (diarsipkan)';

        return redirect()->back()->with('success', 'Produk ' . $product->nama_produk . ' berhasil ' . $status . '!');
    }
}