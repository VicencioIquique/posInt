<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$rut = $_POST['rut'];
	
	$consultaUsuario="SELECT 
							Rut as rut, 
							Nombres as nombres, 
							Direccion as direccion ,
							Ciudad as ciudad,
							Fono as telefono,
							eMail as email
						FROM [RP_VICENCIO].[dbo].[Clientes]
						WHERE rut = '".$rut."'"; 
						
	$rsUsuario = odbc_exec( $conn, $consultaUsuario );
	if (!$rsUsuario){  
		exit( "Error en la consulta SQL" );
	}	
	$resultado = odbc_fetch_array($rsUsuario);
	$res = array(
		'rut'=>$resultado['rut'],
		'nombres'=>$resultado['nombres'],
		'direccion'=>$resultado['direccion'],
		'ciudad'=>$resultado['ciudad'],
		'telefono'=>$resultado['telefono'],
		'email'=>$resultado['email']
	);
	echo json_encode($res);
?>