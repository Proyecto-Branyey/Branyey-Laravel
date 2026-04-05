<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VentasExport implements FromView
{
    protected $ventas;

    public function __construct($ventas)
    {
        $this->ventas = $ventas;
    }

    public function view(): View
    {
        return view('admin.ventas.reporte_excel', [
            'ventas' => $this->ventas
        ]);
    }
}
