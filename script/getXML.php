<?php     
	session_start();
	require_once("../clases/conexionocdb.php");
	header("Access-Control-Allow-Origin:*");
	$ipLocal=$_POST['ipLocal'];
	$bodega=$_POST['bodega'];
	$workstation=$_POST['workstation'];
	$fechaActual=$_POST['fechaActual'];
	$time=$_POST['time'];
	
	header('Content-type: application/xml');
	echo file_get_contents("http://".$ipLocal."/xmlrespuesta/boleta".$bodega.$workstation.$fechaActual.$time.".xml");
	
?>