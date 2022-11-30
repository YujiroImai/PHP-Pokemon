<?php

function consoleLog($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
}

function battleBase($db, $myPoke, $enemyPoke, $myTech, $enemyTech){
    $myPriority = $myTech->getPriority();
    $enemyPriority = $enemyTech->getPriority();
    $mySpeed = $myPoke->getSpeed();
    $enemySpeed = $enemyPoke->getSpeed();

    if($myPriority > $enemyPriority){
        $mySpeed += 1000; 
    }elseif($myPriority < $enemyPriority){
        $enemySpeed += 1000;
    }else{
        if($mySpeed == $enemySpeed){
            $randomSpeed = rand(1,10);
            if($randomSpeed <= 5){
                $mySpeed += 1;
            }elseif($randomSpeed >= 6){
                $enemySpeed += 1;
            }
        }
    }


    if($mySpeed > $enemySpeed){
        $attackingFirst = battle($db, $myPoke, $enemyPoke, $myTech);
        if($enemyPoke->getCurrentHp() <= 0){
            $text = $attackingFirst[0]->getName() . 'の' . $attackingFirst[1]->getName() .'!!!' . '<br>' 
            . 'あいての' . $enemyPoke->getName() . 'に' .  $attackingFirst[2] . 'のダメージ' . '<br>' . $attackingFirst[3] . '<br>'
            . 'あいての' . $enemyPoke->getName() . 'はたおれた' . '<br>';
            
        }else{
            $attackingSecond = battle($db, $enemyPoke, $myPoke, $enemyTech);
            if($myPoke->getCurrentHp() <= 0){
                $text = $attackingFirst[0]->getName() . 'の' . $attackingFirst[1]->getName() .'!!!' . '<br>' 
                . 'あいての' . $enemyPoke->getName() . 'に'. $attackingFirst[2] . 'のダメージ' . '<br>' . $attackingFirst[3] . '<br>'
                . 'あいての' . $attackingSecond[0]->getName() . 'の' . $attackingSecond[1]->getName() .'!!!' . '<br>' 
                . $attackingSecond[2] . 'のダメージ' . '<br>'. $attackingSecond[3] . '<br>'
                . $myPoke->getName() . 'はたおれた' . '<br>';    
            }else{
                $text  =  $attackingFirst[0]->getName() . 'の' . $attackingFirst[1]->getName() .'!!!' . '<br>' 
                . 'あいての' . $enemyPoke->getName() . 'に' .  $attackingFirst[2] . 'のダメージ' . '<br>' . $attackingFirst[3] . '<br>'
                . 'あいての' . $attackingSecond[0]->getName() . 'の' . $attackingSecond[1]->getName() .'!!!' . '<br>' 
                .  $attackingSecond[2] . 'のダメージ' . '<br>'. $attackingSecond[3];
            }
        }
    }
    else{
        $attackingFirst = battle($db, $enemyPoke, $myPoke, $enemyTech);
        if($myPoke->getCurrentHp() <= 0){
            $text = 'あいての' . $attackingFirst[0]->getName() . 'の' . $attackingFirst[1]->getName() .'!!!' . '<br>'
            . $attackingFirst[2] . 'のダメージ' . '<br>' . $attackingFirst[3] . '<br>'
            . $myPoke->getName() . 'はたおれた...' . '<br>';
        }else{
            $attackingSecond = battle($db, $myPoke, $enemyPoke, $myTech);
            if($enemyPoke->getCurrentHp() <= 0){
                $text = 'あいての' . $attackingFirst[0]->getName() . 'の' . $attackingFirst[1]->getName() .'!!!' . '<br>'
                . $attackingFirst[2] . 'のダメージ' . '<br>' . $attackingFirst[3] . '<br>'
                . $attackingSecond[0]->getName() . 'の' . $attackingSecond[1]->getName() .'!!!' . '<br>' 
                . 'あいての' . $enemyPoke->getName() . 'に' . $attackingSecond[2] . 'のダメージ' . '<br>'. $attackingSecond[3] .'<br>' 
                . 'あいての' . $enemyPoke->getName() . 'はたおれた...' . '<br>';
            }else{
                $text  =  'あいての' . $attackingFirst[0]->getName() . 'の' . $attackingFirst[1]->getName() .'!!!' . '<br>' 
                .  $attackingFirst[2] . 'のダメージ' . '<br>' . $attackingFirst[3] . '<br>'
                . $attackingSecond[0]->getName() . 'の' . $attackingSecond[1]->getName() .'!!!' . '<br>' 
                . 'あいての' . $enemyPoke->getName() . 'に' .  $attackingSecond[2] . 'のダメージ' . '<br>'. $attackingSecond[3];
            }
        }
    }
   

    return $text;
}


function battle($db, $offensive, $deffensive, $tech){
    $offensivePower = 0;
    $deffensiveHardness = 0;
    $techPower = 0;
    $relation = 0;
    if($tech->getClass() == 'phy'){
        $offensivePower = $offensive->getAtk();
        $deffensiveHardness = $deffensive->getDef();
    }
    else if($tech->getClass() == 'sp'){
        $offensivePower = $offensive->getSp_atk();
        $deffensiveHardness = $deffensive->getSp_def();
    }
    
    if($offensive->getType1() === $tech->getType() 
    || $offensive->getType2() === $tech->getType()){
        $techPower = $tech->getPower() * 1.5;
    }
    else{
        $techPower = $tech->getPower();
    }
    console_log( '技名'. $tech->getName(). '技威力' . $tech->getPower() . 'techpower' . $techPower);
    consoleLog($deffensive->getType1() .  ' ' . $deffensive->getType2());
    //守備側のタイプが1つの場合
    if(!($deffensive->getType2())){
        $relation = typeRelation($db, $tech->getType(), $deffensive->getType1());
    }
    //守備側のタイプが2つの場合
    else{
        $relation = typeRelation($db, $tech->getType(), $deffensive->getType1(), $deffensive->getType2());
    }
    
    //乱数の生成
    $random_num = (100 - rand(0, 15))/100;
    console_log('乱数' . $random_num);
    //ダメージ計算
    $damage = round(round(round(22 * $techPower * $offensivePower / $deffensiveHardness) / 50 + 2 ) / $random_num);
    // $damage = $offensivePower * (1 + $techPower / 100) - $deffensiveHardness ;
    
    $damage = round($damage * $relation);

    console_log('技威力' . $techPower  .'攻撃または特攻' . $offensivePower . '防御または特防' . $deffensiveHardness);
    consoleLog('ダメージ' . $damage);



    if ($damage < 0){
        $damage = 1;
    }

    if($relation >= 2){
        $relationTxt = 'こうかはばつぐんだ!!!';
    }
    else if($relation === 0){
        $relationTxt = 'こうかはないようだ...';
    }
    else if($relation < 1){
        $relationTxt = 'こうかはいまひとつのようだ...';
    }
    else {
        $relationTxt =  '';
    }

    $currentHp = ($deffensive->getCurrentHp()) - $damage;
    if($currentHp <= 0){
        $currentHp = 0;
        // return $deffensive->getName . 'はたおれた...';
    }
    $deffensive->setCurrentHp($currentHp); 

    // consoleLog('ダメージ' . $damage);
    return array($offensive, $tech, $damage, $relationTxt);
}

function typeRelation($db, $offensiveType, $deffensiveType1, ?int $deffensiveType2 = null){
    $relation = 1;
    $stmt = $db->prepare('select super_effective, not_effective, not_affect from type where id = ?');
    if(!$stmt){
        die($stmt->error);
    }
    $stmt->bind_param('i', $offensiveType);
    $success = $stmt->execute();            
    if(!$success){
        die($db->error);
    }
    $stmt->bind_result($superEffective, $notEffective, $notAffect);
    $stmt->fetch();


    if ($deffensiveType2 === null){
        $deffensiveType = array($deffensiveType1);
    }
    else{
        $deffensiveType = array($deffensiveType1, $deffensiveType2);
    }
    consoleLog('攻撃側'. $offensiveType);
    consoleLog('守備側'. $deffensiveType1 . $deffensiveType2);
    foreach($deffensiveType as $defType){
        //こうかはばつぐんの判定
        $superEffectiveArray = explode(',', $superEffective);
        foreach($superEffectiveArray as $typeId){
            if($defType == $typeId){
                $relation *= 2;
            }
        }
        //こうかはいまひとつの判定
        $notEffectiveArray = explode(',', $notEffective);
        foreach($notEffectiveArray as $typeId){
            if($defType == $typeId){
                $relation /= 2;
            }
        }
        //こうかなしの判定
        $notAffectArray = explode(',', $notAffect);
        foreach($notAffectArray as $typeId){
            if($defType == $typeId){
                $relation *= 0;
            }
        }
    }
    return $relation; 

}


?>