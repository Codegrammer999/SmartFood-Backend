<?php

namespace App\Listeners;

use App\Events\NewReferral;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUuserNewReferral
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewReferral $event): void
    {
        //
    }
}
