<?php

class Move {
    private $id;
    private $name;
    private $type;
    private $power;
    private $class;
    private $priority;

    public function __construct($moveData){
        $this->id = $moveData[0];
        $this->name = $moveData[1];
        $this->type = $moveData[2];
        $this->power = $moveData[3];
        $this->class = $moveData[4];
        $this->priority = $moveData[5];
    }

     public function getId(){
        return $this->id;
     }
     public function getName(){
        return $this->name;
     }
     public function getType(){
        return $this->type;
     }
     public function getPower(){
        return $this->power;
     }
     public function getClass(){
        return $this->class;
     }
     public function getPriority(){
        return $this->priority;
     }
}

?>