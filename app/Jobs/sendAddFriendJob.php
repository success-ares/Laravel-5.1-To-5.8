<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendAddFriendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $from;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $from)
    {
        $this->email = $email;
        $this->from = $from;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        $from = $this->from;

        Mail::send('emails.add-friend', compact('from'), function ($message) use ($email, $from) {
            $message->to($email)->subject($from->first_name . ' ' . $from->last_name . ' has invited you to join Pyramd');
        });
    }
}
