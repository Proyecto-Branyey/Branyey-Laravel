<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;
use PDF;

class ReporteVentasController extends Controller
{
    public function descargar(Request $request, $formato = 'pdf')
    {
        $ventas = Venta::with('usuario')
            ->filtros($request->all())
            ->get();

        if ($formato === 'csv') {
            $filename = 'reporte_ventas.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];
            $callback = function() use ($ventas) {
                $handle = fopen('php://output', 'w');
                // Encabezados
                fputcsv($handle, ['ID', 'Cliente', 'Tipo de cliente', 'Fecha', 'Total', 'Estado'], ';');
                foreach ($ventas as $venta) {
                    fputcsv($handle, [
                        $venta->id,
                        $venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-',
                        $venta->usuario->rol->nombre ?? '-',
                        ' ' . $venta->created_at->format('Y-m-d H:i:s'),
                        $venta->total,
                        $venta->estado_label,
                    ], ';');
                }
                fclose($handle);
            };
            return response()->stream($callback, 200, $headers);
        }

        // PDF sigue igual
        $pdf = \PDF::loadView('admin.ventas.reporte_pdf', compact('ventas'));
        return $pdf->download('reporte_ventas.pdf');
    }
}