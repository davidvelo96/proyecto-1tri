<?php

require_once "clases/DB.php";
require_once "clases/examenes.php";
require_once "clases/examenes_preguntas.php";

if (isset($_POST["datos"])) {
    try {
        DB::conecta();

        $con = DB::getConex();
        $con->beginTransaction();
        $datos = json_decode($_POST["datos"]);

        for ($i=0; $i < count($datos->usuarios); $i++) { 
            if (DB::obtieneUsuario($datos->usuarios[$i])==true) {
                $error[]=$datos->usuarios[$i];
            }
            else {
                DB::insertaMasiva($datos->usuarios[$i],"ALUMNO");
                $id_usu=DB::ultiUsuario();
                DB::altaUsuarioPendiente($id_usu);
            }
        }

        echo json_encode($error);

        $con->commit();
    } catch (PDOException $e) {
        $con->rollBack();
    }
} else {
    // header("Location: altaMasivaUsuarios.php");
}
