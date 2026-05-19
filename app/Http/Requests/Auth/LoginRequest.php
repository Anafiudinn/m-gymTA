<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'whatsapp' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // 1. Ambil data user berdasarkan nomor WhatsApp
        $user = User::where('whatsapp', $this->input('whatsapp'))->first();

        // 🌟 JIKA NOMOR WA TIDAK ADA DI DB
        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'whatsapp' => 'Nomor WhatsApp tidak terdaftar di sistem UB GYM.',
            ]);
        }

        // 🌟 JIKA NOMOR WA ADA, TAPI PASSWORD-NYA SALAH
        if (! Hash::check($this->input('password'), $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah. Silakan coba lagi.',
            ]);
        }

        // 2. Jika nomor & password cocok, langsung login akunnya
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        // 🌟 Ubah target error key dari 'email' menjadi 'whatsapp' agar teks pembatasan muncul di UI
        throw ValidationException::withMessages([
            'whatsapp' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // 🌟 Ubah 'email' menjadi 'whatsapp' agar penguncian spam mendeteksi nomor WA + IP penembak
        return Str::transliterate(Str::lower($this->string('whatsapp')).'|'.$this->ip());
    }
}