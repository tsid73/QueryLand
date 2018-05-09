<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Ansdel extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $vara;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vara)
    {
        $this->vara = $vara;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->view('emails.ansdelete')->with('ques',$this->vara['re']->ques_heading)
             ->subject($this->vara['subject']);
    }
}
