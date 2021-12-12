<?php
require_once "clases/DB.php";
require_once "clases/sesion.php";
require_once "clases/usuarios.php";

$error = "";
DB::conecta();

if (isset($_GET["confirma"])) {
    if (DB::obtieneUsuarioPendiente($_GET["confirma"]) == true) {
        if (isset($_POST["alta"])) {

            $resul = validar();
            if (empty($resul)) {

                try {
                    $con = DB::getConex();
                    $con->beginTransaction();

                    if ($_POST["passwd"] == $_POST["conf_passwd"]) {
                        $id_usu = $_GET["confirma"];
                        DB::borraUsuarioPendiente($id_usu);
                        DB::confirmaPasswdPendiente(md5($_POST["passwd"]), $id_usu);
                        $con->commit();
                        header('Location: login.php');

                    } else {
                        $error = "Las contraseñas no coinciden";
                    }

                } catch (PDOException $e) {
                    $con->rollBack();
                }
            }
        }
    }
} else {
    header('Location: login.php');
}

function validar()
{
    $error = [];
    if (!preg_match("/(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z\u00d1]).{6,25}/", $_POST["passwd"])) {
        $error['pass1'] = "Contraseña de +6 caracteres, con un numero, una mayus minimo";
    }
    if (!preg_match("/(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z\u00d1]).{6,25}/", $_POST["conf_passwd"])) {
        $error['pass2'] = "Contraseña de +6 caracteres, con un numero, una mayus minimo";
    }


    return $error;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>CONFIRMA PASSWD</title>
    <link rel="stylesheet" href="../scss/css/main.css">
</head>

<body>
    <div class="cajaLogeo">
        <div class="cajaImagen">
            <img class="imagenInicio" src="../img/batman.png" alt="Inicio">
        </div>
        <div class="cajaCampos">
            <form action="" method="post">
                <div class="password">
                    <p class="tituloCajas">Contraseña nueva</p>
                    <input class="inputCaja" type="password" placeholder="Contraseña" name="passwd" pattern="(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z \u00d1]).{6,25}" title="Contraseña de +6 caracteres, con un numero, una mayus minimo" required />
                    <p class="tituloCajas">Confirmar Contraseña</p>
                    <input class="inputCaja" type="password" placeholder="Confirmar contraseña" name="conf_passwd" pattern="(?=.*\d)(?=.*[a-z \u00f1])(?=.*[A-Z \u00d1]).{6,25}" title="Contraseña de +6 caracteres, con un numero, una mayus minimo" required />
                </div>
                <input class="botonSubmit" type="submit" value="Aceptar" name="alta" />
            </form>
        </div>
        <?php
        echo "<span style='color:red;'>" . $error . "</span>";
        ?>
    </div>


</body>



</html>