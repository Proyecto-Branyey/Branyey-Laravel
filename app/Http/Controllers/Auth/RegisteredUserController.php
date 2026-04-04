<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol; // Importante para asignar el rol inicial
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
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validamos según los campos de tu modelo y formulario
      // CÁMBIALO POR ESTO:
$request->validate([
    'username' => ['required', 'string', 'max:255', 'unique:usuarios'], // <-- APUNTA A LA NUEVA TABLA
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);

        // 2. Buscamos el ID del rol para nuevos usuarios (ajusta el nombre según tu DB)
        // Normalmente el ID 1 o el rol 'Minorista'/'Cliente'
        $rolInicial = Rol::where('nombre', 'minorista')->first();

        // 3. Creamos el usuario con tus campos personalizados
        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $rolInicial->id ?? 3, // Si no encuentra el rol, pone el ID 1 por defecto
        ]);

        event(new Registered($user));

        Auth::login($user);

        // 4. Redirigimos al catálogo para que vea los productos de inmediato
        return redirect(route('tienda.catalogo', absolute: false));
    }
}