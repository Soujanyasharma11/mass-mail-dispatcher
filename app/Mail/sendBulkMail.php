<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class sendBulkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $emailContent;
    public $attachment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, 
    $emailContent,
    $attachment=null
    )
    {
        $this->name = $name;
        $this->emailContent = $emailContent;
        // (isset($attachement)) ? $this->attachement = $attachement : $this->attachement = null;
        $this->attachment = $attachment;
    }
    
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $getAttachmentName=explode('/',$this->attachment);
        // dd($getAttachmentName[1]);
        
        $sendMail= $this->markdown('emails.welcome')
        ->attach(public_path('attachment/').$getAttachmentName[1])
        ->subject('Welcome to this proj')
        ;
        return $sendMail; 
    }

}