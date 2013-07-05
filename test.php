<?php

date_default_timezone_set('France/paris');

if($date = date('H') < 11)
{
	echo 'too early';
}

if($date = date('H') > 18)
{
	echo 'too late';
}
?>