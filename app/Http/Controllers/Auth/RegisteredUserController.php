<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Maneja la solicitud de registro entrante.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDACIÓN COMPLETA
        // Validamos cada campo que viene del formulario para asegurar la integridad de Branyey
        $request->validate([
            'nombre_completo'      => ['required', 'string', 'max:255'],
            'username'             => ['required', 'string', 'max:255', 'unique:usuarios,username'],
            'email'                => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono'             => ['required', 'string', 'max:20'],
            'direccion_defecto'    => ['required', 'string', 'max:255'],
            'ciudad_defecto'       => ['required', 'string', 'max:100'],
            'departamento_defecto' => ['required', 'string', 'max:100'],
            'password'             => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. ASIGNACIÓN DE ROL
        // Buscamos el rol 'minorista' (ID 3) para nuevos clientes
        $rolInicial = Rol::where('nombre', 'minorista')->first();
        $rolId = $rolInicial ? $rolInicial->id : 3;

        // 3. CREACIÓN DEL USUARIO EN LA DB
        // Mapeamos cada dato validado a su columna correspondiente en la tabla 'usuarios'
        $user = User::create([
            'name'                 => $request->nombre_completo,
            'username'             => $request->username,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'rol_id'               => $rolId,
            'telefono'             => $request->telefono,
            'direccion_defecto'    => $request->direccion_defecto,
            'ciudad_defecto'       => $request->ciudad_defecto,
            'departamento_defecto' => $request->departamento_defecto,
        ]);

        // 4. EVENTOS Y LOGUEO
        event(new Registered($user));

        Auth::login($user);

        // 5. REDIRECCIÓN
        // Si no tienes creada la ruta 'tienda.catalogo', cámbiala por '/' o 'dashboard'
        if (view()->exists('tienda.catalogo')) {
            return redirect(route('tienda.catalogo'));
        }

        return redirect('/');
    }
}