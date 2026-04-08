<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Genera un reporte estadístico de ventas en PDF.
     * Cumple con el Ítem 4 de la lista de chequeo del SENA.
     */
    public function ventasPdf()
    {
        // Obtenemos todas las ventas con la relación del usuario (cliente)
        $ventas = Venta::with('usuario')->orderBy('fecha', 'desc')->get();

        // Datos que se enviarán a la plantilla del PDF
        $data = [
            'ventas'         => $ventas,
            'total_ingresos' => $ventas->sum('total'),
            'promedio_venta' => $ventas->avg('total') ?? 0,
            'cantidad'       => $ventas->count(),
            'fecha_reporte'  => now()->format('d/m/Y H:i A'),
            'empresa'        => 'BRANYEY - Urban Style'
        ];

        // Cargamos la vista del reporte y le pasamos los datos
        $pdf = Pdf::loadView('admin.reportes.ventas_pdf', $data);
        
        // Retornamos la descarga del archivo
        return $pdf->download('reporte-ventas-branyey-' . now()->format('Ymd') . '.pdf');
    }
}