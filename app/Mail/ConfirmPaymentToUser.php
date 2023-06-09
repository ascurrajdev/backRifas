<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Collection;
class ConfirmPaymentToUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $collection;
    /**
     * Create a new message instance.
     */
    public function __construct(Collection $collection)
    {
        $collection->load([
            'detail.raffle',
            'user',
            'client'
        ]);
        $this->collection = $collection;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pago Recibido',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payments.confirm_user',
            with:[
                'details' => $this->collection->detail,
                'amount' => number_format($this->collection->amount,0,',','.'),
                'userName' => $this->collection->user->name,
                'clientName' => $this->collection->client->name,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
