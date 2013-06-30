<?php

$nosId = file_get_contents('http://nos.nl/dossier/515430-tour-de-france-2013/tab/730/live/');
preg_match("/el: 'liveblog', id: (?P<id>\d+)/", $nosId, $matches);
echo $matches['id'];
?>