<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\PtMembership;
use App\Models\PtPackage;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $tab = $request->tab ?? 'aktivasi';
        $hasMonthlyPackage = false;

        if ($request->filled('search')) {
            $user = User::where('whatsapp', $request->search)
                ->orWhere('member_code', $request->search)
                ->first();

            if (!$user) {
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
            'whatsapp' => 'required',
            'payment_method' => 'required',
        ]);

        $existingUser = User::where('whatsapp', $request->whatsapp)->first();

        if ($existingUser) {
            if ($existingUser->is_active_member) {
                return redirect()->back()->with('error', 'User ini sudah menjadi member aktif!');
            }

            $existingUser->update(['is_active_member' => true]);
            $user = $existingUser;
        } else {
            do {
                $memberCode = 'GYM-' . strtoupper(Str::random(5));
            } while (User::where('member_code', $memberCode)->exists());

            $user = User::create([
                'name' => $request->name,
                'whatsapp' => $request->whatsapp,
                'password' => bcrypt('12345678'),
                'role' => 'member',
                'is_active_member' => true,
                'member_code' => $memberCode,
            ]);
        }

        Transaction::create([
            'invoice_code' => 'ACT-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'category' => 'activation',
            'amount' => 80000,
            'payment_method' => $request->payment_method,
            'status' => 'success',
            'source' => 'onsite',
        ]);

        return redirect()->route('admin.package.index', ['tab' => 'aktivasi'])
            ->with('success', $user->name . ' berhasil diaktivasi menjadi member!');
    }

    public function buyPackage(Request $request)
    {
        if ($request->filled('user_id')) {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'payment_method' => 'required',
            ]);
            $user = User::findOrFail($request->user_id);
        } else {
            $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_whatsapp' => 'required',
                'payment_method' => 'required',
            ]);

            $existingUser = User::where('whatsapp', $request->guest_whatsapp)->first();

            if ($existingUser) {
                $user = $existingUser;
            } else {
                do {
                    $memberCode = 'GYM-' . strtoupper(Str::random(5));
                } while (User::where('member_code', $memberCode)->exists());

                $user = User::create([
                    'name' => $request->guest_name,
                    'whatsapp' => $request->guest_whatsapp,
                    'password' => bcrypt('12345678'),
                    'role' => 'member',
                    'is_active_member' => false,
                    'member_code' => $memberCode,
                ]);
            }
        }

        $isActiveMember = $user->is_active_member;

        if ($isActiveMember) {
            $packageName = 'Bulanan Member';
            $packagePrice = Setting::where('key', 'bulanan_member')->value('value') ?? 110000;
        } else {
            $packageName = 'Bulanan Non Member';
            $packagePrice = Setting::where('key', 'bulanan_tamu')->value('value') ?? 200000;
        }

        Membership::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'expired']);

        $lastMembership = Membership::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->latest('end_date')
            ->first();

        $startDate = $lastMembership 
            ? Carbon::parse($lastMembership->end_date)->addDay()
            : now();

        $endDate = Carbon::parse($startDate)->addDays(30);

        Membership::create([
            'user_id' => $user->id,
            'package_name' => $packageName,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        Transaction::create([
            'invoice_code' => 'PKG-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'category' => 'monthly',
            'amount' => $packagePrice,
            'payment_method' => $request->payment_method,
            'status' => 'success',
            'source' => 'onsite',
        ]);

        return redirect()->route('admin.package.index', [
            'tab' => 'bulanan',
            'search' => $user->member_code,
        ])->with('success', $packageName . ' berhasil dibeli!');
    }

    public function buyPT(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'pt_package_id' => 'required',
            'payment_method' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);
        $hasMonthlyPackage = Membership::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->exists();

        if (!$user->is_active_member && !$hasMonthlyPackage) {
            return redirect()->back()
                ->with('error', 'PT hanya untuk member aktif atau pemilik paket bulanan!');
        }

        $package = PtPackage::findOrFail($request->pt_package_id);

        Transaction::create([
            'invoice_code' => 'PT-'.strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'category' => 'pt',
            'amount' => $package->harga,
            'payment_method' => $request->payment_method,
            'status' => 'success',
            'source' => 'onsite',
        ]);

        PtMembership::create([
            'user_id' => $user->id,
            'pt_package_id' => $package->id,
            'total_sessions' => $package->jumlah_sesi,
            'remaining_sessions' => $package->jumlah_sesi,
            'status' => 'active',
        ]);

        return redirect()->route('admin.package.index', [
            'tab' => 'pt',
            'search' => $user->member_code ?? $user->whatsapp,
        ])->with('success', 'Paket PT '.$package->nama_paket.' berhasil ditambahkan!');
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        if (!$transaction->created_at->isToday()) {
            return redirect()->back()->with('error', 'Transaksi lama tidak bisa dibatalkan!');
        }

        if ($transaction->status === 'cancelled') {
            return redirect()->back()->with('error', 'Transaksi sudah dibatalkan.');
        }

        $transaction->update(['status' => 'cancelled']);

        if ($transaction->category === 'activation') {
            $transaction->user?->update(['is_active_member' => false]);
        } elseif ($transaction->category === 'monthly') {
            Membership::where('user_id', $transaction->user_id)
                ->where('status', 'active')
                ->whereDate('end_date', '>=', now())
                ->update(['status' => 'expired']);
        } elseif ($transaction->category === 'pt') {
            PtMembership::where('user_id', $transaction->user_id)
                ->latest()
                ->first()
                ?->update(['status' => 'completed']);
        }

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan!');
    }
}