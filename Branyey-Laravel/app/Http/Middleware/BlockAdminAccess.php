<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockAdminAccess
{
    /**
     * Bloquea acceso del rol administrador a rutas de cliente.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->rol?->nombre === 'administrador') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Los administradores no pueden acceder a compras, perfil ni pedidos de cliente.');
        }

        return $next($request);
    }
}
