<?php
require_once "DB.php";


if (isset($_POST["alta"])) {
    $resul=validar();
    if ($resul=="") {
        DB::conecta();
        $passwd = md5($_POST["passwd"]);
        $usu = new usuarios("default",$_POST["mail"],$_POST["nombre"],$_POST["apellidos"],$passwd,$_POST["fechaNac"],"null",$_POST["rol"],"0");
        DB::altaUsuario($usu); 
        header('Location: registroUsuarios.html');  
    }
    else {
        header('Location: registroUsuarios.html');
    }
}


function validar(){
    $error="";
    if (!preg_match("/^[a-zA-Z-'\s]+$/",$_POST["nombre"])) {
        $error['name'] = "Solo letras y espacios";
    }
    if (!preg_match("/^[a-zA-Z-'\s]+$/",$_POST["apellidos"])) {
        $error['apes'] = "Solo letras y espacios"; 
    }
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $error['mail'] = "Formato email invalido";
    }

    return $error;

}   

?> 