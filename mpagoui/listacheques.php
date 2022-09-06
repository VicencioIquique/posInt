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
		<script src="js/mpago/mp_ListaCheque.js"></script>
		<script src="js/jQuery.print.js"></script>
		
		<!-- SCRIPT ESPECIAL PARA OBTENER MONTO POR PAGAR DESDE VENTANA PADRE -->
		<script>
			
			<?php	
					echo "var rutCliente ='{$_POST['jsonCheques']['rut']}';";
					echo "var nombreCliente ='{$_POST['jsonCheques']['nombre']}';";
					echo "var tipoPago = [];";
					echo "var numeroDoc = [];";
					echo "var monto = [];";
					echo "var desc1 = [];";
					echo "var desc2 = [];";
					echo "var desc3 = [];";
					echo "var fechaCheque = [];";
					
					$contVectores = $_POST['jsonCheques']['contVector'];
					echo "var contVectorJS = '{$_POST['jsonCheques']['contVector']}';"; //usar en javascript para las repeticiones
					for($i=0;$i<$contVectores;$i++){
						echo "tipoPago.push('{$_POST['jsonCheques']['tipoPago'][$i]}');";
						echo "numeroDoc.push('{$_POST['jsonCheques']['numeroDoc'][$i]}');";
						echo "monto.push('{$_POST['jsonCheques']['monto'][$i]}');";
						echo "desc1.push('{$_POST['jsonCheques']['desc1'][$i]}');";
						echo "desc2.push('{$_POST['jsonCheques']['desc2'][$i]}');";
						echo "desc3.push('{$_POST['jsonCheques']['desc3'][$i]}');";
						echo "fechaCheque.push('{$_POST['jsonCheques']['fechaCheque'][$i]}');";
					}
			?>
		</script>
		<!-- FIN SCRIPT ESPECIAL -->	
	</head>
	<body>
		<div class="contenedor">
			<div class="row"> <!-- Fila Titulo-->
	
				<div class="col-lg-12">
					<center><h2>Lista de Cheques</h2></center>
				</div>
			</div>
			<hr>
			<div class="row"> <!-- rut y nombre Cliente-->
				<div class="col-lg-4">
				 	<div class="panel panel-default">
				      	<div class="panel-heading">Cliente</div>
				      	<div class="panel-body">
				      		<form class="form-horizontal">
								<div class="form-group">
									<label class="control-label col-sm-4 etiquetaFormulario">Rut</label>
										<div class="col-sm-8">
											<input id="rutCliente" class="form-control" name="rutCliente" placeholder="" type="text">
										</div>
								</div>
								<div class="form-group mpCheque_margintop">								
									<label class="control-label col-sm-4 col-lg-4 etiquetaFormulario">Nombre</label>
										<div class="col-sm-8 col-lg-8">
											<input id="nombreCliente" class="form-control" name="nombreCliente" placeholder="" disabled="" type="text">
										</div>
								</div>							
							</form>
				      	</div>
			    	</div>
				</div>
			</div>
			<div class="row"> <!-- Lista de Cheques-->
				<div class="col-lg-12 col-sm-12">
					<div id="printTabla">
						<div class="panel panel-default">
							<div class="panel-heading">Lista de Cheques</div>
							 <table id="tablaCheques" class="table table-striped">
								<thead>
								  <tr>
									<th>Banco</th>	
									<th>Cuenta</th>
									<th>Número Cheque</th>
									<th>Fecha</th>
									<th>Monto</th>
									<th>Cod.Autorización</th>
									<th>Tipo</th>
								  </tr>
								</thead>
								  </tr>
							  </table>
						</div>			
					</div>
							
				</div>
			</div>
			<div class="row"> <!-- Boton Volver-->
				<center>
					<button id="mpListaCheque_imprimir" class="btn btn-default">
					<span class="glyphicon glyphicon-print"></span>
					<label>Imprimir (F11)</label>
					</button>
					<button id="mpListaCheque_volver" class="btn btn-default">
					<span class="glyphicon glyphicon-circle-arrow-left"></span>
					<label>Volver (F3)</label>
					</button>						
				</center>
			</div>
		</div>			
	</body>
</html>