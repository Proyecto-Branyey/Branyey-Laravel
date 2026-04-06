<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'ventas_count'   => Venta::count(),
            'ingresos_total' => Venta::sum('total'),
            // Solo clientes (no administradores)
            'usuarios_count' => User::where('rol_id', '!=', 1)->count(),
            'productos_count'=> Producto::count(),
        ];

        // Variantes bajas en stock (<= 5)
        $bajo_stock = \App\Models\Variante::with('producto', 'talla')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Ventas recientes (últimas 5)
        $ventas_recientes = Venta::with('usuario')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'bajo_stock', 'ventas_recientes'));
    }
}