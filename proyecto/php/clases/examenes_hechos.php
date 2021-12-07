<?php

    class examenes_hechos{

        private $id;
        private $id_examen;
        private $id_alumno;
        private $fecha;
        private $ejecucion;
        
        public function __construct($id,$id_examen,$id_alumno,$fecha,$ejecucion)
        {
            $this->id=$id;
            $this->id_examen=$id_examen;
            $this->id_alumno=$id_alumno;
            $this->fecha=$fecha;
            $this->ejecucion=$ejecucion;
        }

        public function getId(){return $this->id;}
        public function getId_examen(){return $this->id_examen;}
        public function getid_alumno(){return $this->id_alumno;}
        public function getfecha(){return $this->fecha;}
        public function getEjecucion(){return $this->ejecucion;}

    }

?>