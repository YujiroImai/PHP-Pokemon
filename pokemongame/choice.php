<?php
session_start();
require('library.php');
require('Pokemon.class.php');
require('battle.php');
require('Move.class.php');

$db = dbconnect();

$enemyPokeId = enemyPokemonChoice();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"/>
        <title>Choose Pokemon</title>
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
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div id="commandView">
                        <p>使うポケモンを</p>
                        <p>選択して下さい</p>
                    </div>               
                    <div id="messageView">
                        <p>ポケモン　　タイプ１　タイプ2</p>
                        <form action='index.php'method='post'>
                            <input type="hidden" name="enemyPokeId" value='<?php echo $enemyPokeId;?>'></input>
                            <?php
                            $stmt = $db->prepare('SELECT p.id, p.name, t1.name, t2.name FROM (pokemon p left join type t1 on p.type1 = t1.id) left join type t2 on p.type2 = t2.id;');
                            if(!$stmt){
                                die($stmt->error);
                            }
                            $success = $stmt->execute();            
                            if(!$success){
                                die($db->error);
                            }
                            $stmt->bind_result($id, $name, $type1, $type2);
                            while($stmt->fetch()):
                            ?>
            
                            <p><input type='radio' value='<?php echo $id?>' name='myPokeId'><?php echo $name . '　' . $type1 . '　' . $type2;?></input></p>
                            <?php endwhile;?>
                            <br>
                            <input type="submit" value="決定">
                        <form>
                    </div>
                </div>
            </div>
        </div>
            
</body>
</html>