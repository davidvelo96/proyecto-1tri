<?php 

require_once "DB.php";
require_once "examenes_hechos.php";

if (isset($_POST["datos"])) {

$datos=json_decode($_POST["datos"]);


$descripcion=$datos->desc;
$numero_p=$datos->n_preguntas;
$duracion=$datos->duracion.":00";
$id_preg=$datos->id_preguntas;


    DB::conecta();
    $examen=new examenes("default",$descripcion,$duracion,$numero_p,0);
    DB::altaExamen($examen);
    $cuenta_Examenes=DB::cuentaExamenes();
    for ($i=0; $i < count($id_preg); $i++) { 
        $ex_preg=new examenes_preguntas($id_preg[$i],($cuenta_Examenes));
        DB::altaExamen_preg($ex_preg);
    }

}
else {
    header("Location: altaExamen.php");
}
