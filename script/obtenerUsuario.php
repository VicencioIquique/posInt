<?php     
	session_start();
	require_once("../clases/conexionocdb.php");
	$usuario=$_POST['usuario'];
	$pass=$_POST['pass'];
	
	$consultaUsuario="SELECT [usuario_nombre],
							SlpCode,
							usuario_rol
					  FROM [RP_VICENCIO].[dbo].[sisap_usuarios]
					  WHERE usuario_user ='".$usuario."'and usuario_pass ='".$pass."'";
	
	$rsUsuario = odbc_exec( $conn, $consultaUsuario );
	if (!$rsUsuario){
		exit( "Error en la consulta SQL Usuario" );
	}
	
	$resultado = odbc_fetch_array($rsUsuario);
	//echo $resultado;

	if($resultado['usuario_nombre']==''){
		echo 0;
	}else{
		
		$_SESSION["nombreCajero"]=utf8_encode($resultado['usuario_nombre']);
		$_SESSION['slpCode']=$resultado['SlpCode'];
		$_SESSION["ip"] = getHostByName(php_uname('n'));
		$_SESSION["rol"] = $resultado['usuario_rol'];
		//Consulta de datos del equipo (bodega y workstation) según su IP
		$sqlIpBodegaWorkstation="SELECT ip, bodega, workstation FROM RP_VICENCIO.dbo.RP_IP_BODEGAS WHERE ip = '".$_SESSION["ip"]."'";
		$rsIpBodegaWorkstation = odbc_exec( $conn, $sqlIpBodegaWorkstation );
		if ( !$rsIpBodegaWorkstation ){
			exit( "Error en la consulta SQL IP" );
		}
		$resultadoIpBodegaWorkstation = odbc_fetch_array($rsIpBodegaWorkstation);
		
		$_SESSION["bodega"]=$resultadoIpBodegaWorkstation['bodega'];
		$_SESSION["workstation"]=$resultadoIpBodegaWorkstation['workstation'];
		
		/*$_SESSION['ipRegistrada'] = $resultadoIpBodegaWorkstation['ip']; //Variable sesión para poder mantener la IP
		if($_SESSION['ipRegistrada'] == null){
			session_destroy();
			echo "<script>location.href='index.php';</script>";
		}*/
		echo $sqlIpBodegaWorkstation;
		// echo 1;
	}
	
	
?>