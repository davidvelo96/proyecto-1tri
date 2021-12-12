<?php
require_once "clases/DB.php";
require_once "clases/preguntas.php";
require_once "clases/respuestas.php";
require_once "clases/usuarios.php";
require_once "clases/sesion.php";


sesion::iniciar();
$usuario = sesion::leer("usuario");
if (!empty($usuario)) {

    if ($usuario->getRol() != "PROFESOR") {
        header('Location: datosPersonales.php');
    } else {
        if (!isset($_GET["id"])) {
            header('Location: altaPregunta.php');
        }

        if (isset($_POST["edita"])) {

            DB::conecta();
            $respuestas = DB::obtieneRespuestas($_GET["id"]);
            $resul = validar($respuestas);
            if (empty($resul)) {
                $correc = $_POST["respuesta"];
                $respuesta = [$_POST[$respuestas[0]->id], $_POST[$respuestas[1]->id], $_POST[$respuestas[2]->id], $_POST[$respuestas[3]->id]];

                $pregunta = new preguntas("default", $_POST["enun"], $correc, "null", $_POST["tematica"], $respuesta);
                DB::editaPregunta($pregunta, $_GET["id"]);

                $i = 0;
                while ($i <= 3) {
                    $respuesta = new respuestas("default", $_POST[$respuestas[$i]->id], "null");
                    DB::editaRespuesta($respuesta, $respuestas[$i]->id);
                    $i++;
                }
            }
            header('Location: tablaPreguntas.php');
        }
    }
} else {
    header('Location: login.php');
}


function validar($idresp)
{
    $error = [];
    if (!preg_match("/^[a-zA-Z-'\s\,\?]+$/", $_POST["enun"])) {
        $error['enun'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST[$idresp[0]->id])) {
        $error['$idresp[0]->id'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST[$idresp[1]->id])) {
        $error['$idresp[1]->id'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST[$idresp[2]->id])) {
        $error['$idresp[2]->id'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST[$idresp[3]->id])) {
        $error['$idresp[3]->id'] = "Solo letras y espacios";
    }


    return $error;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaUsuarios.css" title="Color">
    <link rel="stylesheet" href="../scss/css/main.css">

    <title>Registro</title>
</head>

<body>
    <header>
        <div class="perfil">
            <img src="../img/batman.png" width="100px" height="100px">
            <a href="datosPersonales.php"> <img src="../img/batman.png" width="100px" height="100px"></a>
        </div>


        <div class="nav">
            <nav id="menu">
                <ul>
                    <li><a href="tablaUsuarios.php">Usuarios</a>
                        <ul>
                            <li><a href="altaUsuarios.php">Alta usuarios</a></li>
                            <li><a href="altaMasivaUsuarios">Alta masiva</a></li>
                        </ul>
                    </li>
                    <li><a href="tablaTematicas.php">Tematicas</a>
                        <ul>
                            <li><a href="altaTematica.php">Alta tematicas</a></li>
                        </ul>
                    </li>
                    <li><a href="tablaPreguntas.php">Preguntas</a>
                        <ul>
                            <li><a href="altaPregunta.php">Alta preguntas</a></li>
                            <li><a href="">Alta masiva</a></li>
                        </ul>
                    </li>
                    <li><a href="tablaExamen.php">Examenes</a>
                        <ul>
                            <li><a href="altaExamen.php">Alta examen</a></li>
                            <li><a href="historicoExamenes.php">Historico</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

    </header>

    <div class="cuadroAlta">
        <div class="titulo">
            <h1>Edita preguntas</h1>
        </div>
        <form action="" method="post">
            <div class="cajaCampos">
                <p>Tematica</p>
                <select name="tematica" required>
                    <option value="" selected>Seleccionar</option>
                    <?php
                    DB::conecta();
                    $pregunta = DB::obtienePregunta($_GET["id"]);
                    $respuestas = DB::obtieneRespuestas($_GET["id"]);
                    $tematicas = DB::obtienetematicas();
                    $count = DB::cuentatematicas();

                    for ($i = 0; $i < $count; $i++) {
                        echo  "<option value='" . $tematicas[$i]->getId() . "'" . ($tematicas[$i]->getId() == $pregunta->tematicas_id ? "selected" : "") . " >" . $tematicas[$i]->getDesc() . "</option>";
                    }


                    echo "</select>";
                    echo "<p>Enunciado</p>";
                    echo "<textarea required pattern='[A-Za-z \,]{1,30}' style='width:200px; height:100px;' name='enun'>" . $pregunta->enunciado . "</textarea>";


                    echo "<p>Opcion 1</p>";
                    echo "<input type='text' style='width:200px;' name='" . $respuestas[0]->id . "' pattern='[A-Za-z 0-9\,]{1,30}''  value='" . $respuestas[0]->enunciado . "' required/>";
                    echo "<input type='radio' id='" . $respuestas[0]->id . "' name='respuesta' value='" . $respuestas[0]->id . "' required" . ($pregunta->resp_correcta == $respuestas[0]->id ? "checked" : "") . "/>correcta";
                    echo "<p>Opcion 2</p>";
                    echo "<input type='text' style='width:200px;' name='" . $respuestas[1]->id . "' pattern='[A-Za-z 0-9\,]{1,30}'' value='" . $respuestas[1]->enunciado . "' required />";
                    echo "<input type='radio' id='" . $respuestas[1]->id . "'name='respuesta' value='" . $respuestas[1]->id . "' required " . ($pregunta->resp_correcta == $respuestas[1]->id ? "checked" : "") . "/>correcta";
                    echo "<p>Opcion 3</p>";
                    echo "<input type='text' style='width:200px;' name='" . $respuestas[2]->id . "' pattern='[A-Za-z 0-9\,]{1,30}'' value='" . $respuestas[2]->enunciado . "' required/>";
                    echo "<input type='radio' id='" . $respuestas[2]->id . "'name='respuesta' value='" . $respuestas[2]->id . "' required " . ($pregunta->resp_correcta == $respuestas[2]->id ? "checked" : "") . "/>correcta";
                    echo "<p>Opcion 4</p>";
                    echo "<input type='text' style='width:200px;' name='" . $respuestas[3]->id . "' pattern='[A-Za-z 0-9\,]{1,30}'' value='" . $respuestas[3]->enunciado . "' required />";
                    echo "<input type='radio' id='" . $respuestas[3]->id . "'name='respuesta' value='" . $respuestas[3]->id . "' required " . ($pregunta->resp_correcta == $respuestas[3]->id ? "checked" : "") . "/>correcta";
                    ?>

                    <br><br>
                    <div class="botonSubmit">
                        <input type="submit" style='width:70px;' name="edita"></input>
                    </div>
                    <!-- <?php
                            echo "<span style='color:red;'>" . $error . "</span>";
                            ?>                -->
            </div>
        </form>
    </div>

    <footer>
        <hr>
        <div>
            <br>
            <p><a href="#">Guia de estilo</a></p>
            <p><a href="#">Mapa del sitio web</a></p>
        </div>
        <div>
            <p>Enlaces relacionados</p>
            <p><a href="#">DGT</a></p>
            <p><a href="#">Solicitud oficial de examen</a></p>
            <p><a href="#">Normativa de examen</a></p>
        </div>
        <div>
            <p>Contacto</p>
            <p>Telefono: 9531111111</p>
            <p>Email: info@ewfsd.com</p>
            <p>Redes sociales</p>
        </div>

    </footer>

</body>


</html>