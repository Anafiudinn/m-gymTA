<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | DATE RANGE
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        $startOfMonth = Carbon::now()->startOfMonth();

        $endOfMonth = Carbon::now()->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | BASIC KPI
        |--------------------------------------------------------------------------
        */

        // Omzet hari ini
        $incomeToday = Transaction::where('status', 'success')
            ->whereDate('created_at', $today)
            ->sum('amount');

        // Omzet bulan ini
        $incomeMonth = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Total transaksi hari ini
        $transactionsToday = Transaction::where('status', 'success')
            ->whereDate('created_at', $today)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | MEMBER
        |--------------------------------------------------------------------------
        */

        // Member aktif
        $activeMembers = User::where('role', 'member')
            ->where('is_active_member', true)
            ->count();

        // Total member
        $totalMembers = User::where('role', 'member')
            ->count();

        // Total admin
        $totalAdmins = User::where('role', 'admin')
            ->count();

        // Member baru bulan ini
        $newMembersThisMonth = User::where('role', 'member')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION
        |--------------------------------------------------------------------------
        */

        // Pending verifikasi
        $pendingVerifications = Transaction::where('status', 'pending')
            ->where('source', 'online')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE
        |--------------------------------------------------------------------------
        */

        // Kehadiran hari ini
        $attendanceToday = Attendance::whereDate('created_at', $today)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | CATEGORY STATS
        |--------------------------------------------------------------------------
        */

        // Statistik omzet berdasarkan kategori
        $statsCategory = Transaction::select(
                'category',
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'success')
            ->groupBy('category')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MONTHLY INCOME
        |--------------------------------------------------------------------------
        */

        $monthlyIncome = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'success')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP PACKAGE
        |--------------------------------------------------------------------------
        */

        $topPackages = Transaction::select(
                'category',
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'success')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT TRANSACTIONS
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaction::with([
                'user',
                'admin'
            ])
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('owner.dashboard', [

            // KPI
            'incomeToday' => $incomeToday,
            'incomeMonth' => $incomeMonth,
            'transactionsToday' => $transactionsToday,

            // Member
            'activeMembers' => $activeMembers,
            'totalMembers' => $totalMembers,
            'totalAdmins' => $totalAdmins,
            'newMembersThisMonth' => $newMembersThisMonth,

            // Verification
            'pendingVerifications' => $pendingVerifications,

            // Attendance
            'attendanceToday' => $attendanceToday,

            // Category Stats
            'statsCategory' => $statsCategory,

            // Monthly Chart
            'monthlyIncome' => $monthlyIncome,

            // Top Package
            'topPackages' => $topPackages,

            // Recent Transactions
            'recentTransactions' => $recentTransactions,
        ]);
    }
}