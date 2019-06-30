<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $msg;
    public function __construct($name ,$msg)
    {
        $this->msg=$msg;
        $this->$name=$name;

    }

    public function build()
    {
        return $this->view('emailMsg');
    }
}
