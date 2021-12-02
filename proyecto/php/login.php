<?php
require_once "DB.php";


// require_once "sesion.php";
// require_once "usuario.php";
// require_once "DB.php";

// setcookie ("pepe", "", time() - 3600);
// setcookie ("passwd", "", time() - 3600);
// if (isset($_COOKIE)) {
//     // unset($_COOKIE);
//     var_dump($_COOKIE);
//     // echo $_COOKIE["user"];
//     // echo $_COOKIE["passwd"];
// }

$error = "";

if (isset($_POST["login"])) {

    DB::conecta();
    $mail = $_POST['mail'];
    $password = md5($_POST['passwd']);

    if (empty($mail) || empty($password))
        $error = "Debes introducir un nombre de usuario y una contraseña";
    else {
        $usuario = DB::existeusuario($mail, $password);
        if (!empty($usuario)) {
            header('Location: altaUsuarios.php');
        } else {
            $error = "Este usuario no existe";
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
        <div class="cajaImagen">
            <img class="imagenInicio" src="../img/batman.png" alt="Inicio">
        </div>
        <div class="cajaCampos">
            <form action="" method="post">

                <div class="usuario">
                    <p class="tituloCajas">Usuario/email</p>
                    <input class="inputCaja" type="text" placeholder="Marcador de Posicion" name="mail"/>
                </div>
                <div class="password">
                    <p class="tituloCajas">Password</p>
                    <input class="inputCaja" type="password" placeholder="Marcador de Posicion" name="passwd"/>
                </div>
                <input class="botonSubmit" type="submit" value="Aceptar" name="login" />
                <div class="enlaces">
                    <a href="">¿Has olvidado tu password?</a><br /><br />
                    <?php
                        echo "<span style='color:red;'>" . $error . "</span>";
                        ?>
                </div>
               
            </form>
        </div>
      
    </div>

       
</body>



</html>