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
use Illuminate\Support\Facades\Http;
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

            // Enviar correo de bienvenida usando el microservicio Java
            try {
                $correo = $user->email;
                $nombre = $user->nombre_completo ?: $user->username;
                $nombre = e($nombre);
                $correo = e($correo);
                $dashboardUrl = 'http://127.0.0.1:8000/dashboard';
                $correoBienvenida = "
                    <div style='margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;'>
                        <div style='max-width:680px;margin:0 auto;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf2;'>
                            <div style='background:#111827;padding:22px 24px;color:#fff;'>
                                <div style='font-size:20px;font-weight:800;letter-spacing:.3px;'>Branyey</div>
                                <div style='opacity:.85;font-size:13px;margin-top:4px;'>Cuenta creada con exito</div>
                            </div>
                            <div style='padding:24px;'>
                                <h2 style='margin:0 0 10px;color:#111827;font-size:22px;'>Bienvenido a Branyey, {$nombre}</h2>
                                <p style='margin:0 0 14px;color:#4b5563;'>Tu registro fue completado correctamente. Ya puedes explorar productos, gestionar tu perfil y realizar compras.</p>

                                <div style='border:1px solid #eee;border-radius:10px;padding:14px;background:#fcfcfd;'>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Usuario:</strong> {$nombre}</p>
                                    <p style='margin:0;color:#374151;'><strong>Correo:</strong> {$correo}</p>
                                </div>

                                <div style='margin-top:18px;'>
                                    <a href='{$dashboardUrl}' style='display:inline-block;background:#111827;color:#fff;text-decoration:none;padding:10px 14px;border-radius:8px;font-weight:700;'>
                                        Ir a mi cuenta
                                    </a>
                                </div>

                                <p style='margin:18px 0 0;color:#4b5563;'>Gracias por confiar en Branyey.</p>
                            </div>
                        </div>
                    </div>
                ";
                $response = Http::post('http://localhost:8080/api/mail/send', [
                    'to' => $correo,
                    'subject' => '¡Bienvenido a Branyey!',
                    'body' => $correoBienvenida
                ]);
                // Opcional: puedes loguear el resultado o manejar errores
            } catch (\Exception $e) {
                // Log::error('Error enviando correo de bienvenida: ' . $e->getMessage());
            }

        return redirect()->route('dashboard');
    }
}