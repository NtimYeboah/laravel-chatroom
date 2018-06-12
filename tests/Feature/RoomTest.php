<?php

namespace Tests\Feature;

use App\User;
use App\Room;
use Tests\TestCase;
use App\Events\RoomJoined;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateRoom()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                        ->post('rooms/store', [
                            'name' => 'New room',
                            'description' => 'This is a new room'
                        ]);
        
        $this->assertDatabaseHas('rooms', [
            'name' => 'New room',
            'description' => 'This is a new room'
        ]);
    }

    public function testCanBroadcastRoomJoinedEvent()
    {
        Event::fake();

        $user = factory(User::class)->create();
        $room = factory(Room::class)->create();

        $response = $this->actingAs($user)
                        ->post('rooms/' . $room->id . '/join');

        Event::assertDispatched(RoomJoined::class, function($e) use ($user, $room) {
            return $e->user->id === $user->id &&
                $e->room->id === $room->id;
        });
    }
}
