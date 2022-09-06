<?php
require_once("../clases/conexionocdb.php");
$rut= $_POST['rut'];
$vectorEmp =   array (
					"nombres" => '',
					"apellidoPaterno" => '',
					"apellidoMaterno" => '',
					"Direccion"=>'',
					"email" => '',
					"ciudad" =>'Iquique',
					"ano"=>'1900',
					"mes"=>'01',
					"dia"=>'01',
					"comuna"=>'Iquique',
					"fono" =>'',
					"email" =>'',
					"sexo" =>'',			
					"nacionalidad" =>'');
//---------------------------------SISAP CLIENTES--------------------------------------------------
$sqlClientes="SELECT Rut,Nombres,Apellido_Paterno,Apellido_Materno,Direccion,Ciudad,YEAR(Fecha_Nacimiento)Ano,MONTH(Fecha_Nacimiento)Mes,DAY(Fecha_Nacimiento)Dia,Fecha_Ingreso,Comuna,Fono,Email,Sexo,Nacionalidad
 FROM [RP_VICENCIO].[dbo].[Clientes] WHERE rut ='".$rut."'";
		
$rs = odbc_exec( $conn, $sqlClientes);
							
	if (!$rs)
	{
		exit( "Error en la consulta SQL" );
	}
	 while($resultado = odbc_fetch_array($rs)){
		if ($resultado['Rut']!= ''){
		$vectorEmp = array ( //Datos del empleado que se podrían utilizar
					"nombres" => $resultado['Nombres'],
					"apellidoPaterno" => $resultado['Apellido_Paterno'],
					"apellidoMaterno" => $resultado['Apellido_Materno'],
					"direccion" => $resultado['Direccion'],
					"fono" => $resultado['Fono'],
					"ano" => $resultado['Ano'],
					"mes" => $resultado['Mes'],
					"dia" => $resultado['Dia'],
					"email" => $resultado['Email'],
					"ciudad" => $resultado['Ciudad'],					
					"comuna" => $resultado['Comuna'],
					"sexo" => $resultado['Sexo'],
					"nacionalidad"=>$resultado['Nacionalidad']
					);	 
		}		
	 }

//------------------------------------ENVIAR JSON-------------------------------------------------------------
	echo (json_encode($vectorEmp));								
	odbc_close( $conn );
?>