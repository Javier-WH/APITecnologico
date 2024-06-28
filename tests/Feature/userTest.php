<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;


class userTest extends TestCase
{

    /**
     * @test
    */
    public function an_existging_user_can_login()
    {
        $credentials = [
            'user' => 'Admin',
            'password' => '123456789',
        ];

        $response = $this->postJson("{$this->baseUrl}/login", $credentials);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
                'expires_in',
                'id'
            ],
            'status',
            'message',
            'errors'
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
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['password'],
            'message',
            'status',
            'data'
        ]);
    }

    /**
     * @test
     */
    public function an_user_cannot_be_created_by_user(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => 'user',
            'password' => 'user123456',
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //datos del test
        $data = [
            'user' => 'TestUser2',
            'password' => 'test1234',
            'level' => '1',
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(403);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["error"]
        ]);
        $this->assertDatabaseMissing('api_users', ["user" => "TestUser2"]);
    }

    /**
     * @test
     */
    public function an_user_can_be_created_by_admin(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => 'Admin',
            'password' => '123456789',
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //datos del test
        $data = [
            'user' => 'TestUser',
            'password' => 'test1234',
            'level' => '2',
        ];
        $header = [
           'Authorization' => 'Bearer ' . $token,
           'Content-Type' => 'application/json',
           'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['user_id'],
            'message',
            'status',
            'errors'
        ]);
        $this->assertDatabaseHas('api_users',["user" => "TestUser"]);

    }


    /**
     * @test
     */
    public function an_user_cannot_be_deleted_by_user(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => 'user',
            'password' => 'user123456',
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', 'TestUser')->first()->id;


        //datos del test
        $data = [
            'id' => $userID
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->withHeaders($header)->deleteJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(403);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["error"]
        ]);
        $this->assertDatabaseHas('api_users', ["user" => "TestUser"]);
    }


    /**
     * @test
     */
    public function an_user_can_be_deleted_by_admin(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => 'Admin',
            'password' => '123456789',
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', 'TestUser')->first()->id;


        //datos del test
        $data = [
            'id' => $userID
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->withHeaders($header)->deleteJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ["user_id"],
            'message',
            'status',
            'errors'
        ]);
        $this->assertDatabaseMissing('api_users',["user" => "TestUser"]);
    }


}
