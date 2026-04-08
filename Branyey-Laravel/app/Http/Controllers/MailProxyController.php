<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MailProxyController extends Controller
{
    public function enviarCorreo(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        // Llama al microservicio Java
        $response = Http::post('http://localhost:8080/api/mail/send', [
            'to' => $validated['to'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Correo enviado correctamente desde Java'], 200);
        } else {
            return response()->json(['error' => 'Error enviando correo', 'detalle' => $response->body()], 500);
        }
    }
}
