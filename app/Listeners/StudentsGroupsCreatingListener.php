<?php

namespace App\Listeners;

use App\Events\StudentsGroupsCreatingEvent;
use App\Models\Groups;
use App\Models\LinksGroups;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Students;

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
        echo '<script>console.log("Welcome to GeeksforGeeks!"); </script>';
        $student = Students::where('IdEleve', $event->compoGroupes->IdEleve)
                             ->get();
        $group = Groups::where('IdGrp', $event->compoGroupes['IdGrp'])
                         ->get();
        $divisions = LinksGroups::where('IdGrp', $event->compoGroupes['IdGrp'])
                                  ->get();
        if($divisions->contains([$student['IdDiv'], $group['IdGrp']]))
            $event->compoGroupes->save();
    }
}
