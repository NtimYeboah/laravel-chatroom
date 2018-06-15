<?php

namespace Tests\Feature;

use App\User;
use App\Room;
use App\Message;
use Tests\TestCase;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateAMessage()
    {
        $user = factory(User::class)->create();
        $room = factory(Room::class)->create();

        $response = $this->actingAs($user)
                        ->post('messages/store', [
                            'body' => 'Hi, there!',
                            'room_id' => $room->id
                        ]);

        $this->assertDatabaseHas('messages', [
            'body' => 'Hi, there!',
            'room_id' => $room->id
        ]);
        
        $response->assertStatus(201);
    }

    public function testCanBroadcastMessage()
    {
        Event::fake();

        $user = factory(User::class)->create();
        $room = factory(Room::class)->create();

        $response = $this->actingAs($user)
                        ->post('messages/store', [
                            'body' => 'Hi, there',
                            'room_id' => $room->id
                        ]);

        $message = Message::first();

        Event::assertDispatched(MessageCreated::class, function ($e) use($message, $room) {
            return $e->message->id === $message->id && 
                $e->room->id === $room->id;
        });
    }
}
