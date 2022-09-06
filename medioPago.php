<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
		<title>LOGIN</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/vista.css" rel="stylesheet">
		
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/datepicker.js"></script>
		<script src="js/medioPago.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		<script src="js/boletaG.js"></script>
		<script src="https://unpkg.com/transbank-pos-sdk-web@3/dist/pos.js"></script>
		<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.5.6/sweetalert2.min.css">
		<script src="https://cdn.jsdelivr.net/sweetalert2/6.5.6/sweetalert2.min.js"></script> -->
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
		// En este caso, el objeto en vez de ser POS, es Transbank.POS
		// Ej: Transbank.POS.connect(...); en vez de POS.connect(...) como se especifica en los ejemplos de mas abajo.
		</script>
		<script src="js/mpago/modalEfectivo.js"></script>
		<script src="js/mpago/modalCredito.js"></script>
		<script src="js/mpago/modalDebito.js"></script>
		<!-- <script src="js/mpago/modalPosIntegrado.js"></script> -->
		<script src="js/mpago/posIntegrado.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER ID PHP DESDE VENTANA PRINCIPAL -->
		<script>
			<?php
				echo "var ID = '{$_POST['ID']}';";
				echo "var totalMPago = '{$_POST['totalMPago']}';";
				echo "clienteRut = '{$_POST['clienteRut']}';";
				echo "clienteNombre = '{$_POST['clienteNombre']}';";
				echo "vendedorNumero = '{$_POST['vendedorNumero']}';";
				echo "vendedorNombre = '{$_POST['vendedorNombre']}';";
				
				//Valores de la tabla de productos
				echo "tablaCantPromos = '{$_POST['tablaCantPromos']}';";
				echo "tablaCantNoPromos = '{$_POST['tablaCantNoPromos']}';";
				echo "tablaItemTipo = '{$_POST['tablaItemTipo']}';";
				
				echo "tablaProdNum = '{$_POST['tablaProdNum']}';";
				echo "tablaProdALU = '{$_POST['tablaProdALU']}';";
				echo "tablaProdDesc = '{$_POST['tablaProdDesc']}';";
				echo "tablaProdMarca = '{$_POST['tablaProdMarca']}';";
				echo "tablaProdCantidad = '{$_POST['tablaProdCantidad']}';";
				echo "tablaProdDscto = '{$_POST['tablaProdDscto']}';";
				echo "tablaProdVOrig = '{$_POST['tablaProdVOrig']}';";
				echo "tablaProdVFinal = '{$_POST['tablaProdVFinal']}';";
				echo "tablaProdVendedor = '{$_POST['tablaProdVendedor']}';";
				echo "tablaProdIDPreventa = '{$_POST['tablaProdIDPreventa']}';";
				
				
				//Variables de sesión
				echo "var nombre = '{$_SESSION['nombre']}';";
				echo "var bodega = '{$_SESSION['bodega']}';";
				echo "var workstation = '{$_SESSION['workstation']}';";
				echo "var slpCode = '{$_SESSION['slpCode']}';";
				echo "var ipLocal = '{$_SESSION['ip']}';";
				
				//Valores boleta
				echo "var boletaTipoDocto = '{$_POST['boletaTipoDocto']}';";
				
				//Valores fecha y hora locales
				echo "var fechaVP = '{$_POST['fechaVP']}';";
				echo "var horaVP = '{$_POST['horaVP']}';";
				
				//Fecha inicio compra
				echo "var fechaInicio = '{$_POST['fechaInicio']}';";
				
				//Valores nota de crédito
				echo "var numeroDoctoNC = '{$_POST['numeroDoctoNC']}';";
				echo "var tipoDoctoNC = '{$_POST['tipoDoctoNC']}';";
				echo "var bodegaNC = '{$_POST['bodegaNC']}';";
				echo "var workstationNC = '{$_POST['workstationNC']}';";
				echo "var fechaDoctoRef = '{$_POST['fechaDoctoRef']}';";
				echo "var idNcRef = '{$_POST['idNcRef']}';";
				echo "var razonNC = '{$_POST['razonNC']}';";
				
				
				//Valor folio
				echo "var folioVPMedioPago = '{$_POST['folioVPMedioPago']}';";
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->
	</head>
	<body>
		<div class="contenedor">
			<!-- INICIO ROW TITULO Y BOTON ATRÁS -->
			<div class="row">
				<div class="col-lg-12">
					<center><h2>Seleccionar medio de pago </h2></center>
					<form action="vprincipal.php" method="post">
						<input type="text" id="hidden" value="" name="ID" hidden>
						<input type="text" id="clienteRutP" value="" name="clienteRutP" hidden>
						<input type="text" id="clienteNombreP" value="" name="clienteNombreP" hidden>
						<button id="mpVolver" class="btn btn-danger pull-right" style="margin-top:-44px;">Volver</button>
					</form>
				</div>
			</div>
			<!-- FIN ROW TITULO Y BOTON ATRÁS -->
			<!-- INICIO ROW MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12 colMediosPago">
					<center>
						<button id="mpEfectivo" class="btn btn-default btnMedioPago"><img src="img/iconos/efectivo.png"/><br><label>Efectivo(F1)</label></button>
						<button id="mpCredito" class="btn btn-default btnMedioPago"><img src="img/iconos/credito.png"/><br><label>Crédito(F2)</label></button>
						<button id="mpDebito" class="btn btn-default btnMedioPago"><img src="img/iconos/redcompra.png"/><br><label>RedCompra(F3)</label></button>						
						<button id="mpCheque" class="btn btn-default btnMedioPago"><img src="img/iconos/cheque.png"/><br><label>Cheque(F4)</label></button>
						<button id="posIntegrado" class="btn btn-default btnMedioPago"><img src="img/iconos/credito.png"/><br><label>POS integrado(F5)</label></button>
						<button style="display: none;" id="posiDebito" class="btn btn-default btnMedioPago"><img src="img/iconos/redcompra.png"/><br><label>POS INT. RedCompra(F6)</label></button>
						<button  id="mpCreditoTienda" class="btn btn-default btnMedioPago"><img src="img/iconos/creditotienda.png"/><br><label>Crédito tienda(F5)</label></button>
						<button  id="mpListaCheques" class="btn btn-default btnMedioPago"><img src="img/iconos/cheque.png"/><br><label>Ver lista cheques(F6)</label></button>
					</center>
				</div>
			</div>
			<!-- FIN ROW MEDIOS DE PAGO -->
			<hr> <!-- LINEA HORIZONTAL -->
			<!-- INICIO ROW TOTAL - MONTO RESTANTE -->
			<div class="row mediosPagoRealizados">
				<div class="col-lg-offset-4 col-lg-4">
					<table id="tablaMediosPago" class="table">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Medio de pago</th>
								<th>Total</th>
								<th></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td></td>
								<td class="total"><strong>Vuelto</strong></td>
								<td class="total">0</td>
							</tr>
						</tfoot> <!-- DESHABILITADO PARA SEPARAR TOTAL EN INFO DEL LOCAL -->
						<tbody>
							<tr>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="loader">
						<center><img id="loading" src="img/loading.gif" height="150" width="150"/></center>
					</div>
				</div>
			</div>
			<div class="row total_montoPorPagar">
				<div class="col-lg-offset-4 col-lg-4">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">TOTAL</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="total" name="total" placeholder="" disabled>
							</div>
						</div>
						<div class="form-group montoPorPagar">
							<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Monto por pagar</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="montoPorPagar" name="montoPorPagar" placeholder="" disabled>
							</div>
						</div>
					</form>
					<center>
						<button id="imprimirBoleta" class="btn btn-default medioPagoImprimir"><img src="img/iconos/imprimir.png"/><br><label>Generar boleta(F11)</label></button>
					</center>
				</div>
			</div>
			<!-- FIN TOTAL  - MONTO RESTANTE -->
	
			<?php
				include ("mpagoui/efectivoModal.php");
				include ("mpagoui/creditoModal.php");
				include ("mpagoui/debitoModal.php");
			?>
		</div>
	</body>
</html>