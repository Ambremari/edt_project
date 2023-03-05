<?php

namespace App\Events;

use App\Models\StudentsGroups;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentsGroupsCreatingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $compoGroupes;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(StudentsGroups $compoGroupes)
    {
        $this->compoGroupes = $compoGroupes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
