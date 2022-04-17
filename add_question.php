<?php
function add_question($quest, $connect)
{
    $command = "insert into questions (quest) values ('$quest')" 
    or die("Ошибка подключения к базе данных.".pg_last_error());
    pg_query($connect, $command);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Новый вопрос</title>
    <link rel="stylesheet" href="styles/anketa.css">
</head>

<body>
<div id="page">
    <form method="post">
        <ul>
            <li>
                <label for="quest1">Вопрос:</label>
                <input type="text" name="que"/>
            </li>
            <li class="button">
                <button type="submit">Отправить вопрос</button>
            </li>
            <?php
            include_once('connect.php');
            if (isset($_POST['que']) and strlen($_POST['que']) > 4) 
            {
                add_question($_POST['que'], $connect);
                header('Location: main.php');
            }
            ?>
        </ul>
    </form>
</div>
</body>
</html>
