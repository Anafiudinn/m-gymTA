<?php


namespace App\Http\Controllers;

use App\Models\PtPackage;
use App\Models\Setting;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil paket PT yang aktif untuk SECTION 5
        $paket_pt = PtPackage::where('is_active', true)->get();

        // Ambil semua settings untuk SECTION 3 & 4
        $settings = Setting::pluck('value', 'key')->all();

        return view('welcome', compact('paket_pt', 'settings'));
    }
}