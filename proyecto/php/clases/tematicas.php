<?php

    class tematicas{

        private $id;
        private $descripcion;

        public function __construct($id,$descripcion)
        {
            $this->id=$id;
            $this->descripcion=$descripcion;   
        }

        public function getId(){return $this->id;}
        public function getDesc(){return $this->descripcion;}


        // public static function muestraDatos($user){
        //     echo $user->getNombre()."-".$user->getCorreo()."-".$user->getPasswd()."-".$user->getRol()."<img src='data:image/png;base64,".$user->getFoto()."'><br>";

        // }

    }

?>