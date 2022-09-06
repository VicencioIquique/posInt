<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$codigo = $_POST['codigo'];
	$consultaStock="SELECT Articulo, ItemCode, Bodega, SUM(Cantidad) as Cantidad, DESC2, DESC3
						FROM RP_VICENCIO.dbo.LotesDisponibles 
						LEFT JOIN RP_VICENCIO.dbo.RP_Articulos ON RP_VICENCIO.dbo.RP_Articulos.ALU = RP_VICENCIO.dbo.LotesDisponibles.ItemCode
						WHERE ItemCode ='".$codigo."'
						GROUP BY Articulo, ItemCode, Bodega, DESC2, DESC3"; // consulta sql
						
	$rsStock = odbc_exec( $conn, $consultaStock );
	if (!$rsStock){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Bancos" );
	}	
	while($resultado = odbc_fetch_array($rsStock)){
		$res[] = array(
			'articulo'=>$resultado['Articulo'],
			'codigo'=>$resultado['ItemCode'],
			'bodega'=>$resultado['Bodega'],
			'cantidad'=>(int)$resultado['Cantidad'],
			'descripcion'=>$resultado['DESC2'],
			'marca'=>$resultado['DESC3']
		);
	}
	odbc_close($conn);
	echo json_encode($res);
?>