<?php
	$prueba = $_POST['ID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Consulta de stock global</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/vista.css" rel="stylesheet">
		
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/detalle/consultaStock.js"></script>
	</head>
	<body>
		<div class="contenedor">
			<div class="row"> <!-- Fila Titulo-->
	
				<div class="col-lg-12">
					<center><h2>Consulta de stock global</h2></center>
				</div>
			</div>
			<hr>
			<div class="row"> <!-- Lista de Cheques-->
				<div class="col-lg-12 col-sm-12">
					<label>Código de producto</label>
					<input type="text" class="form-control" id="codigoConsultaStock"/>
					<br>
					<table id="tablaConStock" class="table table-striped">
						<thead>
							<tr>
								<th># Art</th>
								<th>ALU</th>
								<th>Descripcion</th>	
								<th>Marca</th>	
								<th>Local</th>
								<th>Stock</th>
							</tr>
						</thead>
						<tbody>
							<tr></tr>
						</tbody>
						<tfoot>
							<tr></tr>
						</tfoot>
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