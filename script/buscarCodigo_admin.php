<?php
	session_start();
	require_once("../clases/conexionocdb.php");
	$codigo = $_POST['codigo'];
	$bodega = $_POST['bodega'];
	$largo = strlen($codigo);
	$rut = $_POST['rut'];
	//Se cambia DESC1 por DESC2 15-11-2016 para el cambio de descripción visible al sistema y boleta fiscal
	$sqlPreVenta = "SELECT 	RecNumber,
							ALU,
							DESC2,
							DESC3,
							Cantidad,
							PrecioFinal,
							PrecioExtendido,
							Descuento,
							Vendedor
					FROM RP_VICENCIO.dbo.RP_ReceiptsDetPre_SAP
					LEFT JOIN RP_VICENCIO.dbo.RP_Articulos ON RP_VICENCIO.dbo.RP_Articulos.ALU = RP_VICENCIO.dbo.RP_ReceiptsDetPre_SAP.Sku
					WHERE ID = '".$codigo."'
					ORDER BY Secuencia ASC";
	
	$sqlProducto = "SELECT 	RecNumber,
							ALU,
							DESC2,
							DESC3,
							PRICE01
					FROM RP_VICENCIO.dbo.RP_Articulos
					WHERE ALU = '".$codigo."'";
	
	$sqlProductoLike = "SELECT 	RecNumber,	
							ALU,
							DESC2,
							DESC3,
							PRICE01
					FROM RP_VICENCIO.dbo.RP_Articulos
					WHERE ALU like '%".$codigo."%'";
	
	$sqlBuscarUsuarioConvenio = "SELECT Nombres
								FROM RP_VICENCIO.dbo.RP_Clientes
								WHERE RUT = '".$rut."'AND
										Direccion1 = 'Sindicato N1'";
	$rsBuscarUsuarioConvenio= odbc_exec( $conn, $sqlBuscarUsuarioConvenio );
	if (!$rsBuscarUsuarioConvenio){
		exit( "Error en la consulta SQL Cliente collahuasi" );
	}							
	$resultadoBuscarUsuarioConvenio = odbc_fetch_array($rsBuscarUsuarioConvenio);
	
	if($largo < 18){ //Producto regular
		$rsProducto = odbc_exec( $conn, $sqlProducto );
		if (!$rsProducto){
			exit( "Error en la consulta SQL" );
		}
		
		while($resultado = odbc_fetch_array($rsProducto)){
			$sqlStock = "SELECT SUM(Cantidad) as Cantidad FROM RP_VICENCIO.dbo.LotesDisponibles WHERE ItemCode = '".$resultado['ALU']."' AND Bodega = '".$bodega."'";
			$rsStock = odbc_exec($conn, $sqlStock);
			if(!$rsStock){
				exit("Error en la consulta SQL Stock");
			}
			$resStock = odbc_fetch_array($rsStock);
			//Buscar descuento
			if($resultadoBuscarUsuarioConvenio['Nombres'] != ''){
				$precioProducto = round((int)$resultado['PRICE01'] * 0.9);
				$descuento = $resultado['PRICE01'] - $precioProducto;
			}else{
				$sqlDescuento = "SELECT descuento, cantidad FROM [RP_VICENCIO].[dbo].[RP_Descuento_Navidad2] WHERE upc = '".$resultado['ALU']."'";
				$rsDescuento = odbc_exec($conn, $sqlDescuento);
				if(!$rsDescuento){
					exit("Error en la consulta SQL Stock");
				}
				$resDescuento = odbc_fetch_array($rsDescuento);
				if($resDescuento != '' && $resDescuento['cantidad'] > 1){
					$precioProducto = (int)$resultado['PRICE01'];
					$descuento = (int)$resDescuento['descuento'];
				}else if($resDescuento != ''){
					$precioProducto = (int)$resDescuento['descuento'];
					$descuento = $resultado['PRICE01'] - $resDescuento['descuento'];
				}else{
					$precioProducto = (int)$resultado['PRICE01'];
					$descuento = 0;
				}
			}
			
			$res[] = array(
				"RecNumber"=>$resultado['RecNumber'],
				"ALU"=>$resultado['ALU'],
				"DESC2"=>$resultado['DESC2'],
				"DESC3"=>$resultado['DESC3'],
				"Cantidad"=>1,
				"PrecioFinal"=>(int)$resultado['PRICE01'],
				"PrecioExtendido"=>$precioProducto,
				"Descuento"=>(int)$descuento,
				"Vendedor"=>'',
				"CantidadLotes"=>(int)$resStock['Cantidad'],
				"IDPreventa"=>'',
				"cantPromocion"=>$resDescuento['cantidad']
			);		
		}
	}else{ //Preventa
		$rsPreventa = odbc_exec( $conn, $sqlPreVenta );
		if (!$rsPreventa){
			exit( "Error en la consulta SQL" );
		}
		
		while($resultado = odbc_fetch_array($rsPreventa)){
			//CONSULTAR STOCK
			$sqlStock = "SELECT SUM(Cantidad) as Cantidad FROM RP_VICENCIO.dbo.LotesDisponibles WHERE ItemCode = '".$resultado['ALU']."' AND Bodega = '".$bodega."'";
			$rsStock = odbc_exec($conn, $sqlStock);
			if(!$rsStock){
				exit("Error en la consulta SQL Stock");
			}
			$resStock = odbc_fetch_array($rsStock);
			//FIN CONSULTAR STOCK
			//El descuento de la preventa se define ahí.
			$res[] = array(
				"RecNumber"=>$resultado['RecNumber'],
				"ALU"=>$resultado['ALU'],
				"DESC2"=>$resultado['DESC2'],
				"DESC3"=>$resultado['DESC3'],
				"Cantidad"=>(int)$resultado['Cantidad'],
				"PrecioFinal"=>(int)$resultado['PrecioFinal'],
				"PrecioExtendido"=>(int)$resultado['PrecioExtendido'],
				"Descuento"=>(int)$resultado['Descuento'],
				"Vendedor"=>$resultado['Vendedor'],
				"CantidadLotes"=>(int)$resStock['Cantidad'],
				"IDPreventa"=>$codigo,
				"cantPromocion"=>$resDescuento['cantidad']
			);		
		}
	}
	echo json_encode($res);
?>