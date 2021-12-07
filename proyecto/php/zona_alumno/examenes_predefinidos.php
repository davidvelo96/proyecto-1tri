<!--tabla usuario por dar alta ----- id usuario, id, fecha   ".DB::borraPregunta($_GET['borrar'])." -->
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
    DB::conecta();
} else {
    header('Location: ../login.php');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../../css/tablaUsu.css" title="Color">
    <link rel="stylesheet" href="../../css/comun.css" title="Color">

    <title>Registro</title>

</head>



<body>

    <header>
        <div class="perfil">
            <img src="../../img/batman.png" width="100px" height="100px">
            <a href="#">
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
                    <?php
                    echo "<li><a href='realizarExamen.php?exam=" . DB::examenAleatorio() . "'>Examen aleatorio</a></li>"
                    ?>
                </ul>
            </nav>
        </div>

    </header>


    <div class="cuadroAlta">
        <div class="titulo">
            <h1>Examenes</h1>
        </div>
        <div class="search">
            <input type="text">
        </div>
        <table border="1" class="t1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>Nº preguntas</th>
                    <th>Duracion</th>
                    <th>Realizar</th>
                </tr>
            </thead>
            <tbody id="tablaPre">
                <?php
                DB::conecta();
                $pagina = isset($_GET['pag']) ? $_GET['pag'] : 0;
                $filas = 3;
                $lista = DB::obtieneExamenesPaginadas($pagina, $filas);
                for ($i = 0; $i < count($lista); $i++) {
                    echo "<tr>";
                    echo "<td>" . $lista[$i]['id'] . "</td>";
                    echo "<td>" . $lista[$i]['descripcion'] . "</td>";
                    echo "<td>" . $lista[$i]['n_preguntas'] . "</td>";
                    echo "<td>" . $lista[$i]['duracion'] . "</td>";
                    echo "<td><a href='realizarExamen.php?exam=" . $lista[$i]['id'] . "'>Realizar</a></td>";
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
                $paginas = ceil(DB::cuentaExamenes() / $filas);

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