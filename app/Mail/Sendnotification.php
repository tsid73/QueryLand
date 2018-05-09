<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Sendnotification extends Mailable implements ShouldQueue
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
        if(empty($this->vara['re']->ques_heading))
        {
        $url = url('/questions/'.$this->vara['re']->slug);
        return $this->markdown('emails.approve')->with('url',$url)
            ->subject($this->vara['subject']);
        }
        else{
         return $this->view('emails.approve')->with('ques',$this->vara['re']->ques_heading)
             ->subject($this->vara['subject']);
        }
    }
}
