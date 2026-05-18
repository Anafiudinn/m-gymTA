<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PtMembership;
use App\Models\PtSessionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalTrainerController extends Controller
{
    /**
     * Display PT sessions dashboard
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'active');

        /*
        |--------------------------------------------------------------------------
        | ACTIVE PT MEMBERS
        |--------------------------------------------------------------------------
        */
        $query = PtMembership::with([
            'user',
            'package'
        ])
            ->where('status', 'active')
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('member_code', 'like', "%{$search}%")
                    ->orWhere('whatsapp', 'like', "%{$search}%")
            );
        }

        $ptMemberships = $query->paginate(8);

        /*
        |--------------------------------------------------------------------------
        | RECENT ACTIVITY
        |--------------------------------------------------------------------------
        | Sidebar hanya tampilkan aktivitas hari ini
        | Full histori ada di menu laporan PT
        |--------------------------------------------------------------------------
        */
        $recentActivities = PtSessionLog::with([
            'user',
            'admin'
        ])
            ->whereDate('created_at', today())
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STATS
        |--------------------------------------------------------------------------
        */

        // Total member PT aktif
        $totalActive = PtMembership::where(
            'status',
            'active'
        )->count();

        // Sesi hampir habis (<= 3)
        $lowSession = PtMembership::where(
            'status',
            'active'
        )
            ->where('remaining_sessions', '<=', 3)
            ->where('remaining_sessions', '>', 0)
            ->count();

        // Aktivitas penggunaan sesi hari ini
        $todayActivity = PtSessionLog::whereDate(
            'created_at',
            today()
        )->count();

        return view(
            'admin.pt.index',
            compact(
                'tab',
                'ptMemberships',
                'recentActivities',

                // stats
                'totalActive',
                'lowSession',
                'todayActivity'
            )
        );
    }

    /**
     * Cut 1 PT session
     */
    public function cutSession($id)
    {
        return DB::transaction(function () use ($id) {
            $membership = PtMembership::with(['user', 'package'])->findOrFail($id);

            if ($membership->remaining_sessions <= 0) {
                return back()->with('error', 'Sesi PT member sudah habis!');
            }

            // Simpan data lama untuk log
            $before = $membership->remaining_sessions;

            // Eksekusi potong sesi
            $membership->subtractSession();

            $after = $membership->remaining_sessions;

            // CATAT KE LOG PT SESSION
            \App\Models\PtSessionLog::create([
                'user_id'          => $membership->user_id,
                'admin_id'         => auth()->id(),
                'pt_membership_id' => $membership->id,
                'member_name'      => $membership->user->name,
                'coach_name'       => $membership->package->coach_name ?? 'Personal Trainer',
                'previous_session' => $before,
                'current_session'  => $after,
            ]);

            return back()->with('success', "1 sesi digunakan. Sisa: $after");
        });
    }
}
