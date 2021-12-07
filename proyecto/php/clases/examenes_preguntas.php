<?php

    class examenes_preguntas{

        private $preguntas_id;
        private $examenes_id;


        public function __construct($preguntas_id,$examenes_id)
        {
            $this->preguntas_id=$preguntas_id;
            $this->examenes_id=$examenes_id;
    
        }

        public function getPreguntas_id(){return $this->preguntas_id;}
        public function getexamenes_id(){return $this->examenes_id;}


        // public static function muestraDatos($user){
        //     echo $user->getpreguntas_id()."-".$user->getexamenes_id()."-".$user->gettematica()."-".$user->getRol()."<img src='data:image/png;base64,".$user->getFoto()."'><br>";

        // }

    }

?>