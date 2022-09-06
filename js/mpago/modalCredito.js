//--------------------------------------------------------FUNCION ACEPTAR-----------------------------------------------------------
function aceptarCredito(){
	  var ctTipocredito = $("#mpCredito_TipoTarjeta").val();
		if (ctTipocredito=='7'){
			var ctCdCuenta='Person';
		}else
			var ctCdCuenta='Transb';
	var ctNumCuotas = $("#mpCredito_cantidadCuotas").val();
	var ctNumTarjeta = $("#mpCredito_numeroTarjeta").val();
	var ctCodAutorizacion = $("#mpCredito_codAutorizacion").val();
	var ctMonto = parseInt($("#mpCredito_monto").val());
	var ctTotal = parseInt($("#mpCredito_total").val());
	actualizar((ctTotal-ctMonto),"2","Credito", ctMonto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	obtenerDatosPagos('CreditCard', ctNumCuotas, ctMonto, ctCdCuenta, ctNumTarjeta, ctCodAutorizacion, '2', ctCdCuenta);
	$('#creditoModal').modal("hide"); //cerrar ventana actual
};

//--------------------------------------------------------INICIAR MODAL------------------------------------------------------------------
var modalCreditoAbierto=false;//GLOBAL
$(document).on('click', '#mpCredito', function () {	// Evento Click boton 'Credito'	FUNCIÓN PARA ABRIR MODAL DESDE VENTANA PADRE
	var montoPorPagar = $("#montoPorPagar").val(); // Viene de la ventana 
	if(montoPorPagar <= 0){
		alert("Ya se ha cancelado todo el monto registrado en la venta.");
	}else{
		$('#creditoModal').modal("show");
		$("#creditoModal").on('shown.bs.modal', function(event) { // funcion para cuando se abra el modal
			modalCreditoAbierto=true;
			var ctPorPagar= parseInt($("#montoPorPagar").val());
			$("#mpCredito_numeroTarjeta").focus();
			$("#mpCredito_total").val(ctPorPagar);
			$("#mpCredito_folioActual").val(folioVPMedioPago);
		});
	}
});
//-----------------------------------------------------------CERRAR MODAL-------------------------------------------------------------------
$(document).on('hidden.bs.modal', '#creditoModal', function (event) {
		modalCreditoAbierto=false;
		ctIniciarCampos();
});
//-------------------------------------------------------------CONTROLES-------------------------------------------------------------------------------------------------------------------
$(document).on('keydown', '#mpCredito_numeroTarjeta', function (e) {
		ctEnterInput(e);
});
$(document).on('keydown', '#mpCredito_cantidadCuotas', function (e) {
		ctEnterInput(e);
});
$(document).on('keydown', '#mpCredito_codAutorizacion', function (e) {
		ctEnterInput(e);
});
$(document).on('keydown', '#mpCredito_monto', function (e) {
		ctEnterInput(e);
});

$(document).on('hidden.bs.modal', '#efectivoModal', function (event) {   
		ctIniciarCampos();
});
//---------------------------------------------botones Aceptar Cancelar------------------------------------------------------------
$(document).on('click', '#mpCredito_aceptar', function () {
	var ctMonto = parseInt($("#mpCredito_monto").val());
	var ctTotal = parseInt($("#mpCredito_total").val());
	if(ctMonto == ""){
		alert("Primero debe ingresar un valor al campo.");
	}else{
		aceptarCredito();
	}
});
$(document).on('click', '#mpCredito_cancelar', function () {
	$('#creditoModal').modal("hide"); //cerrar ventana actual
});


//------------------------------------------------LIMPIAR CONTROLES----------------------------------------------------
function ctIniciarCampos(){
	//bloquear inputs
	$("#mpCredito_aceptar").attr('disabled', true);
	$("#mpCredito_numeroTarjeta").attr('disabled', false);
	$("#mpCredito_TipoTarjeta").attr('disabled', false);
	$("#mpCredito_cantidadCuotas").attr('disabled', false);
	$("#mpCredito_codAutorizacion").attr('disabled', false);
	$("#mpCredito_monto").prop("readonly", false);
	// vaciar inputs
	$("#mpCredito_numeroTarjeta").val("");
	$("#mpCredito_TipoTarjeta").val("");
	$("#mpCredito_cantidadCuotas").val("");
	$("#mpCredito_codAutorizacion").val("");
	$("#mpCredito_monto").val("");
}

function ctEnterInput(e){
	var code = e.keyCode || e.which;                                   //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter  
			var ctNumTarjeta = $("#mpCredito_numeroTarjeta").val();
			var ctTipoTarjeta = $("#mpCredito_TipoTarjeta").val();
			var ctCantCuotas = $("#mpCredito_cantidadCuotas").val();
			var ctCodAutorizacion = $("#mpCredito_codAutorizacion").val();
			var ctMonto = parseInt($("#mpCredito_monto").val());
			var ctTotal = parseInt($("#mpCredito_total").val());
			if(parseInt(ctMonto) > parseInt(ctTotal)){
				alert("No puede pagar más del total de la compra");
				$("#mpCredito_monto").val("");
				$("#mpCredito_monto").focus();
			}else if(ctNumTarjeta == "" || ctTipoTarjeta == 0 || ctCantCuotas == "" || ctCodAutorizacion == "" || $("#mpCredito_monto").val() == ""){
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
		}else if(code == 113 && modalCreditoAbierto == true ){ // SI PRESIONA F2 SE EJECUTA ENTER
			$("#mpCredito_aceptar").click();
			return false;
		}	
}