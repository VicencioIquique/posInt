<?php
require_once("../clases/conexionocdb.php");
$rut= $_POST['rut'];

$vectorEmp =   array (
					"nombres" => '',
					"apellidos" => '',
					"fono" => '',
					"email" => '',
					"ciudad" =>'Iquique',					
					);
//---------------------------------SISAP CLIENTES--------------------------------------------------
$sqlSisapClientes="SELECT TOP 1 [cliente_id]
      ,[rut]
      ,[nombres]
      ,[ApellidoPaterno]
      ,[fono1]
	  ,[email]
	  ,[direccion1]
	  ,UPPER(LEFT([direccion2],1))+LOWER(SUBSTRING([direccion2],2,LEN([direccion2]))) as direccion2 
  FROM [RP_VICENCIO].[dbo].[sisap_clientes]
  WHERE rut ='".$rut."'
  order by fechaIngreso desc";
		
$rs = odbc_exec( $conn, $sqlSisapClientes );
							
	if ( !$rs )
	{
	exit( "Error en la consulta SQL" );
	}
	 while($resultado = odbc_fetch_array($rs)){
		if ($resultado['rut']!= ''){
		$vectorEmp = array ( //Datos del empleado que se podrían utilizar
					"nombres" => $resultado['nombres'],
					"apellidos" => $resultado['ApellidoPaterno'],
					"fono" => $resultado['fono1'],
					"email" => $resultado['email'],
					"direccion" => $resultado['direccion1'],
					"ciudad" => $resultado['direccion2'],					
					);	 
		}		
	 }

//------------------------------------ENVIAR JSON-------------------------------------------------------------
	echo (json_encode($vectorEmp));								
	odbc_close( $conn );
?>