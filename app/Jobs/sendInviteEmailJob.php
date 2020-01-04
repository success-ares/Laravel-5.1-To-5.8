<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendInviteEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $biz, $parent;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $biz, $parent)
    {
        $this->user = $user;
        $this->biz = $biz;
        $this->parent = $parent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $biz = $this->biz;
        $parent = $this->parent;

        Mail::send('emails.refer-invite', compact('user', 'biz', 'parent'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('Accept Invitation');
        });
    }
}
