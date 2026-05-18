<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\AttendanceExport;
use App\Exports\Admin\PtActivityExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\PtMembership;
use App\Models\PtSessionLog;
use App\Models\Setting;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RIWAYAT TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $query = Transaction::with([
            'user',
            'admin',
            'items.product',
            'ptPackage' // relasi PT package kalau ada
        ])->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTER CATEGORY
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {

            $query->where('category', $request->category);
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH INVOICE / NAMA
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('invoice_code', 'like', "%{$search}%")
                    ->orWhere('guest_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {

                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('member_code', 'like', "%{$search}%");
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER SOURCE
        |--------------------------------------------------------------------------
        */
        if ($request->filled('source')) {

            $query->where('source', $request->source);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $transactions = $query->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | DETAIL LABEL
        |--------------------------------------------------------------------------

        /*
    |--------------------------------------------------------------------------
    | AMBIL SETTING DI LUAR LOOP (BIAR GAK BERAT)
    |--------------------------------------------------------------------------
    */
        $bulananMember = Setting::where('key', 'bulanan_member')->value('value');
        $bulananTamu   = Setting::where('key', 'bulanan_tamu')->value('value');
        $visitMember   = Setting::where('key', 'visit_member')->value('value');
        $visitTamu     = Setting::where('key', 'visit_tamu')->value('value');

        $transactions->getCollection()->transform(function ($trx) use ($bulananMember, $bulananTamu, $visitMember, $visitTamu) {
            $trx->detail_label = '-';

            // Filter Bulanan & Visit
            if ($trx->category == 'monthly') {
                if ($trx->amount == $bulananMember) {
                    $trx->detail_label = 'Bulanan Member';
                } elseif ($trx->amount == $bulananTamu) {
                    $trx->detail_label = 'Bulanan Tamu';
                } else {
                    $trx->detail_label = 'Paket Bulanan';
                }
            } elseif ($trx->category == 'visit') {
                if ($trx->amount == $visitMember) {
                    $trx->detail_label = 'Visit Member';
                } elseif ($trx->amount == $visitTamu) {
                    $trx->detail_label = 'Visit Tamu';
                } else {
                    $trx->detail_label = 'Visit Harian';
                }
            } elseif ($trx->category == 'activation') {
                $trx->detail_label = 'Aktivasi Member';
            } elseif ($trx->category == 'pt') {
                $trx->detail_label = $trx->ptPackage->nama_paket ?? $trx->ptPackage->name ?? 'Personal Trainer';
            } elseif ($trx->category == 'retail') {
                $trx->detail_label = 'Pembelian Retail';
            }

            return $trx;
        });

        return view('admin.report.transactions', compact('transactions'));
    }

    private function getFilteredTransactions(Request $request)
    {
        $query = Transaction::with([
            'user',
            'admin',
            'items.product',
            'ptPackage'
        ])->latest();

        // 1. Filter Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 2. Search Invoice / Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                    ->orWhere('guest_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('member_code', 'like', "%{$search}%");
                    });
            });
        }

        // 3. Filter Source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->get(); // Pakai get() karena untuk export kita butuh semua data terfilter

        // Ambil master setting untuk detail label
        $bulananMember = Setting::where('key', 'bulanan_member')->value('value');
        $bulananTamu   = Setting::where('key', 'bulanan_tamu')->value('value');
        $visitMember   = Setting::where('key', 'visit_member')->value('value');
        $visitTamu     = Setting::where('key', 'visit_tamu')->value('value');

        // Transformasi untuk menambahkan detail_label & item_details_string
        return $transactions->map(function ($trx) use ($bulananMember, $bulananTamu, $visitMember, $visitTamu) {
            // Logic detail_label
            if ($trx->category == 'monthly') {
                $trx->detail_label = ($trx->amount == $bulananMember) ? 'Bulanan Member' : (($trx->amount == $bulananTamu) ? 'Bulanan Tamu' : 'Paket Bulanan');
            } elseif ($trx->category == 'visit') {
                $trx->detail_label = ($trx->amount == $visitMember) ? 'Visit Member' : (($trx->amount == $visitTamu) ? 'Visit Tamu' : 'Visit Harian');
            } elseif ($trx->category == 'activation') {
                $trx->detail_label = 'Aktivasi Member';
            } elseif ($trx->category == 'pt') {
                $trx->detail_label = $trx->ptPackage->nama_paket ?? $trx->ptPackage->name ?? 'Personal Trainer';
            } elseif ($trx->category == 'retail') {
                $trx->detail_label = 'Pembelian Retail';
            } else {
                $trx->detail_label = '-';
            }

            // Gabungkan item retail jadi string untuk mempermudah cetak di Excel/PDF
            if ($trx->category == 'retail' && $trx->items->isNotEmpty()) {
                $trx->item_details_string = $trx->items->map(function ($item) {
                    return ($item->product->nama_produk ?? 'Produk') . " ({$item->qty}x)";
                })->implode(', ');
            } else {
                $trx->item_details_string = $trx->detail_label;
            }

            return $trx;
        });
    }

    /**
     * LOGIC EXCEL EXPORT
     */
    public function exportExcel(Request $request)
    {
        $transactions = $this->getFilteredTransactions($request);

        // Penamaan file dinamis berdasarkan filter & tanggal download
        $category = $request->filled('category') ? '_' . strtoupper($request->category) : '_SEMUA';
        $timestamp = Carbon::now()->format('Ymd_His');
        $fileName = "LAPORAN_TRANSAKSI{$category}_{$timestamp}.xlsx";

        return Excel::download(new \App\Exports\Admin\TransactionsExport($transactions), $fileName);
    }

    /**
     * LOGIC PDF EXPORT
     */
    public function exportPdf(Request $request)
    {
        $transactions = $this->getFilteredTransactions($request);

        $category = $request->filled('category') ? '_' . strtoupper($request->category) : '_SEMUA';
        $timestamp = Carbon::now()->format('Ymd_His');
        $fileName = "LAPORAN_TRANSAKSI{$category}_{$timestamp}.pdf";

        // Menggunakan DomPDF facade untuk load view khusus PDF
        $pdf = Pdf::loadView('admin.report.pdf_transactions', compact('transactions'))
            ->setPaper('a4', 'landscape'); // Set landscape agar muat banyak kolom beserta detailnya

        return $pdf->download($fileName);
    }


    /*
    |--------------------------------------------------------------------------
    | REPORT ATTENDANCE & PT ACTIVITY
    |--------------------------------------------------------------------------
    */
    public function attendance(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ACTIVE TAB
        |--------------------------------------------------------------------------
        */
        $tab = $request->get('tab', 'attendance');

        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | ATTENDANCE REPORT
        | ==============================================================
        |--------------------------------------------------------------------------
        */
        $attendanceQuery = Attendance::with([
            'user',
            'admin'
        ])->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTER TYPE
        |--------------------------------------------------------------------------
        */
        if ($tab == 'attendance' && $request->filled('type')) {

            $attendanceQuery->where(
                'type',
                $request->type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER DATE
        |--------------------------------------------------------------------------
        */
        if ($tab == 'attendance' && $request->filled('date_from')) {

            $attendanceQuery->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($tab == 'attendance' && $request->filled('date_to')) {

            $attendanceQuery->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH ATTENDANCE
        |--------------------------------------------------------------------------
        */
        if ($tab == 'attendance' && $request->filled('search')) {

            $search = $request->search;

            $attendanceQuery->where(function ($q) use ($search) {

                $q->where(
                    'guest_name',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'guest_whatsapp',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('user', function ($u) use ($search) {

                        $u->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                            ->orWhere(
                                'member_code',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'whatsapp',
                                'like',
                                "%{$search}%"
                            );
                    });
            });
        }

        $attendances = $attendanceQuery->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | PT ACTIVITY REPORT
        | ==============================================================
        |--------------------------------------------------------------------------
        */

        // IMPORTANT:
        // Report PT sekarang berbasis LOG ACTIVITY
        // BUKAN state membership

        $ptQuery = PtSessionLog::with([
            'user',
            'admin'
        ])->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTER DATE PT
        |--------------------------------------------------------------------------
        */
        if ($tab == 'pt' && $request->filled('date_from')) {

            $ptQuery->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($tab == 'pt' && $request->filled('date_to')) {

            $ptQuery->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER COACH
        |--------------------------------------------------------------------------
        */
        if ($tab == 'pt' && $request->filled('coach')) {

            $ptQuery->where(
                'coach_name',
                'like',
                '%' . $request->coach . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER ADMIN
        |--------------------------------------------------------------------------
        */
        if ($tab == 'pt' && $request->filled('admin')) {

            $ptQuery->whereHas('admin', function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->admin . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH PT LOGS
        |--------------------------------------------------------------------------
        */
        if ($tab == 'pt' && $request->filled('search')) {

            $search = $request->search;

            $ptQuery->where(function ($q) use ($search) {

                $q->where(
                    'member_name',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'coach_name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('admin', function ($a) use ($search) {

                        $a->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        $ptReports = $ptQuery->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | ATTENDANCE STATS
        | ==============================================================
        |--------------------------------------------------------------------------
        */
        $totalAttendance = Attendance::count();

        $memberAttendance = Attendance::where(
            'type',
            'member_package'
        )->count();

        $guestAttendance = Attendance::where(
            'type',
            'paid_visit'
        )->count();

        $todayAttendance = Attendance::whereDate(
            'created_at',
            today()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | PT ACTIVITY STATS
        | ==============================================================
        |--------------------------------------------------------------------------
        */

        // Total seluruh aktivitas PT
        $totalPtActivities = PtSessionLog::count();

        // Aktivitas PT hari ini
        $todayPtActivities = PtSessionLog::whereDate(
            'created_at',
            today()
        )->count();

        $totalSessionUsed = PtSessionLog::sum(
            DB::raw('previous_session - current_session')
        );

        return view(
            'admin.report.attendance',
            compact(
                'tab',

                // attendance
                'attendances',

                // pt activity
                'ptReports',

                // attendance stats
                'totalAttendance',
                'memberAttendance',
                'guestAttendance',
                'todayAttendance',

                // pt stats
                'totalPtActivities',
                'todayPtActivities',
                'totalSessionUsed'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportAttendanceExcel(Request $request)
    {
        $tab = $request->get('tab', 'attendance');

        $timestamp = now()->format('Ymd_His');

        if ($tab == 'attendance') {

            $fileName = "LAPORAN_KEHADIRAN_GYM_{$timestamp}.xlsx";

            return Excel::download(
                new AttendanceExport($request),
                $fileName
            );
        }

        // PT ACTIVITY EXPORT
        $fileName = "LAPORAN_AKTIVITAS_PT_{$timestamp}.xlsx";

        return Excel::download(
            new PtActivityExport($request),
            $fileName
        );
    }
}
