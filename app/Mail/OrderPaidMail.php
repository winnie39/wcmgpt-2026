<?php

namespace App\Mail;

use App\Models\Trade;
use App\Models\TradeLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private $startTime;
    public $data;
    public function __construct($userId)
    {
        $trade = Trade::where('user_id', $userId)->first();
        $undefined = 'waiting...';
        $firstLog = TradeLog::where('user_id', $userId)->orderBy('created_at', 'asc')->first();
        $this->startTime = Carbon::parse($firstLog ? $firstLog->bot_closing_time : now())->subDay();
        $tradeLogs = TradeLog::where('user_id', $userId)->orderBy('created_at', 'asc')->get()->map(function ($value) use ($trade, $undefined) {
            $data =   [
                'actual_profits_and_loss' => $trade->stake * $value->rate / 100  ?? $undefined,
                'status' => $trade->status ?? $undefined,
                'rate' => $value->rate,
                'order_profit_and_loss' => 0 ?? $undefined,
                'deferred_fee' => 0 ?? $undefined,
                'handling_fee' => 0 ?? $undefined,
                'order_id' => $value->order_id,
                'margin' => $trade->stake,
                'bot_start_time' => $this->startTime . ' UTC' ?? $undefined,
                'bot_close_time' => $value->bot_closing_time . ' UTC' ?? $undefined,
                'order_type' =>  $value->type  ?? $undefined,
                'symbol' => $value->symbol ?? $undefined,
                'occupy_margin' => $value->stake ?? $undefined,
                'session_open_price' => $value->session_opening_price ?? $undefined,
                'session_close_price' => $value->session_closing_price ?? $undefined,
                'session_open_time' => $value->session_open_time,
                'session_close_time' => $value->session_close_time,
            ];

            $this->startTime = $value->bot_closing_time;

            return $data;
        });

        $tradeLogs = $tradeLogs->reverse();
        $this->data['order'] = $tradeLogs->first();
        $this->data['userId'] = $userId;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ' Bot Payment Confirmation - Order Details',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order-paid-mail',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
