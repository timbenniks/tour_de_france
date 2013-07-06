<?php
header('Content-type: application/json');
echo $_GET['callback'] . '(' . file_get_contents('http://app.nos.nl/data/tourscherm/current/gaps_iframe.json?' . $_GET['_']) . ')';
?>