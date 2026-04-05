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
        $request->validate([
            'name'                 => ['nullable', 'string', 'max:255'],
            'nombre_completo'      => ['nullable', 'string', 'max:255'],
            'username'             => ['nullable', 'string', 'max:255', 'unique:usuarios,username'],
            'email'                => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono'             => ['nullable', 'string', 'max:20'],
            'direccion_defecto'    => ['nullable', 'string', 'max:255'],
            'ciudad_defecto'       => ['nullable', 'string', 'max:100'],
            'departamento_defecto' => ['nullable', 'string', 'max:100'],
            'password'             => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $rolId = Rol::firstOrCreate(['nombre' => 'minorista'])->id;

        $nombreCompleto = $request->nombre_completo ?: ($request->name ?: 'Usuario');
        $username = $request->username;

        if (! $username) {
            $baseUsername = strstr($request->email, '@', true) ?: 'usuario';
            $candidate = $baseUsername;
            $suffix = 1;

            while (User::where('username', $candidate)->exists()) {
                $suffix++;
                $candidate = $baseUsername.$suffix;
            }

            $username = $candidate;
        }

        $user = User::create([
            'name'                 => $nombreCompleto,
            'username'             => $username,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'rol_id'               => $rolId,
            'telefono'             => $request->telefono,
            'nombre_completo'      => $nombreCompleto,
            'direccion_defecto'    => $request->direccion_defecto,
            'ciudad_defecto'       => $request->ciudad_defecto,
            'departamento_defecto' => $request->departamento_defecto,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}