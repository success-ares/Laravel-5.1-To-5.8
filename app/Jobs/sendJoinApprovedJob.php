<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendJoinApprovedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $bizName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $bizName)
    {
        $this->user = $user;
        $this->bizName = $bizName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $bizName = $this->bizName;

        Mail::send('emails.join-approved', compact('bizName'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('A new request for accession to the referral program');
        });
    }
}
