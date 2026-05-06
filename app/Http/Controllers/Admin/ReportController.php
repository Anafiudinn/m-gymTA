<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

use App\Models\Transaction;

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

        $transactions = $query->paginate(10);

        return view(
            'admin.report.transactions',
            compact('transactions')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT KEHADIRAN
    |--------------------------------------------------------------------------
    */
 public function attendance(Request $request)
{
    $query = Attendance::with('user')->latest();

    /*
    |--------------------------------------------------------------------------
    | FILTER TYPE
    |--------------------------------------------------------------------------
    */
    if ($request->filled('type')) {

        $query->where('type', $request->type);
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('guest_name', 'like', "%{$search}%")
              ->orWhere('guest_whatsapp', 'like', "%{$search}%")
              ->orWhereHas('user', function ($u) use ($search) {

                    $u->where('name', 'like', "%{$search}%");

              });
        });
    }

    $attendances = $query->paginate(12);

    return view(
        'admin.report.attendance',
        compact('attendances')
    );
}
}