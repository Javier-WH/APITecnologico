<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * @test
     */
    public function an_existging_user_can_login(): void
    {
       
        $credentials = [
            'email' => 'test@test.com',
            'password' => 'test1234',
        ];

        $response = $this->post("{$this->baseUrl}/login", $credentials);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }

    /**
     * @test
     */
    public function an_non_existging_user_cannot_login(): void
    {

        $credentials = [
            'email' => 'falso@correoFalso.com',
            'password' => 'unknown1234',
        ];

        $response = $this->post("{$this->baseUrl}/login", $credentials);


        $response->assertStatus(401);
        $response->assertJsonFragment([
            'status' => 401,
            'message' => 'Credenciales Invalidas',
            'errors' => ['unauthorized' => 'Credenciales Invalidas']
        ]);
    }
}
