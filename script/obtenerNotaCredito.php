<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$numeroDocto = $_POST['numeroDocto'];
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	$tipoDocto = $_POST['tipoDocto'];
	
	$sqlVentaNotaCredito="SELECT 
								RecNumber,
								ALU,
								REPLACE(DESC2, ',', '.') DESC2,
								DESC3,
								Cantidad, 
								Descuento,
								PrecioFinal,
								PrecioExtendido,
								RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Vendedor,
								FechaDocto,
								RP_VICENCIO.dbo.RP_ReceiptsCAb_SAP.ID
						FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
						LEFT JOIN RP_VICENCIO.dbo.RP_Articulos ON RP_VICENCIO.dbo.RP_Articulos.ALU = RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Sku
						LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsCab_SAP ON RP_VICENCIO.dbo.RP_ReceiptsCab_SAP.ID = RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.ID
						WHERE 
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.NumeroDocto = '".$numeroDocto."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Bodega = '".$bodega."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.WorkStation = '".$workstation."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.tipoDocto = '".$tipoDocto."'
							AND FechaDocto >'2016-07-01'"; // consulta sql la fecha fue agregada por la duplicidad de los folios de CAJA 2 EN EL LOCAL 1132
							
							
	$rsVentaNC = odbc_exec( $conn, $sqlVentaNotaCredito );
	if (!$rsVentaNC){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Venta NC" );
	}	
	while($resultado = odbc_fetch_array($rsVentaNC)){
		$res[] = array(
			"RecNumber"=>$resultado['RecNumber'],
			"ALU"=>$resultado['ALU'],
			"DESC2"=>sanear_string(utf8_encode($resultado['DESC2'])),
			"DESC3"=>sanear_string(utf8_encode($resultado['DESC3'])),
			"Cantidad"=>(int)$resultado['Cantidad'],
			"Descuento"=>(int)$resultado['Descuento'],
			"PrecioFinal"=>(int)$resultado['PrecioFinal'],
			"PrecioExtendido"=>(int)$resultado['PrecioExtendido'],
			"Vendedor"=>(int)$resultado['Vendedor'],
			"FechaDocto"=>$resultado['FechaDocto'],
			"ID"=>$resultado['ID']
		);
	}
	echo json_encode($res);

	function sanear_string($string) {
		$string = trim($string);
	
		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);
	
		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);
	
		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);
	
		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);
	
		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);
	
		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);
	
		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
			array("\\", "¨", "º", "-", "~",
				 "#", "@", "|", "!", "\"",
				 "·", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "`", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				 ".", ""),
			'',
			$string
		);
		return $string;
	}
?>