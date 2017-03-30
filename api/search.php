<?php
header("Content-Type: application/json");

$dist = array();

$names = array("basilica of the sacred heart","main building");

$query = $_GET['query'];

foreach ($names as $str) {
	array_push($dist,levenshtein(strtolower($query),$str,1,20,50));
}

array_multisort($dist,$names);

//eventually should return list of ids/name pairs sorted by dist
echo $_GET['callback'] . '(' . json_encode($names) . ')';
?>