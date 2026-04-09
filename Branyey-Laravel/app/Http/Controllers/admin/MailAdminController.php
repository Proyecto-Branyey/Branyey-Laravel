<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailAdminController extends Controller
{
    public function create()
    {
        $roles = Rol::orderBy('nombre')->get(['id', 'nombre']);
        $users = User::with('rol:id,nombre')
            ->whereNotNull('email')
            ->where('activo', 1)
            ->orderBy('nombre_completo')
            ->get(['id', 'nombre_completo', 'email', 'rol_id']);

        return view('admin.mail.create', compact('roles', 'users'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'recipient_mode' => 'required|in:all,role,selected',
            'role_id' => 'nullable|required_if:recipient_mode,role|exists:roles,id',
            'selected_users' => 'nullable|required_if:recipient_mode,selected|array|min:1',
            'selected_users.*' => 'integer|exists:usuarios,id',
        ]);

        $usersQuery = User::whereNotNull('email')
            ->where('activo', 1);

        if ($validated['recipient_mode'] === 'role') {
            $usersQuery->where('rol_id', (int) $validated['role_id']);
        }

        if ($validated['recipient_mode'] === 'selected') {
            $usersQuery->whereIn('id', $validated['selected_users'] ?? []);
        }

        $recipients = $usersQuery->get(['email']);

        if ($recipients->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['recipient_mode' => 'No se encontraron destinatarios con el filtro seleccionado.']);
        }

        $subject = $validated['subject'];
        $message = $validated['message'];
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('mail-broadcast', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }
        $emailHtml = $this->buildEmailTemplate($subject, $message, $imageUrl);

        $sentCount = 0;
        $failedCount = 0;

        foreach ($recipients as $recipient) {
            try {
                $response = Http::timeout(8)->post('http://localhost:8080/api/mail/send', [
                    'to' => $recipient->email,
                    'subject' => $subject,
                    'body' => $emailHtml,
                ]);

                if ($response->successful()) {
                    $sentCount++;
                } else {
                    $failedCount++;
                    Log::error('Fallo correo masivo (respuesta no exitosa)', [
                        'to' => $recipient->email,
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                }
            } catch (\Throwable $e) {
                $failedCount++;
                Log::error('Excepcion en correo masivo', [
                    'to' => $recipient->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if ($sentCount === 0) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'No se pudo enviar ningun correo. Verifica que el servicio Java este activo en el puerto 8080.']);
        }

        return redirect()->back()->with('success', "Correos enviados: {$sentCount}. Fallidos: {$failedCount}.");
    }

    private function buildEmailTemplate(string $subject, string $message, ?string $imageUrl = null): string
    {
        $safeSubject = e($subject);
        $safeMessage = nl2br(e($message));
        $imageBlock = '';

        if ($imageUrl) {
            $safeImageUrl = e($imageUrl);
            $imageBlock = "<img src=\"{$safeImageUrl}\" alt=\"Imagen del anuncio\" style=\"width:100%;max-width:572px;border-radius:10px;display:block;object-fit:cover;\">";
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$safeSubject}</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background:#0f172a;color:#ffffff;padding:20px 24px;font-weight:bold;font-size:20px;letter-spacing:0.5px;">BRANYEY</td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <h1 style="margin:0 0 12px;font-size:24px;line-height:1.2;color:#0f172a;">{$safeSubject}</h1>
                            <p style="margin:0 0 18px;font-size:15px;line-height:1.7;color:#374151;">{$safeMessage}</p>
                            {$imageBlock}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 24px;background:#f9fafb;color:#6b7280;font-size:12px;line-height:1.5;">
                            Este es un mensaje informativo enviado por el equipo de Branyey.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
}
