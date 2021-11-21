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
        if (DB::existeTematica($tematica)){
            $error="Tematica ya existe";
        }else {
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
</head>

<body>
    <div class="cajaLogeo">
        <div class="cajaCampos">
            <form action="" method="post">

                <div class="usuario">
                    <p class="tituloCajas">Descripcion</p>
                    <input class="inputCaja" type="text" pattern="[A-Za-z ]{1,30}" placeholder="Marcador de Posicion" name="tematica" title="Maximo 30 caracteres, solo letras y espacios"/>
                </div>
                <input class="botonSubmit" type="submit" value="Aceptar" name="enviar" />
                <br>
                    <?php
                        echo "<span style='color:red;'>" . $error . "</span>";
                     ?>               
            </form>
        </div>
      
    </div>

       
</body>



</html>