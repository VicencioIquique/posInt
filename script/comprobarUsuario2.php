<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$rut = $_POST['rut'];
	$nombre = $_POST['nombre'];
	
	$consultaUsuario="SELECT [Rut]
						FROM [RP_VICENCIO].[dbo].[Clientes]
						WHERE rut = '".$rut."'"; 
						
	$rsUsuario = odbc_exec( $conn, $consultaUsuario );
	if (!$rsUsuario){
		echo 2; // no existe en la base de datos
	}	
	$resultado = odbc_fetch_array($rsUsuario);
	if($resultado['Rut'] != ""){
		echo 1; //El usuario ya existe en la base de datos
	}
	
?>