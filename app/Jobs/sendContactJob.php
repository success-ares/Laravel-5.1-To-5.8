<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin, $m;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($admin, $m)
    {
        $this->admin = $admin;
        $this->m = $m;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admin = $this->admin;
        $m = $this->m;

        Mail::send('emails.contact', compact('m'), function ($message) use ($admin) {
            $message->to($admin->email, $admin->first_name)->subject('[Pyramd] Contact form');
        });
    }
}
