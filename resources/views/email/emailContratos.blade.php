<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class emailContratos extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
		
    }

    public function build()
    {
        return $this->view('email.contatoEmail');
    }
}
