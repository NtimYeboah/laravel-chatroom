<?php

namespace Tests\Feature;

use App\User;
use App\Room;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    public function testCanCreateAMessage()
    {
        $user = factory(User::class)->create();
        $room = factory(Room::class)->create();

        $response = $this->actingAs($user)
                        ->post('messages/store/' . $room->id, [
                            'body' => 'Hi, there!'
                        ]);

        $this->assertDatabaseHas('messages', [
            'body' => 'Hi, there!'
        ]);

        $response->assertStatus(200);
    }
}
