<?php
require_once "vendor/autoload.php";
require_once "proyecto/php/clases/usuarios.php";
require_once "proyecto/php/clases/sesion.php";
require_once "proyecto/php/clases/DB.php";

use Dompdf\Dompdf;

DB::conecta();
$idex = $_GET["exam"];
$object = new stdClass();
$object->exam = [];
$examen = DB::obtieneExamenesHecho_id($idex);
$todo = json_decode($examen[0]["ejecucion"]);
$puntos = DB::obtienePuntuacion($todo);
$object->exam[] = $todo;
$resp_correc = [];

for ($i = 0; $i < count($todo->n_preguntas); $i++) {
    $resp_correc[] = DB::obtieneRespuesta_correc($todo->n_preguntas[$i][0]);
}
$object->exam[] = $resp_correc;

// <div style="page-break-after:always;"></div>
$html ="";

for ($i = 0; $i < count($todo->n_preguntas); $i++) {

    if ($todo->n_preguntas[$i][3] != null) {
        $path = str_replace("..", "proyecto", $todo->n_preguntas[$i][3]);
    } else {
        $path = "proyecto/img/defectoPreg.jpg";
    }

    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $html .= "
    <div style='page-break-after:always; page-break-inside: avoid; page-break-inside: auto;'>
    <h1 id='titulo_preg'>Pregunta " . $i . "</h1>
    <div id='preg5' style=''>
    <div id='imagen_preg'>
    <img width='300px' height='200px' src='" . $base64 . "'>
    </div> <div id='resp_preg'>
    <p id='enunciado'>" . $todo->n_preguntas[$i][1] . " </p>";

    for ($j = 0; $j < 4; $j++) {

        if ($todo->respuestas_seleccionadas[$i] == $todo->n_preguntas[$i][2][$j]->id) {
            $html .= "<input type='radio' disabled='' checked><span id='20'>" . $todo->n_preguntas[$i][2][$j]->enunciado . "</span>";
        } else {
            $html .= "<input type='radio' disabled='' ><span id='20'>" . $todo->n_preguntas[$i][2][$j]->enunciado . "</span>";
        }
        if ($todo->n_preguntas[$i][2][$j]->id == $object->exam[1][$i]) {
            $html .= "<span style='color:green;'>    correcta</span><br>";
        } else {
            $html .= "<span></span><br>";
        }
    }
    $html .= "</div><br></div>";
};

$html .= '<h3 style="text-align: right;">Has sacado un ' . $puntos . '/100</h3>';



$mipdf = new Dompdf();

# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf->setPaper("letter", "portrait");
# Cargamos el contenido HTML.
$mipdf->loadHtml($html);

# Renderizamos el documento PDF.
$mipdf->render();

# Creamos un fichero
$pdf = $mipdf->output();
$filename = "Examen corregido.pdf";
// file_put_contents($filename, $pdf);

# Enviamos el fichero PDF al navegador.
$mipdf->stream($filename);
