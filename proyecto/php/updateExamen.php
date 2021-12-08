<?php

require_once "clases/DB.php";
require_once "clases/examenes.php";
require_once "clases/examenes_preguntas.php";

if (isset($_POST["datos"])) {
    try {

        DB::conecta();
        $con = DB::getConex();
        $con->beginTransaction();
        $datos = json_decode($_POST["datos"]);


        $descripcion = $datos->desc;
        $numero_p = $datos->n_preguntas;
        $duracion = $datos->duracion . ":00";
        $id_preg = $datos->id_preguntas;
        $id_exam = $datos->id_examen;

        $examen = new examenes($id_exam, $descripcion, $duracion, $numero_p, 0);
        DB::editaExamen($examen);
        DB::borraExamenPreg($id_exam);
        for ($i = 0; $i < count($id_preg); $i++) {
            $ex_preg = new examenes_preguntas($id_preg[$i], ($id_exam));
            DB::altaExamen_preg($ex_preg);
        }

        $con->commit();
    } catch (PDOException $e) {
        $con->rollBack();
    }
} else {
    header("Location: altaExamen.php");
}
