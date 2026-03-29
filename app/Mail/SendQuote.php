<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

use function Illuminate\Support\now;

class SendQuote extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance. 
     * All public data on the constructor can be used on the template.
     * If we use private or protected, we need to pass the 'with' parameter.
     * We are going to use private and use viewData array. 
     */
    public function __construct(
        private string $action,
        private string $description,
        private string $projectName,
        private string $technicianName
    ){ }

    /**
     * Get the message envelope.
     */

    public function envelope(): Envelope
    {
        return new Envelope(
            subject:'Actualización de una cotización',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $viewData = [];
        $viewData['action'] = $this->action;
        $viewData['description'] = $this->description;
        $viewData['projectName'] = $this->projectName;
        $viewData['technicianName'] = $this->technicianName;
        $viewData['timestamp'] = now()->toDateTimeString(); // e.g., "2025-04-20 15:30:00"
        
        return new Content(
            view:'components.mail.notification',
            with: ['viewData' => $viewData]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attachment::fromPath('')
            // ->as('Cotizacion1') # Name of the quote in the desired format
            // ->withMime('application/pdf'),
        ];
    }
}
