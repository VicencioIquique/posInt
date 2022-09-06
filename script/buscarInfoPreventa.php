<?php
	require_once("../clases/conexionocdb.php");
	$codigo = $_POST['codigo'];
	$largo = strlen($codigo);
	
	$sqlInfoPreVenta = "SELECT	RutCliente, 
								Nombres,
								SlpCode as Codigo,
								SlpName as Vendedor
						FROM RP_VICENCIO.dbo.RP_ReceiptsCabPre_SAP
						LEFT JOIN RP_VICENCIO.dbo.RP_Clientes ON RP_VICENCIO.dbo.RP_ReceiptsCabPre_SAP.RutCliente = RP_VICENCIO.dbo.RP_Clientes.RUT
						LEFT JOIN SBO_Imp_Eximben_SAC.dbo.OSLP ON RP_VICENCIO.dbo.RP_ReceiptsCabPre_SAP.Vendedor = SBO_Imp_Eximben_SAC.dbo.OSLP.SlpCode
						WHERE RP_VICENCIO.dbo.RP_ReceiptsCabPre_SAP.ID = '".$codigo."'
						ORDER BY Nombres DESC";
	
	if($largo < 18){
		/*
			No devolver resultado ya que solo es un producto
		*/
	}else{
		$rsInfoPreventa = odbc_exec( $conn, $sqlInfoPreVenta );
		if (!$rsInfoPreventa){
			exit( "Error en la consulta SQL" );
		}
		
		while($resultado = odbc_fetch_array($rsInfoPreventa)){
			$res = array(
				"RutCliente"=>$resultado['RutCliente'],
				"Nombres"=>$resultado['Nombres'],
				"Codigo"=>$resultado['Codigo'],
				"Vendedor"=>$resultado['Vendedor']
			);		
		}
	}
	echo json_encode($res);
?>