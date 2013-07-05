<?php
header('Content-type: application/json');
date_default_timezone_set('France/paris');

$early = date('H') < 8;
$late = date('H') > 18;
$nosId = file_get_contents('http://nos.nl/dossier/515430-tour-de-france-2013/tab/730/live/');
$callback = $_GET['callback'];
$timestamp = $_GET['_'];

if($nosId)
{
	preg_match("/el: 'liveblog', id: (?P<id>\d+)/", $nosId, $matches);
	$id = $matches['id'];
}

if($id && !$early && !$late)
{
	$return_value = $callback . '(' . file_get_contents('http://nos.nl/data/liveblog/report/items_'. $id .'.json?' . $timestamp) . ')';
}

if(!$id || $early || $late)
{
	$return_value = $callback . '({"error":true})';
}

echo $return_value;
?>