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
            'user' => 'TestUser',
            'password' => 'test1234',
        ];

        $response = $this->postJson("{$this->baseUrl}/login", $credentials);

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
            'user' => 'falso@correoFalso.com',
            'password' => 'unknown1234',
        ];

        $response = $this->postJson("{$this->baseUrl}/login", $credentials);


        $response->assertStatus(401);
        $response->assertJsonFragment([
            'status' => 401,
            'message' => 'Credenciales Invalidas',
            'errors' => ['unauthorized' => 'Credenciales Invalidas']
        ]);
    }

    /**
     * @test
     */
    public function an_user_must_be_provided(): void
    {
        $credentials = ['password' => 'testPassword'];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
       // $response->dd();
        $response->assertStatus(422);  
        $response->assertJsonStructure([
            'errors' => ['user'],
            'message',
            'status',
            'data'
        ]);
       
    }

    /**
     * @test
     */
    public function a_password_must_be_provided(): void
    {
        $credentials = ['user' => 'testUser'];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        //$response->dd();
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['password'],
            'message',
            'status',
            'data'
        ]);
     
    }
}
