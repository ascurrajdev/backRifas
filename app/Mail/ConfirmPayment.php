<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
use App\Models\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailables\Attachment;

class ConfirmPayment extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $payment;
    public $collection;
    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment, Collection $collection)
    {
        $this->payment = $payment;
        $collection->load([
            'raffleNumbers.raffle',
            'client',
            'user'
        ]);
        $this->collection = $collection;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pago Confirmado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payments.confirm',
            with:[
                'description' => $this->payment->description,
                'amount' => $this->payment->amount
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
        $attachments = [];
        $customPaper = array(0,0,340,190);
        foreach($this->collection->raffleNumbers as $raffleNumber){
            $attachments[] = Attachment::fromData(fn () => Pdf::loadView('pdf.raffles.number',[
                'raffleNumber' => $raffleNumber,
                'collection' => $this->collection
            ])->setPaper($customPaper)->output(),"Rifa-{$raffleNumber->number}.pdf")->withMime('application/pdf');
        }
        return $attachments;
    }
}
