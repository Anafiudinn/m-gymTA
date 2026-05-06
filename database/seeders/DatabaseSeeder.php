<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun penampung untuk semua tamu harian
        User::create([
            'name' => 'Tamu Umum / Guest',
            'whatsapp' => 'guest_system',
            'password' => Hash::make('password_rahasia'),
            'role' => 'guest',
            'is_active_member' => false,
        ]);
        // 1. Buat Akun Owner Utama
        User::create([
            'name' => 'Ahmad Owner UB',
            'whatsapp' => '08123456789', // Nomor WA untuk login
            'password' => Hash::make('owner123'), // Password login
            'role' => 'owner',
            'is_active_member' => true,
        ]);

        // 2. Buat Akun Contoh Admin
        User::create([
            'name' => 'Admin Kasir 1',
            'whatsapp' => '08987654321',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active_member' => false,
        ]);

        // 3. Setup Harga Default (Settings)
        // Ini SANGAT PENTING agar getVisitPrice() tidak error
        $defaultSettings = [
            'biaya_aktivasi' => '80000',
            'visit_member' => '7000',
            'visit_tamu' => '15000',
            'bulanan_member' => '110000',
            'bulanan_tamu' => '200000',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
