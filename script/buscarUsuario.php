<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$rut = $_POST['rut'];
	
	$consultaUsuario="SELECT 
							[RUT] as rut, 
							[Nombres] as nombres, 
							[Direccion1] as direccion ,
							[Direccion2] as ciudad,
							Fono1 as telefono,
							eMail as email
						FROM [RP_VICENCIO].[dbo].[RP_Clientes]
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