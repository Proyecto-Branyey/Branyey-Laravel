<?php

namespace App\Mail;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionOrdenMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venta $venta) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu pedido #' . $this->venta->id . ' ha sido confirmado! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion_orden',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('admin.ventas.factura', ['venta' => $this->venta]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'factura_pedido_' . $this->venta->id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
