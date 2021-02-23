<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Auth;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $random;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($random)
    {
        $this->random = $random;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $member = Auth::user()->name;
        
        return $this->markdown('emails.verification')
        ->subject('Leemon Codigo de Verificación')
        ->with(['member_name' => $member
        ,'radomNum' => $this->random]);
    }
}
