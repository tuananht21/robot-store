<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckoutEmail implements ShouldQueue
{
    use Queueable;
    private $user;
    private $order;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $order)
    {
        //
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->user->email)->send(new OrderConfirmation($this->order));
    }
}
