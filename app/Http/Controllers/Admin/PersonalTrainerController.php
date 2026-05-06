<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PtMembership;
use Illuminate\Http\Request;

class PersonalTrainerController extends Controller
{
    /**
     * Display PT sessions dashboard
     */
    public function index(Request $request)
    {
        // Query active PT memberships
        $query = PtMembership::with(['user', 'package'])->where('status', 'active')->latest();

        // Search by name, member_code, or whatsapp
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('member_code', 'like', "%{$search}%")
                ->orWhere('whatsapp', 'like', "%{$search}%"));
        }

        // Paginate results
        $ptMemberships = $query->paginate(8);

        // Stats
        $totalActive = PtMembership::where('status', 'active')->count();
        $lowSession = PtMembership::where('status', 'active')->where('remaining_sessions', '<=', 3)->count();
        $emptySession = PtMembership::where('status', 'active')->where('remaining_sessions', '<=', 0)->count();

        return view('admin.pt.index', compact('ptMemberships', 'totalActive', 'lowSession', 'emptySession'));
    }

    /**
     * Cut 1 PT session
     */
    public function cutSession($id)
    {
        $membership = PtMembership::findOrFail($id);

        // Check if sessions depleted
        if ($membership->remaining_sessions <= 0) {
            return back()->with('error', 'Sesi PT member sudah habis!');
        }

        // Subtract session
        $membership->subtractSession();

        // Auto finish if no sessions left
        if ($membership->fresh()->remaining_sessions <= 0) {
            $membership->update(['status' => 'finished']);
        }

        return back()->with('success', '1 sesi PT berhasil digunakan. Sisa sesi: '.$membership->fresh()->remaining_sessions);
    }
}
