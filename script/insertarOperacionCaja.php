<?php     
require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server	
	$fecha1 = $_POST['fechaInicio'];
	$fecha2 = $_POST['fechaFinal'];
	$ID = $_POST['ID'];
	$consultaUsuario="INSERT INTO RP_VICENCIO.[dbo].[RP_OperacionCaja]
						VALUES('".$fecha1."','".$fecha2."','".$ID."')"; // consulta sql
	odbc_exec($conn, $consultaUsuario);
	odbc_close( $conn );
?>