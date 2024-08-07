<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); //se hace referencia a la clase conexion que contiene los parametros para entrar a sql server	
	
	$jsonBoletaDetalle = $_POST["jsonBoletaDetalle"];			//recibir JSON con campos de detalle de boleta
	$jsonBoletaCabecera = $_POST['jsonBoletaCabecera'];			//recibir JSON con campos de cabecera de boleta
	$jsonBoletaPagos = $_POST['jsonBoletaPagos'];			//recibir JSON con campos de pagos de boleta
	$caja = $jsonBoletaCabecera['workstation'];
	//Obtener bodega para direccionar log
	switch ($jsonBoletaCabecera['bodega']){
		case '000':
			$my_file = '../log/2077-'.$caja.'.txt';
			break;
		case '001':
			$my_file = '../log/1010-'.$caja.'.txt';
			break;
		case '002':
			$my_file = '../log/1132-'.$caja.'.txt';
			break;
		case '004':
			$my_file = '../log/184-'.$caja.'.txt';
			break;
		case '005':
			$my_file = '../log/2002-'.$caja.'.txt';
			break;
		case '006':
			$my_file = '../log/6115-'.$caja.'.txt';
			break;
		case '007':
			$my_file = '../log/6130-'.$caja.'.txt';
			break;
		case '008':
			$my_file = '../log/2077-'.$caja.'.txt';
			break;
		default:
			$my_file = '../log/no_bodega.txt';
			break;
	}
	
	$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file); //Abrir el archivo de texto en modo w
	
	$log = PHP_EOL . PHP_EOL . '----------------------------------------------- INICIO TRANSACCIÓN -----------------------------------------------';
	fwrite($handle, $log);
	
	$fechaHoraLog = date('Y-m-d H:i:s'); 
	//Variables para controlar la no repetición de una inseción
	$numeroDoctoComp = $jsonBoletaCabecera['numeroDocto'];
	$bodegaComp = $jsonBoletaCabecera['bodega'];
	$workstationComp = $jsonBoletaCabecera['workstation'];
	$tipoDoctoComp = $jsonBoletaCabecera['tipoDocto'];
	
	
		/*OBTENER DOLAR DEL DIA*/
		$sqlTipoCambio = "SELECT TOP 1 [Monto]
			FROM [RP_VICENCIO].[dbo].[RP_MONEDA]
			ORDER BY Fecha DESC";
							
		$rsTipoCambio = odbc_exec( $conn, $sqlTipoCambio );
		
		if (!$rsTipoCambio){ 
			exit( "Error en la consulta SQL Seleccionar tipo cambio" );
			$log = PHP_EOL . $fechaHoraLog . " : Error en la consulta SQL Seleccionar tipo cambio - SQL: " . $sqlTipoCambio;
			fwrite($handle, $log); // Guardar SQL en Log en caso de error
		}else{
			$log = PHP_EOL . $fechaHoraLog . ' : ' . $sqlTipoCambio;
			fwrite($handle, $log); // Guardar SQL en LOG si no hay error
		}
		
		$resultadoTipoCambio = odbc_fetch_array($rsTipoCambio);
		$tipoCambio = $resultadoTipoCambio['Monto'];
		
		$log = PHP_EOL . $fechaHoraLog . ' : Tipo Cambio: ' . $tipoCambio;
		fwrite($handle, $log);
		/*FIN OBTENER DOLAR DEL DIA*/
		
		//Acumuladores de resultados de Detalle para CABECERA*/
		$acumCIF = 0;
		
		//Obtener fecha actual del servidor para FechaCreacion
		$fechaCreacion = date('Y-d-m H:i:s'); 
		$log = PHP_EOL . $fechaHoraLog . ' : Fecha de creación: ' . $fechaCreacion;
		fwrite($handle, $log);
		//Factor temporal para el cálculo de la retenciónDL
		$factor = 0.0035; //update 31.03.24
		$log = PHP_EOL . $fechaHoraLog . ' : Factor (constante): ' . $factor;
		fwrite($handle, $log);
		//Secuencia para inserción en tabla Detalle
		$secuencia = 1; 
		
		/*INSERTAR DETALLE*/
		echo "\nINSERCION DE DETALLE \n";
		
		$sqlDetalleOrig = "SELECT 
								RecNumber,
								ALU,
								DESC2,
								DESC3,
								Cantidad, 
								Descuento,
								PrecioFinal,
								PrecioExtendido,
								RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Vendedor,
								FechaDocto 
						FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
						LEFT JOIN RP_VICENCIO.dbo.RP_Articulos ON RP_VICENCIO.dbo.RP_Articulos.ALU = RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Sku
						LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsCab_SAP ON RP_VICENCIO.dbo.RP_ReceiptsCab_SAP.ID = RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.ID
						WHERE 
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.NumeroDocto = '".$numeroDocto."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Bodega = '".$bodega."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.WorkStation = '".$workstation."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.tipoDocto = '".$tipoDocto."'
							AND FechaDocto >'2016-07-01'";
		$rsDetalleOrig = odbc_exec( $conn, $sqlDetalleOrig );
		
		if (!$rsDetalleOrig){  //si la fila esta vacia no entra
			exit( "Error en la inserción de Detalle" );
			//exit( "Error en la inserción de Detalle" );
		}	
		while($resDetalleOrig = odbc_fetch_array($rsDetalleOrig)){
			$sqlInsertarDetalle = "INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
									VALUES('".$jsonBoletaCabecera['bodega']."',
											'".$jsonBoletaCabecera['tipoDocto']."',
											'".$jsonBoletaCabecera['numeroDocto']."',
											'".$resDetalleOrig['Secuencia']."',
											'".$resDetalleOrig['Sku']."',
											'".$resDetalleOrig['Cantidad']."',
											'".$resDetalleOrig['PrecioOriginal']."',
											'".$resDetalleOrig['Descuento']."',
											'".$resDetalleOrig['PrecioFinal']."',
											'".$resDetalleOrig['Vendedor']."',
											'".$resDetalleOrig['CIF']."',
											'".$resDetalleOrig['Lote']."',
											'".$resDetalleOrig['PrecioExtendido']."',
											'".$resDetalleOrig['Factor']."',
											'".$jsonBoletaCabecera['workstation']."',
											'".$jsonBoletaCabecera['ID']."',
											'".$resDetalleOrig['CostoExt']."',
											'".$resDetalleOrig['NumListaPrecio']."',
											'".$resDetalleOrig['ProductoID']."',
											'".$resDetalleOrig['CodigoBarra']."',
											'".$resDetalleOrig['IDPreVenta']."',
											'".$resDetalleOrig['TipoImpuesto']."',
											'".$resDetalleOrig['PorcentajeImpuesto']."',
											'".$resDetalleOrig['Aux']."',
											'".$resDetalleOrig['Attr']."',
											'".$resDetalleOrig['CodPromo']."')";
			$log = PHP_EOL . $fechaHoraLog . ' : SQL Detalle: ' . $sqlInsertarDetalle;	
			fwrite($handle, $log);
		}
		/*FIN INSERTAR DETALLE*/
		
		/*INICIO INSERTAR CABECERA*/
		if($jsonBoletaCabecera['tipoDocto'] == '1'){
			$fechaDocto = $fechaCreacion;
			$log = PHP_EOL . $fechaHoraLog . ' : Tipo de documento 1 - Fecha de creación igual a fecha de documento: ' . $fechaDocto;
			fwrite($handle, $log);
		}else{
			$fechaDocto = $jsonBoletaCabecera['fechaDocto'];
			$log = PHP_EOL . $fechaHoraLog . ' : Tipo de documento 2,3 o 4 - Fecha de creación distinto a fecha de documento: ' . $fechaDocto;
			fwrite($handle, $log);
		}
		echo "\nINSERCION CABECERA\n";
		//Obtener Serie
		if($jsonBoletaCabecera['bodega'] == '000'){
			$local = 'ZFI.2077';
		}else if($jsonBoletaCabecera['bodega'] == '001'){
			$local = 'ZFI.1010';
		}else if($jsonBoletaCabecera['bodega'] == '002'){
			$local = 'ZFI.1132';
		}else if($jsonBoletaCabecera['bodega'] == '003'){
			$local = 'ZFI.181';
		}else if($jsonBoletaCabecera['bodega'] == '004'){
			$local = 'ZFI.184';
		}else if($jsonBoletaCabecera['bodega'] == '005'){
			$local = 'ZFI.2002';
		}else if($jsonBoletaCabecera['bodega'] == '006'){
			$local = 'ZFI.6115';
		}else if($jsonBoletaCabecera['bodega'] == '007'){
			$local = 'ZFI.6130';
		}
		$sqlSerie="SELECT Serie 
			FROM [RP_VICENCIO].[dbo].[Serie]
			WHERE Bodega = '".$local."' AND 
					Caja = '".$jsonBoletaCabecera['workstation']."' AND 
					Documento = '".$jsonBoletaCabecera['tipoDocto']."'";
		
		$rsSerie = odbc_exec( $conn, $sqlSerie );
		if (!$rsSerie){
			exit( "Error en la consulta SQL Serie" );
			$log = PHP_EOL . $fechaHoraLog . ' : Error en la consulta SQL Serie: ' . $sqlSerie;
			fwrite($handle, $log);
		}else{
			$log = PHP_EOL . $fechaHoraLog . ' : ' . $sqlSerie;
			fwrite($handle, $log);
		}
		$resultadoSerie = odbc_fetch_array($rsSerie);
		
		$retencionDL18219 = (($acumCIF * $tipoCambio) * $factor); //Formula para obtener retenciónDL18219
		$sqlInsertarCabecera = "INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
						VALUES ('".$jsonBoletaCabecera['bodega']."',
							'".$jsonBoletaCabecera['workstation']."',
							'".$jsonBoletaCabecera['tipoDocto']."',
							'".$jsonBoletaCabecera['numeroDocto']."',
							'".$fechaDocto."',
							'".$jsonBoletaCabecera['totNeto']."',
							'".$jsonBoletaCabecera['totDescuento']."',
							'".$jsonBoletaCabecera['totIva']."',
							'".$jsonBoletaCabecera['total']."',
							'".$jsonBoletaCabecera['rutCliente']."',
							'".$jsonBoletaCabecera['rutDespacho']."',
							'".$jsonBoletaCabecera['cajera']."',
							'".round($retencionDL18219)."',
							".number_format($tipoCambio, 2, '.', '').",
							".number_format($acumCIF, 4, '.', '').",
							'".((int)$jsonBoletaCabecera['total'] - round($retencionDL18219))."',
							'".$jsonBoletaCabecera['vendedorNumero']."',
							'".$jsonBoletaCabecera['estado']."',
							'".$jsonBoletaCabecera['numeroDoctoRef']."',
							'".$jsonBoletaCabecera['fechaDoctoRef']."',
							'".$jsonBoletaCabecera['ID']."',
							'".$fechaCreacion."',
							'".$resultadoSerie['Serie']."',
							'".$jsonBoletaCabecera['retencionCarnes']."',
							'".$jsonBoletaCabecera['netoRetencionCarnes']."',
							'0.41',
							'".$jsonBoletaCabecera['billToCompany']."',
							'".number_format(($jsonBoletaCabecera['total'] - round($retencionDL18219)), 0, ',', '.')."',
							'".$jsonBoletaCabecera['type']."',
							'".$jsonBoletaCabecera['Status']."',
							'".$jsonBoletaCabecera['baseEntry']."')";
		$log = PHP_EOL . $fechaHoraLog . ' : SQL Insertar Cabecera: ' . $sqlInsertarCabecera;
		fwrite($handle, $log);
		//echo $sqlInsertarCabecera;
		/*$rsInsertarCabecera = odbc_exec( $conn, $sqlInsertarCabecera );
		if (!$rsInsertarCabecera){  //si la fila esta vacia no entra
			exit( "Error en la inserción de Cabecera" );
			echo( "Error en la inserción de Cabecera" );
		}*/
		
		/*FIN INSERTAR CABECERA*/
		
		/*INICIO INSERTAR PAGOS*/
		
		$secuenciaPagos = 0;
		echo "\nINSERCION DE PAGOS\n";
		for($i=0;$i<count($jsonBoletaPagos['tipoPago']);$i++){
			if($jsonBoletaPagos['tipoDocto'] == '1' && ($jsonBoletaPagos['tipoPago'][$i] == 'Check' || $jsonBoletaPagos['tipoPago'][$i] == 'Payments')){
				$fechaDocto = $jsonBoletaPagos['fechaCheque'][$i];
			}else if($jsonBoletaPagos['tipoDocto'] == '1'){
				$fechaDocto = $fechaCreacion;
			}else{
				$fechaDocto = $jsonBoletaPagos['fechaDoc'];
			}
			$sqlInsertarPagos = "INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP
						VALUES('".$jsonBoletaPagos['bodega']."',
							'".$jsonBoletaPagos['tipoDocto']."',
							'".$jsonBoletaPagos['numeroDocto']."',
							'".($secuenciaPagos+1)."',
							'".$jsonBoletaPagos['tipoPago'][$i]."',
							'".$jsonBoletaPagos['NumeroDoc'][$i]."',
							'".$fechaDocto."',
							'".$jsonBoletaPagos['monto'][$i]."',
							'".$jsonBoletaPagos['desc1'][$i]."',
							'".$jsonBoletaPagos['desc2'][$i]."',
							'".$jsonBoletaPagos['desc3'][$i]."',
							'".$jsonBoletaPagos['desc4'][$i]."',
							'".$jsonBoletaPagos['CdCuenta'][$i]."',
							'".$jsonBoletaPagos['workstation']."',
							'".$jsonBoletaPagos['ID']."')";
			$secuenciaPagos++;
			$log = PHP_EOL . $fechaHoraLog . ' : SQL Insertar Pagos: ' . $sqlInsertarPagos;
			fwrite($handle, $log);
			/*$rsInsertarPagos = odbc_exec( $conn, $sqlInsertarPagos );
			if (!$rsInsertarPagos){  //si la fila esta vacia no entra
				exit( "Error en la inserción de Pagos" );
				echo( "Error en la inserción de Pagos" );
			}*/
			//echo $sqlInsertarPagos;
		}
		
		/*Actualizar ultimo folio de los documentos*/
		if($jsonBoletaCabecera['tipoDocto'] == '1'){
			$sqlActualizarFolio = "UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
										SET ultFolioFiscal = '".$jsonBoletaCabecera['numeroDocto']."'
										WHERE ip = '".$_SESSION["ip"]."'";
			//$rsActualizarFolio = odbc_exec( $conn, $sqlActualizarFolio );
			
			$log = PHP_EOL . $fechaHoraLog . ' : Actrualizando último Folio Fiscal: ' . $sqlActualizarFolio;
			fwrite($handle, $log);
						
		}else if($jsonBoletaCabecera['tipoDocto'] == '2'){
			$sqlActualizarFolio = "UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
										SET ultFactura = '".$jsonBoletaCabecera['numeroDocto']."'
										WHERE ip = '".$_SESSION["ip"]."'";
			
			$log = PHP_EOL . $fechaHoraLog . ' : Actrualizando último Folio Factura: ' . $sqlActualizarFolio;
			fwrite($handle, $log);
			
		}else if($jsonBoletaCabecera['tipoDocto'] == '3'){
			$sqlActualizarFolio = "UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
										SET ultNotaCredito = '".$jsonBoletaCabecera['numeroDocto']."'
										WHERE ip = '".$_SESSION["ip"]."'";
			
			$log = PHP_EOL . $fechaHoraLog . ' : Actrualizando último Folio Nota Crédito: ' . $sqlActualizarFolio;
			fwrite($handle, $log);
			
		}else if($jsonBoletaCabecera['tipoDocto'] == '4'){
			$sqlActualizarFolio = "UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
										SET ultBoletaManual = '".$jsonBoletaCabecera['numeroDocto']."'
										WHERE ip = '".$_SESSION["ip"]."'";
			
			$log = PHP_EOL . $fechaHoraLog . ' : Actrualizando último Folio Boleta Manual: ' . $sqlActualizarFolio;
			fwrite($handle, $log);
			
		}
		
		$log = PHP_EOL . '----------------------------------------------- FIN TRANSACCIÓN -----------------------------------------------';
		fwrite($handle, $log);
?>