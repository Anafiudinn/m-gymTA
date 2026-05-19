<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form dynamically based on role.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // 🌟 Jika Owner atau Admin, arahkan ke layout dashboard management
        if (in_array($user->role, ['owner', 'admin'])) {
            return view('owner_admin.profile.edit', compact('user'));
        }

        // 🌟 Jika Member, arahkan ke layout member area (Satrio Gym Theme)
        return view('member.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Isi data baru hasil validasi (name & whatsapp)
        $request->user()->fill($request->validated());

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account (Hanya diizinkan untuk Member).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 🛡️ PROTEKSI: Owner & Admin tidak boleh hapus akun sendiri lewat jalur ini!
        if (in_array($user->role, ['owner', 'admin'])) {
            return back()->withErrors(['error' => 'Akun manajemen tidak dapat dihapus secara mandiri.']);
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}