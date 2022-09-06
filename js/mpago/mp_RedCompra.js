//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
	var monto = $("#mpRedCompra_monto").val(); 
	var numTarjeta = $("#mpRedCompra_numeroTarjeta").val();
	var codAutorizacion = $("#mpRedCompra_codAutorizacion").val();
	opener.actualizar((montoPorPagar-monto),"3","RedCompra", monto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	opener.obtenerDatosPagos('DebitCard', '1', monto, 'RedCom', numTarjeta, codAutorizacion, '1', 'RedCom');
	window.close(); //cerrar ventana actual
};
function cancelar(){
	window.close();
};
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
$(document).ready(function(){
	$("#mpRedCompra_folioActual").val(folio);
	$("#mpRedCompra_numeroTarjeta").focus();
	$("#mpRedCompra_aceptar").click(function(){
		aceptar();
	});
	$("#mpRedCompra_cancelar").click(function(){
		cancelar();
	});
	$("#mpRedCompra_total").val(montoPorPagar);
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
	$(document).keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 113){
			$("#mpRedCompra_aceptar").click();
			return false;
		}
		if(code == 114 ){
			$("#mpRedCompra_cancelar").click();
			return false;
		}
	});
	/*FIN FUNCION PARA CAPTURAR TECLAS*/
	
	//Validaciones
	$("#mpRedCompra_numeroTarjeta").keydown(function(e){
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter 
			var monto = parseInt($("#mpRedCompra_monto").val());
			var total = parseInt($("#mpRedCompra_total").val());
			var numTarjeta = $("#mpRedCompra_numeroTarjeta").val();
			var codAutorizacion = $("#mpRedCompra_codAutorizacion").val();
			if(monto > total){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpRedCompra_monto").val("");
				$("#mpRedCompra_monto").focus();
			}else if(numTarjeta == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else if(monto <= 0){
				alert("El valor del monto a pagar no puede ser igual o menor que 0");
				return false;
			}else{
				$("#mpRedCompra_aceptar").attr('disabled', false);
				$("#mpRedCompra_total").attr('disabled', true);
				$("#mpRedCompra_numeroTarjeta").attr('disabled', true);
				$("#mpRedCompra_codAutorizacion").attr('disabled', true);
				$("#mpRedCompra_monto").attr('readonly', true);
			}
		}else if(code == 113){
			$("#mpRedCompra_aceptar").click();
			return false;
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}
	});
	
	$("#mpRedCompra_codAutorizacion").keydown(function(e){
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter 
			var monto = parseInt($("#mpRedCompra_monto").val());
			var total = parseInt($("#mpRedCompra_total").val());
			var numTarjeta = $("#mpRedCompra_numeroTarjeta").val();
			var codAutorizacion = $("#mpRedCompra_codAutorizacion").val();
			if(monto > total){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpRedCompra_monto").val("");
				$("#mpRedCompra_monto").focus();
			}else if(numTarjeta == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else if(monto <= 0){
				alert("El valor del monto a pagar no puede ser igual o menor que 0");
				return false;
			}else{
				$("#mpRedCompra_aceptar").attr('disabled', false);
				$("#mpRedCompra_total").attr('disabled', true);
				$("#mpRedCompra_numeroTarjeta").attr('disabled', true);
				$("#mpRedCompra_codAutorizacion").attr('disabled', true);
				$("#mpRedCompra_monto").attr('readonly', true);
			}
		}else if(code == 113){
			$("#mpRedCompra_aceptar").click();
			return false;
		}else{
	
		}
	});
	
	$("#mpRedCompra_monto").keydown(function(e){                       // leer tecla ingresada
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter 
			var monto = parseInt($("#mpRedCompra_monto").val());
			var total = parseInt($("#mpRedCompra_total").val());
			var numTarjeta = $("#mpRedCompra_numeroTarjeta").val();
			var codAutorizacion = $("#mpRedCompra_codAutorizacion").val();
			if(monto > total){
				alert("No puede pagar más del total acordado en la compra");
				$("#mpRedCompra_monto").val("");
				$("#mpRedCompra_monto").focus();
			}else if(numTarjeta == "" || codAutorizacion == "" || monto == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else if(monto <= 0){
				alert("El valor del monto a pagar no puede ser igual o menor que 0");
				return false;
			}else{
				$("#mpRedCompra_aceptar").attr('disabled', false);
				$("#mpRedCompra_total").attr('disabled', true);
				$("#mpRedCompra_numeroTarjeta").attr('disabled', true);
				$("#mpRedCompra_codAutorizacion").attr('disabled', true);
				$("#mpRedCompra_monto").attr('readonly', true);
			}
		}else if(code == 113){
			$("#mpRedCompra_aceptar").click();
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