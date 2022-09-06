<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Registrar Cliente</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/usuario.css" rel="stylesheet">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/mpago/registroUsuario.js"></script>	
		<script>
			<?php
				echo "var rut = '{$_POST['rut']}';";
			?>
		</script>
	
	</head>
	<body>		
		<div class ="col-xs-offset-1 col-xs-12">
		<center><H1>Registro Cliente<h1/></center>
		 <hr>
			<div class ="form-group">
				<div class="row">
					<label class="col-xs-3">RUT/DNI</label>
					<div class ="col-xs-6">
						<input type="text" name="" id="txtRut"  maxlength="10" class="form-control" placeholder="11111111-9">
					</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">	
				<div class ="row">
					<label class='col-xs-3'>Sexo</label>
					<div class ="col-xs-6">
							<input type="radio" id="rbMasculino" name="sexo" value="Masculino" checked>
							<label style="margin-left:20px;" for="rbMasculino">Masculino</label>
							<input type="radio" id="rbFemenino" name="sexo" value="Femenino">
							<label for="rbFemenino">Femenino</label>
					</div>
				</div>
			</div>
			<div class ="form-group">	
				<div class ="row">
					<label class='col-xs-3'>Fecha Nacimiento</label>
					<div class ="col-xs-6">
						<select id="cmbDia" name="cmbDia" class="col-xs-4">
							<option value ="" selected></option>
							<option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option>
							<option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option>
							<option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
							<option value="31">31</option>
						</select>
						<select id="cmbMes" name="cmbMes" class="col-xs-4">
							<option value ="" selected></option>
							<option value="1" selected>Enero</option>
							<option value="2">Febrero</option>
							<option value="3">Marzo</option>
							<option value="4">Abril</option>
							<option value="5">Mayo</option>
							<option value="6">Junio</option>
							<option value="7">Julio</option>
							<option value="8">Agosto</option>
							<option value="9">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>
						<select id="cmbAno" name="cmbAno" class="col-xs-4">
							<option value ="" selected></option>
							<option value="1930"selected>1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option>
							<option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option>
							<option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option>
							<option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option>
							<option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option>
							<option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1994</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1999">1989</option>
							<option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option>
							<option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option>
						</select>
					</div>
				</div>
			</div>
			<div class ="form-group">	
				<div class ="row">
						<label class='col-xs-3'>Nombre</label>
						<div class ="col-xs-6">
							<input type="text" name="" id="txtNombres" class="form-control">
						</div>
						<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<div class ='row'>
					<label class='col-xs-3'>Apellido Paterno</label>
					<div class ="col-xs-6">
						<input type="text" name="" id="txtApellidoPaterno" class="form-control">
					</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<div class ='row'>
					<label class='col-xs-3'>Apellido Materno</label>
					<div class ="col-xs-6">
						<input type="text" name="" id="txtApellidoMaterno" class="form-control">
					</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<div class ='row'>
					<label class='col-xs-3'>Telefono</label>
						<div class ="col-xs-6">
							<input type="Text" name="" id="txtFono" class="form-control" placeholder="+569 12345678">
						</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<div class ='row'>
					<label class='col-xs-3'>Correo</label>
					<div class ="col-xs-6">
						<input type="Text" name="" id="txtCorreo" class="form-control" placeholder="correo@ejemplo.com">
					</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<div class ='row'>
					<label class='col-xs-3'>Direccion</label>
					<div class ="col-xs-6">
						<input type="Text" name="" id="txtDireccion" class="form-control" placeholder="">					
					</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<div class="row">
				<label class ="col-xs-3">Ciudad</label>
					<div class ="col-xs-6">
						<select id='cmbCiudad' class="form-control">
							<option selected="selected" value="1">     </option>
							<option value="Arica">Arica</option>
							<option value="Iquique" selected>Iquique</option>
							<option value="Tocopilla">Tocopilla</option>
							<option value="Antofagasta">Antofagasta</option>
							<option value="Calama">Calama</option>
							<option value="Copiapo">Copiapo</option>
							<option value="AltoHospicio">Alto Hospicio</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Vallenar">Vallenar</option>
							<option value="Coquimbo">Coquimbo</option>
							<option value="La Serena">La Serena</option>
							<option value="Valparaiso">Valparaiso</option>
							<option value="Vina del mar">Vina del mar</option>
							<option value="Santiago">Santiago</option>
							<option value="Rancagua">Rancagua</option>
							<option value="Curico">Curico</option>
							<option value="Talca">Talca</option>
							<option value="Chillan">Chillan</option>
							<option value="Concepcion">Concepcion</option>
							<option value="Temuco">Temuco</option>
							<option value="Valdivia">Valdivia</option>
							<option value="Coyhaique">Coyhaique</option>
							<option value="Puerto Montt">Puerto Montt</option>
							<option value="Puerto Aisen">Puerto Aisen</option>
							<option value="Puerto Arenas">Punta Arenas</option>
							<option value="Puerto Natales">Puerto Natales</option>
							<option value="Puerto Varas">Puerto Varas</option>
							<option value="otros">Otros</option>
						</select>
					</div>
					<span class ="col-xs-3 help-block"></span>
				</div>
			</div>
			<!--<div class ="form-group">
				<div class ='row'>
				<label class ="col-xs-3">País</label>
				<div class ="col-xs-8">
				<select id='cmbPais'name="pais">
					<option value="CHILE" SELECTED>Chile</option>
					<option value="EXTRANJERO">Extranjero</option>
					</select>
				</div>
				</div>
			</div>-->
			
			<div class ="form-group">
				<button type="button" class="btn btn-success btn-lg col-xs-offset-3" id="btnGuardarCliente">Guardar Cliente</button>
				<button type="button" class="btn btn-danger btn-lg col-xs-offset-1" id="btnCancelar"> Cancelar </button>
			</div>
			
		

		<div class=" col-xs-offset-3 col-xs-6 modal fade" id="modalMensaje" role="dialog">
			<div class="modal-dialog modal-sm  " style="margin-top:70%;opacity: 1;">
			  <div class="modal-content">
				<div class="modal-header">
				</div>
				<div class="modal-body">
					<center><label id='msg'></label></center>
				</div>
				<div class="modal-footer">	</div>	
			</div>
			</div>
		</div>	
		</div>
	
	</body>
</html>