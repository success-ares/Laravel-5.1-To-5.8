<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendToReferralJob implements ShouldQueue
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
        $user = $this->user;
        $refer = $this->refer;

        Mail::send('emails.to-referral', compact('refer'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('Referred company details');
        });
    }
}
