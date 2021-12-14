<?php
require_once "clases/sesion.php";
require_once "clases/usuarios.php";
require_once "clases/DB.php";

DB::conecta();
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
    <link rel="stylesheet" href="../css/altaExamen.css" title="Color">
    <link rel="stylesheet" href="../scss/css/main.css">

    <script type="text/javascript" src="../js/editaExamen.js"></script>

    <title>Registro</title>
</head>

<body>
    <header>
        <div class="perfil">
        <img src="../img/autoescuela.png" width="100px" height="100px">
            <a href="datosPersonales.php">
                <?php
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
                    <li><a href="">Tematicas</a>
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
            <h1>Alta de examen</h1>
        </div>
        <form action="" method="post">
            <br>
            <p>
                <?php
                $datos=DB::obtieneExamen_edit($_GET["exam"]);
                $duracion = $datos->duracion;	
                $duracionPartes = explode(":", $duracion);
                $minutosTotales= ($duracionPartes[0] * 60) + $duracionPartes[1];

                  echo  "Descripcion del examen ";
                  echo  "<input type='text' value='".$datos->descripcion."' style='width:200px; margin-right: 5%;' id='descripcion' pattern='[A-Za-z 0-9]{1,30}''  required/>";
                  echo     " Duracion (en minutos) ";
                  echo  "<input type='text' value='".$minutosTotales."' style='width:50px;' id='duracion' pattern='(\d|[1-9]\d|[1-9]\d{2}|1[0-3]\d{2}|14[0-3]\d)' maxlength='4' required />";
                ?> 
            </p>
            <div class="cajaCampos">

                <div class="titulos">
                    <span>Preguntas posibles</span> <span class="seleccion">Preguntas seleccionadas</span>
                </div>
                <div id="tabla1">
                    <table border="1" class="t1">
                        <thead>
                            <tr>
                                <th>Sel.</th>
                                <th>Enunciado</th>
                                <th>Tematica</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPre">
                        </tbody>
                    </table>
                </div>

                <div class="botones">
                    <input type="button" value="&#9668==" id="izquierda">
                    <br>
                    <input type="button" value===&#9658 id="derecha">
                </div>

                <div id="tabla2">
                    <table border="1" class="t2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Enunciado</th>
                                <th>Tematica</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPost">
                        </tbody>
                    </table>
                </div>

                <br><br>
                <div class="botonSubmit">
                    <input type="submit" style=' width:70px;' id="enviar"></input>
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