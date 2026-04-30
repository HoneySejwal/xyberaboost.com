<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RedeemConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
     public function __construct($redeemed) {
        $this->redeemed= $redeemed;
    }

     public function build() {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Game Redemption Confirmation !!!')
                    ->view('emails.redeem')
                      ->with([
                              'order' => $this->redeemed ?? 'N/A',
                              'game_name'  => $this->redeemed->product->title,
                              'points' => $this->redeemed->price,
                         ]);
    }

    

    /**
     * Get the message content definition.
     */
    

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
