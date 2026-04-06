<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstadoOrdenMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venta $venta, public string $estadoAnterior) {}

    public function envelope(): Envelope
    {
        $etiquetas = [
            'en_proceso' => 'está siendo procesado',
            'enviado'    => 'ha sido enviado 🚚',
            'entregado'  => 'fue entregado ✅',
            'cancelado'  => 'fue cancelado',
        ];

        $texto = $etiquetas[$this->venta->estado] ?? 'fue actualizado';

        return new Envelope(
            subject: 'Tu pedido #' . $this->venta->id . ' ' . $texto,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.estado_orden',
        );
    }
}
