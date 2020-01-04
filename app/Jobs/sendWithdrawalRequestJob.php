<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendWithdrawalRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin, $user, $amount, $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($admin, $user, $amount, $id)
    {
        $this->admin = $admin;
        $this->user = $user;
        $this->amount = $amount;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admin = $this->admin;
        $user = $this->user;
        $amount = $this->amount;
        $id = $this->id;

        Mail::send('emails.withdrawal', compact('user', 'amount', 'id'), function ($message) use ($admin) {
            $message->to($admin->email, $admin->first_name)->subject('Confirm withdrawal of funds');
        });
    }
}
