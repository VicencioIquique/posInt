<?php
	$prueba = $_POST['ID'];
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
		
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/mpago/mp_Cheque.js"></script>
		<script src="js/funcionesGenerales.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER MONTO POR PAGAR DESDE VENTANA PADRE -->
		<script>
			<?php
				echo "var montoPorPagar = '{$_POST['montoPorPagar']}';";
				echo "var clienteRut = '{$_POST['clienteRut']}';";
				echo "var clienteNombre = '{$_POST['clienteNombre']}';";
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->	
	</head>
	<body>
		<div class="contenedor">
			<div class="row">
				<div class="col-lg-12">
					<center><h2>Medio de pago - Cheque</h2></center>
				</div>
			</div>
			<hr>
			<!-- Fila  de Cliente y Banco-->   
			<div class="row">
				<!-- Columna de Cliente--> 
				<div class="col-lg-4 col-sm-4">
				 	<div class="panel panel-default">
				      	<div class="panel-heading"><span class="glyphicon glyphicon-user"></span>&nbsp;Cliente</div>
				      	<div class="panel-body">
				      		<form class="form-horizontal">
								<div class="col-lg-10"> <!-- Columna Nombre y Rut-->
									<div class="form-group">
										<label class="control-label col-sm-4 etiquetaFormulario">Rut</label>
										<div class="col-sm-8">
											<input id="rutCliente" class="form-control rutCliente" name="rutCliente" placeholder="" type="text">
											<input type="button" id="mpCheque_agregarCliente" class="btnAgregarUsuario btn btn-default" value="+">
											<!--<button id="mpCheque_agregarCliente" class="btn btn-default btnAgregarUsuario"><span class="glyphicon glyphicon-plus"></span></button>-->
										</div>
									</div>
									<div class="form-group mpCheque_margintop">
										
										<label class="control-label col-sm-4 col-lg-4 etiquetaFormulario">Nombre</label>
										<div class="col-sm-8 col-lg-8">
											<input id="nombreCliente" class="form-control" name="nombreCliente" placeholder="" disabled="" type="text">
										</div>
									</div>							
								</div>
							</form>
							<div class="col-lg-2"> <!-- Columna Boton AGREGAR--> 
							</div>
				      	</div>
			    	</div>
				</div>
				<!-- FIN Columna de Cliente-->
				<!-- Columna BANCO-->
				<div class="col-lg-8 col-sm-8">
					<div class="panel panel-default">
						<div class="panel-heading">Banco</div>
						<div class="panel-body">
							<div class="col-lg-6">
								<form class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-6 col-lg-6 etiquetaFormulario">Nombre</label>
										<div class="col-sm-6 col-lg-6">
											<select id="mpCheque_nombreBanco" name="mpCheque_nombreBanco" class="form-control">
												<option value=""></option>
											</select>
										</div>	
									</div>
									<div class="form-group">
										<label class="control-label col-sm-6 col-lg-6 etiquetaFormulario">Num. Cta Corriente</label>
										<div class="col-sm-6 col-lg-6">
											<input id="mpCheque_cuentaCorriente" class="form-control" name="nombreBanco" placeholder="" type="text">
										</div>	
									</div>
								</form>
							</div>
							<div class="col-lg-6 col-sm-6">
								<form class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-6 col-lg-6 etiquetaFormulario">Localidad (Ciudad)</label>
									    <div class="col-sm-6 col-lg-6">
											<select id="mpCheque_localidad" name="mpCheque_localidad" class="form-control">
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
								</form>
							</div>
							
						</div>
					</div>
					
				</div>
				<!-- FIN Columna BANCO-->                 
			</div>
			<!-- FIN fila de Clientes y banco-->
			<div class="row">  <!-- INICIO Fila cheques lista de cheques-->
				<!-- Columna de Cheque y validar/Finalizar--> 
				<div class="col-lg-4 col-sm-4">
				 	<div class="panel panel-default">
				      	<div class="panel-heading">Cheques</div>
				      	<div class="panel-body">
				      		<form class="form-horizontal">
								<div class="form-group">
									<label class="control-label col-sm-4 etiquetaFormulario">Cant Cheques</label>
									<div class="col-sm-8">
										<input id="mpCheque_cantCheques" class="form-control" name="cantCheques" placeholder="" type="text">
									</div>
								</div>
								<div class="form-group mpCheque_margintop">
									<label class="control-label col-sm-4 col-lg-4 etiquetaFormulario">Número de cheque Inicial</label>
									<div class="col-sm-8 col-lg-8">
										<input id="mpCheque_numeroCheques" class="form-control" name="numeroCheques" placeholder="" type="text">
									</div>
								</div>
								<div class="form-group mpCheque_margintop">
									<label class="control-label col-sm-4 col-lg-4 etiquetaFormulario">Fecha Cheque</label>
									<div class="col-sm-8 col-lg-8">
										<input id="mpCheque_fecha" class="form-control" name="fecha" placeholder="" type="text">
									</div>
								</div>
								<div class="form-group mpCheque_margintop">
									<label class="control-label col-sm-4 col-lg-4 etiquetaFormulario">Monto</label>
									<div class="col-sm-8 col-lg-8">
										<input id="mpCheque_monto" class="form-control" name="monto" placeholder="" type="text">
									</div>
								</div>
							</form>
							<div>
								<div class="col-lg-4">								
									<button id="mpCheque_agregarCheque" class="btn btn-default">
										<span class="glyphicon glyphicon-plus color_iconoAceptar"></span> <label>Agregar Cheques</label>
									</button>								
								</div>
								<div class="col-lg-offset-3 col-lg-5">								
									<button id="mpCheque_limpiar" class="btn btn-default">
										<span class="glyphicon glyphicon-trash color_iconoCancelar"></span> <label>Limpiar</label>
									</button>								
								</div>
							</div>
				      	</div>
			    	</div>
				</div>
				<!-- FIN Columna de Cheque y validar / finalizar-->
				<!-- Columna Lista Cheque-->
				<div class="col-lg-8 col-sm-8"> <!--Lista Cheques-->
					<div class="panel panel-default">
						<div class="panel-heading">Lista de Cheques</div>
						 <table id="tablaCheques" class="table">
							<thead>
							  <tr>
								<th>#</th>	
								<th>Codigo Banco</th>
								<th style="vertical-align:top">Localidad</th>
								<th>Cuenta Corriente</th>
								<th>N° Cheque</th>
								<th>Fecha Cheque</th>
								<th>Monto Cheque</th>
								<th>Cod. Autorización</th>
								<th></th>
							  </tr>
							</thead>
							<tbody>
							</tbody>
						  </table>
					</div>
				</div>
				<!-- FIN Lista de Cheque-->				
			</div>
			<div class="row">  <!-- INICIO Fila  validar /finalizar y Total-->
				<div class="col-lg-4 col-sm-4"><!-- INICIO Columna  validar /finalizar-->
					<div class="panel panel-default">
						<div class="panel-heading">Validar / Finalizar</div>
						<div class="panel-body">
							<div>
								<center>
									<button id="mpCheque_validarAutorizacion" class="btn btn-default" disabled="">
									 <span class="glyphicon glyphicon-ok color_iconoAceptar"></span> <label>Validar Autorización</label>
									</button>
								</center>
							</div>
							<div>
								<center>
									<button id="mpCheque_finalizar" class="btn btn-default mpCheque_margentop">
									<span class="glyphicon glyphicon-floppy-saved"></span>
									<label>Guardar (F2)</label>
									</button>
									<button id="mpCheque_cancelar" class="btn btn-default mpCheque_boton">
									<span class="glyphicon glyphicon-remove color_iconoCancelar"></span>
									<label>Cancelar (F3)</label></button>
								</center>
							</div>			
						</div>
					</div>
				</div>
				
				<div class="col-lg-offset-4 col-lg-4 col-sm-4"><!-- INICIO Columna Total-->
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4 etiquetaFormulario">Total Cheque</label>
							<div class="col-sm-8">
								<input id="mpCheque_totalCheque" class="form-control" name="rutCliente" disabled="" placeholder="" type="text">
							</div>
						</div>
						<div class="form-group mpCheque_margintop">								
							<label class="control-label col-sm-4 col-lg-4 etiquetaFormulario">Total</label>
							<div class="col-sm-8 col-lg-8">
								<input id="mpCheque_total" class="form-control" name="nombreCliente" placeholder="" disabled="" type="text">
							</div>
						</div>							
					</form>
				</div>				
			</div>
			<!-- FIN Fila  validar /finalizar y Total-->
		</div>			
	</body>
</html>