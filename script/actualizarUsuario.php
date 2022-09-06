<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$jsonUsuario = $_POST['jsonUsuario'];
	$nombreCompleto =$jsonUsuario['nombres']." ".$jsonUsuario['apellidos'];
	$actualizarUsuario="UPDATE [RP_VICENCIO].[dbo].[RP_Clientes]
						SET RUT = '".$jsonUsuario['rut']."',
							Nombres = '".$nombreCompleto."',
							ApellidoPaterno = '".$jsonUsuario['apellidos']."',
							Direccion1 = '".$jsonUsuario['direccion']."',
							Direccion2 = '".$jsonUsuario['ciudad']."',
							Fono1 = '".$jsonUsuario['telefono']."',
							eMail = '".$jsonUsuario['email']."'
						WHERE rut = '".$jsonUsuario['rut']."'"; 
	
	$rsUsuario = odbc_exec( $conn, $actualizarUsuario );
	if (!$rsUsuario){  //si la fila esta vacia no entra
		exit( "Error en la consulta Actualizar Usuario" );
	}	
	if($rsUsuario){
		echo 2; //Usuario actualizado correctamente
	}else{
		echo 3; //Problema al actualizar
	}
?>