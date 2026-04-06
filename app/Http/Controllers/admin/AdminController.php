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

        return view('admin.dashboard', compact('stats'));
    }
}