<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_user_can_register(): void
    {
        //$this->withoutExceptionHandling();
        $data = [
            'user' => 'TestUser2',
            'password' => 'test1234',
            'level' => '1',
        ];
        
        $response = $this->postJson("{$this->baseUrl}/users", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('api_users',["user" => "TestUser2"]);

    }
}
