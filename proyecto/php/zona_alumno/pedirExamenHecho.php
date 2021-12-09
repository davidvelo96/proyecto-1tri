<?php
require_once "../clases/DB.php";


DB::conecta();
$idex=$_GET["exa"];
$object= new stdClass();
$object -> exam=[];
$examen=DB::obtieneExamenesHecho_id($idex);
$todo=json_decode($examen[0]["ejecucion"]);
$object->exam[]=$todo;
$resp_correc=[];

for ($i=0; $i < count($todo->n_preguntas); $i++) { 
    $resp_correc[]=DB::obtieneRespuesta_correc($todo->n_preguntas[$i][0]);
}
$object->exam[]=$resp_correc;
echo json_encode($object);
