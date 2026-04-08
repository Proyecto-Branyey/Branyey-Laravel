<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- LÓGICA DE REDIRECCIÓN POR ROL PARA BRANYEY ---
        $user = Auth::user();

        // Accedemos al nombre del rol a través de la relación que definimos en el modelo User
        $rol = $user?->rol?->nombre;

        if ($rol === 'administrador') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Si no es administrador, usa dashboard general (compatibilidad con auth estándar)
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}