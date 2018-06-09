<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
{
    public function testCanCreateRoom()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                        ->post('room/store', [
                            'name' => 'New room'
                        ]);
        
        $this->assertDatabaseHas('rooms', [
            'name' => 'New room',
            'owner_id' => $user->id
        ]);

        $response->assertStatus(302);
        $response->assertLocation('room/index');
    }
}
