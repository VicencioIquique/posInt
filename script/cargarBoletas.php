<?php 
set_time_limit(60);
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	$ano = $_POST['ano'];
	$mes = $_POST['mes'];
	$numDocto = $_POST['numDocto'];
	if($numDocto != ''){
		$consultaBoletas="SELECT 
						   TABLA.Bodega
						  ,TABLA.Workstation
						  ,TABLA.TipoDocto
						  ,TABLA.NumeroDocto
						  ,TABLA.FechaDocto
						  ,TABLA.TipoPago
						  ,SUM(TABLA.Monto) [Monto]

					FROM 
					(
					 SELECT 
							TRCab.Bodega
						,TRCab.Workstation
						,FechaDocto
						,TRCab.TipoDocto
						,TRCab.NumeroDocto
						,TRPagos.Monto
						, CASE 
					   WHEN (SELECT
						COUNT(TipoPago) 
						FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as S2 
						  WHERE S2.ID = TRPagos.ID)  > 1 THEN 'Pago Mixto'
						ELSE TRPagos.TipoPago
					   END [TipoPago]
					  FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as TRCab
					  LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as TRPagos ON TRPagos.ID = TRCab.ID
					  WHERE 
							TRCab.Bodega = '".$bodega."' AND 
							TRCab.Workstation = '".$workstation."' AND 
							YEAR(TRCab.FechaDocto) = '".$ano."' AND 
							MONTH(TRCab.FechaDocto) = '".$mes."' 
							AND TRCab.NumeroDocto = '".$numDocto."'
					) as Tabla
					GROUP BY
						TABLA.Bodega
					   ,TABLA.Workstation
					   ,TABLA.FechaDocto
					   ,TABLA.TipoDocto
					   ,Tabla.NumeroDocto
					   ,TABLA.TipoPago

					ORDER BY Tabla.FechaDocto DESC"; // consulta sql
	}else{
		$consultaBoletas="SELECT 
						   TABLA.Bodega
						  ,TABLA.Workstation
						  ,TABLA.TipoDocto
						  ,TABLA.NumeroDocto
						  ,TABLA.FechaDocto
						  ,TABLA.TipoPago
						  ,SUM(TABLA.Monto) [Monto]

					FROM 
					(
					 SELECT 
							TRCab.Bodega
						,TRCab.Workstation
						,FechaDocto
						,TRCab.TipoDocto
						,TRCab.NumeroDocto
						,TRPagos.Monto
						, CASE 
					   WHEN (SELECT
						COUNT(TipoPago) 
						FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as S2 
						  WHERE S2.ID = TRPagos.ID)  > 1 THEN 'Pago Mixto'
						ELSE TRPagos.TipoPago
					   END [TipoPago]
					  FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as TRCab
					  LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as TRPagos ON TRPagos.ID = TRCab.ID
					  WHERE 
							TRCab.Bodega = '".$bodega."' AND 
							TRCab.Workstation = '".$workstation."' AND 
							YEAR(TRCab.FechaDocto) = '".$ano."' AND 
							MONTH(TRCab.FechaDocto) = '".$mes."'
					) as Tabla
					GROUP BY
						TABLA.Bodega
					   ,TABLA.Workstation
					   ,TABLA.FechaDocto
					   ,TABLA.TipoDocto
					   ,Tabla.NumeroDocto
					   ,TABLA.TipoPago

					ORDER BY Tabla.FechaDocto DESC"; // consulta sql
	}
	$rsConsultaBoletas = odbc_exec( $conn, $consultaBoletas );
	if (!$rsConsultaBoletas){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Bancos" );
	}	
	while($resultado = odbc_fetch_array($rsConsultaBoletas)){
		$res[] = array(
			'bodega'=>$resultado['Bodega'],
			'workstation'=>$resultado['Workstation'],
			'tipoDocto'=>$resultado['TipoDocto'],
			'numeroDocto'=>$resultado['NumeroDocto'],
			'fechaDocto'=>$resultado['FechaDocto'],
			'tipoPago'=>$resultado['TipoPago'],
			'monto'=>(int)$resultado['Monto']
		);
	}
	echo json_encode($res);
?>