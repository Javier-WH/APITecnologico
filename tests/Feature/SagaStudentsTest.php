<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
/*
    Date: june 15 2024
    Created by: Francisco Javier Rodríguez Hernández
    Description: Endpoints unit test for SAGA Students for the API Tecnologico
    Version: 1.0
*/

class SagaStudentsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_an_admin_can_get_student_info(): void
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
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $response = $this->withHeaders($header)->getJson("{$this->baseUrl}/student?ci=25664254", []);
        //dd($response->json());
        $response->assertStatus(200);
        $response->assertJsonStructure($this->expectedGetStudentsResponse);
    }

    public function test_an_user_can_get_student_info(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////


        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $response = $this->withHeaders($header)->getJson("{$this->baseUrl}/student?ci=16193765", []);

        $response->assertStatus(200);
        $response->assertJsonStructure($this->expectedGetStudentsResponse);
    }

    public function test_a_guest_can_get_student_info(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////


        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $response = $this->withHeaders($header)->getJson("{$this->baseUrl}/student?ci=16193765", []);

        $response->assertStatus(200);
        $response->assertJsonStructure($this->expectedGetStudentsResponse);
    }

    public function test_an_guest_cannot_create_student(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $body = [
            "cedulapasaporte" => "3333",
            "nombre" => "guestCreation",
            "apellido" => "guestCreation",
            "nacionalidad_id" => "1",
            "sexo_id" => "1",
            "fechanacimiento" => "2001-01-01",
            "lugarnacimiento" => "Altagracia de Orituco",
            "direccion" => "Calle Sucre N°11",
            "parroquia_id" => "2",
            "telefono1" => "041455545",
            "telefono2" => "52656265",
            "email1" => "fddsfdsf",
            "email2" => "dfdsfds",
            "provieneinstitucion" => "dsfdsfdsfdsfsd",
            "fechaegresoinstitucion" => "2012-12-23",
            "tienerusnies" => 1,
            "esrusnies" => 0,
            "snirusnies" => "213213",
            "semestre" => "dsfdsf",
            "opcion" => "3424324",
            "esimpedido" => "NO",
            "discapacidad_id" => "1",
            "etnia_id" => "0"
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/student", $body);

        $response->assertStatus(403);
        $response->assertJsonStructure([
            "data" => [],
            'message',
            'status',
            'errors' =>["error"]
        ]);
        $this->assertDatabaseMissing('alumnos', ["cedulapasaporte" => "3333"]);
    }

    public function test_an_user_can_create_student(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $body = [
            "cedulapasaporte" => "2222",
            "nombre" => "userCreation",
            "apellido" => "userCreation",
            "nacionalidad_id" => "1",
            "sexo_id" => "1",
            "fechanacimiento" => "2001-01-01",
            "lugarnacimiento" => "Altagracia de Orituco",
            "direccion" => "Calle Sucre N°11",
            "parroquia_id" => "2",
            "telefono1" => "041455545",
            "telefono2" => "52656265",
            "email1" => "fddsfdsf",
            "email2" => "dfdsfds",
            "provieneinstitucion" => "dsfdsfdsfdsfsd",
            "fechaegresoinstitucion" => "2012-12-23",
            "tienerusnies" => 1,
            "esrusnies" => 0,
            "snirusnies" => "213213",
            "semestre" => "dsfdsf",
            "opcion" => "3424324",
            "esimpedido" => "NO",
            "discapacidad_id" => "1",
            "etnia_id" => "0"
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/student", $body);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data" => [
                "cedulapasaporte",
                "nombre",
                "apellido",
                "nacionalidad_id",
                "sexo_id",
                "fechanacimiento",
                "lugarnacimiento",
                "direccion",
                "parroquia_id",
                "telefono1",
                "telefono2",
                "email1",
                "email2",
                "provieneinstitucion",
                "fechaegresoinstitucion",
                "tienerusnies",
                "esrusnies",
                "snirusnies",
                "semestre",
                "opcion",
                "esimpedido",
                "discapacidad_id",
                "etnia_id",
                "user_id",
                "CodigoCuidad",
                "DescripcionMunicipio",
                "CodigoOpsu",
                "Observacion",
                "CodigoCarnet",
                "estatus",
                "id",

            ],
            'message',
            'status',
            'errors'
        ]);
        $this->assertDatabaseHas('alumnos', ["cedulapasaporte" => "2222"]);
    }

    public function test_an_admin_can_create_student(): void
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
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $body = [
            "cedulapasaporte" => "1111",
            "nombre" => "adminCreation",
            "apellido" => "adminCreation",
            "nacionalidad_id" => "1",
            "sexo_id" => "1",
            "fechanacimiento" => "2001-01-01",
            "lugarnacimiento" => "Altagracia de Orituco",
            "direccion" => "Calle Sucre N°11",
            "parroquia_id" => "2",
            "telefono1" => "041455545",
            "telefono2" => "52656265",
            "email1" => "fddsfdsf",
            "email2" => "dfdsfds",
            "provieneinstitucion" => "dsfdsfdsfdsfsd",
            "fechaegresoinstitucion" => "2012-12-23",
            "tienerusnies" => 1,
            "esrusnies" => 0,
            "snirusnies" => "213213",
            "semestre" => "dsfdsf",
            "opcion" => "3424324",
            "esimpedido" => "NO",
            "discapacidad_id" => "1",
            "etnia_id" => "0"
        ];

        $response = $this->withHeaders($header)->postJson("{$this->baseUrl}/student", $body);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data" => [
                "cedulapasaporte",
                  "nombre",
                  "apellido",
                  "nacionalidad_id",
                  "sexo_id",
                  "fechanacimiento",
                  "lugarnacimiento",
                  "direccion",
                  "parroquia_id",
                  "telefono1",
                  "telefono2",
                  "email1",
                  "email2",
                  "provieneinstitucion",
                  "fechaegresoinstitucion",
                  "tienerusnies",
                  "esrusnies",
                  "snirusnies",
                  "semestre",
                  "opcion",
                  "esimpedido",
                  "discapacidad_id",
                  "etnia_id",
                  "user_id",
                  "CodigoCuidad",
                  "DescripcionMunicipio",
                  "CodigoOpsu",
                  "Observacion",
                  "CodigoCarnet",
                  "estatus",
                  "id",

            ],
            'message',
            'status',
            'errors'
        ]);
        $this->assertDatabaseHas('alumnos', ["cedulapasaporte" => "1111"]);
    }



    public function test_an_guest_cannot_update_student(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $body = [
            "nombre" => "userUpdate",
            "apellido"=> "userUpdate",
            "nacionalidad_id"=> "1",
            "sexo_id"=> "1",
            "fechanacimiento"=> "2001-01-01",
            "lugarnacimiento"=> "Altagracia de Orituco",
            "direccion"=> "Calle Sucre N°11",
            "parroquia_id"=> "2",
            "telefono1"=> "041455545",
            "telefono2"=> "52656265",
            "email1"=> "fddsfdsf",
            "email2"=> "dfdsfds",
            "provieneinstitucion"=> "dsfdsfdsfdsfsd",
            "fechaegresoinstitucion"=> "2012-12-23",
            "tienerusnies"=> 1,
            "esrusnies"=> 0,
            "snirusnies"=> "213213",
            "semestre"=> "dsfdsf",
            "opcion"=> "3424324",
            "esimpedido"=> "NO",
            "discapacidad_id"=> "1",
            "etnia_id"=> "0",
            "user_id"=> "1"
        ];


        $response = $this->withHeaders($header)->putJson("{$this->baseUrl}/student?ci=2222", $body);
        $response->assertStatus(403);
        $response->assertJsonStructure([
            "data",
            'message',
            'status',
            'errors' => ["error"]
        ]);

    }

    public function test_an_user_can_update_student(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $body = [
            "nombre" => "userUpdate",
            "apellido" => "userUpdate",
            "nacionalidad_id" => "1",
            "sexo_id" => "1",
            "fechanacimiento" => "2001-01-01",
            "lugarnacimiento" => "Altagracia de Orituco",
            "direccion" => "Calle Sucre N°11",
            "parroquia_id" => "2",
            "telefono1" => "041455545",
            "telefono2" => "52656265",
            "email1" => "fddsfdsf",
            "email2" => "dfdsfds",
            "provieneinstitucion" => "dsfdsfdsfdsfsd",
            "fechaegresoinstitucion" => "2012-12-23",
            "tienerusnies" => 1,
            "esrusnies" => 0,
            "snirusnies" => "213213",
            "semestre" => "dsfdsf",
            "opcion" => "3424324",
            "esimpedido" => "NO",
            "discapacidad_id" => "1",
            "etnia_id" => "0",
            "user_id" => "1"
        ];


        $response = $this->withHeaders($header)->putJson("{$this->baseUrl}/student?ci=2222", $body);
        $response->assertStatus(204);

    }

    public function test_an_admin_can_update_student(): void
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
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $body = [
            "nombre" => "userUpdate",
            "apellido" => "userUpdate",
            "nacionalidad_id" => "1",
            "sexo_id" => "1",
            "fechanacimiento" => "2001-01-01",
            "lugarnacimiento" => "Altagracia de Orituco",
            "direccion" => "Calle Sucre N°11",
            "parroquia_id" => "2",
            "telefono1" => "041455545",
            "telefono2" => "52656265",
            "email1" => "fddsfdsf",
            "email2" => "dfdsfds",
            "provieneinstitucion" => "dsfdsfdsfdsfsd",
            "fechaegresoinstitucion" => "2012-12-23",
            "tienerusnies" => 1,
            "esrusnies" => 0,
            "snirusnies" => "213213",
            "semestre" => "dsfdsf",
            "opcion" => "3424324",
            "esimpedido" => "NO",
            "discapacidad_id" => "1",
            "etnia_id" => "0",
            "user_id" => "1"
        ];


        $response = $this->withHeaders($header)->putJson("{$this->baseUrl}/student?ci=2222", $body);
        $response->assertStatus(204);
    }



    public function test_an_guest_cannot_delete_student(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultGuest,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];


        $response = $this->withHeaders($header)->deleteJson("{$this->baseUrl}/student?ci=2222", []);
        $response->assertStatus(403);
        $response->assertJsonStructure([
            "data",
            'message',
            'status',
            'errors' => ["error"]
        ]);
        $this->assertDatabaseHas('alumnos', ["cedulapasaporte" => "2222"]);
    }


    public function test_an_user_can_delete_student(): void
    {
        //obtener el token de validacion
        $credentials = [
            'user' => $this::defaultUser,
            'password' => $this::defaultPassword,
        ];
        $response = $this->postJson("{$this->baseUrl}/login", $credentials);
        $token = $response->json('data.token');
        /////////////////////////////////////////////////////////////////////

        //datos del test
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];


        $response = $this->withHeaders($header)->deleteJson("{$this->baseUrl}/student?ci=2222", []);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data",
            'message',
            'status',
            'errors'
        ]);
        $this->assertDatabaseMissing('alumnos', ["cedulapasaporte" => "2222"]);
    }

    public function test_an_admin_can_delete_student(): void
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
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];


        $response = $this->withHeaders($header)->deleteJson("{$this->baseUrl}/student?ci=1111", []);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data",
            'message',
            'status',
            'errors'
        ]);
        $this->assertDatabaseMissing('alumnos', ["cedulapasaporte" => "1111"]);
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
