<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('member.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'whatsapp' => 'required',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}