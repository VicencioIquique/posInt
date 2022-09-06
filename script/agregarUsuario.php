<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$jsonUsuario = $_POST['jsonUsuario'];
		$codigoSBO = explode('-',$jsonUsuario['rut']); //Quitar guión del RUT para agregar código a SAP
		$fechaCreacion = date('Y-m-d H:i:s'); //Obtener fecha actual del servidor para FechaCreacion
		$nombreCompleto =$jsonUsuario['nombres']." ".$jsonUsuario['apellidos'];
		$agregarUsuario="INSERT INTO [RP_VICENCIO].[dbo].[RP_Clientes] (RUT, CodigoClienteSBO,Nombres,FechaIngreso, estado, Bodega,Direccion1,ApellidoPaterno,Direccion2,Fono1,eMail)
							VALUES('".$jsonUsuario['rut']."',
									'C".$codigoSBO[0]."',
									'".$nombreCompleto."',
									'".$fechaCreacion."',
									'0',
									'".$_SESSION['bodega']."',
									'".$jsonUsuario['direccion']."',
									'".$jsonUsuario['apellidos']."',
									'".$jsonUsuario['ciudad']."',
									'".$jsonUsuario['telefono']."',
									'".$jsonUsuario['email']."')";
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