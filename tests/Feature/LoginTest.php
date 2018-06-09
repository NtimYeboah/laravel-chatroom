<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    public function testCanLogin()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->email, 
            'password' => $user->password
        ]);

        $response->assertStatus(302);
    }
}
