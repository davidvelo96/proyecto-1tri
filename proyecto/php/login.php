<?php


require_once "clases/DB.php";
require_once "clases/sesion.php";

// $cookie_name = ;
// $cookie_passwd = "123Qwe";
// setcookie("user", $cookie_name, time() + (86400 * 30), "/");
// setcookie("passwd", $cookie_passwd, time() + (86400 * 30), "/");
// // setcookie ("pepe", "", time() - 3600);
// // setcookie ("passwd", "", time() - 3600);
// if (isset($_COOKIE)) {
//     $e=$_COOKIE;
//     // unset($_COOKIE);
//     var_dump($_COOKIE);
//     echo $_COOKIE["user"];
//     echo $_COOKIE["passwd"];
// }


sesion::iniciar();

if (sesion::existe("usuario")) {

    header('Location: tablaUsuarios.php');
} else {


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
                sesion::escribir("usuario", $usuario);

                if (isset($_POST["recuerdame"])) {
                    $cookie_mail = $mail;
                    $cookie_passwd = $_POST['passwd'];
                    setcookie("mail", $cookie_mail, time() + (86400 * 30), "/");
                    setcookie("passwd", $cookie_passwd, time() + (86400 * 30), "/");
                }

                header('Location: tablaUsuarios.php');
            } else {
                $error = "Este usuario no existe";
            }
        }
    }
}

?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>PRUEBA</title>
    <link rel="stylesheet" href="../scss/css/main.css">
    <link rel="stylesheet" href="../css/login.css" title="Color">


</head>

<body>
    <div class="cajaLogeo">
        <div class="cajaImagen">
            <img class="imagenInicio" src="../img/autoescuela.png" alt="Inicio">

        </div>
        <div class="cajaCampos">
            <form action="" method="post">

                <div class="usuario">
                    <p class="tituloCajas">Usuario/email</p>
                    <input class="inputCaja" type="text" placeholder="Marcador de Posicion" name="mail" />
                </div>
                <div class="password">
                    <p class="tituloCajas">Password</p>
                    <input class="inputCaja" type="password" placeholder="Marcador de Posicion" name="passwd" <?php
                                                                                                                if (isset($_COOKIE["passwd"])) {
                                                                                                                    echo "value='" . $_COOKIE["passwd"] . "'";
                                                                                                                }
                                                                                                                ?> />
                    <br>
                    <p><input type="checkbox" name="recuerdame"> Recuerdame</p>
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