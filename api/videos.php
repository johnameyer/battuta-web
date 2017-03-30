<?php
header("Content-Type: application/json");

function vid($vid,$name,$age,$img){
	return array("vid"=>$vid,"pro"=>array("name"=>$name,"age"=>$age,"img"=>$img));
}

$videos = null;

switch($_GET['id']){
	case 0:
	$videos = array(array(
		vid("QOlTaYp_QGo","Chris",22,"chris.jpg"),
		vid(".mp4","Jack",22,"jack.jpg")
		),
	array(
		vid(".mp4","Sue",19,"sue.png"),
		vid(".mp4","Jim",71,"jim.png"),
		vid(".mp4","Bob",29,"bob.png")
		));//recommended vs other content
	break;
	case 1:
	$videos = array(array(),array());
	break;
	case 2:
	$videos = array(array(),array());
	break;
	case 3:
	$videos = array(array(),array());
	break;
}

echo $_GET['callback'] . '(' . json_encode($videos) . ')';
?>