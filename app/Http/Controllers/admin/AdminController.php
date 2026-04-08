<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;

class AdminController extends Controller
{
    public function dashboard()
    {
        $adminsCount = User::where('activo', true)->whereHas('rol', function ($q) {
            $q->where('nombre', 'administrador');
        })->count();

        $clientesCount = User::where('activo', true)->whereHas('rol', function ($q) {
            $q->whereIn('nombre', ['mayorista', 'minorista']);
        })->count();

        $mayoristasCount = User::where('activo', true)->whereHas('rol', function ($q) {
            $q->where('nombre', 'mayorista');
        })->count();

        $minoristasCount = User::where('activo', true)->whereHas('rol', function ($q) {
            $q->where('nombre', 'minorista');
        })->count();

        $usuariosPapeleraCount = User::where('activo', false)->count();

        $stats = [
            'ventas_count'   => Venta::count(),
            'ingresos_total' => Venta::sum('total'),
            'clientes_count' => $clientesCount,
            'admins_count'   => $adminsCount,
            'mayoristas_count' => $mayoristasCount,
            'minoristas_count' => $minoristasCount,
            'usuarios_papelera_count' => $usuariosPapeleraCount,
            'productos_count'=> Producto::count(),
        ];

        // Obtener variantes con stock bajo (5 o menos unidades)
        $bajo_stock = \App\Models\Variante::with(['producto', 'talla'])
            ->where('stock', '<=', 5)
            ->where('activo', true)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        // Obtener ventas recientes (últimas 5)
        $ventas_recientes = Venta::with('usuario')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'bajo_stock', 'ventas_recientes'));
    }
}