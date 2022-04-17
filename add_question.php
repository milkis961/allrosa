<?php
function add_question($quest, $connect){
    $command = "insert into questions (quest) values ('$quest')";
    pg_query($connect, $command);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>New question</title>
    <link rel="stylesheet" href="styles/anketa.css">
</head>

<body>
<div id="page">
    <form method="post" action="main.php">
        <ul>
            <li>
                <label for="quest1">Вопрос:</label>
                <input type="text" name="que"/>
            </li>
            <li class="button">
                <button type="submit">Отправить вопрос</button>
            </li>
            <?php
            if (isset($_POST['que'])) {
                add_question($_POST['que'], $connect);
            }
            ?>
        </ul>
    </form>
</div>
</body>
</html>
