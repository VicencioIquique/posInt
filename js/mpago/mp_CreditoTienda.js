//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
	var monto = $("#mpCreditoTienda_monto").val();
	opener.actualizar((montoPorPagar-monto),"5","CreditoTienda", monto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	window.close(); //cerrar ventana actual
};
function cancelar(){
	window.close();
};
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
$(document).ready(function(){
	$("#mpCreditoTienda_monto").focus();
	$("#mpCreditoTienda_total").val(montoPorPagar);
	$("#mpCreditoTienda_aceptar").click(function(){
		aceptar();
	});
	$("#mpCreditoTienda_cancelar").click(function(){
		cancelar();
	});		
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
			$("#mpCreditoTienda_aceptar").click();
			return false;
		}	
		if(code == 114){
			$("#mpCreditoTienda_cancelar").click();
			return false;
		}
	});
	/*FIN FUNCION PARA CAPTURAR TECLAS*/
	
	// funcion que resta lo que se pagara en efectivo del total de la compra.
	$("#mpCreditoTienda_monto").keydown(function(e){                     // leer tecla ingresada
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter
			var total = $("#mpCreditoTienda_total").val();
			var monto = $("#mpCreditoTienda_monto").val();
			var diferencia = total-monto; 
			if(monto == ""){
				alert("Primero debe ingresar un valor al campo.");
			}else if(diferencia < 0){
				alert("Este medio de pago no permite ingresar un valor mayor al que se debe pagar.");
				$("#mpCreditoTienda_monto").val('');
			}else{
				$("#mpCreditoTienda_diferencia").val(diferencia);                       //asignar el vuelto al campo correspondiente
				$("#mpCreditoTienda_aceptar").attr('disabled', false);          // funcion para habilitar boton que venia deshabilitado de php 
			}
		}else if(code == 113){
			$("#mpCreditoTienda_aceptar").click();
			return false;
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}
	});
});