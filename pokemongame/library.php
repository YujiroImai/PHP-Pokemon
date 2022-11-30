<?php 
session_start();

function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}

function dbconnect(){
    $db = new mysqli('localhost:8889', 'root', 'root', 'pokemondb');
    if(!$db){
        die($db->error);
    }
    return $db;
}

function console_log($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
  }


function getTech($techid){
    $db = dbconnect();
    $stmt = $db->prepare('select id, name, type, power, class, priority from move m where id = ?;');
    if(!$stmt){
        die($stmt->error);
    }
    $stmt->bind_param('i', $techid);
    $success = $stmt->execute();            
    if(!$success){
        console_log('hoge');
        die($db->error);
    }
    $stmt->bind_result($id, $techname, $type, $power, $class, $priority);
    $stmt->fetch();
    $techArray = array($id, $techname, $type, $power, $class, $priority);
    return  $techArray;
}

function sessionReset(){
    $_SESSION = array();
    
    console_log('resetsuccess');
}

function enemyPokemonChoice(){
    $db = dbconnect();
    $stmt = $db->prepare('select id from pokemon');
    if(!$stmt){
        die($stmt->error);
    }
    $success = $stmt->execute();     
    if(!$success){
        die($db->error);
    }
    $stmt->bind_result($id);
    $counts = array();
    while($stmt->fetch()){
        array_push($counts, $id);
    }
    $count = count($counts);
    $randNum = rand(0, $count - 1);
    
    $enemyPokeId = $counts[$randNum];
    console_log($enemyPokeId);

    return $enemyPokeId;
}

function accessPokemon($pokeId){
    console_log($pokeId);
    $db = dbconnect();
    $stmt = $db->prepare('select id, name, type1, type2, hp, atk, def, sp_atk, sp_def, speed, tech1, tech2, tech3, tech4 from pokemon p where id = ?');
    if (!$stmt) {
        die($stmt->error);
    }
    $stmt->bind_param('i', $pokeId);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }
    $stmt->bind_result($id, $name, $type1, $type2, $hp, $atk, $def, $sp_atk, $sp_def, $speed, $tech1, $tech2, $tech3, $tech4);
    $stmt->fetch();
    $pokeArray = array($id, $name, $type1, $type2, $hp, $hp, $atk, $def, $sp_atk, $sp_def, $speed, $tech1, $tech2, $tech3, $tech4);
    console_log('id, name'.$id . $name);
    return $pokeArray;
}

?>