<?php
require_once "clases/DB.php";
require_once "clases/sesion.php";
require_once "clases/usuarios.php";

$error = "";

sesion::iniciar();
$usuario = sesion::leer("usuario");
if (!empty($usuario)) {

    if ($usuario->getRol() != "PROFESOR") {
        header('Location: datosPersonales.php');
    } else {

        if (isset($_POST["edita"])) {

            DB::conecta();
            $tematica = $_POST['tematica'];

            if (empty($tematica))
                $error = "Introduce una descripcion";
            else {
                $t = DB::newTematica($tematica);
                if (DB::existeTematica($tematica)) {
                    $error = "Tematica ya existe";
                } else {
                    DB::editaTematica($t, $_GET["id"]);
                    header('Location: tablaTematicas.php');
                }
            }
        }
    }
} else {
    header('Location: login.php');
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/login.css" title="Color">
    <link rel="stylesheet" href="../css/comun.css" title="Color">

    <title>Registro</title>
</head>

<body>
    <header>
        <div class="perfil">
            <img src="../img/batman.png" width="100px" height="100px">
            <a href="#"> <img src="../img/batman.png" width="100px" height="100px"></a>
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

    <div class="cajaLogeo">
        <div class="cajaCampos">
            <form action="" method="post">

                <div class="usuario">
                    <p class="tituloCajas">Descripcion</p>
                    <?php
                    DB::conecta();
                    $pregunta = DB::obtieneTematica($_GET["id"]);

                    echo "<input class='inputCaja' type='text' value='" . $pregunta->descripcion . "' pattern='[A-Za-z ]{1,30}' placeholder='Marcador de Posicion' name='tematica' title='Maximo 30 caracteres, solo letras y espacios' />"
                    ?>
                </div>
                <input class="botonSubmit" type="submit" value="Aceptar" name="edita" />
                <br>
                <?php
                echo "<span style='color:red;'>" . $error . "</span>";
                ?>
            </form>
        </div>

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