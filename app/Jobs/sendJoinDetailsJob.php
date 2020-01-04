<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendJoinDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $business, $user, $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($business, $user, $code)
    {
        $this->business = $business;
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $business = $this->business;
        $user = $this->user;
        $code = $this->code;

        Mail::send('emails.join-details', compact('user', 'code'), function ($message) use ($business) {
            $message->to($business->email, $business->contact_person)->subject('A new request for accession to the referral program');
        });
    }
}
