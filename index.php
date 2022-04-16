<?php
include_once("connect.php");

session_start();
 
if(isset($_GET['logout'])){    
     
    //Simple exit message
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
 
function loginForm(){
    echo
    '<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="index.php" method="post">
      <label for="name">Name &mdash;</label>
      <input type="text" name="name" id="name" />
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div>';
}

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
        loginForm();
    }
    else {
    ?>

    <div>
    <div id="header">
        <div>
            <img id= logo src="img/Diamond.png">
        </div>
        <div id="user">
            <p class="profile">Здесь будет профиль пользователя</p>
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
                $command = "SELECT quest  FROM questions where que_id = '$id'";
                $query = pg_query($connect, $command);
                $result = pg_fetch_all($query);
                echo $result[0]['quest'];
                ?>
            </div>
            <input class="que" type="button" value="Да" id="yes">
            <input class="que" type="button" value="Нет" id="no">
            <input class="que" type="button" value="ДОБАВИТЬ ВОПРОС" id="add_que">
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
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
        </script>
    </div>
    <div id="right">
        <div id="birthday">
            <input type="button" value="Дни рождения">

        </div>
        <div id="compatibility">
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
            <p>a</p>
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
if(!pg_ping($connect))
    die("Ошибка соединения с базой данных");
compatibility(1, 2, $connect);
pg_close($connect);
}
function compatibility($myid, $otherid, $connect){
//    $command = "select que_id, answer from empl_quest where empl_id='$myid'";
//    $query = pg_query($connect, $command);
    $myanswers = array(array(3, 1), array(5, 0), array(7, 1));
    $otheranswers = array(array(3, 1), array(5, 1), array(7, 1));
    $common = array();
    $compatibility = 0;
    foreach ($myanswers as $my){
        foreach ($otheranswers as $other){
            if($my[0] == $other[0]){
                array_push($common, $my[0]);
            }
        }
    }
    $compatibility = 0;
    foreach ($common as $c){
        $compatibility += $myanswers[$c][1] * $otheranswers[$c][1];
    }
    $compatibility /= sizeof($common);
    
}
?>