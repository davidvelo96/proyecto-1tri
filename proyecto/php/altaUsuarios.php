<?php
require_once "clases/DB.php";
require_once "clases/sesion.php";
require_once "clases/usuarios.php";
require_once "clases/correo.php";

$error = "";
DB::conecta();
sesion::iniciar();
$usuario = sesion::leer("usuario");
if (!empty($usuario)) {

    if ($usuario->getRol() != "PROFESOR") {
        header('Location: datosPersonales.php');
    } else {

        if (isset($_POST["alta"])) {
            $resul = validar();
            if (empty($resul)) {
                if (DB::obtieneUsuario($_POST["mail"])) {
                    $error = "Este usuario ya existe";
                } else {

                    try {

                        $con = DB::getConex();
                        $con->beginTransaction();

                        $usu = new usuarios("default", $_POST["mail"], $_POST["nombre"], "", "", $_POST["fechaNac"], "null", $_POST["rol"], "0");
                        DB::altaUsuario($usu);
                        $id_usu = DB::ultiUsuario();
                        DB::altaUsuarioPendiente($id_usu);
                        mail::correo($id_usu);

                        $con->commit();
                    } catch (PDOException $e) {
                        $con->rollBack();
                    }
                    // header('Location: altaUsuarios.php');
                }
            }
        }
    }
}
else {
    header('Location: login.php');
}


function validar()
{
    $error = [];
    if (!preg_match("/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/", $_POST["nombre"])) {
        $error['name'] = "Solo letras y espacios";
    }
    if (!preg_match("/[a-z0-9._%+-\u00f1\u00d1]+@[a-z0-9.-]+\.[a-z]{2,4}$/", $_POST["mail"])) {
        $error['mail'] = "Formato email invalido";
    }

    return $error;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../scss/css/main.css">
    <link rel="stylesheet" href="../css/altaUsuarios.css" >



    <title>Registro</title>
</head>



<body>
    <header>
        <div class="perfil">
            <img src="../img/batman.png" width="100px" height="100px">
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
            <h1>Alta de Usuario</h1>
        </div>
        <form action="" method="post">
            <div class="cajaCampos">
                <p>Email</p>
                <input type="text" style='width:200px;' name="mail" required pattern="[a-z0-9._%+-\u00f1\u00d1]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                <p>Nombre</p>
                <input type="text" style='width:200px;' name="nombre" pattern="^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$" />
                <!-- <p>Contraseña</p>
                <input type="password" style='width:200px;' name="passwd" pattern="(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z \u00d1]).{6,25}" title="min 6 caracteres, min 1 mayus" /> -->
                <p>Fecha de nacimiento</p>
                <input type="date" style='width:200px;' name="fechaNac" required />
                <p>Rol</p>
                <select name="rol" required>
                    <option value="" selected>Seleccione una opción</option>
                    <option value="PROFESOR">PROFESOR</option>
                    <option value="ALUMNO">ALUMNO</option>
                </select>
                <br><br>
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