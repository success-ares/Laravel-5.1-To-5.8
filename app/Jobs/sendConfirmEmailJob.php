<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class sendConfirmEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $refer;
  
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $refer)
    {
        $this->user = $user;
        $this->refer = $refer;
    }
   
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new sendConfirmEmail($this->user,$this->refer);
        // Mail::to(($this->user)->email)->send($email)->subject("Please confirm your email address");
        $user = $this->user;
        $refer = $this->refer;
        Mail::send('emails.activate', compact('user', 'refer'), function ($message) use ($user) {
                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Please confirm your email address');
            });
    }
}
