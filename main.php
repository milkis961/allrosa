<?php
include_once("connect.php");
// if(!pg_ping($connect))
//     die("Ошибка соединения с базой данных");
session_start();
$my_id = 1;
$_SESSION['name'] = 'Собянин Сергей';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>ALLROSA</title>
        <meta name="description" content="ALLROSA" />
        <link rel="stylesheet" href="styles/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <?php
    if(!isset($_SESSION['name'])){
        include('index.php');
    }
    else {
    ?>

    <div>
    <div id="header">
        <div>
            <img id= logo src="img/Diamond.png">
        </div>
        <div id="user">
            <p class="profile">Привет, <?php echo $_SESSION['name'];?></p>
        </div>
    </div>
    <div id="page">
    <div id="left">
        <div id="question">
            <div id="quest">
                <?php
                $command = "select quest from questions";
                $query = pg_query($connect, $command);
                $questions = pg_fetch_all($query);
                $id = rand(1, sizeof($questions));
                $command = "SELECT quest, id FROM questions where id = '$id'";
                $query = pg_query($connect, $command);
                $result = pg_fetch_all($query);
                echo $result[0]['quest'];
                ?>
            </div>
            <input class="que" type="submit" value="Да" id="yes" name='action'>
            <input class="que" type="submit" value="Нет" id="no" name='action'>
            <?php
                if (isset($_POST['action'])) {
                    switch ($_POST['action']) {
                        case 'yes':
                            send_answer($my_id, $result[0]['id'], 1, $connect);
                            break;
                        case 'no':
                            send_answer($my_id, $result[0]['id'], 0, $connect);
                            break;
                    }
                }
            ?>
            <form method="POST" action="add_question.php">
            <input class="que2" type="submit" value="ДОБАВИТЬ ВОПРОС" id="add_que">
            </form>
        </div>
        <div id="applications">
            <button class="btn" id="first">Заявки</button>
            <div class="dropdown">
                <button id="second" class="btn" style="border-left:1px solid #0d8bf2">
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Зарплата</a>
                    <a href="#">Отпуск</a>
                </div>
            </div>
        </div>
    </div>
    <div id="wrapper">
        <div id="center">
            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");          
                echo $contents;
            }
            ?>
            </div>
    
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Отправить" />
            </form>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });
 
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 2500);
            });
        </script>
    </div>
    <div id="right">
        <div id="birthday">
            <div class="dropdown">
                <button id="third" class="btn" style="border-left:1px solid #0d8bf2" text="Дни рождения">
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                <?php
                include('birthdays.php');
                $birthdays = birthdays();
                foreach ($birthdays as $bd){
                    echo "<p>".$bd['name'].' '.$bd['birthday']."</p>";
                }
                ?>
                </div>
            </div>
        </div>
        <div id="compatibility">
            <?php
            include('compatibility.php');
          //  $people = get_compatibilities($my_id, $connect);
          $my_id = 1;
            $command = "select id, name from employees where id <> $my_id";
        $query = pg_query($command);
        $people = pg_fetch_all($query);
            foreach ($people as $_p){
                echo "<p>".$_p['name'].' '.number_format(compatibility($my_id, $_p['id'], $connect), 2)."</p>";
            }
            ?>
        </div>
        <div id="tech">
            <input type="button" value="Тех. поддержка">
        </div>
    </div>
        </div>
    </div>
    </body>
</html>

<?php

pg_close($connect);
}
?>