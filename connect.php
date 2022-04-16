<?php
$connect = pg_connect("host=localhost port=5432 dbname=allrosa1 password=root")
     OR die("Ошибка подключения к базе данных.".pg_last_error());