<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/altaExamen.css" title="Color">
    <script type="text/javascript" src="../js/altaExamen.js"></script>

    <title>Registro</title>
</head>

<body>
    <div class="cuadroAlta">
        <div class="titulo">
            <h1>Alta de examen</h1>
        </div>
        <form action="" method="post">
            <div class="cajaCampos">
                <p>
                    Descripcion
                    <input type='text' style='width:200px; margin-right: 5%;' name='descripcion' pattern='[A-Za-z ]{1,30}''  required/>
                    Duracion
                    <input type=' text' style='width:50px;' name='duracion' pattern='[0-9]{1,8}''  required/>
                </p>

                <div id="tabla1">
                    <table border="1" class="t1">
                    <thead>
                        <tr>
                            <th>Sel.</th>
                            <th>Enunciado</th>
                            <th>Tematica</th>
                        </tr>                       
                     </thead>
                        <tbody id="tablaPre">
                        </tbody>
                    </table>
                </div>
                
                <div class="botones">
                    <input type="button" value=&#9668== id="izquierda">
                    <br>
                    <input type="button" value===&#9658 id="derecha">
                </div>
                
                <div id="tabla2">
                    <table border="1" class="t2">
                        <thead>
                            <tr><th>ID</th><th>Enunciado</th><th>Tematica</th></tr>
                        </thead>
                        <tbody id="tablaPost">
                        </tbody>
                    </table>
                </div>

                <br><br>
                <div class="botonSubmit">
                    <input type="submit" style=' width:70px;' name="alta"></input>
                </div>

            </div>
        </form>
    </div> 
</body>


</html>