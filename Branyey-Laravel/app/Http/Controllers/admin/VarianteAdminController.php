<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Variante;

class VarianteAdminController extends Controller
{
    /**
     * Papelera de variantes (inactivas o soft deleted).
     */
    public function papelera()
    {
        $variantes = Variante::withTrashed()
            ->with(['producto' => function ($query) {
                $query->withTrashed();
            }, 'talla', 'colores'])
            ->where(function ($query) {
                $query->where('activo', false)
                    ->orWhereNotNull('deleted_at');
            })
            ->orderByDesc('id')
            ->get();

        return view('admin.variantes.papelera', compact('variantes'));
    }

    /**
     * Envía una variante a papelera sin afectar su producto.
     */
    public function destroy($id)
    {
        $variante = Variante::findOrFail($id);
        $variante->activo = false;
        $variante->save();
        $variante->delete();

        return redirect()->back()->with('success', 'Variante enviada a la papelera.');
    }

    /**
     * Reactiva una variante desde papelera.
     */
    public function activar($id)
    {
        $variante = Variante::withTrashed()->with(['producto' => function ($query) {
            $query->withTrashed();
        }])->findOrFail($id);

        $producto = $variante->producto;
        if (!$producto || !$producto->activo || $producto->trashed()) {
            return redirect()->route('admin.variantes.papelera')
                ->withErrors(['error' => 'No se puede reactivar la variante porque su producto está inactivo o en papelera. Reactiva primero el producto completo.']);
        }

        if ($variante->trashed()) {
            $variante->restore();
        }

        $variante->activo = true;
        $variante->save();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Variante reactivada correctamente.');
    }
}
