<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$tipoDocto = $_POST['tipoDocto'];
	
	$consultarFolio="SELECT ultFolioFiscal, ultFactura, ultNotaCredito, ultBoletaManual
					FROM RP_VICENCIO.dbo.RP_IP_BODEGAS
					WHERE ip = '".$_SESSION["ip"]."'"; // consulta sql
	$rsFolio = odbc_exec( $conn, $consultarFolio );
	if (!$rsFolio){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}	
	$resultado = odbc_fetch_array($rsFolio);
	if($tipoDocto == '1'){
		echo $resultado['ultFolioFiscal'];
	}else if($tipoDocto == '2'){
		echo (int)$resultado['ultFactura'];
	}else if($tipoDocto == '3'){
		echo (int)$resultado['ultNotaCredito'];
	}else if($tipoDocto == '4'){
		echo (int)$resultado['ultBoletaManual'];
	}
?>