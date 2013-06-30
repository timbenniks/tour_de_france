<?php
header('Content-type: application/json');

$nosId = file_get_contents('http://nos.nl/dossier/515430-tour-de-france-2013/tab/730/live/');
preg_match("/el: 'liveblog', id: (?P<id>\d+)/", $nosId, $matches);
$id = $matches['id'];

echo $_GET['callback'] . '(' . file_get_contents('http://nos.nl/data/liveblog/report/items_'. $id .'.json?' . $_GET['_']) . ')';
?>