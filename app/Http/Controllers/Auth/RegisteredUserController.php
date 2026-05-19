<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\WhatsappFormat; // 1. Panggil helper kamu di sini
use App\Helpers\WhatsappMessage; // Opsional: jika ingin kirim WA selamat bergabung nanti
use App\Services\FonnteService;  // Opsional
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 2. SANITASI INPUT: Bersihkan nomor WhatsApp dari spasi, strip, atau tanda '+' sebelum validasi unique bekerja
        if ($request->filled('whatsapp')) {
            $cleanedInput = WhatsappFormat::formatNumber($request->whatsapp);
            
            if ($cleanedInput) {
                $request->merge(['whatsapp' => $cleanedInput]);
            }
        }

        // 3. JALANKAN VALIDASI
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => [
                'required', 
                'string', 
                'max:30', 
                'unique:'.User::class, // Mengecek keunikan data yang sudah dalam format bersih (628...)
                function ($attribute, $value, $fail) {
                    // Karena sudah dibersihkan di atas, kita tinggal pastikan polanya valid
                    if (!preg_match('/^(628|8)\d{7,13}$/', $value)) {
                        $fail('Nomor WhatsApp harus nomor Indonesia yang valid (diawali 08, 628, atau 8).');
                    }
                }
            ], 
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'whatsapp.unique' => 'Nomor WhatsApp ini sudah terdaftar di sistem UB GYM.',
        ]);

        // 4. SIMPAN KE DATABASE
        $user = User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp, // Tersimpan rapi dengan format standar (misal: 62812345678)
            'password' => Hash::make($request->password),
            'role' => 'member', // Default saat daftar mandiri adalah member
        ]);

        event(new Registered($user));

        Auth::login($user);

        // --- OPSIONAL: JIKA INGIN LANGSUNG KIRIM WA PEMBUATAN AKUN ---
        // try {
        //     $waMessage = WhatsappMessage::newMemberAccount($user);
        //     FonnteService::send($user->whatsapp, $waMessage);
        // } catch (\Throwable $th) {
        //     // Biarkan log error jika WA gagal, jangan sampai menggagalkan proses login user
        // }
        // -------------------------------------------------------------

        return redirect(route('member.dashboard', absolute: false));
    }
}