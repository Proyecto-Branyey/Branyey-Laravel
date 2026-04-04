<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
     */
    public function rules(): array
    {
        return [
            // Cambiamos 'email' por 'login' para aceptar cualquier string
            'login' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // LÓGICA DE DETECCIÓN:
        // Si el input tiene formato de email, buscamos por la columna 'email'.
        // De lo contrario, buscamos por la columna 'username'.
        $login = $this->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Intentamos el login usando el campo detectado dinámicamente
        if (! Auth::attempt([$fieldType => $login, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        // Usamos 'login' para el throttle key
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
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
        // Cambiamos 'email' por 'login' para que el bloqueo por intentos funcione correctamente
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}