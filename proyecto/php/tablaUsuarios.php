<!--tabla usuario por dar alta ----- id usuario, id, fecha   ".DB::borraPregunta($_GET['borrar'])." -->
<?php
require_once "usuarios.php";
require_once "sesion.php";

    sesion::iniciar();
    $usuario=sesion::leer("usuario");
    if ($usuario->getRol()!="PROFESOR") {
        header('Location: datosPersonales.php');
    } 

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/tablaUsu.css" title="Color">
    <link rel="stylesheet" href="../css/comun.css" title="Color">

    <title>Registro</title>

</head>



<body>

<header>
    <div class="perfil">
        <img src="../img/batman.png" width="100px" height="100px">
        <a href="datosPersonales.php"> <img src="../img/batman.png" width="100px" height="100px"></a>
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
                            <li><a href="altaExamen.php">Alta examen</a></li>
                            <li><a href="">Historico</a></li>
                        </ul>   
                    </li>
                </ul>
            </nav>
        </div>

    </header>


    <div class="cuadroAlta">
        <div class="titulo">
            <h1>Usuarios </h1>
        </div>
        <div class="search">
            <input type="text">
        </div>
        <table border="1" class="t1">
            <thead>
                <tr>
                    <th>Alumno/a</th>
                    <th>Rol</th>
                    <th>Examenes realizados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaPre">
                <?php
                    require_once("DB.php");
                    DB::conecta();
                    $pagina = isset($_GET['pag']) ? $_GET['pag'] : 0;
                    $filas=3;
                    $lista = DB::obtieneUsuarioPaginados($pagina, $filas);
                    for ($i = 0; $i < count($lista); $i++) {
                        echo "<tr>";
                        echo "<td>" . $lista[$i]['nombre']." ". $lista[$i]['apellidos'] . "</td>";
                        echo "<td>" . $lista[$i]['rol'] . "</td>";
                        echo "<td> Calcular cuando haga examenes </td>";
                        echo "<td><a href='#'>Editar</a><a href='#'>Borrar</a></td>";
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
                    $paginas = ceil(DB::cuentaUsuarios() / $filas);

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


<?php 
require_once "DB.php";

    if (isset($_GET['borrar'])) {
        echo "<script>
        if(confirm('Estas seguro que quieres borrar la pregunta ".$_GET['borrar']." ?')){

           ".DB::borraPregunta($_GET['borrar']).";
            alert('Operacion aceptada');   
            document.location='tablaPreguntas.php';
 
        } 
        else  
        {         
            alert('Operacion Cancelada');    
        }
        </script> ";
    }

?>