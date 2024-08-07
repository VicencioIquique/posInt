<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); //se hace referencia a la clase conexion que contiene los parametros para entrar a sql server	
	
	$jsonBoletaDetalle = $_POST["jsonBoletaDetalle"];			//recibir JSON con campos de detalle de boleta
	$jsonBoletaCabecera = $_POST['jsonBoletaCabecera'];			//recibir JSON con campos de cabecera de boleta
	$jsonBoletaPagos = $_POST['jsonBoletaPagos'];			//recibir JSON con campos de pagos de boleta
	$workstationNC = $_POST['workstationNC'];				//recibir workstation de origen de documento de nota de crédito
	
	//Variables para controlar la no repetición de una inseción
	$numeroDoctoComp = $jsonBoletaCabecera['numeroDocto'];
	$bodegaComp = $jsonBoletaCabecera['bodega'];
	$workstationComp = $jsonBoletaCabecera['workstation'];
	$tipoDoctoComp = $jsonBoletaCabecera['tipoDocto'];
	
	$sqlComprobarNoRepeticion = "SELECT numeroDocto, bodega, workstation 
									FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
									WHERE numeroDocto = '".$numeroDoctoComp."' AND
											bodega = '".$bodegaComp."' AND
											workstation = '".$workstationComp."' AND
											TipoDocto = '".$tipoDoctoComp."'";
	
	$rsComprobarNoRepeticion = odbc_exec( $conn, $sqlComprobarNoRepeticion );
	if (!$rsComprobarNoRepeticion){ 
		exit( "Error en la consulta SQL Comprobar repetición de boletas" );
		echo( "Error en la consulta SQL Comprobar repetición de boletas" );
	}	
	$resultadoNoRepeticion = odbc_fetch_array($rsComprobarNoRepeticion);
	
	if($resultadoNoRepeticion['numeroDocto'] != null || $resultadoNoRepeticion['numeroDocto'] != ''){
		echo 0; //Resultado de respuesta a control de repetición de boleta
	}else{
		/*OBTENER DOLAR DEL DIA*/
		$sqlTipoCambio = "SELECT TOP 1 [Monto]
							FROM [RP_VICENCIO].[dbo].[RP_MONEDA]
							ORDER BY Fecha DESC";
		$rsTipoCambio = odbc_exec( $conn, $sqlTipoCambio );
		if (!$rsTipoCambio){ 
			exit( "Error en la consulta SQL Seleccionar tipo cambio" );
			echo( "Error en la consulta SQL Seleccionar tipo cambio" );
			
		}	
		$resultadoTipoCambio = odbc_fetch_array($rsTipoCambio);
		$tipoCambio = $resultadoTipoCambio['Monto'];
		/*FIN OBTENER DOLAR DEL DIA*/
		
		//Acumuladores de resultados de Detalle para CABECERA*/
		$acumCIF = 0;
		
		//Obtener fecha actual del servidor para FechaCreacion
		$fechaCreacion = date('Y-m-d H:i:s'); 
		
		//Factor temporal para el cálculo de la retenciónDL
		$factor = 0.0035; //update 31.03.24
		
		//Secuencia para inserción en tabla Detalle
		$secuencia = 1; 
		
		/*INSERTAR DETALLE*/
		//echo "\nINSERCION DE DETALLE \n";
		
		
		$sqlDetalleOrig = "SELECT * FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
								WHERE NumeroDocto = '".$jsonBoletaCabecera['numeroDoctoNC']."'
									AND TipoDocto = '".$jsonBoletaCabecera['tipoDoctoNC']."'
									AND Bodega = '".$jsonBoletaCabecera['bodega']."'
									AND Workstation = '".$workstationNC."'";
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
			$rsInsertarDetalle= odbc_exec( $conn, $sqlInsertarDetalle );
			if (!$rsInsertarDetalle){  //si la fila esta vacia no entra
				exit( "Error en la inserción de Detalle" );
				//exit( "Error en la inserción de Detalle" );
			}	
		}

		/*FIN INSERTAR DETALLE*/
		
		/*INICIO INSERTAR CABECERA*/
		if($jsonBoletaCabecera['tipoDocto'] == '1'){
			$fechaDocto = $jsonBoletaCabecera['fechaDocto'];
		}else{
			$fechaDocto = $jsonBoletaCabecera['fechaDocto'];
		}
		//echo "\nINSERCION CABECERA\n";
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
		$sqlSerie="SELECT 
						Serie 
					FROM 
						[RP_VICENCIO].[dbo].[Serie]
					WHERE 
						Bodega = '".$local."' AND 
						Caja = '".$jsonBoletaCabecera['workstation']."' AND 
						Documento = '".$jsonBoletaCabecera['tipoDocto']."'";
		
		$rsSerie = odbc_exec( $conn, $sqlSerie );
		if (!$rsSerie){
			exit( "Error en la consulta SQL Serie" );
			echo( "Error en la consulta SQL Serie" );
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
		//echo $sqlInsertarCabecera;
		$rsInsertarCabecera = odbc_exec( $conn, $sqlInsertarCabecera );
		if (!$rsInsertarCabecera){  //si la fila esta vacia no entra
			exit( "Error en la inserción de Cabecera" );
			echo( "Error en la inserción de Cabecera" );
		}
		
		/*FIN INSERTAR CABECERA*/
		
		/*INICIO INSERTAR PAGOS*/
		
		$secuenciaPagos = 0;
		//echo "\nINSERCION DE PAGOS\n";
		for($i=0;$i<count($jsonBoletaPagos['tipoPago']);$i++){
			if($jsonBoletaPagos['tipoDocto'] == '1' && ($jsonBoletaPagos['tipoPago'][$i] == 'Check' || $jsonBoletaPagos['tipoPago'][$i] == 'Payments')){
				$fechaDocto = $jsonBoletaPagos['fechaCheque'][$i];
			}else if($jsonBoletaPagos['tipoDocto'] == '1'){
				$fechaDocto = $jsonBoletaPagos['fechaDoc'];
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
			$rsInsertarPagos = odbc_exec( $conn, $sqlInsertarPagos );
			if (!$rsInsertarPagos){  //si la fila esta vacia no entra
				exit( "Error en la inserción de Pagos" );
				echo( "Error en la inserción de Pagos" );
			}
			//echo $sqlInsertarPagos;
		}
		/*FIN INSERTAR PAGOS*/
		
		echo 1;	//Resultado de respuesta a control de repetición	
	}
?>