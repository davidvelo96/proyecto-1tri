<?php

require_once "DB.php";
require_once "examenes_hechos.php";

if (isset($_POST["datos"])) {

    $datos = json_decode($_POST["datos"]);


    $id_examen = $datos->id;
    $id_alumno = 1; // CAMBIAR CUANDO TENGA LAS SESIONES
    $fecha = date("Y-m-d H:i:s");
    $ejecucion = $_POST["datos"];


    // DB::conecta();
    $examen = new examenes_hechos("default", $id_examen, $id_alumno, $fecha, json_encode($ejecucion));
    // DB::altaExamen_Hecho($examen);
    header("Location: tablaExamen.php");

} else {
    header("Location: altaExamen.php");
}
