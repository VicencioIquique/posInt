<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>LOGIN</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/login.css" rel="stylesheet">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/login.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-offset-4 col-lg-4">
					<img src="img/vicencio.png" style="width:100%; margin-bottom:30px;">
					<div class="form-group">
						<input id ="usuario"type="text" class="form-control" placeholder="Usuario SISAP" required="" autofocus="">
					</div>
					<div class="form-group">
						<input id="pass"type="password" class="form-control" placeholder="Contraseña SISAP" required="">
					</div>
					<button id ="btn_login"class="btn btn-lg btn-primary btn-block" type="button">Ingresar</button>
				</div>
			</div>
		</div>
	</body>
</html>