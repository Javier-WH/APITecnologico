<?php

namespace App\Http\Controllers;

use App\Models\SagaAlumnos;
use Illuminate\Http\Request;

class SagaStudentController extends Controller
{

  public function getStudent(Request $request){

    $ci =$request->query('ci');
        //$student = SagaAlumnos::where('cedulapasaporte', $ci)->first();

        $student = SagaAlumnos::join("nacionalidads", "nacionalidads.id", "=", "alumnos.nacionalidad_id")
        ->join("sexos", "sexos.id", "=", "alumnos.sexo_id")
        ->join("parroquias", "parroquias.id", "=", "alumnos.parroquia_id")
        ->join("municipios", "municipios.id", "=", "parroquias.municipio_id")
        ->join("estados", "estados.id", "=", "municipios.estado_id")
        ->join("discapacidads", "discapacidads.id", "=", "alumnos.discapacidad_id")
        ->where('alumnos.cedulapasaporte', $ci)
        ->select(
            'alumnos.id as id',
            'alumnos.cedulapasaporte as cedula',
            'alumnos.nombre as nombre',
            'alumnos.apellido as apellido',
            'alumnos.fechanacimiento  as fecha_nacimiento',
            'alumnos.lugarnacimiento as lugar_nacimiento',
            'alumnos.direccion as direccion',
            'alumnos.telefono1 as telefono',
            'alumnos.telefono2 as telefono2',
            'alumnos.email1 as email',
            'alumnos.email2 as email2',
            'alumnos.provieneinstitucion as institucion_origen',
            'alumnos.fechaegresoinstitucion as fecha_egreso_institucion_origen',
            'alumnos.tienerusnies',
            'alumnos.esrusnies',
            'alumnos.snirusnies',
            'alumnos.semestre',
            'alumnos.opcion',
            'alumnos.esimpedido as impedido',
            'alumnos.dconsignados as documentos_consignados',
            'nacionalidads.des as nacionalidad',
            'sexos.sexo as sexo',
            'parroquias.parroquia as parroquia',
            'municipios.municipio as municipio',
            'estados.estado as estado',
            'discapacidads.describe as discapacidad'

        )
        ->first();

    if(!$student) return jsonResponse(message: "No se encontraron datos", status: 404);

    //hay que normalizar la respuesta por que en la base de datos no tiene entradas normalizadas
    $responseData = normalizeResponseArrayData($student->toArray());

    return jsonResponse(data: $responseData, message: "OK", status: 200);
  }
    
}
