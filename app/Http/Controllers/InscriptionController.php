<?php

namespace App\Http\Controllers;

use App\Models\SagaInscriptions;
use App\Models\SagaPensums;
use App\Models\SagaPrelacions;
use App\Models\SagaProgramas;
use App\Models\SagaTrayectos;
use App\Models\SagaTurnos;
use App\Models\SagaUcs;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller {

    public function Inscriptions() {
        $inscriptions = SagaInscriptions::leftJoin("programas", "programas.id", "=", "api_inscripcions.programa_id")
            ->leftJoin("ucs", "ucs.id", "=", "api_inscripcions.uc_id")
            ->Leftjoin("lapsos", "lapsos.id", "=", "api_inscripcions.lapso_id")
            ->Leftjoin("turnos", "turnos.id", "=", "api_inscripcions.turno_id")
            ->Leftjoin("alumnos", "alumnos.id", "=", "api_inscripcions.alumno_id")
            ->Leftjoin("sexos", "alumnos.sexo_id", "=", "sexos.id")
            ->select(
                "api_inscripcions.id as id",
                "api_inscripcions.nota as grade",
                "api_inscripcions.alumno_id as student_id",
                "api_inscripcions.Seccion as section",
                "programas.id as programa_id",
                "programas.programa",
                "programas.estatus",
                "programas.largo",
                "programas.char",
                "ucs.id as uc_id",
                "ucs.descripcion as uc_description",
                "ucs.trayecto_id as uc_trayecto_id",
                "ucs.programa_id as uc_programa_id",
                "ucs.tiene_prerequisito as uc_prelation",
                "ucs.estatus as uc_status",
                "lapsos.id as lapso_id",
                "lapsos.Orden as lapso_orden",
                "lapsos.PeriodoAcademico as lapso_periodo",
                "lapsos.ReferenciaLapso as lapso_reference",
                "lapsos.Observacion as lapso_observations",
                "lapsos.inicio_lapso as lapso_start",
                "lapsos.fin_lapso as lapso_end",
                "lapsos.inicio_inscripciones as inscription_start",
                "lapsos.fin_inscripciones as inscription_end",
                "lapsos.inicio_reingresos as reingreso_start",
                "lapsos.fin_reingresos as reingreso_end",
                "lapsos.inicio_traslados as traslado_start",
                "lapsos.fin_traslados as traslado_end",
                "lapsos.inicio_cambios as change_start",
                "lapsos.fin_cambios as change_end",
                "lapsos.inicio_clases as start",
                "lapsos.inicio_carga_notas as start_notes",
                "lapsos.fin_carga_notas as end_notes",
                "lapsos.inicio_congelacion as freeze_start",
                "lapsos.fin_congelacion as freeze_end",
                "lapsos.fecha_cierre as close_date",
                "turnos.id as turno_id",
                "turnos.turno",
                "turnos.char as turno_char",
                "turnos.estatus as turno_status",
                "alumnos.cedulapasaporte as student_ci",
                "alumnos.nombre as student_name",
                "alumnos.apellido as student_last_name",
                "alumnos.sexo_id as student_sex",
                "sexos.sexo as student_sex_name"
            )
            ->orderBy('api_inscripcions.alumno_id', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    "inscription_id" => $item->id,
                    "student_id" => $item->student_id,
                    "section" => $item->section,
                    "grade" => $item->grade,
                    "pnf_info" => [
                        "id" => $item->programa_id,
                        "programa" => $item->programa,
                        "estatus" => $item->estatus,
                        "largo" => $item->largo,
                        "char" => $item->char
                    ],
                    "uc_info" => [
                        "id" => $item->uc_id,
                        "description" => $item->uc_description,
                        "trayecto_id" => $item->uc_trayecto_id,
                        "programa_id" => $item->uc_programa_id,
                        "prelation" => $item->uc_prelation,
                        "status" => $item->uc_status
                    ],
                    "lapso_info" => [
                        "id" => $item->lapso_id,
                        "orden" => $item->lapso_orden,
                        "periodo" => $item->lapso_periodo,
                        "reference" => $item->lapso_reference,
                        "observations" => $item->lapso_observations,
                        "start" => $item->lapso_start,
                        "end" => $item->lapso_end,
                        "inscription_start" => $item->inscription_start,
                        "inscription_end" => $item->inscription_end,
                        "reingreso_start" => $item->reingreso_start,
                        "reingreso_end" => $item->reingreso_end,
                        "traslado_start" => $item->traslado_start,
                        "traslado_end" => $item->traslado_end,
                        "change_start" => $item->change_start,
                        "change_end" => $item->change_end,
                        "start" => $item->start,
                        "start_notes" => $item->start_notes,
                        "end_notes" => $item->end_notes,
                        "freeze_start" => $item->freeze_start,
                        "freeze_end" => $item->freeze_end,
                        "close_date" => $item->close_date
                    ],
                    "turno_info" => [
                        "id" => $item->turno_id,
                        "turno" => $item->turno,
                        "char" => $item->turno_char,
                        "status" => $item->turno_status
                    ],
                    "student_info" => [
                        "id" => $item->student_id,
                        "ci" => $item->student_ci,
                        "name" => $item->student_name,
                        "last_name" => $item->student_last_name,
                        "sex" => $item->student_sex_name
                    ]
                ];
            });

        return jsonResponse($data = $inscriptions, $status = 200);
    }


    public function ucs() {
        /*
        $informaticaId = SagaPensums::where('tipopensum_id', 1)
            ->where('programa_id', 13)
            ->latest('id')
            ->value('id');

        $administracionId = SagaPensums::where('tipopensum_id', 1)
            ->where('programa_id', 12)
            ->latest('id')
            ->value('id');

        $agroalimentacionId = SagaPensums::where('tipopensum_id', 1)
            ->where('programa_id', 11)
            ->latest('id')
            ->value('id');

        $veterinariaId = SagaPensums::where('tipopensum_id', 1)
            ->where('programa_id', 18)
            ->latest('id')
            ->value('id');
*/
        $pensumIds = SagaPensums::where('tipopensum_id', 1)
            //->whereIn('programa_id', [13, 12, 11, 18]) // Filtra los programa_id
            ->groupBy('programa_id')
            ->selectRaw('programa_id, MAX(id) as max_id')
            ->pluck('max_id') // Obtiene solo los valores (IDs)
            ->toArray();



        $ucs = SagaUcs::leftJoin("trayectos", "trayectos.id", "=", "ucs.trayecto_id")
            ->leftJoin("programas", "programas.id", "=", "ucs.programa_id")
            ->leftJoin("pensum_ucs", "pensum_ucs.uc_id", "=", "ucs.id")->whereIn("pensum_ucs.pensum_id", $pensumIds)
            ->select(
                "ucs.id",
                "ucs.descripcion",
                "ucs.ucr",
                "ucs.htea",
                "ucs.htei",
                "ucs.thte",
                "ucs.trayecto_id",
                "ucs.programa_id",
                "trayectos.trayecto",
                "trayectos.estatus AS trayecto_status",
                "programas.programa",
                "programas.estatus",
                "programas.largo",
                "programas.char",
                "pensum_ucs.total_horas as hours",
                "pensum_ucs.numero_de_veces as times",
                DB::raw('CASE
                    WHEN pensum_ucs.ptrimestre_1 = 0 THEN false
                    ELSE true
                END as q1'),
                DB::raw('CASE
                    WHEN pensum_ucs.ptrimestre_2 = 0 THEN false
                    ELSE true
                END as q2'),
                DB::raw('CASE

                    WHEN pensum_ucs.ptrimestre_3 = 0 THEN false
                    ELSE true
                END as q3')
            )
            ->get()
            ->map(function ($subject) {
                return [
                    "id" => $subject->id,
                    "description" => $subject->descripcion,
                    "ucr" => $subject->ucr,
                    "hours" => [
                        "total" => $subject->hours,
                        "times" => $subject->times,
                        "htea" => $subject->htea,
                        "htei" => $subject->htei,
                        "thte" => $subject->thte
                    ],
                    "trayecto_info" => [
                        "id" => $subject->trayecto_id,
                        "trayecto" => $subject->trayecto,
                        "status" => $subject->trayecto_status
                    ],
                    "programa_info" => [
                        "id" => $subject->programa_id,
                        "programa" => $subject->programa,
                        "status" => $subject->estatus,
                        "largo" => $subject->largo,
                        "char" => $subject->char
                    ],
                    "quarters" => [
                        "q1" => $subject->q1,
                        "q2" => $subject->q2,
                        "q3" => $subject->q3
                    ]
                ];
            });

        return jsonResponse($data = $ucs, $status = 200);
    }

    public function prelations() {
        $prelations = SagaPrelacions::select(
            "id",
            "uc_id",
            "PreladaPor",
            "programa_id",
            "pensum_id",
            "estatus"
        )
            ->get();
        return jsonResponse($data = $prelations, $status = 200);
    }

    public function programas() {
        $programas = SagaProgramas::where('estatus', 'A')
            ->select(
                "id",
                "programa",
                "largo",
                "char"
            )
            ->get();
        return jsonResponse($data = $programas, $status = 200);
    }

    public function trayectos() {
        $trayectos = SagaTrayectos::where('estatus', 'A')
            ->select(
                "id",
                "trayecto",
                "estatus"
            )
            ->get();
        return jsonResponse($data = $trayectos, $status = 200);
    }

    public function turnos() {
        $turnos = SagaTurnos::where('estatus', 'A')
            ->select(
                "id",
                "turno",
                "user_id",
                "char"
            )
            ->get();
        return jsonResponse($data = $turnos, $status = 200);
    }
}
