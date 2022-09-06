<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$jsonUsuario = $_POST['jsonUsuario'];
	$actualizarUsuario="UPDATE [RP_VICENCIO].[dbo].[Clientes]
						SET Rut= '".$jsonUsuario['rut']."',
							Nombres = '".$jsonUsuario['nombres']."',
							Apellido_Paterno = '".$jsonUsuario['apellidoPaterno']."',
							Apellido_Materno = '".$jsonUsuario['apellidoMaterno']."',
							Direccion = '".$jsonUsuario['direccion']."',
							Ciudad = '".$jsonUsuario['ciudad']."',
							Fono = '".$jsonUsuario['telefono']."',
							Email = '".$jsonUsuario['email']."',
							Sexo = '".$jsonUsuario['sexo']."',
							Fecha_Nacimiento = '".$jsonUsuario['fechaNacimiento']."',
							Comuna = '".$jsonUsuario['ciudad']."'
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