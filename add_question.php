<?php
function add_question($quest, $connect){
    $command = "insert into questions (quest) values ('$quest')";
    pg_query($connect, $command);
}