<?php

namespace App\Http\Controllers\Owner;

use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * =========================================================
     * LAPORAN TRANSAKSI / KEUANGAN
     * =========================================================
     */
    public function transactions(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth();

        $category = $request->category;

        $paymentMethod = $request->payment_method;

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Transaction::with([
            'user',
            'admin',
            'items.product' // Eager load produk untuk laporan PDF
        ])
            ->where('status', 'success')
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ]);

        // Filter kategori
        if ($category) {

            $query->where('category', $category);
        }

        // Filter metode pembayaran
        if ($paymentMethod) {

            $query->where('payment_method', $paymentMethod);
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $transactions = $query
            ->latest()
            ->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalIncome = (clone $query)->sum('amount');

        $totalTransactions = (clone $query)->count();

        $cashIncome = (clone $query)
            ->where('payment_method', 'cash')
            ->sum('amount');

        $transferIncome = (clone $query)
            ->where('payment_method', 'transfer')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | CATEGORY STATS
        |--------------------------------------------------------------------------
        */

        $statsByCategory = Transaction::select(
            'category',
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'success')
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ])
            ->groupBy('category')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DAILY CHART
        |--------------------------------------------------------------------------
        */

        $dailyIncome = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'success')
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('owner.reports.transactions', [

            // Data
            'transactions' => $transactions,

            // Filter
            'startDate' => $startDate,
            'endDate' => $endDate,
            'category' => $category,
            'paymentMethod' => $paymentMethod,

            // Summary
            'totalIncome' => $totalIncome,
            'totalTransactions' => $totalTransactions,
            'cashIncome' => $cashIncome,
            'transferIncome' => $transferIncome,

            // Stats
            'statsByCategory' => $statsByCategory,
            'dailyIncome' => $dailyIncome,
        ]);
    }

    /**
     * =========================================================
     * LAPORAN KEHADIRAN
     * =========================================================
     */
    public function attendance(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER DATE
        |--------------------------------------------------------------------------
        */

        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Attendance::with([
            'user',
            'admin'
        ])
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ]);

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $attendances = $query
            ->latest()
            ->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalAttendance = (clone $query)->count();

        $memberAttendance = (clone $query)
            ->whereHas('user', function ($q) {

                $q->where('is_active_member', true);
            })
            ->count();

        $guestAttendance = $totalAttendance - $memberAttendance;

        /*
        |--------------------------------------------------------------------------
        | DAILY STATS
        |--------------------------------------------------------------------------
        */

        $dailyAttendance = Attendance::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('owner.reports.attendance', [

            // Data
            'attendances' => $attendances,

            // Filter
            'startDate' => $startDate,
            'endDate' => $endDate,

            // Summary
            'totalAttendance' => $totalAttendance,
            'memberAttendance' => $memberAttendance,
            'guestAttendance' => $guestAttendance,

            // Chart
            'dailyAttendance' => $dailyAttendance,
        ]);
    }
    /**
     * =========================================================
     * EXPORT EXCEL TRANSAKSI
     * =========================================================
     */
public function exportTransactionsExcel(Request $request)
{
    $startDate = $request->start_date
        ? \Carbon\Carbon::parse($request->start_date)->startOfDay()
        : \Carbon\Carbon::now()->startOfMonth();

    $endDate = $request->end_date
        ? \Carbon\Carbon::parse($request->end_date)->endOfDay()
        : \Carbon\Carbon::now()->endOfMonth();

    $category = $request->category;

    $paymentMethod = $request->payment_method;

    $query = Transaction::with([
        'user',
        'admin',
        'ptPackage',
        'transactionItems.product'
    ])
    ->where('status', 'success')
    ->whereBetween('created_at', [
        $startDate,
        $endDate
    ]);

    if ($category) {

        $query->where('category', $category);
    }

    if ($paymentMethod) {

        $query->where('payment_method', $paymentMethod);
    }

    $transactions = $query
        ->latest()
        ->get();

    return Excel::download(
        new TransactionExport($transactions),
        'laporan-transaksi.xlsx'
    );
}
    /**
     * =========================================================
     * EXPORT PDF TRANSAKSI
     * =========================================================
     */
    public function exportTransactionsPdf(Request $request)
    {
        $startDate = $request->start_date
            ? \Carbon\Carbon::parse($request->start_date)->startOfDay()
            : \Carbon\Carbon::now()->startOfMonth();

        $endDate = $request->end_date
            ? \Carbon\Carbon::parse($request->end_date)->endOfDay()
            : \Carbon\Carbon::now()->endOfMonth();

        $category = $request->category;

        $paymentMethod = $request->payment_method;

        $query = Transaction::with([
            'user',
            'admin'
        ])
            ->where('status', 'success')
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ]);

        if ($category) {
            $query->where('category', $category);
        }

        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        $transactions = $query
            ->latest()
            ->get();

        $totalIncome = $transactions->sum('amount');

        $pdf = Pdf::loadView('owner.exports.transactions-pdf', [

            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'startDate' => $startDate,
            'endDate' => $endDate,

        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi.pdf');
    }
}
