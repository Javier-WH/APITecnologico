<?php

namespace App\Http\Controllers;

use App\Http\Requests\SagaAddStudentRequest;
use App\Http\Requests\SagaFindStudentRequest;
use App\Http\Requests\SagaUpdateStudentRequest;
use App\Models\SagaAlumnos;
use Exception;

class SagaStudentController extends Controller
{

    public function getStudent(SagaFindStudentRequest $request)
    {

        $request->validated();

        $ci = $request->query('ci');

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

        //hay que normalizar la respuesta por que en la base de datos no tiene entradas normalizadas
        $responseData = normalizeResponseArrayData($student->toArray());

        return jsonResponse(data: $responseData, message: "OK", status: 200);
    }

    public function addStudent(SagaAddStudentRequest $request)
    {
        $data = $request->all();
        //campos que requiere la base de datos por que no tienen valor por defecto, sin estos campos la base de datos no inserta el registro
        $data['CodigoCuidad'] = "";
        $data['DescripcionMunicipio'] = "";
        $data['CodigoOpsu'] = "";
        $data['Observacion'] = "";
        $data['CodigoCarnet'] = "";
        $data['estatus'] = "";

        $student = SagaAlumnos::create($data);
        return jsonResponse(data: $student, message: "El alumno fue creado con exito", status: 201);
    }

    public function deleteStudent(SagaFindStudentRequest $request)
    {
        $request->validated();
        $ci = $request->query('ci');
        $student = SagaAlumnos::where('cedulapasaporte', $ci)->first();
        $student->delete();
        return jsonResponse(message: "El alumno fue borrado con exito", status: 201);
    }

    public function updateStudent(SagaUpdateStudentRequest $request)
    {
        $data = $request->all();
        $ci = $request->query('ci');
        $student = SagaAlumnos::where('cedulapasaporte', $ci)->first();
        $student->update($data);
        return jsonResponse(status: 204);
    }
}
