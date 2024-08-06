<?php

namespace App\Jobs;

use App\Mail\sendBulkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class VerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $email;
    public $emailContent;
    public $attachment;
    
    public function __construct($email,
    $emailContent,
    $attachment=null
    )
    {
        $this->email = $email;
        $this->emailContent = $emailContent;
        $this->attachment = $attachment;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        // if attachment is not null then send email with attachment
        Mail::to($this->email)->send(new sendBulkMail($this->email, $this->emailContent,$this->attachment));
    }

}