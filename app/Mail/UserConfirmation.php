<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $messaggio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($new_message)
     {
         $this->messaggio = $new_message;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@sito.com')
        ->subject('Abbiamo ricevuto il tuo messaggio')
        ->view('mail.conferma-utente');
    }
}
