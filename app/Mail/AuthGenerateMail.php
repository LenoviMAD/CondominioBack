<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthGenerateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $distressCall;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.create_auth')
            ->subject('Prueba de correo')
            ->with([
                "email" => $this->email,
                "password" => $this->password,
            ]);
    }
}
