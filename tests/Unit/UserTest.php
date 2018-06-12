<?php

namespace Tests\Unit;

use App\User;
use App\Room;
use App\Message;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $room;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->room = factory(Room::class)->create();
    }

    public function testCanAddRoom()
    {
        $this->user->addRoom($this->room);

        $found = $this->user->rooms->where('id', $this->room->id)->first();

        $this->assertInstanceOf(Room::class, $found);
        $this->assertEquals($this->room->id, $found->id);
    }

    public function testUserHasJoinedRoom()
    {
        $this->room->join($this->user);

        $this->assertTrue($this->user->hasJoined($this->room->id));
    }
}
