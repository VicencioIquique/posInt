<?php
	session_start();
	require_once("../clases/conexionocdb.php");
	$codigo = $_POST['codigo'];
	$largo = strlen($codigo);
	$bodega =$_POST['bodega'];
	$rut = $_POST['rut'];
	//Se cambia DESC1 por DESC2 15-11-2016 para el cambio de descripción visible al sistema y boleta fiscal
	$sqlPreVenta = "SELECT 	RecNumber,
							ALU,
							CASE
								WHEN DESC2 like '%,%' THEN
									REPLACE(DESC2, ',', '')
								WHEN DESC2 like '%&%' THEN
									REPLACE(DESC2, '&', '')
								WHEN  DESC2 like '%Ñ%' THEN
									REPLACE(DESC2, 'Ñ', '')
								ELSE
									DESC2
							END as DESC2,
							CASE
								WHEN DESC3 like '%,%' THEN
									REPLACE(DESC3, ',', '')
								WHEN DESC3 like '%&%' THEN
									REPLACE(DESC3, '&', '')
								WHEN  DESC3 like '%Ñ%' THEN
									REPLACE(DESC3, 'Ñ', '')
								ELSE
									DESC3
							END as DESC3,
							Cantidad,
							PrecioFinal,
							PrecioExtendido,
							Descuento,
							Vendedor,
							DESC4
					FROM RP_VICENCIO.dbo.RP_ReceiptsDetPre_SAP
					LEFT JOIN RP_VICENCIO.dbo.RP_Articulos ON RP_VICENCIO.dbo.RP_Articulos.ALU = RP_VICENCIO.dbo.RP_ReceiptsDetPre_SAP.Sku
					WHERE ID = '".$codigo."'
					ORDER BY Secuencia ASC";
	
	$sqlProducto = "SELECT 	RecNumber,
							ALU,
							CASE 
								WHEN DESC2 like '%&%' THEN
									REPLACE(DESC2, '&', '') 
								WHEN DESC2 like '%,%' THEN
									REPLACE(DESC2, ',', '')
								WHEN  DESC2 like '%Ñ%' THEN
									REPLACE(DESC2, 'Ñ', '')
								ELSE 
									DESC2
							END as DESC2,
							CASE 
								WHEN DESC3 like '%&%' THEN
									REPLACE(DESC3, '&', '') 
								WHEN  DESC3 like '%,%' THEN
									REPLACE(DESC3, ',', '')
								WHEN  DESC3 like '%Ñ%' THEN
									REPLACE(DESC3, 'Ñ', '')
								ELSE 
									DESC3
							END as DESC3,
							PRICE01,
							DESC4
					FROM RP_VICENCIO.dbo.RP_Articulos
					WHERE ALU = '".$codigo."'";
	
	$sqlProductoLike = "SELECT 	RecNumber,	
							ALU,
							REPLACE(DESC2, '&', '') as DESC2,
							REPLACE(DESC3, '&', '') as DESC3,
							PRICE01
					FROM RP_VICENCIO.dbo.RP_Articulos
					WHERE ALU like '%".$codigo."%'";
	
	$sqlBuscarUsuarioConvenio = "SELECT Nombres
								FROM RP_VICENCIO.dbo.RP_Descuento_Empresa
								WHERE RUT = '".$rut."'";
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

			$sqlStock = "SELECT SUM(Cantidad) as Cantidad FROM RP_VICENCIO.dbo.LotesDisponibles WHERE ItemCode = '".$resultado['ALU']."'AND Bodega = '".$_SESSION["bodega"]."'";

			$rsStock = odbc_exec($conn, $sqlStock);
			if(!$rsStock){
				exit("Error en la consulta SQL Stock");
			}
			$resStock = odbc_fetch_array($rsStock);
			//Buscar descuento
			if($resultadoBuscarUsuarioConvenio['Nombres'] != ''){
				$precioProducto = round(((int)$resultado['PRICE01']/10) * 0.9);
				$precioProducto=$precioProducto*10;
				$descuento = $resultado['PRICE01'] - $precioProducto;
				$res[] = array(
				"RecNumber"=>$resultado['RecNumber'],
				"ALU"=>$resultado['ALU'],
				"DESC2"=>sanear_string(utf8_encode($resultado['DESC2'])),
				"DESC3"=>sanear_string(utf8_encode($resultado['DESC3'])),
				"DESC4"=>$resultado['DESC4'],
				"Cantidad"=>1,
				"PrecioFinal"=>(int)$resultado['PRICE01'],
				"PrecioExtendido"=>$precioProducto,
				"Descuento"=>(int)$descuento,
				"Vendedor"=>'',
				"CantidadLotes"=>(int)$resStock['Cantidad'],
				"IDPreventa"=>'',
				"cantPromocion"=>1,
			);				
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
				$res[] = array(
				"RecNumber"=>$resultado['RecNumber'],
				"ALU"=>$resultado['ALU'],
				"DESC2"=>sanear_string(utf8_encode($resultado['DESC2'])),
				"DESC3"=>sanear_string(utf8_encode($resultado['DESC3'])),
				"DESC4"=>$resultado['DESC4'],
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
		}
	}else{ //Preventa
		$rsPreventa = odbc_exec( $conn, $sqlPreVenta );
		if (!$rsPreventa){
			exit( "Error en la consulta SQL" );
		}
		
		while($resultado = odbc_fetch_array($rsPreventa)){
			//CONSULTAR STOCK
			$sqlStock = "SELECT SUM(Cantidad) as Cantidad FROM RP_VICENCIO.dbo.LotesDisponibles WHERE ItemCode = '".$resultado['ALU']."' AND Bodega = '".$_SESSION["bodega"]."'";
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
				"DESC2"=>sanear_string(utf8_encode($resultado['DESC2'])),
				"DESC3"=>sanear_string(utf8_encode($resultado['DESC3'])),
				"DESC4"=>$resultado['DESC4'],
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