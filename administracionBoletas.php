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
		<script src="js/vprincipal_admin.js"></script>
		<script src="js/vprincipal_tabla_admin.js"></script>
		<script src="js/select2.js"></script>
		<script src="js/popover.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		<!-- SCRIPT ESPECIAL PARA OBTENER ID PHP DESDE VENTANA MEDIOPAGO -->
		<script>
			<?php
				echo "var ID = '{$_POST['ID']}';";
				echo "var clienteRutP = '{$_POST['clienteRutP']}';";
				echo "var clienteNombreP = '{$_POST['clienteNombreP']}';";
				
				//Variables de sesión
				echo "var nombre = '{$_SESSION['nombre']}';";
				echo "var slpCode = '{$_SESSION['slpCode']}';";
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->
	</head>
	<body>
		<div class="contenedor">
			<!-- INICIO ROW ENCABEZADO -->
			<div class="row">
				<div class="col-lg-3 encabezado">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">RUT </label>
							<div class="col-sm-9">
								<input type="text" class="form-control vpRut" id="vpRut" name="vpRut" placeholder="">
								<input type="button" id="agregarUsuario" class="btnAgregarUsuario btn btn-default" value="+">
							</div>
						</div>
						<div class="form-group margenEncabezado">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">Nombre </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vpNombre" name="vpNombre" placeholder="">
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-offset-1 col-lg-5 encabezado">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">Tipo docto.</label>
							<div class="col-sm-9">
								<select id="tipoDocto" name="tipoDocto" class="form-control">
									<option value="1">Boleta fiscal</option>
									<option value="3">Nota de crédito</option>
									<option value="4">Boleta Manual</option>
								</select>
							</div>
						</div>
						<div class="form-group margenEncabezado">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">Vendedor </label>
							<div class="col-sm-9">
								<select class="form-control" id="vendedor" name="vendedor">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="form-group margenEncabezado">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">Cajero </label>
							<div class="col-sm-9">
								<select class="form-control" id="cajero" name="cajero">
									<option value=""></option>
								</select>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-3 encabezado">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2 etiquetaFormulario" for="exampleInputEmail1">Fecha </label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fecha" name="fecha">
							</div>
						</div>
						<div class="form-group margenEncabezado">
							<label class="control-label col-sm-2 etiquetaFormulario" for="exampleInputEmail1">Hora </label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="hora" name="hora" disabled>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- FIN ROW ENCABEZADO -->
			<!-- INICIO ROW TABLA DE PRODUCTOS -->
			<div class="row">
				<div class="col-lg-3">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Código Preventa / Código Producto </label>
						<input type="text" class="form-control" id="codigo" name="codigo">
					</div>
				</div>
				<div class="col-lg-12 colTabla">
					<table id="tabla" class="table tablaProductos">
						<thead>
							<tr>
								<th>N° Artículo</th>
								<th>ALU</th>
								<th>Descripción</th>
								<th>Marca</th>
								<th>Cantidad</th>
								<th>Descuento ($)</th>
								<th>Descuento (%)</th>
								<th>Valor original</th>
								<th>Valor final</th>
								<th>Vendedor</th>
								<th></th>
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
			<div class="row">
				<div class="col-lg-4">
					<form class="form-horizontal">
						<div class="form-group margenInfoLocal">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">Caja</label>
							<div class="col-sm-9">
								<select class="form-control" id="caja" name="caja">
									<option value=""></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3 (2077)</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="8">8</option>
								</select>
							</div>
						</div>
						<div class="form-group margenInfoLocal">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">Local</label>
							<div class="col-sm-9">
								<select class="form-control" id="local" name="local">
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
						</div>
						<div class="form-group margenInfoLocal">
							<label class="control-label col-sm-3 etiquetaFormulario" for="exampleInputEmail1">N° Items</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="numItems" value="0" name="numItems" disabled>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-4">
					<form class="form-horizontal">
						<div class="form-group margenInfoLocalCantTotal">
							<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Folio</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="folioVP" name="folioVP">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Total cantidad</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="totalItems" value="0" name="totalItems" disabled>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-offset-1 col-lg-3">
					<form class="form-horizontal margenInfoLocal">
						<div class="form-group">
							<label class="control-label col-sm-2 etiquetaFormulario" for="exampleInputEmail1">TOTAL</label>
							<div class="col-sm-10">
								<input type="text" class="form-control totalPrincipal" id="total" name="total" disabled>
							</div>
						</div>
					</form>
				</div>
			</div>
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12">
					<form action="medioPago_admin.php" method="post">
						<button id="medioPago" class="btn btn-default pull-right botonMedioPago">Medio de pago</button>
						<input type="text" id="ID" name="ID" value="" hidden>
						<input type="text" id="totalMPago" name="totalMPago" value="" hidden>
						<!--VALORES CLIENTE-->
						<input type="text" id="clienteRut" name="clienteRut" value="" hidden>
						<input type="text" id="clienteNombre" name="clienteNombre" value="" hidden>
						<!--VALORES VENDEDOR-->
						<input type="text" id="vendedorNumero" name="vendedorNumero" value="" hidden>
						<input type="text" id="vendedorNombre" name="vendedorNombre" value="" hidden>
						<!--VALORES CAJERO-->
						<input type="text" id="cajeroNumero" name="cajeroNumero" value="" hidden>
						<input type="text" id="cajeroNombre" name="cajeroNombre" value="" hidden>
						<!--VALORES CAJA-->
						<input type="text" id="workstation" name="workstation" value="" hidden>
						<input type="text" id="bodega" name="bodega" value="" hidden>
						<!--VALORES PRODUCTOS-->
						<input type="text" id="tablaProdNum" name="tablaProdNum" value="" hidden>
						<input type="text" id="tablaProdALU" name="tablaProdALU" value="" hidden>
						<input type="text" id="tablaProdDesc" name="tablaProdDesc" value="" hidden>
						<input type="text" id="tablaProdMarca" name="tablaProdMarca" value="" hidden>
						<input type="text" id="tablaProdCantidad" name="tablaProdCantidad" value="" hidden>
						<input type="text" id="tablaProdDscto" name="tablaProdDscto" value="" hidden>
						<input type="text" id="tablaProdVOrig" name="tablaProdVOrig" value="" hidden>
						<input type="text" id="tablaProdVFinal" name="tablaProdVFinal" value="" hidden>
						<input type="text" id="tablaProdVendedor" name="tablaProdVendedor" value="" hidden>
						<input type="text" id="tablaProdIDPreventa" name="tablaProdIDPreventa" value="" hidden>
						<!--VALORES BOLETA-->
						<input type="text" id="boletaTipoDocto" name="boletaTipoDocto" value="" hidden>
						<!--VALORES FECHA Y HORA-->
						<input type="text" id="fechaVP" name="fechaVP" value="" hidden>
						<input type="text" id="horaVP" name="horaVP" value="" hidden>
						<!--VALORES PARA NOTA DE CREDITO-->
						<input type="text" id="numeroDoctoNC" name="numeroDoctoNC" value="" hidden>
						<input type="text" id="bodegaNC" name="bodegaNC" value="" hidden>
						<input type="text" id="workstationNC" name="workstationNC" value="" hidden>
						<input type="text" id="tipoDoctoNC" name="tipoDoctoNC" value="" hidden>
						<input type="text" id="fechaDoctoRef" name="fechaDoctoRef" value="" hidden>
						<!--VALOR FOLIO PARA MEDIOS DE PAGO 2,3 y 4-->
						<input type="text" id="folioVPMedioPago" name="folioVPMedioPago" value="" hidden>
					</form>
					<button id="valorDolar" class="btn btn-default pull-right botonMedioPago">Valor dolar</button>
					<form action="menu.php" method="post">
						<button id="menuGeneral" class="btn btn-default pull-right botonMedioPago">Menú General</button>
					</form>
					<button type="button" id="cerrarSesion" class="btn btn-danger pull-right botonMedioPago">Cerrar sesión</button>
				</div>
			</div>
			<!-- FIN MEDIOS DE PAGO -->
		</div>
		
		<!-- CONTENIDO DE POPOVERS-->
		<div id="formCambioPrecio" class="hide">
			<!--<form id="popForm">-->
				<div>
					<label for="email">Nuevo valor:</label>
					<input type="text" name="precio" id="precio" class="form-control">
				</div>
			<!--</form>-->
			<button style="margin-top:10px;" type="button" class="btn btn-default btnCambioPrecio">Aceptar</button>
			<button style="margin-top:10px;" type="button" class="btn btn-danger btnCambioPrecioCancelar">Cancelar</button>
		</div>
		
		<div id="formCambioPrecioFinal" class="hide">
			<!--<form id="popForm">-->
				<div>
					<label for="email">Nuevo valor:</label>
					<input type="text" name="precioFinal" id="precioFinal" class="form-control">
				</div>
			<!--</form>-->
			<button style="margin-top:10px;" type="button" class="btn btn-default btnCambioPrecioFinal">Aceptar</button>
			<button style="margin-top:10px;" type="button" class="btn btn-danger btnCambioPrecioFinalCancelar">Cancelar</button>
		</div>
		
		<div id="formCambioCantidad" class="hide">
			<!--<form id="popForm">-->
				<div>
					<label for="email">Cantidad:</label>
					<input type="text" name="cambioCantidad" id="cambioCantidad" class="form-control">
				</div>
			<!--</form>-->
			<button style="margin-top:10px;" type="button" class="btn btn-default btnCambioCantidad">Aceptar</button>
			<button style="margin-top:10px;" type="button" class="btn btn-danger btnCambioCantidadCancelar">Cancelar</button>
		</div>
	</body>
</html>