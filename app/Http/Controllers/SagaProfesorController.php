<?php

namespace App\Http\Controllers;

use App\Models\SagaProfesors;


class SagaProfesorController extends Controller {
    public function getTeachers() {
        $data = SagaProfesors::all();
        return jsonResponse(status: 200, message: "Profesores obtenidos con exito", data: $data);
    }
}
