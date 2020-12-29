<?php

namespace App\Mail;

use App\Claim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Claim $claim)
    {
        $this->claim = $claim;
        $this->id = $claim->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.claim-reply')->subject("Odpowiedź na zgłoszenie #$this->id")->with(['claim' => $this->claim]);
    }
}
