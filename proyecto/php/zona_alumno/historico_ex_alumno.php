<?php
require_once "../DB.php";
require_once "../usuarios.php";
require_once "../sesion.php";

sesion::iniciar();
$usuario = sesion::leer("usuario");
if ($usuario->getRol() != "ALUMNO") {
    header('Location: ../tablaUsuarios.php');
}


DB::conecta();

$pagina = isset($_GET['pag']) ? $_GET['pag'] : 0;
$filas = 3;
$lista = DB::obtieneExamenesHechosPagAlumno($pagina, $filas, $usuario->getId());
$examenes_alum = DB::obtieneExamenesHecho_Alumno($usuario->getId());

$suma = 0;
$promedio = 0;
$mayor=0;




for ($i = 0; $i < ceil(DB::cuentaExamenesAlum($usuario->getId())); $i++) {
    
    $pun=DB::obtienePuntuacion(json_decode($examenes_alum[$i]['ejecucion']));
    $suma += $pun;
    $pun>$mayor ? $mayor=$pun:$mayor=$mayor;

}
$promedio = ceil($suma / $filas);

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../../css/historico_exa_alum.css" title="Color">
    <link rel="stylesheet" href="../../css/comun.css" title="Color">

    <title>Historico</title>

</head>



<body>

    <header>
        <div class="perfil">
            <img src="../../img/batman.png" width="100px" height="100px">
            <a href="#"> <img src="../../img/batman.png" width="100px" height="100px"></a>
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
        <div class="titulo">
            <div class="titu">
                <h1>Historico de examenes</h1>
            </div>
            <div class="datos">
                <?php
                DB::conecta();
                echo "<p>Promedio de puntuaciones: " . $promedio . "/100</p>";
                echo "<p>Mejor puntuación: ".$mayor."/100</p>";
                echo "<p>Exámenes realizados: " . DB::cuentaExamenesAlum($usuario->getId()) . "</p>";
                ?>
            </div>
        </div>
        <div class="search">
            <input type="text">
        </div>
        <table border="1" class="t1">
            <thead>
                <tr>
                    <th>Fecha/Hora</th>
                    <th>Puntuación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaPre">
                <?php

                for ($i = 0; $i < count($lista); $i++) {
                    echo "<tr>";
                    echo "<td>" . $lista[$i]['fecha'] . "</td>";
                    echo "<td>" . DB::obtienePuntuacion(json_decode($lista[$i]['ejecucion'])) . "/100</td>";
                    $suma += DB::obtienePuntuacion(json_decode($lista[$i]['ejecucion']));
                    echo "<td><a href='#'>Revisar</a></td>";
                    echo "</tr>";
                }

                ?>
            </tbody>
        </table>

        <div class="center">
            <ul class="pagination">
                <?php
                $pagina = isset($_GET['pag']) ? $_GET['pag'] : 0;
                DB::conecta();
                $paginas = ceil(DB::cuentaExamenesAlum($usuario->getId()) / $filas);

                //ENLACES HTML DE LA PAGINA
                if ($pagina != 0) {
                    echo "<li><a href='?pag=0' ><<</a></li>";
                }
                $primera = ($pagina - 2) > 1 ? $pagina - 2 : 0;
                $ultima = ($pagina + 2) < $paginas ? $pagina + 2 : $paginas - 1;
                for ($i = $primera; $i <= $ultima; $i++) {
                    echo "<li ><a class='" . ($pagina == $i ? 'active' : '') . "' href='?pag=" . ($i) . "'>" . ($i + 1) . "</a></li>";
                }
                ?>
            </ul>
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