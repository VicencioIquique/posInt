<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	$tipoDocto = $_POST['tipoDocto'];
	$numeroDocto = $_POST['numeroDocto'];
	
	
	$consultaDetalleFormaPago="SELECT 
						Secuencia, 
						TipoDocto,
						NumeroDocto,
						TipoPago, 
						NumeroDoc [Cuotas], 
						FechaDoc, 
						Monto, 
						Descripcion2 [NumTarjeta], 
						Descripcion3 [CodAut]
					 FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP 
					 WHERE 
						NumeroDocto = '".$numeroDocto."' AND 
						TipoDocto = '".$tipoDocto."' AND
						Bodega = '".$bodega."' AND 
						WorkStation = '".$workstation."'"; // consulta sql
						
	$rsDetalleFormaPago = odbc_exec( $conn, $consultaDetalleFormaPago );
	if (!$rsDetalleFormaPago){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}	
	while($resultado = odbc_fetch_array($rsDetalleFormaPago)){
		$res[] = array(
			'Secuencia'=> (int)$resultado['Secuencia'],
			'TipoDocto'=> $resultado['TipoDocto'],
			'NumeroDocto'=> $resultado['NumeroDocto'],
			'TipoPago'=> $resultado['TipoPago'],
			'Cuotas'=> $resultado['Cuotas'],
			'FechaDoc'=> $resultado['FechaDoc'],
			'Monto'=> (int)$resultado['Monto'],
			'NumTarjeta'=> $resultado['NumTarjeta'],
			'CodAut'=> $resultado['CodAut']
		);
	}
	echo json_encode($res);
?>