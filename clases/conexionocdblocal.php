<?php
// Se define la cadena de conexión
$dsn = "pruebalocal"; 
//$dsn = "prueba"; 
//$dsn2 = "dsnrhlocal";
//debe ser de sistema no de usuario
$usuario = "sa";
$clave="U4xyyBLk56";

//realizamos la conexion mediante odbc
$conn=odbc_connect($dsn, $usuario, $clave);
if (!$conn)
{
	exit( "Error al establecer la conexion: ".$conn);
}

/*$connrh=odbc_connect($dsn2, $usuario, $clave);
if (!$conn)
{
	exit( "Error al establecer la conexion: ".$conn);
}
*/
?>