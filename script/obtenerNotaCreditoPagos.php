<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$numeroDocto = $_POST['numeroDocto'];
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	
	
	$sqlVentaNotaCredito="SELECT 
								TipoPago,
								NumeroDoc,
								FechaDoc,
								Monto,
								Descripcion1 as desc1,
								Descripcion2 as desc2,
								Descripcion3 as desc3,
								Descripcion4 as desc4,
								CdCuenta
						FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP
						WHERE
							NumeroDocto = '".$numeroDocto."' AND
							Bodega = '".$bodega."' AND
							WorkStation = '".$workstation."' AND
							TipoDocto IN (1,4) 
							AND FechaDoc >'2016-07-01'
						ORDER BY Secuencia ASC"; // consulta sql
							
	$rsVentaNC = odbc_exec( $conn, $sqlVentaNotaCredito );
	if (!$rsVentaNC){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Venta NC" );
	}	
	while($resultado = odbc_fetch_array($rsVentaNC)){
		$res[] = array(
			"TipoPago"=>$resultado['TipoPago'],
			"NumeroDoc"=>$resultado['NumeroDoc'],
			"FechaDoc"=>$resultado['FechaDoc'],
			"Monto"=>(int)$resultado['Monto'],
			"desc1"=>$resultado['desc1'],
			"desc2"=>$resultado['desc2'],
			"desc3"=>(int)$resultado['desc3'],
			"desc4"=>(int)$resultado['desc4'],
			"CdCuenta"=>(int)$resultado['CdCuenta']
		);
	}
	echo json_encode($res);
?>