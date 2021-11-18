<?php

    class usuarios{

        private $id;
        private $correo;
        private $nombre;
        private $apellidos;
        private $passwd;
        private $fechaNac;
        private $rol;
        private $foto;
        private $activo;

        public function __construct($id,$correo,$nombre,$apellidos,$passwd,$fechaNac,$foto,$rol,$activo)
        {
            $this->id=$id;
            $this->nombre=$nombre;
            $this->apellidos=$apellidos;
            $this->correo=$correo;
            $this->passwd=$passwd;
            $this->fechaNac=$fechaNac;
            $this->rol=$rol;     
            $this->foto=$foto;     
            $this->activo=$activo;     
        }

        public function getId(){return $this->id;}
        public function getNombre(){return $this->nombre;}
        public function getApellidos(){return $this->apellidos;}
        public function getCorreo(){return $this->correo;}
        public function getPasswd(){return $this->passwd;}
        public function getFechaNac(){return $this->fechaNac;}
        public function getRol(){return $this->rol;}
        public function getFoto(){return $this->foto;}
        public function isActivo(){return $this->activo;}


        public static function muestraDatos($user){
            echo $user->getNombre()."-".$user->getCorreo()."-".$user->getPasswd()."-".$user->getRol()."<img src='data:image/png;base64,".$user->getFoto()."'><br>";

        }

    }

?>