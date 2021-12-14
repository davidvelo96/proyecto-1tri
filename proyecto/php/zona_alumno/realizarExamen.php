<?php
require_once "../clases/DB.php";
require_once "../clases/usuarios.php";
require_once "../clases/sesion.php";


sesion::iniciar();
$usuario = sesion::leer("usuario");
if (!empty($usuario)) {

    if ($usuario->getRol() != "ALUMNO") {
        header('Location: ../tablaUsuarios.php');
    }

} else {
    header('Location: ../login.php');
}
?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../../css/realizaExa.css" title="Color">
    <link rel="stylesheet" href="../../scss/css/main.css">
    <script type="text/javascript" src="../../js/realizaExamen.js"></script>


    <title>Registro</title>

</head>



<body>

    <header>
        <div class="perfil">
        <img src="../../img/autoescuela.png" width="100px" height="100px">
            <a href="../datosPersonales.php">
                <?php
                $usuario = sesion::leer("usuario");
                echo $usuario->getFoto() == null ? " <img src='../../img/iconoperfil.jpg' width='50px' height='50px' style='margin:20%;'> " : " <img src='../" . $usuario->getFoto() . "' width='50px' height='50px' style='margin:20%;'> ";
                ?>
            </a>
        </div>


        <div class="nav">
        <nav id="menu">
                <ul>
                    <li><a href="historico_ex_alumno.php">Historico de examenes</a></li>
                    <li><a href="examenes_predefinidos.php">Examen predefinido</a></li>
                    <li><a href="examen_aleatorio.php">Examen aleatorio</a></li>
                </ul>
            </nav>
        </div>

    </header>


    <div class="cuadroAlta">
        <div id="pregunta">
            <div id="titulo">
                <h1 id="titulo_preg">Pregunta 1</h1>
                <h1 id="duracion"></h1>
            </div>
           
        </div>

        <div class="botones">
        <form action="">

            <input type="button" id="finExamen" value="Finalizar"></form>
           
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