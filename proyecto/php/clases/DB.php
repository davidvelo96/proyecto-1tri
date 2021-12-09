<?php

// foreach (glob("./*.php") as $filename) cell(sd/sd)
// {
//     require_once $filename;
// }

require_once "DB.php";
require_once "usuarios.php";
require_once "tematicas.php";
require_once "preguntas.php";
require_once "respuestas.php";



class DB
{


    private static $con;

    public static function conecta()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=proyecto', 'root', '');
    }

    public static function getConex()
    {
        return self::$con;
    }


    public static function newTematica($desc)
    {

        $tem = new tematicas("default", $desc);
        return $tem;
    }

    // FUNCION QUE NOS DEVUELVE TODAS LAS TEMATICAS

    public static function cuentaUsuarios()
    {
        $resultado = self::$con->query("SELECT COUNT(*) FROM usuarios");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function obtienetematicas()
    {
        $resultado = self::$con->query("SELECT * FROM tematicas order by id");

        $t = [];
        while ($registro = $resultado->fetchObject()) {
            $t[] = new tematicas($registro->id, $registro->descripcion);
        }
        return $t;
    }

    public static function cuentatematicas()
    {
        $resultado = self::$con->query("SELECT COUNT(*) FROM tematicas");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaRespuestas()
    {
        $resultado = self::$con->query("SELECT id FROM respuestas ORDER BY id DESC LIMIT 1");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaPreguntas()
    {
        $resultado = self::$con->query("SELECT COUNT(*) FROM preguntas");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaExamenesAlum($id)
    {
        $resultado = self::$con->query("select count(*) from examenes_hechos where id_alumno = $id");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaExamenesHechos()
    {
        $resultado = self::$con->query("select count(*) from examenes_hechos");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }


    public static function ultiPreguntas()
    {
        $resultado = self::$con->query("SELECT id FROM preguntas ORDER BY id DESC LIMIT 1");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function ultiUsuario()
    {
        $resultado = self::$con->query("SELECT id FROM usuarios ORDER BY id DESC LIMIT 1");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaExamenes()
    {
        $resultado = self::$con->query("SELECT COUNT(*) FROM examenes");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }


    public static function existeTematica($tema)
    {
        $resultado = self::$con->query("SELECT * FROM tematicas where descripcion like '" . $tema . "'");

        $t = "";
        while ($registro = $resultado->fetchObject()) {
            $t = new tematicas($registro->id, $registro->descripcion);
        }
        return $t;
    }

    public static function altaTematica($t)
    {
        // $sql = "INSERT INTO usuarios (`email`, `nombre`, `apellidos`, `passwd`, `fecha_nacimiento`, `rol`, `activo`) VALUES ('$correo','$nom','$apellidos','$passwd','$fechaNac','$rol','$activo')";

        $consulta = self::$con->prepare("INSERT INTO tematicas ( descripcion) VALUES (?)");

        // $id="default";
        $descrip = $t->getDesc();
        // $consulta->bindParam(1,$id);
        $consulta->bindParam(1, $descrip);

        $consulta->execute();
    }

    public static function obtienePreguntasEx()
    {
        $resultado = self::$con->query("SELECT preguntas.id,preguntas.enunciado,tematicas.descripcion FROM preguntas JOIN tematicas ON preguntas.tematicas_id = tematicas.id order by preguntas.id");

        return $resultado;
    }

    public static function obtieneExamen($id)
    {
        $resul = self::$con->query(
            "SELECT id,descripcion,duracion,n_preguntas
                                    FROM   examenes
                                    WHERE  id = $id ;"
        );
        return $resul;
    }
    public static function obtieneExamen_edit($id)
    {
        $resul = self::$con->query(
            "SELECT id,descripcion,duracion,n_preguntas
                                    FROM   examenes
                                    WHERE  id = $id ;"
        );
        $re = "";
        $re = $resul->fetchObject();
        return $re;
    }
    

    public static function examenAleatorio()
    {
        $e = [];

        $resul = self::$con->query(
            "SELECT id FROM  examenes;"
        );
        while ($registro = $resul->fetchObject()) {
            $e[] = $registro->id;
        }
        shuffle($e);

        return $e[0];
    }

    public static function altaPregunta($p)
    {
        $consulta = self::$con->prepare("INSERT INTO preguntas (enunciado,tematicas_id,recurso) VALUES (?,?,?)");

        $enunciado = $p->getEnunciado();
        $tem_id = $p->getTematica();
        $image = $p->getRecurso();

        $consulta->bindParam(1, $enunciado);
        $consulta->bindParam(2, $tem_id);
        $consulta->bindParam(3, $image);

        $consulta->execute();
    }

    public static function altaRespuestas($r)
    {
        $consulta = self::$con->prepare("INSERT INTO respuestas (id,enunciado, preguntas_id) VALUES (?,?,?)");

        $id = $r->getId();
        $enunciado = $r->getEnunciado();
        $preguntas_id = $r->getPreguntas_id();

        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $enunciado);
        $consulta->bindParam(3, $preguntas_id);

        $consulta->execute();
    }

    // METODO QUE DEVUELVE UN ALUMNO

    public static function obtieneUsuario($correo)
    {
        $resultado = self::$con->query("SELECT * FROM usuarios where email='" . $correo . "'");

        $u = "";
        while ($registro = $resultado->fetchObject()) {
            $u = new usuarios($registro->id, $registro->email, $registro->nombre, $registro->apellidos, $registro->passwd, $registro->fecha_nacimiento, $registro->foto, $registro->rol);
        }
        return $u;
    }

    public static function obtieneUsuarioPendiente($id)
    {
        $resultado = self::$con->query("SELECT * FROM usuarios_pendientes where usuario_id = $id");

        return $resultado->fetch();
    }
    // METODO QUE COMPRUEBA EN EL LOGIN SI UN ALUMNO EXISTE

    public static function existeusuario($mail, $password)
    {
        $sql = "SELECT * FROM usuarios WHERE email='" . $mail . "' AND passwd='" . $password . "'";
        $resultado = self::$con->query($sql);
        $u = "";
        while ($registro = $resultado->fetchObject()) {
            $u = new usuarios($registro->id, $registro->email, $registro->nombre, $registro->apellidos, $registro->passwd, $registro->fecha_nacimiento, $registro->foto, $registro->rol);
        }
        return $u;
    }

    // METODO QUE DA DE ALTA EN LA BD UN ALUMNO NUEVO PERO NO LO ACTIVA

    public static function altaUsuario($u)
    {

        $consulta = self::$con->prepare("INSERT INTO usuarios (id, email,nombre, apellidos, fecha_nacimiento, rol) VALUES (?,?,?,?,?,?)");

        $id = "default";
        $correo = $u->getCorreo();
        $nom = $u->getNombre();
        $apellidos = $u->getApellidos();
        $fechaNac = $u->getFechaNac();
        $rol = $u->getRol();

        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $correo);
        $consulta->bindParam(3, $nom);
        $consulta->bindParam(4, $apellidos);
        $consulta->bindParam(5, $fechaNac);
        $consulta->bindParam(6, $rol);

        $consulta->execute();
    }

    public static function altaUsuarioPendiente($id)
    {

        $consulta = self::$con->prepare("INSERT INTO usuarios_pendientes (fecha,usuario_id) VALUES (?,?)");

        $fecha = date("Y-m-d H:i:s");

        $consulta->bindParam(1, $fecha);
        $consulta->bindParam(2, $id);

        $consulta->execute();
    }

    public static function editaUsuario($u)
    {

        $consulta = self::$con->prepare("UPDATE usuarios 
                                        SET nombre = ?,
                                        apellidos = ?,
                                        passwd = ?,
                                        fecha_nacimiento = ?
                                        WHERE email = ?)");
        $id = $u->getId();
        $nom = $u->getNombre();
        $apellidos = $u->getApellidos();
        $passwd = $u->getPasswd();
        $fechaNac = $u->getFechaNac();

        $consulta->bindParam(1, $nom);
        $consulta->bindParam(2, $apellidos);
        $consulta->bindParam(3, $passwd);
        $consulta->bindParam(4, $fechaNac);
        $consulta->bindParam(5, $id);


        $consulta->execute();
    }


    public static function altaExamen($u)
    {

        $consulta = self::$con->prepare("INSERT INTO examenes (id, descripcion,duracion,n_preguntas, activo) VALUES (?,?,?,?,?)");

        $id = "default";
        $desc = $u->getDesc();
        $duracion = $u->getDuracion();
        $n_preguntas = $u->getN_preguntas();
        $activo = "0";

        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $desc);
        $consulta->bindParam(3, $duracion);
        $consulta->bindParam(4, $n_preguntas);
        $consulta->bindParam(5, $activo);

        $consulta->execute();
    }

    public static function editaExamen($u)
    {

        $consulta = self::$con->prepare("UPDATE examenes set 
                                        descripcion = ?,
                                        duracion = ?,
                                        n_preguntas = ?
                                        WHERE id = ?");

        $id = $u->getId();
        $desc = $u->getDesc();
        $duracion = $u->getDuracion();
        $n_preguntas = $u->getN_preguntas();

        $consulta->bindParam(1, $desc);
        $consulta->bindParam(2, $duracion);
        $consulta->bindParam(3, $n_preguntas);
        $consulta->bindParam(4, $id);

        $consulta->execute();
    }

    public static function borraExamenPreg($id)
    {
        $re =  self::$con->exec("DELETE from examenes_preguntas WHERE examenes_id = $id ");
        return $re;
    }

    public static function altaExamen_preg($ep)
    {

        $consulta = self::$con->prepare("INSERT INTO examenes_preguntas (preguntas_id,examenes_id) VALUES (?,?)");

        $id = $ep->getPreguntas_id();
        $desc = $ep->getexamenes_id();

        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $desc);

        $consulta->execute();
    }


    public static function obtienePreguntasPaginadas(int $pagina, int $filas): array
    {
        $registros = array();
        $res = self::$con->query("select * from preguntas");
        $registros = $res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total / $filas);
        $registros = array();
        if ($pagina <= $paginas) {
            $pagina == 0 ? $inicio = ($pagina) * $filas : $inicio = ($pagina) * $filas;

            $res = self::$con->query("SELECT preguntas.id, preguntas.enunciado,tematicas.descripcion
                                        FROM   preguntas
                                            JOIN tematicas
                                            ON preguntas.tematicas_id = tematicas.id
                                        WHERE  preguntas.tematicas_id = tematicas.id order by preguntas.id limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }

    public static function obtieneTematicasPaginadas(int $pagina, int $filas): array
    {
        $registros = array();
        $res = self::$con->query("select * from tematicas");
        $registros = $res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total / $filas);
        $registros = array();
        if ($pagina <= $paginas) {
            $pagina == 0 ? $inicio = ($pagina) * $filas : $inicio = ($pagina) * $filas;

            $res = self::$con->query("SELECT id,descripcion
                                        FROM   tematicas
                                        order by id limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }


    public static function obtienePregunta($id)
    {
        $resultado = self::$con->query("SELECT * FROM preguntas where id = $id");
        $re = "";
        $re = $resultado->fetchObject();
        return $re;
    }

    public static function obtienePreguntaExamen($id)
    {
        $resultado = self::$con->query("SELECT preguntas.enunciado,preguntas.id as id_preg,preguntas.recurso
                                        FROM   preguntas
                                        join examenes_preguntas on examenes_preguntas.preguntas_id = preguntas.id
                                        WHERE  examenes_preguntas.examenes_id = $id ;");
        while ($registro = $resultado->fetchObject()) {
            $re[] = $registro;
        }
        return $re;
    }

    public static function obtienePreguntaExamenEdit($id)
    {
        $resultado = self::$con->query("  SELECT preguntas.id
                                            FROM   preguntas
                                            join examenes_preguntas on examenes_preguntas.preguntas_id = preguntas.id
                                            WHERE  examenes_preguntas.examenes_id = $id ;");
        while ($registro = $resultado->fetchObject()) {
            $re[] = $registro;
        }
        return $re;
    }

    public static function obtieneRespuestas($id)
    {
        $resultado = self::$con->query("select * from respuestas where preguntas_id=$id");
        $re = [];

        while ($registro = $resultado->fetchObject()) {
            $re[] = $registro;
        }
        return $re;
    }

    public static function obtieneTematica($id)
    {
        $resultado = self::$con->query("SELECT * FROM tematicas where id = $id");
        $re = "";
        $re = $resultado->fetchObject();
        return $re;
    }


    public static function editaPregunta($p, $id)
    {
        $consulta = self::$con->prepare("UPDATE preguntas
                    SET enunciado = ?,
                    resp_correcta = ?,
                    tematicas_id = ?
                    WHERE id = $id");

        $enunciado = $p->getEnunciado();
        $resp_correct = $p->getResp_correcta();
        $tem_id = $p->getTematica();

        $consulta->bindParam(1, $enunciado);
        $consulta->bindParam(2, $resp_correct);
        $consulta->bindParam(3, $tem_id);

        $consulta->execute();
    }

    public static function editaRespuesta($r, $id)
    {
        $consulta = self::$con->prepare("UPDATE respuestas
                    SET enunciado = ?
                    WHERE id = $id ");

        $enunciado = $r->getEnunciado();

        $consulta->bindParam(1, $enunciado);

        $consulta->execute();
    }

    public static function borraPregunta($id)
    {
        $re =  self::$con->exec("DELETE from preguntas WHERE id = $id ");
        return $re;
    }

    public static function editaTematica($t, $id)
    {
        $consulta = self::$con->prepare("UPDATE tematicas
        SET descripcion = ?
        WHERE id = $id");

        $desc = $t->getDesc();
        $consulta->bindParam(1, $desc);

        $consulta->execute();
    }


    public static function obtieneUsuarioPaginados(int $pagina, int $filas): array
    {
        $registros = array();
        $res = self::$con->query("select * from usuarios");
        $registros = $res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total / $filas);
        $registros = array();
        if ($pagina <= $paginas) {
            $pagina == 0 ? $inicio = ($pagina) * $filas : $inicio = ($pagina) * $filas;

            $res = self::$con->query("SELECT nombre,apellidos,rol,id
                                        FROM   usuarios
                                        order by id limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }

    public static function obtieneExamenesPaginadas(int $pagina, int $filas): array
    {
        $registros = array();
        $res = self::$con->query("select * from examenes");
        $registros = $res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total / $filas);
        $registros = array();
        if ($pagina <= $paginas) {
            $pagina == 0 ? $inicio = ($pagina) * $filas : $inicio = ($pagina) * $filas;

            $res = self::$con->query("SELECT id,descripcion,duracion,n_preguntas
                                        FROM   examenes
                                        order by id limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }

    public static function updateCorrecta($id, $imag)
    {
        $correc = self::cuentaRespuestas();
        $consulta = self::$con->prepare("UPDATE preguntas
        SET resp_correcta = ?,
        recurso = ?
        WHERE id = ?");

        $consulta->bindParam(1, $correc);
        $consulta->bindParam(2, $imag);
        $consulta->bindParam(3, $id);

        $consulta->execute();
    }


    public static function altaExamen_Hecho($examen)
    {

        $consulta = self::$con->prepare("INSERT INTO examenes_hechos (id_examen, id_alumno,fecha,ejecucion) VALUES (?,?,?,?)");

        $id_examen = $examen->getId_examen();
        $id_alumno = $examen->getid_alumno();
        $fecha = $examen->getfecha();
        $ejecucion = $examen->getEjecucion();

        $consulta->bindParam(1, $id_examen);
        $consulta->bindParam(2, $id_alumno);
        $consulta->bindParam(3, $fecha);
        $consulta->bindParam(4, $ejecucion);

        $consulta->execute();
    }

    public static function obtieneRespuesta_correc($id_preg)
    {
        $resultado = self::$con->query("select resp_correcta from preguntas where id=$id_preg");

        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }


    public static function obtieneExamenesHechosPag(int $pagina, int $filas): array
    {
        $registros = array();
        $res = self::$con->query("select * from examenes_hechos");
        $registros = $res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total / $filas);
        $registros = array();
        if ($pagina <= $paginas) {
            $pagina == 0 ? $inicio = ($pagina) * $filas : $inicio = ($pagina) * $filas;

            $res = self::$con->query("SELECT examenes_hechos.fecha,usuarios.nombre,examenes_hechos.ejecucion,examenes_hechos.id  
			                            from examenes_hechos join usuarios
			                            on examenes_hechos.id_alumno = usuarios.id
                                        order by examenes_hechos.id limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }

    public static function obtieneExamenesHechosPagAlumno(int $pagina, int $filas, $id): array
    {
        $registros = array();
        $res = self::$con->query("select * from examenes_hechos where id_alumno = $id ");
        $registros = $res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total / $filas);
        $registros = array();
        if ($pagina <= $paginas) {
            $pagina == 0 ? $inicio = ($pagina) * $filas : $inicio = ($pagina) * $filas;

            $res = self::$con->query("SELECT examenes_hechos.fecha,examenes_hechos.ejecucion,examenes_hechos.id 
                                        from examenes_hechos join usuarios
                                        on examenes_hechos.id_alumno = usuarios.id
                                        where usuarios.id = $id
                                        order by examenes_hechos.id limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }

    public static function obtieneExamenesHecho_Alumno($id)
    {
        $res = self::$con->query("SELECT examenes_hechos.fecha,examenes_hechos.ejecucion,examenes_hechos.id 
                                        from examenes_hechos join usuarios
                                        on examenes_hechos.id_alumno = usuarios.id
                                        where usuarios.id = $id
                                        order by examenes_hechos.id");
        $registros = $res->fetchAll(PDO::FETCH_ASSOC);

        return $registros;
    }

    public static function obtieneExamenesHecho_id($id)
    {
        $res = self::$con->query("SELECT ejecucion,id 
                                        from examenes_hechos 
                                        where id = $id
                                        order by id");
        $registros = $res->fetchAll(PDO::FETCH_ASSOC);

        return $registros;
    }

    public static function obtienePuntuacion($datos)
    {
        $correg = [];
        $finsuma = 0;

        for ($i = 0; $i < count($datos->n_preguntas); $i++) {
            $contest = $datos->respuestas_seleccionadas[$i];
            $correcta = DB::obtieneRespuesta_correc($datos->n_preguntas[$i][0]);
            if ($contest == $correcta) {
                $correg[$i] = "1";
            } else {
                $correg[$i] = "";
            }
        }

        $valor_resp = ceil(100 / count($datos->n_preguntas));
        for ($i = 0; $i < count($datos->n_preguntas); $i++) {
            if (!empty($correg[$i])) {
                $finsuma += 1;
            }
        }
        $total = $finsuma * $valor_resp;
        return $total;
    }

    public static function borraUsuarioPendiente($id_usu)
    {
        $re =  self::$con->exec("DELETE from usuarios_pendientes WHERE usuario_id = $id_usu ");
        return $re;
    }

    public static function confirmaPasswdPendiente($passwd, $id_usu)
    {
        $re =  self::$con->prepare("UPDATE usuarios SET passwd = ? WHERE id = ?");

        $re->bindParam(1, $passwd);
        $re->bindParam(2, $id_usu);

        $re->execute();
    }


    // public static function existeusuario($usuario,$password)
    // {

    //     $sql = "SELECT * FROM usuario WHERE nombre='".$usuario."' AND passwd='".$password."'";

    //     $resultado = self::$con->query($sql);
    //     $u="";

    //     while ($registro = $resultado->fetchObject()) 
    //     {
    //         $u = new usuario($registro->nombre,$registro->correo,$registro->passwd,$registro->rol,$registro->foto);
    //     }
    //     return $u;        
    // }


    // public function borraUsuario(){
    //     $consulta = self::$con->prepare("DELETE FROM usuario (nombre, correo, passwd, rol) VALUES (?,?,?,?)");
    //     $nom=$p->getNombre();
    //     $correo=$p->getCorreo();
    //     $passwd=$p->getPasswd();
    //     $rol=$p->getRol();

    //     $consulta->bindParam(1,$nom);
    //     $consulta->bindParam(2,$correo);
    //     $consulta->bindParam(3,$passwd);
    //     $consulta->bindParam(4,$rol);

    //     $consulta->execute();

    // }




    // if (isset($_POST["mostrar"])) {
    //     select($dwes);
    // }

    // if (isset($_POST["guardar"])) {
    //     // $sql="INSERT INTO usuario (nombre, correo, passwd, rol) VALUES ('a', 'a', 'a', 'a')";
    //     $sql = "INSERT INTO usuario (nombre, correo, passwd, rol) VALUES ('" . $_POST["nombre"] . "', '" . $_POST["correo"] . "', '" . $_POST["contra"] . "', '" . $_POST["rol"] . "')";
    //     $dwes->exec($sql);
    // }




    // function select($dwes)
    // {
    //     $resultado = $dwes->query("SELECT * FROM usuario");

    //     while ($registro = $resultado->fetch()) {
    //         echo "Usuarios " . $registro['nombre'] . ": " . $registro['correo'] . " " . $registro['passwd'] . $registro['rol'] . "<br />";
    //     }

    //     $uwu=$resultado->fetch(PDO::FETCH_NUM);
    //     echo $uwu[0];
    //     $registros = $dwes->exec('SELECT * FROM usuario');

    //     while ($registro = $resultado->fetchObject()) {
    //         echo $registro->nombre.",".$registro->correo."<br>";
    //     }

    // }
}
