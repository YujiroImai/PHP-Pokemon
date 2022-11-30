<?php
session_start();
require('library.php');
require('Pokemon.class.php');
require('battle.php');
require('Move.class.php');


$db = dbconnect();
$mPokeId = filter_input(INPUT_POST, 'myPokeId', FILTER_SANITIZE_NUMBER_INT);
$ePokeId = filter_input(INPUT_POST, 'enemyPokeId', FILTER_SANITIZE_NUMBER_INT);
$tech = filter_input(INPUT_POST, 'move', FILTER_SANITIZE_NUMBER_INT);
$sessionReset = filter_input(INPUT_POST, 'reset', FILTER_SANITIZE_STRING);
if (isset($sessionReset)) {
    sessionReset();
}
console_log('mypokeid' . $myPokeId . 'enemypokeid' . $ePokeId);
if (isset($_SESSION['myPoke'])) {
    $myPoke = unserialize($_SESSION['myPoke']);
}
if (isset($_SESSION['enemyPoke'])) {
    $enemyPoke = unserialize($_SESSION['enemyPoke']);
}

if (isset($tech) && isset($myPoke) && isset($enemyPoke)) {
    //選択したわざ情報を配列として取得
    if ($tech) {
        $techArray = getTech($tech);
    }
    //取得した配列からMoveクラスのインスタンスを生成
    $myTech = new Move($techArray);

    //CPがランダムで選択した技のインスタンスの生成
    $randomTech = rand(1, 4);
    if ($randomTech === 1) {
        $enemyTechId = $enemyPoke->getTech1();
    } elseif ($randomTech === 2) {
        $enemyTechId = $enemyPoke->getTech2();
    } elseif ($randomTech === 3) {
        $enemyTechId = $enemyPoke->getTech3();
    } elseif ($randomTech === 4) {
        $enemyTechId = $enemyPoke->getTech4();
    }
    $enemyTech = new Move(getTech($enemyTechId));

    //必要な情報を用いてバトル関数の実行
    $text = battleBase($db, $myPoke, $enemyPoke, $myTech, $enemyTech);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PokemonGame</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div id="wrap">
        <div id="head">
            <h1>PokemonGame</h1>
        </div>
        <div id="content">
            <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
            <br>
            <div style="text-align: center">
                <div id="rightblock"style="text-align: right">
                    <?php
                    if($ePokeId){
                        $enemyPokeArray = accessPokemon($ePokeId);
                        $enemyPoke = new Pokemon($enemyPokeArray);
                    }
                    $_SESSION['enemyPoke'] = serialize($enemyPoke);
                    ?>
                    <h2>あいての
                        <?php echo h($enemyPoke->getName()); ?>
                    </h2>
                    <p>HP:
                        <?php echo $enemyPoke->getCurrentHp(); ?>/
                        <?php echo $enemyPoke->getHp(); ?>
                    </p>
                    <p>atk: 
                        <?php echo $enemyPoke->getAtk(); ?>
                    </p>
                    <p>def: 
                        <?php echo $enemyPoke->getDef(); ?>
                    </p>
                    <p>sp_atk: 
                        <?php echo $enemyPoke->getSp_atk(); ?>
                    </p>
                    <p>sp_def: 
                        <?php echo $enemyPoke->getSp_def(); ?>
                    </p>
                    <p>speed: 
                        <?php echo $enemyPoke->getSpeed(); ?>
                    </p>
                </div>
                <div id="leftblock" style="text-align: left">
                    <?php
                    if($mPokeId){
                        $myPokeArray = accessPokemon($mPokeId);
                        $myPoke = new Pokemon($myPokeArray);
                    }
                    $_SESSION['myPoke'] = serialize($myPoke);
                    ?>
                    <p>HP:
                        <?php echo $myPoke->getCurrentHp(); ?>/
                        <?php echo $myPoke->getHp(); ?>
                    </p>
                    <p>atk: 
                        <?php echo $myPoke->getAtk(); ?>
                    </p>
                    <p>def: 
                        <?php echo $myPoke->getDef(); ?>
                    </p>
                    <p>sp_atk: 
                        <?php echo $myPoke->getSp_atk(); ?>
                    </p>
                    <p>sp_def: 
                        <?php echo $myPoke->getSp_def(); ?>
                    </p>
                    <p>speed: 
                        <?php echo $myPoke->getSpeed(); ?>
                    </p>
                    <h2>あなたの
                        <?php echo h($myPoke->getName()); ?>
                    </h2>
                </div>
                <div id="commandView">
                    <form action="" method="post">
                        <?php
                        $stmt = $db->prepare('select id, name from move m where id = ? || id = ? || id = ? || id = ?;');
                        if (!$stmt) {
                            die($stmt->error);
                        }
                        $stmt->bind_param('iiii', $myPoke->getTech1(), $myPoke->getTech2(), $myPoke->getTech3(), $myPoke->getTech4());
                        $success = $stmt->execute();
                        if (!$success) {
                            die($db->error);
                        }
                        $stmt->bind_result($techid, $techname);
                        while ($stmt->fetch()):
                        ?>
                        <input type="radio" name="move" value="<?php echo $techid; ?>">
                        <?php echo h($techname) ?></input></br>

                        <?php endwhile; ?>
                        <br>
                        <input type="radio" name="move" value="0">交代</input>
                        <br>
                        <br>
                        <input type="submit" value="決定" />
                    </form>
                </div>
                <div id="messageView">
                    <p>
                        <?php
                        echo $text
                            ; ?>
                    </p>
                    <?php

                    if ($myPoke->getCurrentHp() === 0 || $enemyPoke->getCurrentHp() === 0) {
                        // echo '<form action="" method="post">';
                        // echo '<input type = "hidden" value = "reset" name = "reset"></input>';
                        // echo '<input type = "submit" value = "リセット"></input>';
                        // echo '</form>';
                        echo '<a href="logout.php">終了する</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>