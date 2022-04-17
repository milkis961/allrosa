<?php
function send_answer($my_id, $q_id, $answer, $connect){
    $command = "insert into empl_quest (empl_id, que_id, answer) values ('$my_id', '$q_id', '$answer')";
    pg_query($connect, $command);
}

function get_question($id, $connect) {
    $command = "SELECT quest FROM questions where id = '$id'";
    $query = pg_query($connect, $command);
    $result = pg_fetch_all($query);
    echo $result[0]['quest'];
}

function get_empty_question_id($id, $connect){
    $query = pg_query($connect, "SELECT id from questions 
        left join empl_quest on questions.id = empl_quest.que_id 
        where empl_quest.que_id is null and empl_quest.empl_id=$id");
    $empty_questions = pg_fetch_all($query);
    $var = $empty_questions[rand(0, count($empty_questions))];
    return $var['id'];
}