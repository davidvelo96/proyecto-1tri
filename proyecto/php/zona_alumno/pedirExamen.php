<?php
require_once "../DB.php";


DB::conecta();
$preguntas_examen=DB::obtienePreguntaExamen($_GET["exa"]);
$object= new stdClass();
$object -> exam=[];
$examen=DB::obtieneExamen($_GET["exa"]);

$respuestas=[];

    for ($i=0; $i < count($preguntas_examen); $i++) { 
        $respuestas[$i]=[$preguntas_examen[$i]->id_preg,$preguntas_examen[$i]->enunciado,DB::obtieneRespuestas($preguntas_examen[$i]->id_preg),$preguntas_examen[$i]->recurso];
    }



while ($fila = $examen->fetch()) {
    $objexamen= new stdClass();
    $objexamen->id=$fila[0];
    $objexamen->descripcion=$fila[1];
    $objexamen->duracion=$fila[2];
    $objexamen->n_preguntas=$fila[3];
    $objexamen->n_preguntas=$respuestas;
    $objexamen->respuestas_seleccionadas=[];


    $object->exam[]=$objexamen;

}

echo json_encode($object);
