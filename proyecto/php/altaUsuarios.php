<?php
require_once "DB.php";

$error = "";

if (isset($_POST["alta"])) {
    $resul = validar();
    if (empty($resul)) {
        DB::conecta();
        if (DB::obtieneUsuario($_POST["mail"])) {
            $error = "Este usuario ya existe";
        } else {
            $passwd = md5($_POST["passwd"]);
            $usu = new usuarios("default", $_POST["mail"], $_POST["nombre"], $_POST["apellidos"], $passwd, $_POST["fechaNac"], "null", $_POST["rol"], "0");
            DB::altaUsuario($usu);
        }
    }
    // else {
    //     header('Location: altaUsuarios.php');
    // }
}


function validar()
{
    $error = [];
    if (!preg_match("/^[a-zA-Z-'\s]+$/", $_POST["nombre"])) {
        $error['name'] = "Solo letras y espacios";
    }
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $error['mail'] = "Formato email invalido";
    }

    return $error;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaUsuarios.css" title="Color">
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
            <p>Alta de Usuario</p>
        </div>
        <form action="" method="post">
            <div class="cajaCampos">
                <p>Email</p>
                <input type="text" style='width:200px;' name="mail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                <p>Nombre</p>
                <input type="text" style='width:200px;' name="nombre" pattern="[A-Za-z ]{1,30}" />
                <p>Apellidos</p>
                <input type="text" style='width:200px;' name="apellidos" pattern="[A-Za-z ]{1,30}">
                <p>Contraseña</p>
                <input type="password" style='width:200px;' name="passwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,25}" title="minimo 6 caracteres" />
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



<!-- SELECT * FROM preguntas order by id limit 2(por donde empieza),5(valores que muestra) -->