<?php

class Pokemon {
    private $id;
    private $name;

    private $type1;
    private $type2;

    private $currentHp;
    private $hp;
    private $atk;
    private $def;
    private $sp_atk;
    private $sp_def;
    private $speed;
    
    private $tech1;
    private $tech2;
    private $tech3;
    private $tech4;

    //追加要素
    // private $nature;
    // private $Ability;

    
    public function __construct($pokemonData){
        $this->id = $pokemonData[0];   
        $this->name = $pokemonData[1];   
        $this->type1 = $pokemonData[2];   
        $this->type2 = $pokemonData[3]; 
        $hpRand = rand(0,31);
        $this->currentHp = round($pokemonData[4] + $hpRand/2 + 60);     
        $this->hp = round($pokemonData[5] + $hpRand/2 + 60)  ;   
        $atkRand = rand(0,31);
        $this->atk = round($pokemonData[6] + $atkRand/2 + 5); 
        $defRand = rand(0,31);  
        $this->def = round($pokemonData[7] + $defRand/2 + 5);   
        $sp_atkRand = rand(0,31);
        $this->sp_atk = round($pokemonData[8] + $sp_atkRand/2 + 5);   
        $sp_defRand = rand(0,31);
        $this->sp_def = round($pokemonData[9] + $sp_defRand/2 + 5); 
        $speedRand = rand(0,31);  
        $this->speed = round($pokemonData[10] + $speedRand/2 + 5);  

        $this->tech1 = $pokemonData[11];   
        $this->tech2 = $pokemonData[12];   
        $this->tech3 = $pokemonData[13];   
        $this->tech4 = $pokemonData[14];   
    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getType1(){
        return $this->type1;
    }
    public function getType2(){
        return $this->type2;
    }
    public function getCurrentHp(){
        return $this->currentHp;
    }
    public function getHp(){
        return $this->hp;
    }
    public function getAtk(){
        return $this->atk;
    }
    public function getDef(){
        return $this->def;
    }
    public function getSp_atk(){
        return $this->sp_atk;
    }
    public function getSp_def(){
        return $this->sp_def;
    }
    public function getSpeed(){
        return $this->speed;
    }
    public function getTech1(){
        return $this->tech1;
    }
    public function getTech2(){
        return $this->tech2;
    }
    public function getTech3(){
        return $this->tech3;
    }
    public function getTech4(){
        return $this->tech4;
    }

    public function setCurrentHp($currentHp){
        $this->currentHp = $currentHp;
    }
}

?>