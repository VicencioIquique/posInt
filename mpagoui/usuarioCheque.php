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
		<link href="css/bootstrap.validation.min.css" rel="stylesheet">
		<link href="css/vista.css" rel="stylesheet">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap.validation.min.js"></script>
		<script src="js/mpago/regUsuarioCheque.js"></script>
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
				<center><h2>Registro de usuario</h2></center>
			</div>
			<hr>
			<!-- FIN INO DEL LOCAL Y TOTAL -->
			<!-- INICIO MEDIOS DE PAGO -->
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-offset-4 col-lg-4">
						<form id="formUsuario" commandName="patient" class="form-horizontal">
							<div class="form-group regUsuario_RUT">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">RUT</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_RUT" name="regUsuario_RUT" placeholder="Ej: 12345678-K">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Nombre completo</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_nombre" name="regUsuario_nombre" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Dirección</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_direccion" name="regUsuario_direccion" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Ciudad</label>
								<div class="col-sm-8">
									<select id="regUsuario_ciudad" class="form-control">
										<option value=""></option>
										<option value="Arica">Arica</option>
										<option value="Iquique">Iquique</option>
										<option value="Tocopilla">Tocopilla</option>
										<option value="Antofagasta">Antofagasta</option>
										<option value="Calama">Calama</option>
										<option value="Copiapo">Copiapo</option>
										<option value="Chanaral">Chanaral</option>
										<option value="El Salvador">El Salvador</option>
										<option value="Vallenar">Vallenar</option>
										<option value="Coquimbo">Coquimbo</option>
										<option value="La Serena">La Serena</option>
										<option value="Valparaiso">Valparaiso</option>
										<option value="Vina del mar">Vina del mar</option>
										<option value="Santiago">Santiago</option>
										<option value="Curico">Curico</option>
										<option value="Talca">Talca</option>
										<option value="Chillan">Chillan</option>
										<option value="Valdivia">Valdivia</option>
										<option value="Coihaique">Coihaique</option>
										<option value="Puerto Montt">Puerto Montt</option>
										<option value="Puerto Aisen">Puerto Aisen</option>
										<option value="Puerto Arenas">Punta Arenas</option>
										<option value="Puerto Natales">Puerto Natales</option>
										<option value="Puerto Varas">Puerto Varas</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Teléfono</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_telefono" name="regUsuario_telefono" placeholder="912345678">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Correo electrónico</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_correo" name="regUsuario_correo" placeholder="alguien@ejemplo.cl">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Empresa</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_empresa" name="regUsuario_empresa" placeholder="" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4 etiquetaFormulario" for="exampleInputEmail1">Convenio</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="regUsuario_convenio" name="regUsuario_convenio" placeholder="" disabled>
								</div>
							</div>
							<div class="form-group">
								<center>
									<button id="regUsuario_aceptar" class="btn btn-default regUsuario_aceptar">Aceptar<br>F2</button>
									<button type="button" id="regUsuario_cancelar" class="btn btn-default regUsuario_cancelar">Cancelar<br>F3</button>
								</center>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- FIN MEDIOS DE PAGO -->
		</div>
	</body>
</html>