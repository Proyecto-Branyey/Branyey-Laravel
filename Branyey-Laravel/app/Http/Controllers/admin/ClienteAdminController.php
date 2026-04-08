<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteAdminController extends Controller
{
    public function index()
    {
        $clientes = User::with('rol')->orderBy('id', 'desc')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = User::with('rol')->findOrFail($id);
        return view('admin.clientes.show', compact('cliente'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.clientes.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,username',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'telefono' => 'nullable|string|max:30',
            'nombre_completo' => 'required|string|max:255',
            'direccion_defecto' => 'nullable|string|max:255',
            'ciudad_defecto' => 'nullable|string|max:255',
            'departamento_defecto' => 'nullable|string|max:255',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit($id)
    {
        $cliente = User::findOrFail($id);
        $roles = Rol::all();
        return view('admin.clientes.edit', compact('cliente', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $cliente = User::findOrFail($id);
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,username,' . $cliente->id,
            'email' => 'required|email|max:255|unique:usuarios,email,' . $cliente->id,
            'telefono' => 'nullable|string|max:30',
            'nombre_completo' => 'required|string|max:255',
            'direccion_defecto' => 'nullable|string|max:255',
            'ciudad_defecto' => 'nullable|string|max:255',
            'departamento_defecto' => 'nullable|string|max:255',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $cliente->update($data);
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cliente = User::findOrFail($id);
        $nombre = $cliente->nombre_completo;
        $cliente->delete();
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
