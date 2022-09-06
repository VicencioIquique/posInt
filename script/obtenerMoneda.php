<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	
	$consultaUsuario="SELECT TOP 1 [Fecha]
      ,[Monto]
		FROM [RP_VICENCIO].[dbo].[RP_MONEDA] 
		ORDER BY Fecha DESC"; // consulta sql
	$rsUsuario = odbc_exec( $conn, $consultaUsuario );
	if (!$rsUsuario){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}	
	$resultado = odbc_fetch_array($rsUsuario);
		echo $resultado['Monto'];
?>