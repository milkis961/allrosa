<?php
function send_answer($my_id, $q_id, $answer, $connect){
    $command = "insert into empl_quest (empl_id, que_id, answer) values ('$my_id', '$q_id', '$answer')";
    pg_query($connect, $command);
}