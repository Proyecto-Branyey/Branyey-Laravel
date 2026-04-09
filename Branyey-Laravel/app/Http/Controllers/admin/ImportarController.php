<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ImportarController extends Controller
{
    public function form() {
        return view('admin.importar');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'tabla' => 'required',
            'file' => 'required|file|mimes:xlsx'
        ]);

        $tabla = $request->input('tabla');
        $file = $request->file('file');
        $baseUrl = rtrim(config('services.java_mailer.base_url', 'http://localhost:8080'), '/');

        $response = Http::attach(
            'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
        )->timeout(20)->post("{$baseUrl}/api/import/{$tabla}");

        if ($response->successful()) {
            return back()->with('success', $response->body());
        } else {
            return back()->with('error', 'Error: ' . $response->body());
        }
    }
}
