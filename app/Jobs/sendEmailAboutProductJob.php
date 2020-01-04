<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendEmailAboutProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $seller, $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $seller, $product)
    {
        $this->user = $user;
        $this->seller = $seller;
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $seller = $this->seller;
        $product = $this->product;
        
        Mail::send('emails.about-product', compact('seller', 'product'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('You were added to referral program.');
        });
    }
}
