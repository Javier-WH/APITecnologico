<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Tests\TestCase;
/*
    Date: june 15 2024
    Created by: Francisco Javier Rodríguez Hernández
    Description: Endpoints unit test for user, administratos and guest for the API Tecnologico
    Version: 1.0
*/
class userTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');

    }

    public function test_an_existging_user_can_login()
    {
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
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
    public function test_an_existging_admin_can_login()
    {
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
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

    public function test_an_existging_guest_can_login()
    {
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
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

    public function test_an_non_existging_user_cannot_login(): void
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



    public function test_an_user_must_be_provided(): void
    {
        $credentials = ['password' => $this::defaultPassword];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['user'],
            'message',
            'status',
            'data'
        ]);
    }


    public function test_a_password_must_be_provided(): void
    {
        $credentials = ['user' => $this::defaultAdmin];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['password'],
            'message',
            'status',
            'data'
        ]);
    }


    public function test_an_user_cannot_be_created_by_user(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
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

    public function test_an_user_cannot_be_created_by_guest(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
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

    public function test_an_user_data_must_be_privided_when_created_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //datos del test
        $data = [
            'password' => 'test1234',
            'level' => '2',
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["user"]
        ]);
    }

    public function test_a_password_data_must_be_privided_when_created_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //datos del test
        $data = [
            'user' => 'TestUser',
            'level' => '2',
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["password"]
        ]);
    }

    public function test_a_level_data_must_be_1_2_3_when_created_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //datos del test
        $data = [
            'user' => 'TestUser',
            'password' => 'test1234',
            'level' => '5',
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["level"]
        ]);
    }

    public function test_a_level_data_must_be_privided_when_created_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //datos del test
        $data = [
            'user' => 'TestUser',
            'password' => 'test1234'
        ];
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/user", $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["level"]
        ]);
    }


    public function test_an_user_can_be_created_by_admin(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
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
        $this->assertDatabaseHas('api_users', ["user" => "TestUser"]);
    }

    public function test_an_user_cannot_be_deleted_by_user(): void
    {

        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', 'TestUser')->first()->id;

        ////////////////////////////////////////////////////////////////////
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

    public function test_an_user_cannot_be_deleted_by_guest(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', 'TestUser')->first()->id;

        /////////////////////////////////////////////////////////////////////

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

    public function test_an_user_id_must_be_provided_when_user_is_deleted_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        /////////////////////////////////////////////////////////////////////

        //datos del test

        $header = [
            'Authorization' => 'Bearer ' . $token
        ];


        $response = $this->withHeaders($header)->deleteJson("{$this->baseUrl}/user", []);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["id"]
        ]);
    }


    public function test_an_user_can_be_deleted_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', 'TestUser')->first()->id;

        /////////////////////////////////////////////////////////////////////

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
        $this->assertDatabaseMissing('api_users', ["user" => "TestUser"]);
    }

    public function test_an_user_data_can_be_shown_by_user(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', $this::defaultAdmin)->first()->id;

        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->withHeaders($header)->getJson("{$this->baseUrl}/user?id=$userID", []);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                "id",
                "user",
                "level",
            ],
            'message',
            'status',
            'errors'
        ]);
    }

    public function test_an_user_data_can_be_shown_by_admin(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultAdmin,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', $this::defaultUser)->first()->id;

        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->withHeaders($header)->getJson("{$this->baseUrl}/user?id=$userID", []);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                "id",
                "user",
                "level",
            ],
            'message',
            'status',
            'errors'
        ]);
    }



    public function test_an_user_data_cannot_be_shown_by_guest(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');

        //obtener el id del usuario de la base de datos
        $userID = User::where('user', $this::defaultUser)->first()->id;

        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->withHeaders($header)->getJson("{$this->baseUrl}/user?id=$userID", []);
        $response->assertStatus(403);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'errors' => ["error"]
        ]);
    }

    //esta funcion limpia todos los registros de la base de datos
    public function test_clean_user_data(): void
    {
        try {
            User::where('user', $this::defaultUser)->delete();
            User::where('user', $this::defaultAdmin)->delete();
            User::where('user', $this::defaultGuest)->delete();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }

    }
}
