<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = '/api/v1';
    const defaultAdmin = "defaultAdmin";
    const defaultUser = "defaultUser";
    const defaultGuest = "defaultGuest";
    const defaultPassword = "123456789";

    //Esta es la respuesta esperada si se hace un get a /api/v1/students y no hay ningun error
    protected $expectedGetStudentsResponse = [
        "data" => [
            "id",
            "cedula",
            "nombre",
            "apellido",
            "fecha_nacimiento",
            "lugar_nacimiento",
            "direccion",
            "telefono",
            "telefono2",
            "email",
            "email2",
            "institucion_origen",
            "fecha_egreso_institucion_origen",
            "tienerusnies",
            "esrusnies",
            "snirusnies",
            "semestre",
            "opcion",
            "impedido",
            "documentos_consignados",
            "nacionalidad",
            "sexo",
            "parroquia",
            "municipio",
            "estado",
            "discapacidad",
            "periodo_academico",
            "programa"
        ],
        'message',
        'status',
        'errors'
    ];

}
