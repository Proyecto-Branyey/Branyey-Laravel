<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VentasExport;
use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReporteVentasController extends Controller
{
    public function descargar(Request $request, $formato = 'pdf')
    {
        $ventas = Venta::with('usuario')
            ->filtros($request->all())
            ->get();

        if ($formato === 'excel') {
            return Excel::download(new VentasExport($ventas), 'reporte_ventas.xlsx');
        }

        $pdf = PDF::loadView('admin.ventas.reporte_pdf', compact('ventas'));
        return $pdf->download('reporte_ventas.pdf');
    }
}
