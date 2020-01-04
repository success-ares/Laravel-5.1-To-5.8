<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendAuthorityRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin, $directDebit, $biz;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($admin, $directDebit, $biz)
    {
        $this->admin = $admin;
        $this->directDebit = $directDebit;
        $this->biz = $biz;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admin = $this->admin;
        $directDebit = $this->directDebit;
        $biz = $this->biz;

        Mail::send('emails.direct-authority', compact('directDebit', 'biz'), function ($message) use ($admin, $biz) {
            $message->to($admin->email, $admin->first_name)->subject($biz->biz_name . ' has submitted a direct debit authority request');
        });
    }
}
