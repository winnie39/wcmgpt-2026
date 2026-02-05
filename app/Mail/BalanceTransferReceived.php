<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BalanceTransferReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public function __construct($senderId, $receiverId, $amount)
    {
        $this->data['receiver'] = User::find($receiverId);
        $this->data['sender'] = User::find($senderId);
        [$charge['percentage'], $charge['flatFee']] = explode('%', env('TRANSFER_FEE', '0.1%0'));
        $totalCharge = ($charge['percentage'] * $amount) + $charge['flatFee'];
        $this->data['charge'] = $totalCharge;
        $this->data['amount'] = $amount;
        $this->data['amountAfterDeductions'] = $amount - $totalCharge;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Balance Transfer Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.balance-transfer-received',
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
