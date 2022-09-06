<?php     
	session_start();
	require_once("../clases/conexionocdb.php");
	header("Access-Control-Allow-Origin:*");
	$ipLocal=$_POST['ipLocal'];
	$periodo=$_POST['periodo'];
	
	header('Content-type: application/xml');
	echo file_get_contents("http://".$ipLocal."/xmlrespuesta/".$periodo.".xml");
	
?>