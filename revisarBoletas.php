<?php
	session_start();
	require_once("clases/conexionocdb.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>LOGIN</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/jquery-ui.css" rel="stylesheet">
		<link href="css/jquery-ui.structure.css" rel="stylesheet">
		<link href="css/jquery-ui.theme.css" rel="stylesheet">
		<link href="css/vista.css" rel="stylesheet">
		<link href="css/select2.css" rel="stylesheet">
		
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/revisarBoletas.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		<!-- SCRIPT ESPECIAL PARA OBTENER ID PHP DESDE VENTANA MEDIOPAGO -->
		<script>
			<?php
				echo "var ID = '{$_POST['ID']}';";
				echo "var clienteRutP = '{$_POST['clienteRutP']}';";
				echo "var clienteNombreP = '{$_POST['clienteNombreP']}';";
				
				//Variables de sesión
				echo "var nombre = '{$_SESSION['nombre']}';";
				echo "var rol = '{$_SESSION['rol']}';";
				echo "var bodega = '{$_SESSION['bodega']}';";
				echo "var workstation = '{$_SESSION['workstation']}';";
				echo "var slpCode = '{$_SESSION['slpCode']}';";
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->
	</head>
	<body>
		<div class="contenedor">
			<!-- INICIO ROW ENCABEZADO -->
			<div class="row">
				<div class="col-lg-12 filtroRevisarBoleta">
					<form class="form-inline" action="#">
						<div class="form-group">
							<label class="control-label">Local</label>
							<select class="form-control localRevisarBoleta" id="local">
								<option value=""></option>
								<option value="008">2077</option>
								<option value="001">1010</option>
								<option value="002">1132</option>
								<option value="004">184</option>
								<option value="005">2002</option>
								<option value="006">6115</option>
								<option value="007">6130</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Caja</label>
							<select class="form-control localRevisarBoleta" id="caja">
								<option value=""></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label" for="exampleInputEmail1">Periodo </label>
							<input type="text" class="form-control" id="fecha" name="fecha">
						</div>
						<div class="form-group">
							<label class="control-label" for="exampleInputEmail1">Número de documento </label>
							<input type="text" class="form-control" id="numeroDocto" name="numeroDocto">
						</div>
						<button type="button" id="btnBuscar" class="btn btn-default pull-right">Buscar</button>
					</form>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-12">
					<div class="loaderBoletas">
						<center><img id="loading" src="img/loading.gif" height="150" width="150"/></center>
					</div>
				</div>
			</div>
			<!-- FIN ROW ENCABEZADO -->
			<!-- INICIO ROW TABLA DE PRODUCTOS -->
			<div class="row">
				<div class="col-lg-12 colTablaRevisarBoleta">
					<table id="tablaRevisarBoletas" class="table">
						<thead>
							<tr>
								<th>Local</th>
								<th>Caja</th>
								<th>Tipo documento</th>
								<th>Numero documento</th>
								<th>Fecha</th>
								<th>Tipo Pago</th>
								<th>Monto</th>
							</tr>
						</thead>
						<!--<tfoot>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td class="total">Total</td>
								<td class="total">0</td>
							</tr>
						</tfoot>--> <!-- DESHABILITADO PARA SEPARAR TOTAL EN INFO DEL LOCAL -->
						<tbody>
							<tr>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- FIN TABLA DE PRODUCTOS -->
			<!-- INICIO INFO DEL LOCAL Y TOTAL -->
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12">
					<button type="button" id="btnFormaPago" class="btn btn-success pull-left botonMedioPago" disabled>Forma de pago</button>
					<button type="button" id="btnDetalleVenta" class="btn btn-warning pull-left botonMedioPago" disabled>Detalle de venta</button>
					<form action="menu.php" method="post">
						<button id="menuGeneral" class="btn btn-default pull-right botonMedioPago">Menú General</button>
					</form>
					<button type="button" id="cerrarSesion" class="btn btn-danger pull-right botonMedioPago">Cerrar sesión</button>
				</div>
			</div>
			<!-- FIN MEDIOS DE PAGO -->
		</div>
	</body>
</html>