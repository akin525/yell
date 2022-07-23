<?php

namespace App\Mail;

use App\Console\encription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Emailtrans extends Mailable
{
    use Queueable, SerializesModels;
    protected $bo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bo)
    {
        $this->bo = $bo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $bo= $this->bo;
        return $this->markdown('email.tran',['bo' => $bo])->subject(   encription::decryptdata($bo['username']).' |Email-Transaction|'.'Reno-'. $bo['transactionid']);
    }
}
