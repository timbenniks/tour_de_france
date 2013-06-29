<?php
header('Content-type: application/json');
echo $_GET['callback'] . '(' . file_get_contents('http://nos.nl/data/liveblog/report/items_169.json?' . $_GET['_']) . ')';
?>