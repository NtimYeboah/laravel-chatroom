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

    public function testHasManyRelationshipWithRoom()
    {
        $user = factory(User::class)->create();

        $rooms = factory(Room::class, 3)->create([
            'owner_id' => $user->id
        ]);

        $this->assertCount(3, $user->rooms);
    }

    public function testHasManyRelationshipWithMessage()
    {
        $user = factory(User::class)->create();

        $messages = factory(Message::class, 3)->create([
            'user_id' => $user->id
        ]);

        $this->assertCount(3, $user->messages);
    }
}
