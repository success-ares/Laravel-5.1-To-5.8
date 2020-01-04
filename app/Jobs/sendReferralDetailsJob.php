<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendReferralDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $biz, $referral, $refId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $biz, $referral, $refId)
    {
        $this->user = $user;
        $this->biz = $biz;
        $this->referral = $referral;
        $this->refId = $refId;
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
        $referral = $this->referral;
        $refId = $this->refId;

        Mail::send('emails.refer-detail', compact('user', 'referral', 'refId'), function ($message) use ($biz) {
            $message->to($biz->email, $biz->biz_name)->subject('Added new referral');
        });
    }
}
