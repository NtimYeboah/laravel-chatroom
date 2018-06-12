<?php

namespace App\Events;

use App\Room;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RoomJoined implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * The name of the queue on which to place the event
     */
    public $broadcastQueue = 'events:room-joined';

    /**
     * The user that joined the room
     */
    public $user;

    /**
     * The room the user joined
     */
    public $room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Room $room)
    {
        $this->user = $user;
        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.' . $this->room->id);
    }

    /**
     * The event's broadcast name
     * 
     * @return string
     */
    public function broadcastAs()
    {
        return 'room.joined';
    }
}
