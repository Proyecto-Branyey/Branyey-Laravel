<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $rol  El nombre del rol que queremos validar (ej: 'Mayorista')
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        // 1. Si el usuario no está logueado, lo mandamos al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** * 2. Validamos el nombre del rol.
         * IMPORTANTE: Esto asume que en tu modelo User tienes la relación:
         * public function rol() { return $this->belongsTo(Rol::class); }
         */
        if (Auth::user()->rol && Auth::user()->rol->nombre === $rol) {
            return $next($request);
        }

        // 3. Si no tiene el rol, lo regresamos al inicio con un mensaje de aviso
        return redirect('/')->with('error', 'Tu cuenta no tiene permisos de ' . $rol);
    }
}