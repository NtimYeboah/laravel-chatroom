<?php

namespace Tests\Unit;

use App\User;
use App\Room;
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
}
