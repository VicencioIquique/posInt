<?php
	session_start();
	require_once("../clases/conexionocdb.php");
	$codigo = $_POST['codigo'];
	$largo = strlen($codigo);
	$bodega = $_POST['local'];
	
	$sqlVendedores = "SELECT SlpCode, usuario_nombre
						FROM RP_VICENCIO.dbo.sisap_usuarios
						WHERE SlpCode <> '' and usuario_modulo <> '99'
						ORDER BY usuario_nombre ASC";
						
						
	
	
	$rsVendedores = odbc_exec( $conn, $sqlVendedores );
	if (!$rsVendedores){
		exit( "Error en la consulta SQL Obtener Vendedores" );
	}
		
	while($resultado = odbc_fetch_array($rsVendedores)){
		$res[] = array(
			"slpCode"=>$resultado['SlpCode'],
			"vendedor"=>utf8_encode($resultado['usuario_nombre'])
		);		
	}
	echo json_encode($res);
?>