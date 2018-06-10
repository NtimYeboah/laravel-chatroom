<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
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
            'description' => 'This is a new room',
            'owner_id' => $user->id
        ]);
    }
}
