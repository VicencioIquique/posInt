<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$jsonUsuario = $_POST['jsonUsuario'];
	$fechaCreacion = date('Y-m-d H:i:s'); //Obtener fecha actual del servidor para FechaCreacion
	$rut = $jsonUsuario['rut'];
	$nombres =$jsonUsuario['nombres'];
	$apellidoPaterno =$jsonUsuario['apellidoPaterno'];
	$apellidoMaterno =$jsonUsuario['apellidoMaterno'];
	$direccion =$jsonUsuario['direccion'];
	$ciudad =$jsonUsuario['ciudad'];
	$fechaNacimiento =$jsonUsuario['fechaNacimiento'];
	$fechaIngreso =date('Y-m-d H:i:s'); //Obtener fecha actual del servidor para FechaCreacion
	$comuna =$jsonUsuario['ciudad'];
	$fono =$jsonUsuario['telefono'];
	$email =$jsonUsuario['email'];
	$sexo =$jsonUsuario['sexo'];
	$nacionalidad =$jsonUsuario['apellido_materno'];
	$agregarUsuario="INSERT INTO [RP_VICENCIO].[dbo].[Clientes] (RUT,Nombres,Apellido_Paterno,Apellido_Materno,Direccion,Ciudad,Fecha_Nacimiento,Fecha_Ingreso,Comuna,Fono,Email,Sexo,Nacionalidad)
						VALUES('".$rut."',
							   '".$nombres."',
							   '".$apellidoPaterno."',
							   '".$apellidoMaterno."',
							   '".$direccion."',
							   '".$ciudad."',
							   '".$fechaNacimiento."',
							   '".$fechaIngreso."',
							   '".$comuna."',
							   '".$fono."',
							   '".$email."',
							   '".$sexo."',
							   'CHILE')";
	$rsAgregarUsuario = odbc_exec( $conn, $agregarUsuario );
	if (!$rsAgregarUsuario){  //si la fila esta vacia no entra
		exit( "Error en la consulta Agregar Usuario" );
	}	
	if($rsAgregarUsuario){
		echo 4; //Usuario agregado correctamente
	}else{
		echo 3; //Problema al agregar
	}
?>