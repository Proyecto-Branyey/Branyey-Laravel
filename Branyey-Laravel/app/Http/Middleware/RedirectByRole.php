public function handle(Request $request, Closure $next): Response
{
    if (Auth::check()) {
        $rol = Auth::user()->rol->nombre; // 'administrador', 'mayorista', 'minorista'

        // Si el usuario intenta entrar al login o registro estando ya logueado
        if ($request->is('login') || $request->is('register')) {
            return $this->redirectUserByRole($rol);
        }
    }

    return $next($request);
}

/**
 * Función auxiliar para centralizar las rutas de destino
 */
private function redirectUserByRole($rol)
{
    return match ($rol) {
        'administrador' => redirect()->route('admin.dashboard'),
        'mayorista', 'minorista' => redirect()->route('tienda.catalogo'),
        default => redirect('/'),
    };
}