<?php
$connect = pg_connect("host=localhost port=5432 dbname=allrosa user=postgres password=milana77")
     OR die("Ошибка подключения к базе данных.".pg_last_error());