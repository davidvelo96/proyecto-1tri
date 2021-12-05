<?php
require_once "DB.php";
require_once "sesion.php";
require_once "usuarios.php";

sesion::iniciar();
$usuario = sesion::leer("usuario");

if (!sesion::existe("usuario")) {
    header('Location: login.php');
}

$error = "";

if (isset($_POST["alta"])) {
    $resul = validar();
    if (empty($resul)) {
        if ($_POST["passwd"] != $_POST["conf_passwd"]) {
            $error = "Las contraseñas no coinciden";
        } else {

            DB::conecta();
            if (DB::obtieneUsuario($_POST["mail"])) {
                $error = "Este usuario ya existe";
            } else {
                $passwd = md5($_POST["passwd"]);
                $usu = new usuarios("default", $_POST["mail"], $_POST["nombre"], $_POST["apellidos"], $passwd, $_POST["fechaNac"], "null", $_POST["rol"], "0");
                DB::editaUsuario($usu);
            }
        }
    }
}


function validar()
{
    $error = [];
    if (!preg_match("/^[a-zA-Z-'\s]+$/", $_POST["nombre"])) {
        $error['name'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s]+$/", $_POST["apellidos"])) {
        $error['apellidos'] = "Solo letras y espacios";
    }

    return $error;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaUsuarios.css" title="Color">
    <link rel="stylesheet" href="../css/comun.css" title="Color">


    <title>Datos personales</title>
</head>



<body>
    <header>
        <div class="perfil">
            <img src="../img/batman.png" width="100px" height="100px">
            <a href="#">
                <?php
                $usuario = sesion::leer("usuario");
                echo $usuario->getFoto() == null ? " <img src='../img/iconoperfil.jpg' width='50px' height='50px' style='margin:20%;'> " : " <img src='" . $usuario->getFoto() . "' width='100px' height='100px'> ";
                ?>
            </a>
        </div>


        <div class="nav">
            <nav id="menu">
                <ul>
                    <li><a href="tablaUsuarios.php">Usuarios</a>
                        <ul>
                            <li><a href="altaUsuarios.php">Alta usuarios</a></li>
                            <li><a href="">Alta masiva</a></li>
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
                    <li><a href="">Examenes</a>
                        <ul>
                            <li><a href="">Alta examen</a></li>
                            <li><a href="">Historico</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

    </header>
    <div class="cuadroAlta">
        <div class="titulo">
            <h2>Datos personales</h2>
        </div>
        <form action="" method="post">
            <div class="cajaCampos">
                <?php
                sesion::iniciar();

                $usuario = sesion::leer("usuario");

                echo "    <p>Email</p>";
                echo "    <input type='text' style='width:200px; ' disabled name='mail' value='" . $usuario->getCorreo() . "' required pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'>";
                echo "    <p>Nombre</p>";
                echo "    <input type='text' style='width:200px;'  name='nombre' value='" . $usuario->getNombre() . "' pattern='[A-Za-z ]{1,30}' />";
                echo "    <p>Apellidos</p>";
                echo "    <input type='text' style='width:200px;' name='apellidos' value='" . $usuario->getApellidos() . "' pattern='[A-Za-z ]{1,30}'>";
                echo "    <p>Contraseña</p>";
                echo "    <input type='password' style='width:200px;' name='passwd' value='" . $usuario->getPasswd() . "' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,25}' title='minimo 6 caracteres' required/>";
                echo "    <p>Confirmar contraseña</p>";
                echo "    <input type='password' style='width:200px;' name='conf_passwd' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,25}' title='minimo 6 caracteres' />";
                echo "    <p>Fecha de nacimiento</p>";
                echo "    <input type='date' style='width:200px;' value='" . $usuario->getFechaNac() . "' name='fechaNac' required />";
                ?>
                <div class="botonSubmit">
                    <input type="submit" style='width:70px;' name="alta"></input>
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