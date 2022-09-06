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
		<script src="js/datepicker.js"></script>
		<script src="js/mpago/notaCredito.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER MONTO POR PAGAR DESDE VENTANA PADRE -->
		<script>
			<?php
				
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->
		
	</head>
	<body>
		<div class="contenedor">
			<!-- INICIO ROW ENCABEZADO -->
			<div class="row">
				<center><h2>Ingrese los datos de la boleta que desea anular</h2></center>
			</div>
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-sm-offset-1 col-sm-10">
					<!--<form class="form-horizontal">-->
						<div class="form-group">
							<label class="label-control">Modulo</label>
							<select id="bodega" class="form-control">
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
							<label class="label-control">Caja</label>
							<select id="workstation" class="form-control">
								<option value=""></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="5">5</option>
								<option value="8">8</option>
							</select>
						</div>
						<div class="form-group">
							<label class="label-control">Tipo de documento</label>
							<select id="tipoDocto" name="tipoDocto" class="form-control">
								<option value=""></option>
								<option selected= "selected" value="1">Boleta fiscal</option>
								<option value="4">Boleta Manual</option>
							</select>
						</div>
						<div class="form-group">
							<label class="label-control">Número de boleta</label>
							<input type="text" id="numeroDocto" name="numeroDocto" class="form-control"/>
						</div>
						<div class="form-group">
							<label class="label-control">Razón de Nota de Credito</label>
							<select id="cmbNcRazon" name="cmbNcRazon" class="form-control">
								<option value="Problema de fijacion">Problema de fijacion</option>
								<option value="Producto dañado">Producto Dañado</option>
								<option selected ="Selected" value="Error en generacion de boleta">Error en generación de boleta o pago</option>
								<option value="Error de Cliente">Error de Cliente</option>
								<option value="Otras">Otras</option>
							</select>
							<input style ='margin-top:6px;' type="text" id="txtNcRazon" name="txtNcRazon" class="form-control" placeholder ="Describa la razon de la nota de credito ..."/>								
						</div>
					<br>
					<center>
						<button type="button" id="aceptar" class="btn btn-default">Aceptar</button>
						<button type="button" id="cancelar" class="btn btn-default">Cancelar</button>
					</center>
				</div>
			</div>
			<!-- FIN MEDIOS DE PAGO -->
		</div>
	</body>
</html>