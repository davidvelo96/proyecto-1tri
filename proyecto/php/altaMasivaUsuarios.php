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
    }
} else {
    header('Location: login.php');
}




?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaUsuarios.css" title="Color">
    <link rel="stylesheet" href="../css/comun.css" title="Color">
    <script type="text/javascript" src="../js/altaMasivaUsuarios.js"></script>


    <title>Registro</title>
</head>

<body>
    <header>
        <div class="perfil">
            <img src="../img/batman.png" width="100px" height="100px">
            <a href="#">
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
            <h1>Alta masiva de usuarios</h1>
        </div>
        <form action='' method='post' enctype='multipart/form-data'>
            <div class="cajaCampos">
                <?php
                if (isset($_POST["carga"])) {
                    $filename = $_FILES['imagen_preg']['tmp_name'];
                    $handle = fopen($filename, "r");
                    $q = [];
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        $q[] = ($data[0]);;
                    }


                    echo "<textarea pattern='[A-Za-z \,]{1,30}' style='width:400px; height:200px;' name='usuarios' id='usuarios' placeholder='(Introduce los emails con saltos de linea)'>";

                    for ($i = 0; $i < count($q); $i++) {
                        echo $i == (count($q)-1) ? $q[$i] : $q[$i] . "\n";
                    }
                    echo  "</textarea>";
                } else {
                    echo "<textarea pattern='[A-Za-z \,]{1,30}' style='width:400px; height:200px;' name='usuarios' id='usuarios' placeholder='(Introduce los emails con saltos de linea)'></textarea>";
                }
                ?>

                <input type='file' name='imagen_preg' id='imagen' accept=".csv" />

                <br><br>
                <div class="botonSubmit">
                    <input type="button" value="Guardar" style='width:70px;' name="alta" id="alta"></input>
                    <input type="submit" value="Cargar csv" name="carga"></input>

                </div>

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