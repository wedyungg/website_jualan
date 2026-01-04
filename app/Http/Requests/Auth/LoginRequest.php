<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomer_wa' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    // =============== FIX DISINI ===============
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // FIX 1.1: GANTI dengan array EXPLICIT
        if (! Auth::attempt([
            'nomer_wa' => $this->input('nomer_wa'), // EXPLICIT mapping
            'password' => $this->input('password')  // EXPLICIT mapping
        ], $this->boolean('remember'))) {
            
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nomer_wa' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
    // ==========================================

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nomer_wa' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    // FIX 1.2: Pastikan throttleKey pakai nomer_wa
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('nomer_wa')).'|'.$this->ip());
    }
}