<?php
function birthdays(){
    $command = "SELECT id, name, birthday from employees 
    where (birthday - date_trunc('year', birthday)) 
    BETWEEN (now() - date_trunc('year',now())) AND (now() - date_trunc('year',now()) + interval '7 days')";
    $query = pg_query($command);
    $birthdays =  pg_fetch_all($query);
    return $birthdays;
}