<?php
header('Content-type: application/json');
echo $_GET['callback'] . '(' . file_get_contents('http://app.nos.nl/data/tourscherm/current/position.json?' . $_GET['_']) . ')';
?>