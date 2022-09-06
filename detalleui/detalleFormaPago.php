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
		<script src="js/detalle/detalleFormaPago.js"></script>
		<script src="js/jQuery.print.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER MONTO POR PAGAR DESDE VENTANA PADRE -->
		<script>
			
			<?php	
					echo "var bodega ='{$_POST['jsonDetalleFormaPago']['bodega']}';";
					echo "var workstation ='{$_POST['jsonDetalleFormaPago']['workstation']}';";
					echo "var tipoDocto ='{$_POST['jsonDetalleFormaPago']['tipoDocto']}';";
					echo "var numeroDocto ='{$_POST['jsonDetalleFormaPago']['numeroDocto']}';";
					
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->	
	</head>
	<body>
		<div class="contenedor">
			<div class="row"> <!-- Fila Titulo-->
	
				<div class="col-lg-12">
					<center><h2>Detalle de Forma de pago</h2></center>
				</div>
			</div>
			<hr>
			<div class="row"> <!-- Lista de Cheques-->
				<div class="col-lg-12 col-sm-12">
					<table id="tablaDetFormaPago" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Tipo documento</th>
								<th>Numero documento</th>	
								<th>Tipo pago</th>
								<th>Cuotas</th>
								<th>Fecha documento</th>
								<th>Monto</th>
								<th>Número tarjeta</th>
								<th>Código autorización</th>
							</tr>
						</thead>
						<tbody>
							<tr></tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<center>
					<button id="btnCerrar" class="btn btn-default">Cerrar</button>
				</center>
			<div>
		</div>			
	</body>
</html>