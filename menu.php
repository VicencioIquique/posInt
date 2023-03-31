<?php
	ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
	ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
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
		<script src="js/menu.js"></script>
		<!-- <script src="https://unpkg.com/transbank-pos-sdk-web@3/dist/pos.js"></script> -->
		<script src="js/pos.js"></script>
		<script src="js/menuIntegrado.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		
		<script>
			<?php
				echo "var ipLocal = '{$_SESSION['ip']}';";
				echo "var rol = '{$_SESSION["rol"]}';";
			?>
		</script>
	</head>
	<body>
		<div class="container">
			
					
					<div class="row">
						<div class="col-lg-offset-4 col-lg-4">
							<img src="img/vicencio.png" class="logoMenu" style="width:100%; margin-bottom:30px;">
						</div>
						<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
							<center>
								<button id="abrirPeriodo" class="col btn btn-default btnMenu">Abrir periodo fiscal</button>
								<button id="cerrarPeriodo" class="col btn btn-default btnMenu">Cerrar periodo fiscal</button>
								<button id="informeX" class="col btn btn-default btnMenu">Informe X</button>
								<button id="reporteCaja" class="col btn btn-default btnMenu">Reporte de caja</button>
							</center>
						</div>
						
					</div>
					<div class="col-lg-offset-2 col-lg-12">
							<center>
							<div class="col-lg-2 ">
								<br>
								<center>
									<form action="vprincipal.php" method="post">
										<button id="puntoVenta" class="btn btn-danger btnMenu">Ir a punto de venta</button>
									</form>
								</center>
							</div>
							<div class="col-lg-2 ">
								<br>
								<center>
									<form action="revisarBoletas.php" method="post">
										<button id="revisarBoletas" class="btn btn-info btnMenu ">Revisar boletas</button>
									</form>
								</center>
							</div>
							<div class="col-lg-2 ">
								<br>
								<center>
									<button id="consultarStock" class="btn btn-warning btnMenu ">Consultar Stock</button>
								</center>
							</div>
							</center>
					</div>
						
					<div class="col-lg-offset-2 col-lg-12">
							<center>
							<div class="col-lg-3 ">
								<br>
								<center>
									
										<button id="menuIntegrado" class="btn btn-success btnMenu">Menu POS Integrado</button>
									
								</center>
							</div>
							<div class="col-lg-3 ">
								<br>
								<center>
									<form action="administracionBoletas.php" method="post">
										<button id="administracionBoletas" class="btn btn-success btnMenu" disabled>Administración de boletas</button>
									</form>
								</center>
							</div>
							</center>
					</div>		
					<?php
				include ("detalleui/menuIntegrado.php");
			?>				

			
		</div>


		
	</body>
</html>