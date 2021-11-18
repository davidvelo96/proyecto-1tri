<?php

    class examenes{

        private $id;
        private $descripcion;
        private $duracion;
        private $n_preguntas;
        private $activo;
        
        public function __construct($id,$descripcion,$duracion,$n_preguntas,$activo)
        {
            $this->id=$id;
            $this->descripcion=$descripcion;
            $this->duracion=$duracion;
            $this->n_preguntas=$n_preguntas;
            $this->activo=$activo;
        }

        public function getId(){return $this->id;}
        public function getDesc(){return $this->descripcion;}
        public function getDuracion(){return $this->duracion;}
        public function getN_preguntas(){return $this->n_preguntas;}
        public function isActivo(){return $this->activo;}


    }

?>