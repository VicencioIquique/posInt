//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
	
	  var tipocredito = $("#mpCredito_TipoTarjeta").val();
		if (tipocredito=='7'){
			var cdCuenta='Person';
		}else
			var cdCuenta='Transb';
	var monto = $("#mpCredito_monto").val(); 
	var numCuotas = $("#mpCredito_cantidadCuotas").val();
	var numTarjeta = $("#mpCredito_numeroTarjeta").val();
	var codAutorizacion = $("#mpCredito_codAutorizacion").val();
	opener.actualizar((montoPorPagar-monto),"2","Credito", monto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	opener.obtenerDatosPagos('CreditCard', numCuotas, monto, cdCuenta, numTarjeta, codAutorizacion, '2', cdCuenta);
	window.close(); //cerrar ventana actual
};
function cancelar(){
	window.close();
};
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
$(document).ready(function(){
	$("#mpCredito_folioActual").val(folio);
	$("#mpCredito_numeroTarjeta").focus();
	$("#mpCredito_aceptar").click(function(){
		if($("#mpCredito_monto").val() == ""){
			alert("Primero rellene los campos para continuar");
		}else{
			aceptar();
		}
	});
	$("#mpCredito_cancelar").click(function(){
		cancelar();
	});
	$("#mpCredito_total").val(montoPorPagar);
	/*FUNCIÓN PARA CAPTURAR TECLAS DE ATAJOS PARA EL SISTEMA*/
	/*Lista keyCode 
		F1:		112
		F2: 	113
		F3: 	114
		F4: 	115
		F5: 	116
		F6: 	117
		F7: 	118
		F8: 	119
		F9: 	120
		F10: 	121
		F11:	122
		F12:	123
	*/
	/*FIN FUNCION PARA CAPTURAR TECLAS*/
	$(document).keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 113){
			$("#mpCredito_aceptar").click();
			return false;
		}
		if(code== 114){
			$("#mpCredito_cancelar").click();
			return false;
		}
	});
	
	//Validaciones
	$("#mpCredito_numeroTarjeta").keydown(function(e){
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter  
			var numTarjeta = $("#mpCredito_numeroTarjeta").val();
			var tipoTarjeta = $("#mpCredito_TipoTarjeta").val();
			var cantCuotas = $("#mpCredito_cantidadCuotas").val();
			var codAutorizacion = $("#mpCredito_codAutorizacion").val();
			var monto = parseInt($("#mpCredito_monto").val());
			var total = parseInt($("#mpCredito_total").val());
			if(parseInt(monto) > parseInt(total)){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpCredito_monto").val("");
				$("#mpCredito_monto").focus();
			}else if(numTarjeta == "" || tipoTarjeta == 0 || cantCuotas == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else{
				$("#mpCredito_aceptar").attr('disabled', false);
				$("#mpCredito_numeroTarjeta").attr('disabled', true);
				$("#mpCredito_TipoTarjeta").attr('disabled', true);
				$("#mpCredito_cantidadCuotas").attr('disabled', true);
				$("#mpCredito_codAutorizacion").attr('disabled', true);
				$("#mpCredito_monto").prop("readonly", true);
			}
		}else if(code == 113){
			$("#mpCredito_aceptar").click();
			return false;
		}/*else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}*/
		//Se quita soloNumeros(e) ya que se definió que las tarjetas de crédito internacionales tienen letas / 15-11-2016.-
	});
	
	$("#mpCredito_cantidadCuotas").keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter  
			var numTarjeta = $("#mpCredito_numeroTarjeta").val();
			var tipoTarjeta = $("#mpCredito_TipoTarjeta").val();
			var cantCuotas = $("#mpCredito_cantidadCuotas").val();
			var codAutorizacion = $("#mpCredito_codAutorizacion").val();
			var monto = parseInt($("#mpCredito_monto").val());
			var total = parseInt($("#mpCredito_total").val());
			if(parseInt(monto) > parseInt(total)){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpCredito_monto").val("");
				$("#mpCredito_monto").focus();
			}else if(numTarjeta == "" || tipoTarjeta == 0 || cantCuotas == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else{
				$("#mpCredito_aceptar").attr('disabled', false);
				$("#mpCredito_numeroTarjeta").attr('disabled', true);
				$("#mpCredito_TipoTarjeta").attr('disabled', true);
				$("#mpCredito_cantidadCuotas").attr('disabled', true);
				$("#mpCredito_codAutorizacion").attr('disabled', true);
				$("#mpCredito_monto").prop("readonly", true);
			}
		}else if(code == 113){
			$("#mpCredito_aceptar").click();
			return false;
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}
	});
	
	$("#mpCredito_codAutorizacion").keydown(function(e){
		var code = e.keyCode || e.which; 
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter  
			var numTarjeta = $("#mpCredito_numeroTarjeta").val();
			var tipoTarjeta = $("#mpCredito_TipoTarjeta").val();
			var cantCuotas = $("#mpCredito_cantidadCuotas").val();
			var codAutorizacion = $("#mpCredito_codAutorizacion").val();
			var monto = parseInt($("#mpCredito_monto").val());
			var total = parseInt($("#mpCredito_total").val());
			if(parseInt(monto) > parseInt(total)){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpCredito_monto").val("");
				$("#mpCredito_monto").focus();
			}else if(numTarjeta == "" || tipoTarjeta == 0 || cantCuotas == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else{
				$("#mpCredito_aceptar").attr('disabled', false);
				$("#mpCredito_numeroTarjeta").attr('disabled', true);
				$("#mpCredito_TipoTarjeta").attr('disabled', true);
				$("#mpCredito_cantidadCuotas").attr('disabled', true);
				$("#mpCredito_codAutorizacion").attr('disabled', true);
				$("#mpCredito_monto").prop("readonly", true);
			}
		}else if(code == 113){
			$("#mpCredito_aceptar").click();
			return false;
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return true;
			}
		}
	});	
	
	$("#mpCredito_monto").keydown(function(e){                     // leer tecla ingresada
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter  
			var numTarjeta = $("#mpCredito_numeroTarjeta").val();
			var tipoTarjeta = $("#mpCredito_TipoTarjeta").val();
			var cantCuotas = $("#mpCredito_cantidadCuotas").val();
			var codAutorizacion = $("#mpCredito_codAutorizacion").val();
			var monto = parseInt($("#mpCredito_monto").val());
			var total = parseInt($("#mpCredito_total").val());
			if(monto > total){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpCredito_monto").val("");
				$("#mpCredito_monto").focus();
			}else if(numTarjeta == "" || tipoTarjeta == 0 || cantCuotas == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else{
				$("#mpCredito_aceptar").attr('disabled', false);
				$("#mpCredito_numeroTarjeta").attr('disabled', true);
				$("#mpCredito_TipoTarjeta").attr('disabled', true);
				$("#mpCredito_cantidadCuotas").attr('disabled', true);
				$("#mpCredito_codAutorizacion").attr('disabled', true);
				$("#mpCredito_monto").prop("readonly", true);
			}
		}else if(code == 113){
			$("#mpCredito_aceptar").click();
			return false;
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}
	});
	//Fin Validaciones	
});