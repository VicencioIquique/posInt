<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	
	$consultaBancos="SELECT BankCode as codigo, BankName as banco
						FROM SBO_Imp_Eximben_SAC.dbo.ODSC"; // consulta sql
	$rsBancos = odbc_exec( $conn, $consultaBancos );
	if (!$rsBancos){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Bancos" );
	}	
	while($resultado = odbc_fetch_array($rsBancos)){
		$res[] = array(
			'codigo'=>$resultado['codigo'],
			'banco'=>utf8_encode($resultado['banco'])
		);
	}
	echo json_encode($res);
?>