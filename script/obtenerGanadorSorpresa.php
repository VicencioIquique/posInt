<?php 
	session_start();
	require_once("../clases/conexionocdb.php");
	date_default_timezone_set('America/Santiago');
	try {
		//echo date('H:m:s');
    		$consultarGanador = "SELECT T3.cadaCuanto, COUNT(T1.ID)%T3.cadaCuanto AS Ganador,count(T1.ID)/T3.CADACUANTO,count(T1.ID)
					  FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] T1
					  LEFT JOIN RP_VICENCIO.dbo.RP_PremioSorpresa T3 ON T1.bodega = T3.bodega
					  WHERE 
					  YEAR(T1.FechaDocto) = '2024'
						AND MONTH(T1.FechaDocto) = '07'
						AND	DAY(T1.FechaDocto) = '".date('d')."'
						AND T1.bodega = '".$_SESSION["bodega"]."'
						AND T1.tipodocto ='1'
					  GROUP BY  T3.cadaCuanto";
	$rsFolio = odbc_exec( $conn, $consultarGanador );
	if (!$rsFolio){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
		echo ( "Error en la consulta SQL" );
	}
	$resultado = odbc_fetch_array($rsFolio);
	echo $resultado['Ganador'];
	
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

						  
	
	
?>