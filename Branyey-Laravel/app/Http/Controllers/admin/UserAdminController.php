<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Display a listing of the users with filters.
     */
    public function index(Request $request)
    {
        $query = User::with('rol');

        // 1. FILTRO POR BÚSQUEDA (nombre, usuario, email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 2. FILTRO POR ROL (usando el nombre del rol)
        if ($request->filled('rol')) {
            $rolNombre = $request->rol;
            $query->whereHas('rol', function($q) use ($rolNombre) {
                $q->where('nombre', $rolNombre);
            });
        }

        // 3. FILTRO POR ESTADO
        if ($request->filled('estado')) {
            if ($request->estado == 'activo') {
                $query->where('activo', true);
            } elseif ($request->estado == 'inactivo') {
                $query->where('activo', false);
            }
        } else {
            // Por defecto, mostrar SOLO activos (a menos que se filtre por inactivos)
            if (!$request->filled('estado')) {
                $query->where('activo', true);
            }
        }

        // 4. ORDENAR y PAGINAR
        $usuarios = $query->orderBy('id', 'desc')->paginate(15);

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
            'nombre_completo' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'direccion_defecto' => 'nullable|string|max:1000',
            'ciudad_defecto' => 'nullable|string|max:100',
            'departamento_defecto' => 'nullable|string|max:100',
            'username' => 'required|string|max:255|unique:usuarios',
            'email' => 'required|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario = User::create([
            'nombre_completo' => $request->nombre_completo,
            'telefono' => $request->telefono,
            'direccion_defecto' => $request->direccion_defecto,
            'ciudad_defecto' => $request->ciudad_defecto,
            'departamento_defecto' => $request->departamento_defecto,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'activo' => true,
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
            'nombre_completo' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'direccion_defecto' => 'nullable|string|max:1000',
            'ciudad_defecto' => 'nullable|string|max:100',
            'departamento_defecto' => 'nullable|string|max:100',
            'username' => 'required|string|max:255|unique:usuarios,username,' . $usuario->id,
            'email' => 'required|email|max:255|unique:usuarios,email,' . $usuario->id,
            'rol_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->telefono = $request->telefono;
        $usuario->direccion_defecto = $request->direccion_defecto;
        $usuario->ciudad_defecto = $request->ciudad_defecto;
        $usuario->departamento_defecto = $request->departamento_defecto;
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

    public function exportarPdf(Request $request)
    {
        $query = User::with('rol');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('rol')) {
            $rolNombre = $request->rol;
            $query->whereHas('rol', function($q) use ($rolNombre) {
                $q->where('nombre', $rolNombre);
            });
        }

        if ($request->filled('estado')) {
            if ($request->estado == 'activo') {
                $query->where('activo', true);
            } elseif ($request->estado == 'inactivo') {
                $query->where('activo', false);
            }
        } else {
            $query->where('activo', true);
        }

        $usuarios = $query->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('admin.usuarios.pdf', compact('usuarios'));
        return $pdf->download('usuarios_branyey_' . now()->format('Y-m-d_His') . '.pdf');
    }
}