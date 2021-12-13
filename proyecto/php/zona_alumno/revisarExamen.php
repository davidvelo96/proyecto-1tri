<?php
require_once "../clases/DB.php";
require_once "../clases/usuarios.php";
require_once "../clases/sesion.php";

sesion::iniciar();
$usuario = sesion::leer("usuario");
DB::conecta();
if (!empty($_GET["exa"])) {
    if (!empty($usuario)) {

        // if ($usuario->getRol() != "PROFESOR") {
        //     header('Location: datosPersonales.php');
        // }
    } else {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}


?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../../css/realizaExa.css" title="Color">
    <link rel="stylesheet" href="../../css/comun.css" title="Color">
    <script type="text/javascript" src="../../js/revisarExamen.js"></script>


    <title>Registro</title>

</head>



<body>

    <header>
        <div class="perfil">
            <img src="../../img/batman.png" width="100px" height="100px">
            <a href="datosPersonales.php">
                <?php
                $usuario = sesion::leer("usuario");
                echo $usuario->getFoto() == null ? " <img src='../../img/iconoperfil.jpg' width='50px' height='50px' style='margin:20%;'> " : " <img src='../" . $usuario->getFoto() . "' width='50px' height='50px' style='margin:20%;'> ";
                ?>
            </a>
        </div>


        <div class="nav">
            <?php
                if ($usuario->getRol() == "PROFESOR") {

                 echo   "<nav id='menu'>
                    <ul>
                        <li><a href='../tablaUsuarios.php'>Usuarios</a>
                            <ul>
                                <li><a href='../altaUsuarios.php'>Alta usuarios</a></li>
                                <li><a href='../altaMasivaUsuarios.php'>Alta masiva</a></li>
                            </ul>
                        </li>
                        <li><a href='../tablaTematicas.php'>Tematicas</a>
                            <ul>
                                <li><a href='../altaTematica.php'>Alta tematicas</a></li>
                            </ul>
                        </li>
                        <li><a href='../tablaPreguntas.php'>Preguntas</a>
                            <ul>
                                <li><a href='../altaPregunta.php'>Alta preguntas</a></li>
                                <li><a href=''>Alta masiva</a></li>
                            </ul>
                        </li>
                        <li><a href='../tablaExamen'>Examenes</a>
                            <ul>
                                <li><a href='../altaExamen.php'>Alta examen</a></li>
                                <li><a href='../historicoExamenes.php'>Historico</a></li>
                            </ul>
                        </li>
                    </ul>
                    </nav>";

                }
                else {
                    echo "<nav id='menu'>
                    <ul>
                        <li><a href='historico_ex_alumno.php'>Historico de examenes</a></li>
                        <li><a href='examenes_predefinidos.php'>Examen predefinido</a></li>
                        <li><a href='zona_alumno/realizarExamen.php?exam=" . DB::examenAleatorio() . "'>Examen aleatorio</a></li>
                    </ul>
                </nav>";                
            }
            ?>
            
        </div>

       

    </header>


    <div class="cuadroAlta">
        <div id="pregunta">
            <div id="titulo">
                <h1 id="titulo_preg">Pregunta 1</h1>
            </div>

        </div>

        <div class="botones">
            <form action="">
                <input type="button" value="Atras">
                <input type="button" value="Siguiente">

        </div>

        <div class="n_preguntas">

            <table>
                <tbody id="n_preguntas">

                </tbody>
            </table>
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