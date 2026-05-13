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

     $members = User::where('role', 'member')

    ->where(function ($query) {

        $query->whereNotNull('member_code')
              ->orWhere('is_active_member', true)
              ->orWhereHas('memberships', function ($q) {

                    $q->whereIn('status', ['active', 'expired']);

              });

    })

    ->when($search, function ($query) use ($search) {

        $query->where(function ($q) use ($search) {

            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('whatsapp', 'like', '%' . $search . '%')
              ->orWhere('member_code', 'like', '%' . $search . '%');

        });

    })

    ->when($status !== null && $status !== '', function ($query) use ($status) {

        $query->where('is_active_member', $status);

    })

    ->latest()

    ->paginate(15);
        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalMembers = User::where('role', 'member')->count();

        $activeMembers = User::where('role', 'member')
            ->where('is_active_member', true)
            ->count();

        $inactiveMembers = User::where('role', 'member')
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
