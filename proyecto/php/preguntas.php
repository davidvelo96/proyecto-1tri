<?php

    class preguntas{

        private $id;
        private $enunciado;
        private $resp_correcta;
        private $recurso;
        private $tematica;


        public function __construct($id,$enunciado,$resp_correcta,$recurso,$tematica)
        {
            $this->id=$id;
            $this->resp_correcta=$resp_correcta;
            $this->recurso=$recurso;
            $this->enunciado=$enunciado;
            $this->tematica=$tematica;
    
        }

        public function getId(){return $this->id;}
        public function getResp_correcta(){return $this->resp_correcta;}
        public function getRecurso(){return $this->recurso;}
        public function getEnunciado(){return $this->enunciado;}
        public function getTematica(){return $this->tematica;}


    }

?>