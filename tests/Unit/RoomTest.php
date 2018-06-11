<?php

namespace Tests\Unit;

use App\User;
use App\Room;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
{
    use RefreshDatabase;
    
    public function testUserCanJoinRoom()
    {
        $user = factory(User::class)->create();
        
        $room = factory(Room::class)->create();
        $room->join($user);

        $found = $room->users->where('id', $user->id)->first();

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);  
    }
}
