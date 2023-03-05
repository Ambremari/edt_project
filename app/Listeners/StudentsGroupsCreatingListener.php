<?php

namespace App\Listeners;

use App\Events\StudentsGroupsCreatingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StudentsGroupsCreatingListener
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
     * @param  \App\Events\StudentsGroupsCreatingEvent  $event
     * @return void
     */
    public function handle(StudentsGroupsCreatingEvent $event)
    {
        //
    }
}
