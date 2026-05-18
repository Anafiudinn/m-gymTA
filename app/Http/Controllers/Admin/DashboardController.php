<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Membership;
use App\Models\Product;
use App\Models\PtMembership;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TODAY STATS
        |--------------------------------------------------------------------------
        */

        $todayAttendance = Attendance::whereDate('created_at', today())
            ->count();

        $todayOmzet = Transaction::whereDate('created_at', today())
            ->where('status', 'success')
            ->sum('amount');

        $todayTransactions = Transaction::whereDate('created_at', today())
            ->where('status', 'success')
            ->count();

        $pendingVerifications = Transaction::where('payment_method', 'transfer')
            ->where('status', 'pending')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | MEMBER STATS
        |--------------------------------------------------------------------------
        */

        $activeMembers = User::where('is_active_member', true)->count();

        $activeMemberships = Membership::where('status', 'active')
            ->whereDate('end_date', '>=', today())
            ->count();

        $activePT = PtMembership::where('status', 'active')->count();

        /*
        |--------------------------------------------------------------------------
        | LOW STOCK PRODUCTS
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = Product::where('stok', '<=', 5)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT TRANSACTIONS
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(7)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT ATTENDANCES
        |--------------------------------------------------------------------------
        */

        $recentAttendances = Attendance::with('user')
            ->latest()
            ->take(7)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i);

            $chartLabels[] = $date->format('d M');

            $chartData[] = Transaction::whereDate('created_at', $date)
                ->where('status', 'success')
                ->sum('amount');
        }

        return view('admin.dashboard', compact(
            'todayAttendance',
            'todayOmzet',
            'todayTransactions',
            'pendingVerifications',
            'activeMembers',
            'activeMemberships',
            'activePT',
            'lowStockProducts',
            'recentTransactions',
            'recentAttendances',
            'chartLabels',
            'chartData'
        ));
    }
}