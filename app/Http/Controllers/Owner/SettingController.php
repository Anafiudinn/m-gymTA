<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // 🌟 FIX: Pastikan pakai full namespace facade

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
            /*
            |--------------------------------------------------------------------------
            | AKTIVASI
            |--------------------------------------------------------------------------
            */
            'biaya_aktivasi' => 'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | PAKET BULANAN
            |--------------------------------------------------------------------------
            */
            'bulanan_member' => 'nullable|numeric|min:0',
            'bulanan_tamu'   => 'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | VISIT HARIAN
            |--------------------------------------------------------------------------
            */
            'visit_member' => 'nullable|numeric|min:0',
            'visit_tamu'   => 'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | INFORMASI GYM
            |--------------------------------------------------------------------------
            */
            'gym_name'    => 'nullable|string|max:255',
            'gym_phone'   => 'nullable|string|max:30',
            'gym_address' => 'nullable|string|max:500',

            /*
            |--------------------------------------------------------------------------
            | MEDIA SOSIAL
            |--------------------------------------------------------------------------
            */
            'instagram' => 'nullable|string|max:255',

            /*
            |--------------------------------------------------------------------------
            | REKENING TRANSFER
            |--------------------------------------------------------------------------
            */
            'bank_name'   => 'nullable|string|max:100',
            'bank_number' => 'nullable|string|max:100',
            'bank_holder' => 'nullable|string|max:100',

            /*
            |--------------------------------------------------------------------------
            | WHATSAPP GATEWAY
            |--------------------------------------------------------------------------
            */
            'fonnte_token'      => 'nullable|string',
            'wa_gateway_number' => 'nullable|string|max:20',
            'wa_enabled'        => 'nullable',
        ]);

        /*
        |--------------------------------------------------------------------------
        | HANDLE CHECKBOX
        |--------------------------------------------------------------------------
        */
        $validated['wa_enabled'] = $request->has('wa_enabled') ? 1 : 0;

        // 1. Simpan perubahan ke database terlebih dahulu
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // 🌟 FIX 2: HAPUS CACHE SETELAH DATABASE PASTI TER-UPDATE!
        // Ini menjamin begitu cache terhapus, hit selanjutnya pasti membaca data paling baru.
        Cache::forget('fonnte_gateway_status');

        return back()->with(
            'success',
            'Pengaturan gym berhasil diperbarui.'
        );
    }
}