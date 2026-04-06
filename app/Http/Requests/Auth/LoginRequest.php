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
            // Compatibilidad: permite login (nuevo) o email (tests/formularios legacy)
            'login' => ['nullable', 'string', 'required_without:email'],
            'email' => ['nullable', 'string', 'required_without:login'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Acepta login o email como campo de entrada para autenticar.
        $login = $this->input('login', $this->input('email'));
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Buscar usuario por username/email
        $userModel = Auth::getProvider()->retrieveByCredentials([$fieldType => $login]);
        if ($userModel && !$userModel->activo) {
            $mensaje = "Su cuenta está inhabilitada, <a href='https://wa.me/573213229744' target='_blank' style='color:#0d6efd;font-weight:600'>comuníquese aquí</a> para reactivarla.";
            throw ValidationException::withMessages([
                'login' => $mensaje,
                'email' => $mensaje,
            ]);
        }

        // Solo permite usuarios activos
        $credentials = [$fieldType => $login, 'password' => $this->input('password'), 'activo' => true];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
                'email' => trans('auth.failed'),
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
        $login = $this->input('login', $this->input('email', ''));

        return Str::transliterate(Str::lower($login).'|'.$this->ip());
    }
}