<?php
require_once "clases/DB.php";


DB::conecta();
$respuesta=DB::obtienePreguntasEx();
$preguntas=DB::obtienePreguntaExamenEdit($_GET["exa"]);

$object= new stdClass();
$object -> preguntas=[];

while ($fila = $respuesta->fetch()) {
    $objPreguntas= new stdClass();
    $objPreguntas->id_pregunta=$fila[0];
    $objPreguntas->enunciado=$fila[1];
    $objPreguntas->descripcion_tem=$fila[2];


    $object->preguntas[]=$objPreguntas;

}
$object->preguntas_exa[]=$preguntas;


echo json_encode($object);
