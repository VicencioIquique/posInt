<?php
	$prueba = $_POST['ID'];
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
		<script src="js/datepicker.js"></script>
		<script src="js/mpago/mp_RedCompra.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER MONTO POR PAGAR DESDE VENTANA PADRE -->
		<script>
			<?php
				echo "var montoPorPagar = '{$_POST['montoPorPagar']}';";
				echo "var folio = '{$_POST['folio']}';";
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->
		
	</head>
	<body>
		<div class="contenedor">
			<!-- INICIO ROW ENCABEZADO -->
			<div class="row">
				<center><h2>Medio de pago - Red Compra</h2></center>
			</div>
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12">
					<div class="col-sm-offset-4 col-sm-4 mpRedCompraMargenSup">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Número de Tarjeta</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpRedCompra_numeroTarjeta" name="mpRedCompra_numeroTarjeta" placeholder="Últimos 4 números de la tarjeta">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Cod.Autorización</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpRedCompra_codAutorizacion" name="mpRedCompra_codAutorizacion" placeholder="">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Monto</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpRedCompra_monto" name="mpRedCompra_monto" placeholder="">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Folio Actual</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpRedCompra_folioActual" name="mpRedCompra_folioActual" placeholder="" disabled="true">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Total</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpRedCompra_total" name="mpRedCompra_Total" placeholder="" disabled="true">
								</div>
							</div>
						</form>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 mpBotonesAceCan">
				<center>
					<button id="mpRedCompra_aceptar" class="btn btn-default"disabled>
					<span class="glyphicon glyphicon-ok color_iconoAceptar"></span>
					<label>Aceptar(F2)</label><br></button>		   
					<button id="mpRedCompra_cancelar" class="btn btn-default">
					<span class="glyphicon glyphicon-remove color_iconoCancelar"></span>
					<label>Cancelar(F3)</label><br></button>
				</center>
			   </div>
			</div>
		</div>	
	</body>
</html>