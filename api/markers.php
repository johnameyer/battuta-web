<?php
header("Content-Type: application/json");

$markers = array(array('name'=>"Notre Dame Main Building",'loc'=>array('lat'=>41.703026,'lng'=>-86.238964),'id'=>0),
	array('name'=>"Hesburgh Library",'loc'=>array('lat'=>41.702358,'lng'=>-86.234194),'id'=>1),
	array('name'=>"Basilica of the Sacred Heart",'loc'=>array('lat'=>41.7026517,'lng'=>-86.2397463),'id'=>2),
	array('name'=>"LaFortune Student Center",'loc'=>array('lat'=>41.7019183,'lng'=>-86.2376697),'id'=>3));
//screen parameter filtering

echo $_GET['callback'] . '(' . json_encode($markers) . ')';
?>