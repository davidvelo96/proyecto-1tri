<?php

require_once "../clases/DB.php";
require_once "../clases/examenes_hechos.php";
require_once "../clases/sesion.php";


if (isset($_POST["datos"])) {

    try {

        sesion::iniciar();
        $usuario = sesion::leer("usuario");

        DB::conecta();
        $con = DB::getConex();
        $con->beginTransaction();

        $datos = json_decode($_POST["datos"]);


        $id_examen = $datos->id;
        $id_alumno = $usuario->getId(); // CAMBIAR CUANDO TENGA LAS SESIONES
        $fecha = date("Y-m-d H:i:s");
        $ejecucion = $_POST["datos"];


        // $datos->n_preguntas[i][0]; // sacamos el id de la pregunta para coger su respuesta correcta
        // $datos->respuestas_seleccionadas; //respuestas 

        $examen = new examenes_hechos("default", $id_examen, $id_alumno, $fecha, $ejecucion);
        DB::altaExamen_Hecho($examen);
        // header("Location: tablaExamen.php");


        $con->commit();

    } catch (PDOException $e) {
        $con->rollBack();
        http_response_code(403);
    }
}
else {
    
    header('Location: zona_alumno/historico_ex_alumno.php');

}
