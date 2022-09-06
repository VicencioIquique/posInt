<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	$tipoDocto = $_POST['tipoDocto'];
	$numeroDocto = $_POST['numeroDocto'];
	
	
	$consultaDetalleVenta="SELECT Secuencia, 
										TipoDocto, 
										NumeroDocto, 
										ProductoID,
										Sku, 
										DESC2,
										DESC3,
										Cantidad, 
										Descuento, 
										PrecioFinal [PrecioOriginal], 
										PrecioExtendido [PrecioFinal],
										Vendedor
								FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP as RPDet
								LEFT JOIN RP_VICENCIO.dbo.RP_Articulos as RPArt ON RPArt.ALU = RPDet.Sku
								WHERE
									NumeroDocto = '".$numeroDocto."' AND 
									TipoDocto = '".$tipoDocto."' AND
									Bodega = '".$bodega."' AND 
									WorkStation = '".$workstation."'"; // consulta sql
						
	$rsDetalleVenta = odbc_exec( $conn, $consultaDetalleVenta );
	if (!$rsDetalleVenta){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}	
	while($resultado = odbc_fetch_array($rsDetalleVenta)){
		$res[] = array(
			'Secuencia'=> (int)$resultado['Secuencia'],
			'TipoDocto'=> $resultado['TipoDocto'],
			'NumeroDocto'=> $resultado['NumeroDocto'],
			'ProductoID'=> $resultado['ProductoID'],
			'Sku'=> $resultado['Sku'],
			'Descripcion'=>$resultado['DESC2'].' '.$resultado['DESC3'],
			'Cantidad'=> (int)$resultado['Cantidad'],
			'Descuento'=> (int)$resultado['Descuento'],
			'PrecioOriginal'=> (int)$resultado['PrecioOriginal'],
			'PrecioFinal'=> (int)$resultado['PrecioFinal'],
			'Vendedor'=> $resultado['Vendedor']
		);
	}
	echo json_encode($res);
?>