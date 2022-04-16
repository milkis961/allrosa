<?php
include_once("connect.php");
$command = "select id, quest from questions";
$query = pg_query($connect, $command);
$questions = pg_fetch_all($query);
$used_id = [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Anketa</title>
    <link rel="stylesheet" href="styles/anketa.css">
</head>

<body>
<div id="page">
    <form method="post" action="main.php">
        <ul>
            <li>
                <label for="quest1">Вопрос №1:</label>
                <?php
                $id = rand(0, sizeof($questions) - 1);
                array_push($used_id, $id);
                echo $questions[$id]['quest'];
                ?>
                <div class="answers">
                        <p class="radio">Да</p><input value="1" name="que1"  class="radio" type="radio" id="yes">
                        <p class="radio">Нет</p><input value="0" name="que1"  class="radio" type="radio" id="no">
                </div>
            </li>
            <li>
                <label for="quest2">Вопрос №2:</label>
                <?php
                $id = rand(0, sizeof($questions) - 1);
                while (in_array($id, $used_id)) {
                    $id = rand(0, sizeof($questions) - 1);
                }
                array_push($used_id, $id);
                echo $questions[$id]['quest'];
                ?>
                <div class="answers">
                    <p class="radio">Да</p><input value="1" name="que2"  class="radio" type="radio" id="yes">
                    <p class="radio">Нет</p><input value="0" name="que2"  class="radio" type="radio" id="no">
                </div>
            </li>
            <li>
                <label for="quest3">Вопрос №3:</label>
                <?php
                $id = rand(0, sizeof($questions) - 1);
                while (in_array($id, $used_id)) {
                    $id = rand(0, sizeof($questions) - 1);
                }
                array_push($used_id, $id);
                echo $questions[$id]['quest'];
                ?>
                <div class="answers">
                    <p class="radio">Да</p><input value="1" name="que3"  class="radio" type="radio" id="yes">
                    <p class="radio">Нет</p><input value="0" name="que3"  class="radio" type="radio" id="no">
                </div>
            </li>
            <li>
                <label for="quest4">Вопрос №4:</label>
                <?php
                $id = rand(0, sizeof($questions) - 1);
                while (in_array($id, $used_id)) {
                    $id = rand(0, sizeof($questions) - 1);
                }
                array_push($used_id, $id);
                echo $questions[$id]['quest'];
                ?>
                <div class="answers">
                    <p class="radio">Да</p><input value="1" name="que4"  class="radio" type="radio" id="yes">
                    <p class="radio">Нет</p><input value="0" name="que4"  class="radio" type="radio" id="no">
                </div>
            </li>
            <li>
                <label for="quest5">Вопрос №5:</label>
                <?php
                $id = rand(0, sizeof($questions) - 1);
                while (in_array($id, $used_id)) {
                    $id = rand(0, sizeof($questions) - 1);
                }
                array_push($used_id, $id);
                echo $questions[$id]['quest'];
                ?>
                <div class="answers">
                    <p class="radio">Да</p><input value="1" name="que5"  class="radio" type="radio" id="yes">
                    <p class="radio">Нет</p><input value="0" name="que5"  class="radio" type="radio" id="no">
                </div>
            </li>
            <li class="button">
                <button type="submit">Send your message</button>
            </li>
            <?php
            if (isset($_POST['que1']) && isset($_POST['que2']) && isset($_POST['que3']) && isset($_POST['que4']) && isset($_POST['que5']) ) {
                $command = "select id from employees";
                $query = pg_query($connect, $command);
                $employees = pg_fetch_all($query);
                //$id = rand(0, sizeof($employees));
                $id = 4;
                $count = 0;
                for ($i = 1; $i <= sizeof($used_id); $i++) {
                    $key = "que$i";
                    $answer = $_POST[$key];
                    $index = $i - 1;
                    $command = "insert into empl_quest (empl_id, que_id, answer) values ('$id', '$used_id[$index]', '$answer')";
                    pg_query($connect, $command);
                }
            }
            ?>
        </ul>
    </form>
</div>
</body>
</html>