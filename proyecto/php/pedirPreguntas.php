<?php
require_once "clases/DB.php";


DB::conecta();
$respuesta=DB::obtienePreguntasEx();

$object= new stdClass();
$object -> preguntas=[];

while ($fila = $respuesta->fetch()) {
    $objPreguntas= new stdClass();
    $objPreguntas->id_pregunta=$fila[0];
    $objPreguntas->enunciado=$fila[1];
    $objPreguntas->descripcion_tem=$fila[2];


    $object->preguntas[]=$objPreguntas;

}

echo json_encode($object);
