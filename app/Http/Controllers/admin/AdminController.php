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
            'usuarios_count' => User::count(),
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