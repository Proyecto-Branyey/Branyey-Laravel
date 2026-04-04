<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Variante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito con el total calculado.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $user = Auth::user();
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('tienda.carrito.index', compact('cart', 'user', 'total'));
    }

    /**
     * Agregar producto al carrito con VALIDACIÓN DE STOCK (HU-014)
     */
    public function add(Request $request)
    {
        // 1. Buscamos la variante con sus relaciones
        $variante = Variante::with(['producto.estilo', 'producto.imagenes', 'talla'])->findOrFail($request->variante_id);

        // --- INICIO VALIDACIÓN DE STOCK CRÍTICO ---
        if ($variante->stock <= 0) {
            return redirect()->back()->with('error', 'Lo sentimos, esta talla se encuentra agotada actualmente.');
        }
        // --- FIN VALIDACIÓN ---

        $cart = session()->get('cart', []);
        $user = Auth::user();
        
        // Lógica de precios Branyey (Mayorista vs Minorista)
        $esMayorista = ($user && $user->rol && $user->rol->nombre === 'mayorista');

        $precioBase = $esMayorista 
            ? $variante->producto->estilo->precio_base_mayorista 
            : $variante->producto->estilo->precio_base_minorista;
        
        $recargo = $esMayorista
            ? $variante->talla->recargo_mayorista
            : $variante->talla->recargo_minorista;

        $precioFinal = $precioBase + $recargo;

        // Si ya está en el carrito, verificamos que la nueva cantidad no supere el stock
        if(isset($cart[$variante->id])) {
            if ($cart[$variante->id]['quantity'] + 1 > $variante->stock) {
                return redirect()->back()->with('error', 'No puedes agregar más unidades, has alcanzado el límite de stock disponible.');
            }
            $cart[$variante->id]['quantity']++;
        } else {
            $cart[$variante->id] = [
                "name"     => $variante->producto->nombre_comercial,
                "quantity" => 1,
                "price"    => $precioFinal,
                "talla"    => $variante->talla->nombre,
                "image"    => $variante->producto->imagenes->first()->url ?? 'default.jpg'
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('tienda.cart.index')->with('success', 'Producto añadido al carrito.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Producto eliminado.');
    }

    /**
     * Actualiza la cantidad verificando stock disponible.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $variante = Variante::find($id);

        if(isset($cart[$id]) && $request->quantity > 0) {
            // Validamos stock antes de actualizar cantidad en el input
            if ($request->quantity > $variante->stock) {
                return redirect()->back()->with('error', 'Solo hay ' . $variante->stock . ' unidades disponibles.');
            }

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Carrito actualizado.');
        }
        return redirect()->back()->with('error', 'Cantidad no válida.');
    }
}