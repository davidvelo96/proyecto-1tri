<?php
require_once "DB.php";

$error="";

if (isset($_POST["alta"])) {
    $resul=validar();
    if ($resul=="") {
        DB::conecta();
        if (DB::obtieneUsuario($_POST["mail"])){
            $error="Este usuario ya existe";
        }else {
            $passwd = md5($_POST["passwd"]);
            $usu = new usuarios("default",$_POST["mail"],$_POST["nombre"],$_POST["apellidos"],$passwd,$_POST["fechaNac"],"null",$_POST["rol"],"0");
            DB::altaUsuario($usu); 
        }
    }
    // else {
    //     header('Location: altaUsuarios.php');
    // }
}


function validar(){
    $err="";
    if (!preg_match("/^[a-zA-Z-'\s]+$/",$_POST["nombre"])) {
        $error['name'] = "Solo letras y espacios";
    }
    // if (!preg_match("/^[a-zA-Z-'\s]+$/",$_POST["apellidos"])) {
    //     $error['apes'] = "Solo letras y espacios"; 
    // }
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $error['mail'] = "Formato email invalido";
    }

    return $err;

}   

?> 

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaUsuarios.css" title="Color">

    <title>Registro</title>
</head>



<body>
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
                <input type="password" style='width:200px;' name="passwd"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,25}" title="minimo 6 caracteres" />
                <p>Fecha de nacimiento</p>
                <input type="date" style='width:200px;' name="fechaNac" required/>
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
</body>


</html>



<!-- oder_by_id_limit 40,10 -->