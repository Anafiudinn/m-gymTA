<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * =========================================================
     * HALAMAN SETTINGS
     * =========================================================
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('owner.settings.index', compact('settings'));
    }

    /**
     * =========================================================
     * UPDATE SETTINGS
     * =========================================================
     */
    public function update(Request $request)
    {
        $validated = $request->validate([

            // Aktivasi
            'biaya_aktivasi' => 'nullable|numeric|min:0',

            // Paket Bulanan
            'bulanan_member' => 'nullable|numeric|min:0',
            'bulanan_tamu'   => 'nullable|numeric|min:0',

            // Visit Harian
            'visit_member' => 'nullable|numeric|min:0',
            'visit_tamu'   => 'nullable|numeric|min:0',

            // Informasi Gym
            'gym_name'    => 'nullable|string|max:255',
            'gym_phone'   => 'nullable|string|max:30',
            'gym_address' => 'nullable|string|max:500',

            // Media Sosial
            'instagram' => 'nullable|string|max:255',
            

            // Rekening Transfer
            'bank_name'   => 'nullable|string|max:100',
            'bank_number' => 'nullable|string|max:100',
            'bank_holder' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $key => $value) {

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with(
            'success',
            'Pengaturan gym berhasil diperbarui.'
        );
    }
}