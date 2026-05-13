<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\PtMembership;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
            'items.product'
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
                    ->orWhere('guest_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('status')) {
    $query->where('status', $request->status);
}

        $transactions = $query->paginate(10);

        return view(
            'admin.report.transactions',
            compact('transactions')
        );
    }

    /*
    |--------------------------------------------------------------------------
/*
|--------------------------------------------------------------------------
| RIWAYAT KEHADIRAN & PT
|--------------------------------------------------------------------------
*/
public function attendance(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | TAB
    |--------------------------------------------------------------------------
    */

    $tab = $request->get('tab', 'attendance');

    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE QUERY
    |--------------------------------------------------------------------------
    */

    $attendanceQuery = Attendance::with('user')
        ->latest();

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
    | SEARCH ATTENDANCE
    |--------------------------------------------------------------------------
    */

    if ($tab == 'attendance' && $request->filled('search')) {

        $search = $request->search;

        $attendanceQuery->where(function ($q) use ($search) {

            $q->where('guest_name', 'like', "%{$search}%")
                ->orWhere('guest_whatsapp', 'like', "%{$search}%")
                ->orWhereHas('user', function ($u) use ($search) {

                    $u->where('name', 'like', "%{$search}%")
                        ->orWhere('member_code', 'like', "%{$search}%")
                        ->orWhere('whatsapp', 'like', "%{$search}%");
                });
        });
    }

    $attendances = $attendanceQuery->paginate(12);

  /*
|--------------------------------------------------------------------------
| PT REPORT QUERY
|--------------------------------------------------------------------------
*/

$ptQuery = PtMembership::with([
    'user',
    'package'
])->latest('updated_at');

/*
|--------------------------------------------------------------------------
| FILTER STATUS PT
|--------------------------------------------------------------------------
*/

if ($tab == 'pt' && $request->filled('status')) {

    $ptQuery->where(
        'status',
        $request->status
    );
}

/*
|--------------------------------------------------------------------------
| SEARCH PT
|--------------------------------------------------------------------------
*/

if ($tab == 'pt' && $request->filled('search')) {

    $search = $request->search;

    $ptQuery->where(function ($q) use ($search) {

        $q->whereHas('user', function ($u) use ($search) {

            $u->where('name', 'like', "%{$search}%")
                ->orWhere('member_code', 'like', "%{$search}%")
                ->orWhere('whatsapp', 'like', "%{$search}%");
        })

        ->orWhereHas('package', function ($p) use ($search) {

            $p->where('coach_name', 'like', "%{$search}%")
                ->orWhere('nama_paket', 'like', "%{$search}%");
        });
    });
}

$ptReports = $ptQuery->paginate(12);

/*
|--------------------------------------------------------------------------
| STATS ATTENDANCE
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
| STATS PT
|--------------------------------------------------------------------------
*/

$totalPt = PtMembership::count();

$activePt = PtMembership::where(
    'status',
    'active'
)->count();

$finishedPt = PtMembership::where(
    'status',
    'completed'
)->count();

$lowSessionPt = PtMembership::where(
    'status',
    'active'
)
->where('remaining_sessions', '<=', 3)
->count();

return view(
    'admin.report.attendance',
    compact(
        'tab',

        'attendances',
        'ptReports',

        'totalAttendance',
        'memberAttendance',
        'guestAttendance',
        'todayAttendance',

        'totalPt',
        'activePt',
        'finishedPt',
        'lowSessionPt'
    )
);
}
}