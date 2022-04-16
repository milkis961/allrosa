<?php
function send_answer($my_id, $q_id, $answer, $connect){
    $command = "insert into empl_quest (empl_id, que_id, answer) values ('$my_id', '$q_id', '$answer')";
    pg_query($connect, $command);
}

function get_question($id, $connect) {
    $command = "select quest from questions";
    $query = pg_query($connect, $command);
    $questions = pg_fetch_all($query);
    //$id = rand(1, sizeof($questions));
    $command = "SELECT quest  FROM questions where que_id = '$id'";
    $query = pg_query($connect, $command);
    $result = pg_fetch_all($query);
    echo $result[0]['quest'];
}