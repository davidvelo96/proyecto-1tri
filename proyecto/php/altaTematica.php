<?php
require_once "DB.php";

$error = "";

if (isset($_POST["enviar"])) {

    DB::conecta();
    $tematica = $_POST['tematica'];

    if (empty($tematica))
        $error = "Introduce una descripcion";
    else {
        $t = DB::newTematica($tematica);
        if (DB::existeTematica($tematica)) {
            $error = "Tematica ya existe";
        } else {
            DB::altaTematica($t);
        }
    }
}


?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>PRUEBA</title>
    <link rel="stylesheet" href="../css/login.css" title="Color">
    <link rel="stylesheet" href="../css/comun.css" title="Color">

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
                    <li><a href="">Usuarios</a>
                        <ul>
                            <li><a href="">Alta usuarios</a></li>
                            <li><a href="">Alta masiva</a></li>
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
                    <li><a href="">Examenes</a>
                        <ul>
                            <li><a href="altaExamen.php">Alta examen</a></li>
                            <li><a href="">Historico</a></li>
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
                    <input class="inputCaja" type="text" pattern="[A-Za-z ]{1,30}" placeholder="Marcador de Posicion" name="tematica" title="Maximo 30 caracteres, solo letras y espacios" />
                </div>
                <input class="botonSubmit" type="submit" value="Aceptar" name="enviar" />
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