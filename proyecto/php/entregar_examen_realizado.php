<?php

require_once "DB.php";
require_once "examenes_hechos.php";

if (isset($_POST["datos"])) {

    try {

        DB::conecta();
        $con = DB::getConex();
        $con->beginTransaction();

        $datos = json_decode($_POST["datos"]);


        $id_examen = $datos->id;
        $id_alumno = 1; // CAMBIAR CUANDO TENGA LAS SESIONES
        $fecha = date("Y-m-d H:i:s");
        $ejecucion = $_POST["datos"];

        $correg=[];
        for ($i=0; $i < count($datos->n_preguntas); $i++) { 
            $contest=$datos->respuestas_seleccionadas[$i];
            $correcta=DB::obtieneRespuesta_correc($datos->n_preguntas[$i][0]);
            if ($contest==$correcta) {
                $correg[$i]="1";
            }
            else{
                $correg[$i]="";
            }
        }

        $valor_resp=ceil(100/count($datos->n_preguntas));
        for ($i=0; $i < count($datos->n_preguntas); $i++) { 
            if (!empty($correg[$i])) {
                $finsuma+=1;
            }
        }
        $total= $finsuma*$valor_resp;

        // $datos->n_preguntas[i][0]; // sacamos el id de la pregunta para coger su respuesta correcta
        // $datos->respuestas_seleccionadas; //respuestas 

        // DB::conecta();
        $examen = new examenes_hechos("default", $id_examen, $id_alumno, $fecha, json_encode($ejecucion));
        // DB::altaExamen_Hecho($examen);
        // header("Location: tablaExamen.php");


        $con->commit();

    } catch (PDOException $e) {
        $con->rollBack();
        http_response_code(403);
    }
}
else {
    
    header('Location: realizarExamen.php');

}
