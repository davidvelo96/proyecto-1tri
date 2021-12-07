<?php

    class respuestas{

        private $id;
        private $enunciado;
        private $preguntas_id;


        public function __construct($id,$enunciado,$preguntas_id)
        {
            $this->id=$id;
            $this->preguntas_id=$preguntas_id;
            $this->enunciado=$enunciado;
    
        }

        public function getId(){return $this->id;}
        public function getPreguntas_id(){return $this->preguntas_id;}
        public function getEnunciado(){return $this->enunciado;}


        // public static function muestraDatos($user){
        //     echo $user->getpreguntas_id()."-".$user->getenunciado()."-".$user->gettematica()."-".$user->getRol()."<img src='data:image/png;base64,".$user->getFoto()."'><br>";

        // }

    }

?>