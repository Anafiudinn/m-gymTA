<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $attendances = Attendance::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('member.history.index', compact(
            'attendances',
            'transactions'
        ));
    }
}