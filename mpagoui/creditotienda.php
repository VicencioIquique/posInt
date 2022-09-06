<?php
	$prueba = $_POST['ID'];
	echo $prueba;
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
		<script src="js/mpago/mp_CreditoTienda.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER MONTO POR PAGAR DESDE VENTANA PADRE -->
		<script>
			<?php
				echo "var montoPorPagar = '{$_POST['montoPorPagar']}';";
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->
		
	</head>
	<body>
		<div class="contenedor">
			<!-- INICIO ROW ENCABEZADO -->
			<div class="row">
				<center><h2>Medio de pago - Crédito tienda</h2></center>
			</div>
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-offset-4 col-lg-4">
						<form class="form-horizontal">
							<div class="form-group mpCreditoTienda_totalV">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">TOTAL</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCreditoTienda_total" name="mpCreditoTienda_total" placeholder="" disabled>
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Monto</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCreditoTienda_monto" name="mpCreditoTienda_monto" placeholder="">
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Diferencia</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mpCreditoTienda_diferencia" name="mpCreditoTienda_diferencia" placeholder="" disabled>
								</div>
							</div>
						</form>
						<center>
							<button id="mpCreditoTienda_aceptar" class="btn btn-default mpCreditoTienda_aceptar"disabled >
								<span class="glyphicon glyphicon-ok color_iconoAceptar" ></span>
								Aceptar (F2)
							</button>
							<button id="mpCreditoTienda_cancelar" class="btn btn-default mpCreditoTienda_cancelar">
								<span class="glyphicon glyphicon-remove color_iconoCancelar"></span>
								Cancelar (F3)</button>
						</center>
					</div>
				</div>
			</div>
			<!-- FIN MEDIOS DE PAGO -->
		</div>
	</body>
</html>