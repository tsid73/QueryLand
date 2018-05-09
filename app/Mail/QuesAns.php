<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuesAns extends Mailable implements ShouldQueue
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
        $url = url('/questions/'.$this->vara['re']->slug);
        return $this->markdown('emails.userans')->with('url',$url)
             ->subject("Your Question Updates");
    }
}
