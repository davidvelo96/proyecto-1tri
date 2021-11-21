<?php
    require_once "DB.php";
    require_once "preguntas.php";
    require_once "respuestas.php";



    if (isset($_POST["alta"])) {
        // $resul=validar();
        // if ($resul=="") {
            DB::conecta();
            // if (DB::obtieneUsuario($_POST["mail"])){
            //     $error="Este usuario ya existe";
            // }else {
                $CRespuestas=DB::cuentaRespuestas();
                $cuentaPreguntas=DB::cuentaPreguntas();
                $correc=$_POST["respuesta"];
                // ,$_POST[$correc]
                $respuestas=[$_POST[$CRespuestas+1],$_POST[$CRespuestas+2],$_POST[$CRespuestas+3],$_POST[$CRespuestas+4]];

                $pregunta=new preguntas("default",$_POST["enun"],$correc,"null",$_POST["tematica"],$respuestas);
                DB::altaPregunta($pregunta);
                $i=1;
                while ($i<=4) {
                    $respuestas=new respuestas("default",$_POST[$CRespuestas+$i],($cuentaPreguntas+1));
                    DB::altaRespuestas($respuestas);
                    $i++;
                }
            }
        // }
    // }
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
            <p>Alta de preguntas</p>
        </div>
        <form action="" method="post">
            <div class="cajaCampos">
                <p>Tematica</p>
                <select name="tematica" required>
                    <option value="" selected>Seleccionar</option>
                    <?php
                        DB::conecta();
                        $tematicas=""; 
                        $tematicas = DB::obtienetematicas();
                        $count = DB::cuentatematicas();
                        for ($i=0; $i < $count; $i++) { 
                            echo  "<option value='".$tematicas[$i]->getId()."'>".$tematicas[$i]->getDesc()."</option>";
                        }
                    ?>
                    
                </select>
                <p>Enunciado</p>
                <textarea required pattern="[A-Za-z ]{1,30}" style='width:200px; height:100px;' name="enun"></textarea>
               
                <?php
                    DB::conecta();
                    $CRespuestas=DB::cuentaRespuestas();
                    echo "<p>Opcion 1</p>";
                    echo "<input type='text' style='width:200px;' name='".($CRespuestas+1)."' pattern='[A-Za-z 0-9]{1,30}''  required/>"; 
                    echo "<input type='radio' id='".($CRespuestas+1)."' name='respuesta' value='".($CRespuestas+1)."' required/>correcta"; 
                    echo "<p>Opcion 2</p>";
                    echo "<input type='text' style='width:200px;' name='".($CRespuestas+2)."' pattern='[A-Za-z 0-9]{1,30}'' required />";
                    echo "<input type='radio' id='".($CRespuestas+2)."'name='respuesta' value='".($CRespuestas+2)."' required/>correcta"; 
                    echo "<p>Opcion 3</p>";
                    echo "<input type='text' style='width:200px;' name='".($CRespuestas+3)."' pattern='[A-Za-z 0-9]{1,30}''  required/>";
                    echo "<input type='radio' id='".($CRespuestas+3)."'name='respuesta' value='".($CRespuestas+3)."' required/>correcta"; 
                    echo "<p>Opcion 4</p>";
                    echo "<input type='text' style='width:200px;' name='".($CRespuestas+4)."' pattern='[A-Za-z 0-9]{1,30}'' required />";  
                    echo "<input type='radio' id='".($CRespuestas+4)."'name='respuesta' value='".($CRespuestas+4)."' required/>correcta"; 
                ?>
              
                <br><br>
                <div class="botonSubmit">
                  <input type="submit" style='width:70px;' name="alta"></input>
                </div>
                <!-- <?php
                    echo "<span style='color:red;'>" . $error . "</span>";
                ?>                -->
            </div>
        </form>
</body>


</html>