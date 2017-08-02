<?php

namespace App\Listeners;

use App\Events\DrcEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DrcListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DrcEvent  $event
     * @return void
     */
    public function handle(DrcEvent $event)
    {
        echo $event->jzh->name;
    }
}
