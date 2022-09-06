var modalEfectivoAbierto=false;
$(document).on('click', '#mpEfectivo', function () {	// Evento Click boton 'EFECTIVO'		//FUNCIÓN PARA ABRIR MODAL
		var montoPorPagar = $("#montoPorPagar").val();
		if(montoPorPagar <= 0){
			alert("Ya se ha cancelado todo el monto registrado en la venta.");
		}else{
			$('#efectivoModal').modal("show");
			$("#efectivoModal").on('shown.bs.modal', function(event) { // funcion para cuando se abra el modal
				modalEfectivoAbierto = true;
				var efectivoPorPagar= parseInt($("#montoPorPagar").val());
				$("#mpEfectivo_efectivo").focus();
				$("#mpEfectivo_total").val(efectivoPorPagar);
			});
		}
});
$(document).on('click', '#mpEfectivo_aceptar', function () {
	var efectivo = $("#mpEfectivo_efectivo").val();
	if(efectivo == ""){
		alert("Primero debe ingresar un valor al campo abierto.");
	}else{
		aceptarEfectivo(parseInt($("#mpEfectivo_total").val()));
	}
});
$(document).on('click', '#mpEfectivo_cancelar', function () {
	efectivoCancelar();
});


function aceptarEfectivo(montoPorPagar){
	var efectivo = $("#mpEfectivo_efectivo").val();
	actualizar((montoPorPagar-efectivo),"1","Efectivo", efectivo); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	if((montoPorPagar-efectivo) < 0){
		var montoPagar = parseInt(montoPorPagar);
	}else{
		var montoPagar = parseInt(efectivo);
	}
	obtenerDatosPagos('Cash', '1', (montoPagar), '', '', '', '', '00'); //funcion opener para llegar al padre y actualizar los valores para guardar el pago
	$('#efectivoModal').modal("hide");
	$("#mpEfectivo_aceptar").attr('disabled', true);          // funcion para deshabilitar boton 
	$("#mpEfectivo_vuelto").val("");
	$("#mpEfectivo_efectivo").val("");
}
function efectivoCancelar(){
	$('#efectivoModal').modal("hide"); // OCULTAR MODAL
	$("#mpEfectivo_aceptar").attr('disabled', true);          // funcion para deshabilitar boton que venia deshabilitado de php 
	$("#mpEfectivo_vuelto").val("");
	$("#mpEfectivo_efectivo").val("");
}

$(document).on('keydown', '#mpEfectivo_efectivo', function (e) {                    // leer tecla ingresada
	var code = e.keyCode || e.which;                               //asignar codigo de tecla ingresada a la variable code
	if(code == 13){                                               //13 corresponde al codigo de la tecla enter
		var efectivo = $("#mpEfectivo_efectivo").val();
		var efectivoPorPagar = parseInt($("#mpEfectivo_total").val());
		var vuelto = efectivo-efectivoPorPagar; 
		if(efectivo == ""){
			alert("Primero debe ingresar un valor al campo abierto.");
			return false;
		}else if(vuelto < 0){
			$("#mpEfectivo_vuelto").val(0);							//Si el valor del vuelto es menor a 0 se mostrará 0 para no confundir al cajero
		}else{
			$("#mpEfectivo_vuelto").val(vuelto);                       //asignar el vuelto al campo correspondiente
		}
		$("#mpEfectivo_aceptar").attr('disabled', false);          // funcion para habilitar boton que venia deshabilitado de php 
	}else if(code == 113&& modalCreditoAbierto==false){
		$("#mpEfectivo_aceptar").click();
		return false;
	}else{
		var num  = soloNumeros(e);
		if(num == -1){
			return false;
		}
	}
});
$(document).on('hidden.bs.modal', '#efectivoModal', function (event) { 
	modalEfectivoAbierto=false;  
//$('#efectivomodal').on('hidden.bs.modal', function(event) { // funcion para cuando modal se cierra	
   	$("#mpEfectivo_aceptar").attr('disabled', true);          // funcion para deshabilitar boton 
	$("#mpEfectivo_vuelto").val("");
	$("#mpEfectivo_efectivo").val("");
	$("#cantidadModalCantidad").val("");
});
