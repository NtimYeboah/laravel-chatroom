<?php

namespace App\Events;

use App\Room;
use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageCreated implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    /**
     * The queue on which to broadcast the event
     */
    public $broadcastQueue = 'events:message-created';

    /**
     * The message to be broadcasted
     */
    public $message;
    
    /**
     * The room on which to broadcast the message
     */
    public $room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, Room $room)
    {
        $this->message = $message;
        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.' . $this->room->id . '.message');
    }

    /**
     * The event's broadcast name
     * 
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.created';
    }
}
