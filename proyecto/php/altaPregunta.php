<?php
require_once "clases/DB.php";
require_once "clases/preguntas.php";
require_once "clases/respuestas.php";
require_once "clases/sesion.php";

sesion::iniciar();
$usuario = sesion::leer("usuario");
if (!empty($usuario)) {

    if ($usuario->getRol() != "PROFESOR") {
        header('Location: datosPersonales.php');
    } else {
        if (isset($_POST["alta"])) {
            try {

                DB::conecta();
                $con = DB::getConex();
                $con->beginTransaction();
                $CRespuestas = DB::cuentaRespuestas();

                $imag = "null";

                $resul = validar($CRespuestas);
                if (empty($resul)) {


                    $correc = $_POST["respuesta"];
                    $respuestas = [$_POST['1'], $_POST['2'], $_POST['3'], $_POST['4']];

                    $pregunta = new preguntas("default", $_POST["enun"], "null", "null", $_POST["tematica"], $respuestas);
                    DB::altaPregunta($pregunta);

                    $cuentaPreguntas = DB::ultiPreguntas();

                    if ($_FILES["imagen_preg"]["name"]!="") {
                        $imag = "../img/imagen" . $cuentaPreguntas . ".jpg";
                        move_uploaded_file($_FILES['imagen_preg']['tmp_name'], $imag);
                    }

                    $i = 1;
                    while ($i <= 4) {
                        $respuestas = new respuestas("default", $_POST[0 + $i], ($cuentaPreguntas));
                        DB::altaRespuestas($respuestas);
                        if ($i == $correc) {
                            DB::updateCorrecta($cuentaPreguntas, $imag);
                        }
                        $i++;
                    }
                }
                $con->commit();
            } catch (PDOException $e) {
                $con->rollBack();
            }
        }
    }
} else {
    header('Location: login.php');
}

function validar()
{
    $error = [];
    if (!preg_match("/^[a-zA-Z-'\s]+$/", $_POST["enun"])) {
        $error['enun'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST['1'])) {
        $error['1'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST['2'])) {
        $error['2'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST['3'])) {
        $error['3'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s\,]+$/", $_POST['4'])) {
        $error['4'] = "Solo letras y espacios";
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
            <img src="../img/autoescuela.png" width="100px" height="100px">
            <a href="datosPersonales.php">
                <?php
                $usuario = sesion::leer("usuario");
                echo $usuario->getFoto() == null ? " <img src='../img/iconoperfil.jpg' width='50px' height='50px' style='margin:20%;'> " : " <img src='" . $usuario->getFoto() . "' width='50px' height='50px' style='margin:20%;'> ";
                ?>
            </a>
        </div>


        <div class="nav">
            <nav id="menu">
                <ul>
                    <li><a href="tablaUsuarios.php">Usuarios</a>
                        <ul>
                            <li><a href="altaUsuarios.php">Alta usuarios</a></li>
                            <li><a href="altaMasivaUsuarios.php">Alta masiva</a></li>
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
            <h1>Alta de preguntas</h1>
        </div>
        <form action='' method='post' enctype='multipart/form-data'>
            <div class="cajaCampos">
                <p>Tematica</p>
                <select name="tematica" required>
                    <option value="" selected>Seleccionar</option>
                    <?php
                    DB::conecta();
                    $tematicas = "";
                    $tematicas = DB::obtienetematicas();
                    $count = DB::cuentatematicas();
                    for ($i = 0; $i < $count; $i++) {
                        echo  "<option value='" . $tematicas[$i]->getId() . "'>" . $tematicas[$i]->getDesc() . "</option>";
                    }
                    ?>

                </select>
                <p>Enunciado</p>
                <textarea required pattern="[A-Za-z \,]{1,30}" style='width:200px; height:100px;' name="enun"></textarea>
                <p>Imagen de la pregunta</p>
                <input type='file' name='imagen_preg' id='imagen' accept="image/*,video/*"/>

                <?php
                DB::conecta();
                $CRespuestas = DB::cuentaRespuestas();
                echo "<p>Opcion 1</p>";
                echo "<input type='text' style='width:200px;' name='1' pattern='[A-Za-z 0-9\,]{1,30}''  required/>";
                echo "<input type='radio' id='ra1' name='respuesta' value='1' required/>correcta";
                echo "<p>Opcion 2</p>";
                echo "<input type='text' style='width:200px;' name='2' pattern='[A-Za-z 0-9\,]{1,30}'' required />";
                echo "<input type='radio' id='ra2' name='respuesta' value='2' required/>correcta";
                echo "<p>Opcion 3</p>";
                echo "<input type='text' style='width:200px;' name='3' pattern='[A-Za-z 0-9\,]{1,30}''  required/>";
                echo "<input type='radio' id='ra3' name='respuesta' value='3' required/>correcta";
                echo "<p>Opcion 4</p>";
                echo "<input type='text' style='width:200px;' name='4' pattern='[A-Za-z 0-9\,]{1,30}'' required />";
                echo "<input type='radio' id='ra4' name='respuesta' value='4' required/>correcta";
                ?>

                <br><br>
                <div class="botonSubmit">
                    <input type="submit" style='width:70px;' name="alta"></input>
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