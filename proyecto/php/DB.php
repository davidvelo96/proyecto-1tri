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





class DB {

    private static $con;

    public static function conecta()
    {
       self::$con = new PDO('mysql:host=localhost;dbname=proyecto', 'root', '');
    }


    public static function newTematica($desc){

        $tem = new tematicas("default",$desc);
        return $tem;
    }

    // FUNCION QUE NOS DEVUELVE TODAS LAS TEMATICAS

    public static function obtienetematicas(){
        $resultado = self::$con->query("SELECT * FROM tematicas");

        $t=[];
        while ($registro = $resultado->fetchObject()) {
            $t[] = new tematicas($registro->id,$registro->descripcion);
        }
        return $t;
    }

    public static function cuentatematicas(){
        $resultado = self::$con->query("SELECT COUNT(*) FROM tematicas");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaRespuestas(){
        $resultado = self::$con->query("SELECT COUNT(*) FROM respuestas");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }

    public static function cuentaPreguntas(){
        $resultado = self::$con->query("SELECT COUNT(*) FROM preguntas");
        $result = $resultado->fetch();
        $count = $result[0];
        return $count;
    }


    public static function existeTematica($tema){
        $resultado = self::$con->query("SELECT * FROM tematicas where descripcion like '".$tema."'");

        $t="";
        while ($registro = $resultado->fetchObject()) {
            $t = new tematicas($registro->id,$registro->descripcion);
        }
        return $t;
    }
    
    public static function altaTematica ($t)
    {
        // $sql = "INSERT INTO usuarios (`email`, `nombre`, `apellidos`, `passwd`, `fecha_nacimiento`, `rol`, `activo`) VALUES ('$correo','$nom','$apellidos','$passwd','$fechaNac','$rol','$activo')";

        $consulta = self::$con->prepare("INSERT INTO tematicas ( descripcion) VALUES (?)");
       
        // $id="default";
        $descrip=$t->getDesc();


        // $consulta->bindParam(1,$id);
        $consulta->bindParam(1,$descrip);
  

        $consulta->execute();

    }

    public static function altaPregunta ($p)
    {
        $consulta = self::$con->prepare("INSERT INTO preguntas (enunciado, resp_correcta,tematicas_id) VALUES (?,?,?)");
       
        $enunciado=$p->getEnunciado();
        $resp_correct=$p->getResp_correcta();
        $tem_id=$p->getTematica();

        $consulta->bindParam(1,$enunciado);
        $consulta->bindParam(2,$resp_correct);
        $consulta->bindParam(3,$tem_id);

        $consulta->execute();

    }

    public static function altaRespuestas ($r)
    {
        $consulta = self::$con->prepare("INSERT INTO respuestas (id,enunciado, preguntas_id) VALUES (?,?,?)");
       
        $id=$r->getId();
        $enunciado=$r->getEnunciado();
        $preguntas_id=$r->getPreguntas_id();

        $consulta->bindParam(1,$id);
        $consulta->bindParam(2,$enunciado);
        $consulta->bindParam(3,$preguntas_id);

        $consulta->execute();

    }

    // METODO QUE DEVUELVE UN ALUMNO

    public static function obtieneUsuario($correo){
        $resultado = self::$con->query("SELECT * FROM usuarios where email='".$correo."'");

        $u="";
        while ($registro = $resultado->fetchObject()) {
            $u = new usuarios($registro->id,$registro->email,$registro->nombre,$registro->apellidos,$registro->passwd,$registro->fecha_nacimiento,$registro->foto,$registro->rol,$registro->activo);
        }
        return $u;
    }

    // METODO QUE COMPRUEBA EN EL LOGIN SI UN ALUMNO EXISTE

     public static function existeusuario($mail,$password)
    {
        $sql = "SELECT * FROM usuarios WHERE email='".$mail."' AND passwd='".$password."'";       
        $resultado = self::$con->query($sql);
        $u="";
        while ($registro = $resultado->fetchObject()) 
        {
            $u = new usuarios($registro->id,$registro->email,$registro->nombre,$registro->apellidos,$registro->passwd,$registro->fecha_nacimiento,$registro->foto,$registro->rol,$registro->activo);
        }
        return $u;        
    }

    // METODO QUE DA DE ALTA EN LA BD UN ALUMNO NUEVO PERO NO LO ACTIVA

    public static function altaUsuario ($u)
    {


        // $sql = "INSERT INTO usuarios (`email`, `nombre`, `apellidos`, `passwd`, `fecha_nacimiento`, `rol`, `activo`) VALUES ('$correo','$nom','$apellidos','$passwd','$fechaNac','$rol','$activo')";


        $consulta = self::$con->prepare("INSERT INTO usuarios (id, email,nombre, apellidos,passwd, fecha_nacimiento, rol, activo) VALUES (?,?,?,?,?,?,?,?)");
       
        $id="default";
        $correo=$u->getCorreo();
        $nom=$u->getNombre();
        $apellidos=$u->getApellidos();
        $passwd=$u->getPasswd();
        $fechaNac=$u->getFechaNac();
        // $foto="?";
        $rol=$u->getRol();
        $activo="0";

        $consulta->bindParam(1,$id);
        $consulta->bindParam(2,$correo);
        $consulta->bindParam(3,$nom);
        $consulta->bindParam(4,$apellidos);
        $consulta->bindParam(5,$passwd);
        $consulta->bindParam(6,$fechaNac);
        // $consulta->bindParam(7,$foto);
        $consulta->bindParam(7,$rol);
        $consulta->bindParam(8,$activo);

        $consulta->execute();

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
