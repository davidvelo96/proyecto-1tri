<?php
require_once "clases/sesion.php";

sesion::iniciar();
$usuario = sesion::leer("usuario");
if (!empty($usuario)) {
    Sesion::eliminar('usuario');
    Sesion::destruir();
    header("Location:login.php");
} else {
    header("Location:login.php");
}
