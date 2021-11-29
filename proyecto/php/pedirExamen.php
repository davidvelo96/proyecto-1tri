<?php
require_once "DB.php";


DB::conecta();
$preguntas_examen=DB::obtienePreguntaExamen($_GET["exa"]);
$object= new stdClass();
$object -> exam=[];
$examen=DB::obtieneExamen(2);

$respuestas=[];

    for ($i=0; $i < count($preguntas_examen); $i++) { 
        $respuestas[$i]=[$preguntas_examen[$i]->id_preg,$preguntas_examen[$i]->enunciado,DB::obtieneRespuestas($preguntas_examen[$i]->id_preg)];
    }



while ($fila = $examen->fetch()) {
    $objexamen= new stdClass();
    $objexamen->id=$fila[0];
    $objexamen->descripcion=$fila[1];
    $objexamen->duracion=$fila[2];
    $objexamen->n_preguntas=$fila[3];
    $objexamen->n_preguntas=$respuestas;


    $object->exam[]=$objexamen;

}

echo json_encode($object);
