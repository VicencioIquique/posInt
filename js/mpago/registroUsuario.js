$(document).ready(function(){
	

	
	if (rut=="1-9"){ // si es un rut generico no inicializar con ese rut
		$("#txtRut").focus()	
	}else{  // cuando es un rut que no existe en la base de datos clientes, lo muestra como rut a ingresar
		$("#txtRut").val(rut);
		$("#txtRut").focus();
		$.post('script/obtenerCliente2.php',{rut:rut},function(res){
			var vecCliente = $.parseJSON(res);
			
			$("#txtNombres").val(vecCliente["nombres"]);
			$("#txtApellidoPaterno").val(vecCliente["apellidoPaterno"]);
			$("#txtApellidoMaterno").val(vecCliente["apellidoMaterno"]);
			/*$("#cmbAno").val(1990);
			$("#cmbMes").val(vecCliente["mes"]);
			$("#cmbDia").val(vecCliente["dia"]);*/
			$("#txtFono").val(vecCliente["fono"]);
			$("#txtCorreo").val(vecCliente["email"]);
			$("#txtDireccion").val(vecCliente["direccion"]);
			if(vecCliente["ciudad"]==""){
				$("#cmbCiudad").val(1);
			}else{
				$("#cmbCiudad").val(vecCliente["ciudad"]);
			}
		});
	}
	//CARGAR DATOS SISAP CLINTES SI YA ESTA EN LA BD CUANDO INICIA 
	//--------------------------------------------------------EVENTOS EN CAMPOS FOCUS OUT--------------------------------------------------------
	$("#txtRut").focusout(function(){
		
		if (validaRut($("#txtRut").val())){
			$("#txtRut").parent().parent().parent().attr("class","form-group has-success");
			$("#txtRut").parent().parent().children("span").text("Correcto");
			rut=$("#txtRut").val();
			$("#txtRut").val(validarGuion(rut)); //poner el guion en caso de que no posean
			$.post('script/obtenerCliente2.php',{rut:rut},function(res){ //CARGAR DATOS SISAP CLINTES SI YA ESTA EN LA BD CUANDO CAMBIA EL Rut
					var vecCliente = $.parseJSON(res);
					$("#txtNombres").val(vecCliente["nombres"]);
					$("#txtApellidoPaterno").val(vecCliente["apellidoPaterno"]);
					$("#txtApellidoMaterno").val(vecCliente["apellidoMaterno"]);
					/*$("#cmbAno").val(1990);
					$("#cmbMes").val(vecCliente["mes"]);
					$("#cmbDia").val(vecCliente["dia"]);*/
					$("#txtFono").val(vecCliente["fono"]);
					$("#txtCorreo").val(vecCliente["email"]);
					$("#txtDireccion").val(vecCliente["direccion"]);
					if(vecCliente["ciudad"]==""){
						$("#cmbCiudad").val(1);
					}else{
						$("#cmbCiudad").val(vecCliente["ciudad"]);
					}
			});
			
			
		}else{ 
			$("#txtRut").parent().parent().parent().attr("class","form-group has-error");
			$("#txtRut").parent().parent().children("span").text("Rut Invalido");
		}
	});
	$("#txtNombres").focusout(function(){
		if($("#txtNombres").val()==""){
			$("#txtNombres").parent().parent().parent().attr("class","form-group has-error");
			$("#txtNombres").parent().parent().children("span").text("No valido");
		}else{
			$("#txtNombres").parent().parent().parent().attr("class","form-group has-success");
			$("#txtNombres").parent().parent().children("span").text("Correcto");
		}
	});
	$("#txtApellidoPaterno").focusout(function(){
		if($("#txtApellidoPaterno").val()==""){
			$("#txtApellidoPaterno").parent().parent().parent().attr("class","form-group has-error");
			$("#txtApellidoPaterno").parent().parent().children("span").text("No valido");
		}else{
			$("#txtApellidoPaterno").parent().parent().parent().attr("class","form-group has-success");
			$("#txtApellidoPaterno").parent().parent().children("span").text("Correcto");
		}
	});
	$("#cmbCiudad").focusout(function(){
		if($("#cmbCiudad").val()==1){
			$("#cmbCiudad").parent().parent().parent().attr("class","form-group has-error");
			$("#cmbCiudad").parent().parent().children("span").text("No valido");
		}else{
			$("#cmbCiudad").parent().parent().parent().attr("class","form-group has-success");
			$("#cmbCiudad").parent().parent().children("span").text("Correcto");
		}
	});
//-----------------------------------------------------BOTON GUARDAR --------------------------------------------------------------

	$("#btnGuardarCliente").click(function(e){
		if (validaRut($("#txtRut").val())!=true){
			alert("Ingrese Un Rut Valido")
			$("#txtRut").focus();
		}else if($("#txtNombres").val().length <= 2){
			alert("Debe Ingresar Un nombre");
			$("#txtNombres").focus();
		}else if($("#txtApellidoPaterno").val().length <= 2){
			alert("Debe Ingresar Un Apellido");
			$("#txtApellidoPaterno").focus();
		}else if($("#cmbCiudad").val()==1){
			alert("seleccione Una ciudad");
			$("#cmbCiudad").focus();
		}else{
			//---------------------------------------------------------------------
				var rut = $("#txtRut").val();
				var nombres = $("#txtNombres").val();
				var apellidoPaterno = $("#txtApellidoPaterno").val();
				var apellidoMaterno = $("#txtApellidoMaterno").val();
				var direccion = $("#txtDireccion").val();
				var telefono = $("#txtFono").val();
				var ciudad = $("#cmbCiudad option:selected").html();
				var email = $("#txtCorreo").val();
				var sexo = $('input:radio[name=sexo]:checked').val();
				//var extranjero =$("#pais").val();
				var fechaNacimiento = $("#cmbAno").val()+"-"+($("#cmbMes").val()<10 ? '0' : '')+$("#cmbMes").val()+"-"+($("#cmbDia").val()<10 ?'0':'')+$("#cmbDia").val();
			//alert(rut+"-"+nombres+"-"+apellidos+"-"+direccion+"-"+telefono+"-"+ciudad+"-"+email);
			//----------------------------------------------------------------------
			$.post('script/comprobarUsuario2.php', {rut:rut}, function(res){ // primero comprobar si existe en RP clientes
				if(res == 1){// si existe en RP _CLIENTES
				// actualizar datos
					var jsonUsuario = {rut:rut,nombres:nombres,apellidoPaterno:apellidoPaterno,apellidoMaterno:apellidoMaterno,direccion:direccion,ciudad:ciudad,telefono:telefono,email:email,fechaNacimiento:fechaNacimiento,sexo:sexo};
						$.post('script/actualizarUsuario2.php', {jsonUsuario:jsonUsuario}, function(resAc){
							if(resAc == 2){
								alert("Usuario actualizado correctamente");
								opener.actualizarInfoUsuario(rut,nombres); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
								window.close();
							}else if(resAc== 3){
								mensaje("Problema al actualizar el usuario, por favor inténtelo de nuevo");
							}
						});
				}else{// SI NO EXISTE, INSERTAR NUEVO CLIENTE
					var jsonUsuario = {rut:rut,nombres:nombres,apellidoPaterno:apellidoPaterno,apellidoMaterno:apellidoMaterno,direccion:direccion,ciudad:ciudad,telefono:telefono,email:email,fechaNacimiento:fechaNacimiento,sexo:sexo};
					$.post('script/agregarUsuario2.php', {jsonUsuario:jsonUsuario}, function(resIns){
							if(resIns == 4){
								alert("Usuario Ingresado correctamente");
								opener.actualizarInfoUsuario(rut,nombres); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
								window.close();
							}else if(resIns== 3){
								alert("Problema al actualizar el usuario, por favor inténtelo de nuevo");
							}
						});
				}
			});
		}
	});
	$("#btnCancelar").click(function(e){
		window.close();
	});
	

//--------------------------------------------------------------------------ENTER PARA AVANZAR-----------------------------------------------------------
$( "#txtRut" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13 || code ==40){ // enter
			$("#txtNombres"     ).focus();
			return false;
		}		
	});
	$( "#txtNombres" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13 || code ==40){ // enter
			$("#txtApellidos").focus();
			return false;
		}else if(code ==38){
			$( "#txtRut" ).focus();
			return false;
		}		
	});
	$( "#txtApellidos" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13 || code ==40){ // enter
			$("#txtFono").focus();
			return false;
		}else if(code ==38){
			$( "#txtNombres" ).focus();
			return false;
		}
		
	});
	$( "#txtFono" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13 || code ==40){ // enter
			$("#txtCorreo").focus();
			return false;
		}else if(code ==38){
			$( "#txtApellidos" ).focus();
			return false;
		}
		
	});
	$( "#txtCorreo" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13 || code ==40){ // enter
			$("#txtDireccion").focus();
			return false;
		}else if(code ==38){
			$( "#txtFono" ).focus();
			return false;
		}
		
	});
	$( "#txtDireccion" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13 || code ==40){ // enter
			$("#cmbCiudad").focus();
			return false;
		}else if(code ==38){
			$( "#txtCorreo" ).focus();
			return false;
		}
		
	});
		$( "#cmbCiudad" ).keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code ==13){ // enter
			$("#btnGuardarCliente").focus();
			return false;
		}
	});
});//----------------------------------------------------------------------------FIN ENTER PARA AVANZAR----------------

//---------------------------------------------FUNCIONES VALIDACIONES--------------------------------------------------
function validaRut(campo){
	if ( campo.length == 0 & campo != "1-9"){ return false; }
	if ( campo.length < 8 & campo != "1-9"){ return false; }

	campo = campo.replace('-','')
	campo = campo.replace(/\./g,'')

	var suma = 0;
	var caracteres = "1234567890kK";
	var contador = 0;    
	for (var i=0; i < campo.length; i++){
	u = campo.substring(i, i + 1);
	if (caracteres.indexOf(u) != -1)
		contador ++;
	}
	if ( contador==0 ) { return false }
												
	var rut = campo.substring(0,campo.length-1)
	var drut = campo.substring( campo.length-1 )
	var dvr = '0';
	var mul = 2;
												
	for (i= rut.length -1 ; i >= 0; i--) {
	suma = suma + rut.charAt(i) * mul
		if (mul == 7) 	mul = 2
		else	mul++
		}
	res = suma % 11
	if (res==1)		dvr = 'k'
		else if (res==0) dvr = '0'
	else {
		dvi = 11-res
		dvr = dvi + ""
	}
	if ( dvr != drut.toLowerCase() ) { return false; }
	else { 
	return true; 
	}
}
function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
		return false;
	}else{
		return true;
	}

}
function resetearCampos(){
	$("#txtRut").parent().attr("class","form-group");
	$("#txtRut").parent().children("span").text("");
	$("#txtNombres").parent().attr("class","form-group");
	$("#txtNombres").parent().children("span").text("");
	$("#txtApellidos").parent().attr("class","form-group");
	$("#txtApellidos").parent().children("span").text("");
	$("#txtFono").parent().attr("class","form-group");
	$("#txtFono").parent().children("span").text("");
	$("#txtCorreo").parent().attr("class","form-group");
	$("#txtCorreo").parent().children("span").text("");
	$("#txtDireccion").parent().attr("class","form-group");
	$("#txtDireccion").parent().children("span").text("");
}
function mensaje(mensaje){
	$('#modalMensaje').modal("show"); // funcion para abrir modal
	$('#modalMensaje').on('shown.bs.modal', function(event) { // funcion para cuando modal ya este abierto
		$('#msg').text(mensaje);
	});
	setTimeout(function(){
	$('#modalMensaje').modal("hide");
	}, 2200) // tiempo de duracion en el modall, (milisegundos)
}
function validarGuion(rut){
	var tamano = rut.length;
	var vector=[];
	for (var i=0;i<=rut.length-1;i++){
		vector[i]=rut[i];
	}
	
	if(rut[tamano-2]!="-"){
		var auxiliar = vector[tamano-1];
		vector[tamano-1]="-";
		vector[tamano]=auxiliar;
		
		var res="";
		for (var i=0;i<vector.length;i++){
			res=res + vector[i];
		}
		return(res);
	}else {
		return (rut);
	}
	
}
