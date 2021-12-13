<?php
require_once "clases/DB.php";
require_once "clases/sesion.php";
require_once "clases/usuarios.php";

sesion::iniciar();
DB::conecta();
$usuario = sesion::leer("usuario");

$usu = DB::obtieneUsuario($usuario->getCorreo());

sesion::escribir("usuario",$usu);

if (!empty($usuario)) {

    if (!sesion::existe("usuario")) {
        header('Location: login.php');
    }

    $error = "";
    $imag = "";

    if (isset($_POST["alta"])) {
        $resul = validar();
        if (empty($resul)) {
            if ($_POST["passwd"] != $_POST["conf_passwd"]) {
                $error = "Las contraseñas no coinciden";
            } else {

                if (isset($_FILES["imagen_perfil"])) {
                    $imag = "../img/perfil" . $usuario->getId() . ".jpg";
                    move_uploaded_file($_FILES['imagen_perfil']['tmp_name'], $imag);
                }

                if ($_POST["passwd"]!="") {
                    $passwd = md5($_POST["passwd"]);
                } else {
                    $passwd = $usuario->getPasswd();
                }

                $usu = new usuarios("default", $usuario->getCorreo(), $_POST["nombre"], $_POST["apellidos"], $passwd, $_POST["fechaNac"], $imag, $usuario->getRol());
                DB::editaUsuario($usu);
                header('Location: datosPersonales.php');
            }
        }
    }
} else {
    header('Location: login.php');
}


function validar()
{
    $error = [];
    if (!preg_match("/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/", $_POST["nombre"])) {
        $error['name'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/", $_POST["apellidos"])) {
        $error['apellidos'] = "Solo letras y espacios";
    }

    return $error;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaUsuarios.css" title="Color">
    <link rel="stylesheet" href="../scss/css/main.css">


    <title>Datos personales</title>
</head>



<body>
    <header>
        <div class="perfil">
            <img src="../img/batman.png" width="100px" height="100px">
            <a href="datosPersonales.php">
                <?php
                echo $usuario->getFoto() == null ? " <img src='../img/iconoperfil.jpg' width='50px' height='50px' style='margin:20%;'> " : " <img src='" . $usuario->getFoto() . "' width='100px' height='100px'> ";
                ?>
            </a>
        </div>


        <div class="nav">
            <?php
            if ($usuario->getRol() == "PROFESOR") {

                echo   "<nav id='menu'>
                    <ul>
                        <li><a href='tablaUsuarios.php'>Usuarios</a>
                            <ul>
                                <li><a href='altaUsuarios.php'>Alta usuarios</a></li>
                                <li><a href='altaMasivaUsuarios.php'>Alta masiva</a></li>
                            </ul>
                        </li>
                        <li><a href='tablaTematicas.php'>Tematicas</a>
                            <ul>
                                <li><a href='altaTematica.php'>Alta tematicas</a></li>
                            </ul>
                        </li>
                        <li><a href='tablaPreguntas.php'>Preguntas</a>
                            <ul>
                                <li><a href='altaPregunta.php'>Alta preguntas</a></li>
                                <li><a href=''>Alta masiva</a></li>
                            </ul>
                        </li>
                        <li><a href='tablaExamen'>Examenes</a>
                            <ul>
                                <li><a href='altaExamen.php'>Alta examen</a></li>
                                <li><a href='historicoExamenes.php'>Historico</a></li>
                            </ul>
                        </li>
                    </ul>
                    </nav>";
            } else {
                echo "<nav id='menu'>
                    <ul>
                        <li><a href='zona_alumno/historico_ex_alumno.php'>Historico de examenes</a></li>
                        <li><a href='zona_alumno/examenes_predefinidos.php'>Examen predefinido</a></li>
                        <li><a href='zona_alumno/realizarExamen.php?exam=" . DB::examenAleatorio() . "'>Examen aleatorio</a></li>
                    </ul>
                </nav>";
            }
            ?>

        </div>

    </header>
    <div class="cuadroAlta">
        <div class="titulo">
            <h1>Datos personales</h1>
        </div>
        <form action="" method="post" enctype='multipart/form-data'>
            <div class="cajaCampos">
                <?php

                echo "    <p>Email</p>";
                echo "    <input type='text' style='width:200px; ' disabled name='mail' value='" . $usuario->getCorreo() . "' required pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'>";
                echo "    <p>Nombre</p>";
                echo "    <input type='text' style='width:200px;'  name='nombre' value='" . $usuario->getNombre() . "' pattern='^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$' />";
                echo "    <p>Apellidos</p>";
                echo "    <input type='text' style='width:200px;' name='apellidos' value='" . $usuario->getApellidos() . "' pattern='^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$'>";
                echo "    <p>Contraseña</p>";
                echo "    <input type='password' style='width:200px;' name='passwd' pattern='(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z \u00d1]).{6,25}' title='minimo 6 caracteres'/>";
                echo "    <p>Confirmar contraseña</p>";
                echo "    <input type='password' style='width:200px;' name='conf_passwd' pattern='(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z \u00d1]).{6,25}' title='minimo 6 caracteres' />";
                echo "    <p>Fecha de nacimiento</p>";
                echo "    <input type='date' style='width:200px;' value='" . $usuario->getFechaNac() . "' name='fechaNac' required />";
                ?>
                <p>Imagen de perfil</p>
                <input type='file' name='imagen_perfil' id='imagen' accept="image/*" />
                <div class="botonSubmit">
                    <input type="submit" style='width:70px;' name="alta" value="Guardar"></input>
                </div>
                <?php
                echo "<span style='color:red;'>" . $error . "</span>";
                ?>
            </div>
        </form>
    </div>
    <footer>
        <hr>
        <div>
            <br>
            <p><a href="#">Guia de estilo</a></p>
            <p><a href="#">Mapa del sitio web</a></p>
            <?php
            if (sesion::existe("usuario")) {
                echo "<p><a href='logoff.php'>Logoff</a></p>";
            }
            ?>
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



<!-- SELECT * FROM preguntas order by id limit 2(por donde empieza),5(valores que muestra) -->