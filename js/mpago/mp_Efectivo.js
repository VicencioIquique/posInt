//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
	var efectivo = $("#mpEfectivo_efectivo").val();
	opener.actualizar((montoPorPagar-efectivo),"1","Efectivo", efectivo); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	if((montoPorPagar-efectivo) < 0){
		var montoPagar = parseInt(montoPorPagar);
	}else{
		var montoPagar = parseInt(efectivo);
	}
	opener.obtenerDatosPagos('Cash', '1', (montoPagar), '', '', '', '', '00'); //funcion opener para llegar al padre y actualizar los valores para guardar el pago
	window.close(); //cerrar ventana actual
};
function cancelar(){
	window.close();
}
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
$(document).ready(function(){
	$("#mpEfectivo_efectivo").focus();
	$("#mpEfectivo_total").val(montoPorPagar);
	$("#mpEfectivo_aceptar").click(function(){
		var efectivo = $("#mpEfectivo_efectivo").val();
		if(efectivo == ""){
			alert("Primero debe ingresar un valor al campo cerrado.");
		}else{
			aceptar();
		}
	});
	$("#mpEfectivo_cancelar").click(function(){
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
			$("#mpEfectivo_aceptar").click();
			return false;
		}	
		if(code == 114){
			$("#mpEfectivo_cancelar").click();
			return false;
		}
	});
	/*FIN FUNCION PARA CAPTURAR TECLAS*/
	
	// funcion que resta lo que se pagara en efectivo del total de la compra.
	$("#mpEfectivo_efectivo").keydown(function(e){                     // leer tecla ingresada
		var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter
			var efectivo = $("#mpEfectivo_efectivo").val();
			var vuelto = efectivo-montoPorPagar; 
			if(efectivo == ""){
				alert("Primero debe ingresar un valor al campo.");
				return false;
			}else if(vuelto < 0){
				$("#mpEfectivo_vuelto").val(0);							//Si el valor del vuelto es menor a 0 se mostrará 0 para no confundir al cajero
			}else{
				$("#mpEfectivo_vuelto").val(vuelto);                       //asignar el vuelto al campo correspondiente
			}
			$("#mpEfectivo_aceptar").attr('disabled', false);          // funcion para habilitar boton que venia deshabilitado de php 
			$("#mpEfectivo_efectivo").prop("readonly", true);
		}else if(code == 113){
			$("#mpEfectivo_aceptar").click();
			return false;
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}
	});
});