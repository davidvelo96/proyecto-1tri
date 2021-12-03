<?php
require_once "sesion.php";

sesion::iniciar();

Sesion::eliminar('usuario');
Sesion::destruir();

header("Location:login.php");
