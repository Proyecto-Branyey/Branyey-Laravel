<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    /**
     * Muestra usuarios inactivos (papelera).
     */
    public function papelera()
    {
        $usuarios = User::with('rol')->where('activo', false)->get();
        return view('admin.usuarios.papelera', compact('usuarios'));
    }

    /**
     * Reactiva un usuario inactivo.
     */
    public function activar($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->activo = true;
        $usuario->save();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario reactivado correctamente.');
    }
    public function index()
    {
        $usuarios = User::with('rol')->where('activo', true)->orderBy('id', 'desc')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios',
            'email' => 'required|email|max:255|unique:usuarios',
            'password' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios,username,' . $usuario->id,
            'email' => 'required|email|max:255|unique:usuarios,email,' . $usuario->id,
            'rol_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $usuario->name = $request->name;
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->rol_id = $request->rol_id;
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->activo = false;
        $usuario->save();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}
