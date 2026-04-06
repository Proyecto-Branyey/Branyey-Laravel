<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ColombiaApiController extends Controller
{
    /**
     * Retorna todos los departamentos de Colombia desde api-colombia.com
     * Fuente: https://api-colombia.com
     */
    public function departamentos()
    {
        $response = Http::timeout(10)->get('https://api-colombia.com/api/v1/Department');

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo conectar con la API de Colombia'], 503);
        }

        $departamentos = collect($response->json())
            ->sortBy('name')
            ->values()
            ->map(fn($d) => ['id' => $d['id'], 'nombre' => $d['name']]);

        return response()->json($departamentos);
    }

    /**
     * Retorna las ciudades de un departamento desde api-colombia.com
     * Fuente: https://api-colombia.com
     */
    public function ciudades(int $departamentoId)
    {
        $response = Http::timeout(10)->get("https://api-colombia.com/api/v1/Department/{$departamentoId}/cities");

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo conectar con la API de Colombia'], 503);
        }

        $ciudades = collect($response->json())
            ->sortBy('name')
            ->values()
            ->map(fn($c) => ['id' => $c['id'], 'nombre' => $c['name']]);

        return response()->json($ciudades);
    }
}
