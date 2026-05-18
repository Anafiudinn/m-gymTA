<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Membership;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * =========================================================
     * LIST MEMBER
     * =========================================================
     */
  public function index(Request $request)
{
    $search = $request->search;
    $status = $request->status;

    // 1. QUERY UTAMA: Disamakan dengan Admin (Wajib punya member_code)
    $query = User::with([
        'activeMembership' => function($q) {
            $q->where('status', 'active');
        },
        'ptMemberships' => function($q) {
            $q->where('status', 'active');
        }
    ])
    ->where('role', 'member')
    ->whereNotNull('member_code'); // 🌟 Kunci utama: Akun self-register tanpa kode disembunyikan

    // 2. FILTER PENCARIAN
    if ($request->filled('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('whatsapp', 'like', '%' . $search . '%')
              ->orWhere('member_code', 'like', '%' . $search . '%');
        });
    }

    // 3. FILTER STATUS (Member Aktif vs Tamu/Non-Aktif)
    if ($status !== null && $status !== '') {
        $query->where('is_active_member', $status);
    }

    $members = $query->latest()->paginate(15);

    /*
    |--------------------------------------------------------------------------
    | SUMMARY / STATISTIK (Juga disaring hanya yang sudah punya member_code)
    |--------------------------------------------------------------------------
    */
    // Total seluruh member yang sah di gym
    $totalMembers = User::where('role', 'member')
        ->whereNotNull('member_code')
        ->count();

    // Total member resmi yang status membership registrasinya aktif
    $activeMembers = User::where('role', 'member')
        ->whereNotNull('member_code')
        ->where('is_active_member', true)
        ->count();

    // Total member/tamu yang status registrasinya non-aktif
    $inactiveMembers = User::where('role', 'member')
        ->whereNotNull('member_code')
        ->where('is_active_member', false)
        ->count();

    return view('owner.members.index', [
        'members' => $members,
        'search' => $search,
        'status' => $status,
        'totalMembers' => $totalMembers,
        'activeMembers' => $activeMembers,
        'inactiveMembers' => $inactiveMembers,
    ]);
}

    /**
     * =========================================================
     * DETAIL MEMBER
     * =========================================================
     */
    public function show($id)
    {
        $member = User::where('role', 'member')
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | MEMBERSHIP
        |--------------------------------------------------------------------------
        */

        $membership = Membership::where('user_id', $member->id)
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE
        |--------------------------------------------------------------------------
        */

        $attendances = Attendance::where('user_id', $member->id)
            ->latest()
            ->take(20)
            ->get();

        $totalAttendance = Attendance::where('user_id', $member->id)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        $transactions = Transaction::where('user_id', $member->id)
            ->latest()
            ->take(20)
            ->get();

        $totalTransaction = Transaction::where('user_id', $member->id)
            ->where('status', 'success')
            ->sum('amount');

        return view('owner.members.show', [

            'member' => $member,

            'membership' => $membership,

            'attendances' => $attendances,
            'totalAttendance' => $totalAttendance,

            'transactions' => $transactions,
            'totalTransaction' => $totalTransaction,
        ]);
    }
}
