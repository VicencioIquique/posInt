//--------------------------------------------------------FUNCION ACEPTAR-----------------------------------------------------------
function aceptarDebito(){
	var dtNumTarjeta = $("#mpRedCompra_numeroTarjeta").val();
	var dtCodAutorizacion = $("#mpRedCompra_codAutorizacion").val();
	var dtMonto = parseInt($("#mpRedCompra_monto").val());
	var dtTotal = parseInt($("#mpRedCompra_total").val());
	actualizar((dtTotal-dtMonto),"3","RedCompra", dtMonto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
	obtenerDatosPagos('DebitCard', "1", dtMonto, "redCom", dtNumTarjeta, dtCodAutorizacion, '1', "RedCom");
	$('#debitoModal').modal("hide"); //cerrar ventana actual
};
//--------------------------------------------------------INICIAR MODAL------------------------------------------------------------------
var modalDebitoAbierto = false;//GLOBAL
$(document).on('click', '#mpDebito', function () {	// Evento Click boton 'Debito'	FUNCIÓN PARA ABRIR MODAL DESDE VENTANA PADRE
	var montoPorPagar = $("#montoPorPagar").val(); // Viene de la ventana 
	if(montoPorPagar <= 0){
		alert("Ya se ha cancelado todo el monto registrado en la venta.");
	}else{
		$('#debitoModal').modal("show");

	}
});
//-------------------------------------EVENTO ABRIR MODAL------------------------------
$(document).on('shown.bs.modal','#debitoModal', function (event) {
			modalDebitoAbierto=true;
			var dtPorPagar= parseInt($("#montoPorPagar").val());
			$("#mpRedCompra_numeroTarjeta").focus();
			$("#mpRedCompra_total").val(dtPorPagar);
			$("#mpRedCompra_folioActual").val(folioVPMedioPago);
});
//-----------------------------------------------------------EVENTO CERRAR MODAL-------------------------------------------------------------------
$(document).on('hidden.bs.modal', '#debitoModal', function (event) {
		modalDebitoAbierto=false;
		dtIniciarCampos();
});
//-------------------------------------------------------------CONTROLES-------------------------------------------------------------------------------------------------------------------
$(document).on('keydown', '#mpRedCompra_numeroTarjeta', function (e) {
		dtEnterInput(e);
});
$(document).on('keydown', '#mpRedCompra_codAutorizacion', function (e) {
		dtEnterInput(e);
});
$(document).on('keydown', '#mpRedCompra_monto', function (e) {
		dtEnterInput(e);
});
//---------------------------------------------botones Aceptar Cancelar------------------------------------------------------------
$(document).on('click', '#mpRedCompra_aceptar', function () {
	var dtMonto = parseInt($("#mpRedCompra_monto").val());
	var dtTotal = parseInt($("#mpRedCompra_total").val());
	if(dtMonto == ""){
		alert("Primero debe ingresar un valor al campo.");
	}else{
		aceptarDebito();
	}
});
$(document).on('click', '#mpDebito_cancelar', function () {
	$('#debitoModal').modal("hide"); //cerrar ventana actual
});


//------------------------------------------------LIMPIAR CONTROLES----------------------------------------------------
function dtIniciarCampos(){
	//bloquear inputs
	$("#mpRedCompra_aceptar").attr('disabled', true);
	$("#mpRedCompra_numeroTarjeta").attr('disabled', false);
	$("#mpRedCompra_codAutorizacion").attr('disabled', false);
	$("#mpRedCompra_monto").prop("readonly", false);
	// vaciar inputs
	$("#mpRedCompra_numeroTarjeta").val("");
	$("#mpRedCompra_codAutorizacion").val("");
	$("#mpRedCompra_monto").val("");
}

function dtEnterInput(e){ //presionar enter en cualquier input
	var code = e.keyCode || e.which;                                   //asignar codigo de tecla ingresada a la variable code
		if(code == 13){                                                //13 corresponde al codigo de la tecla enter  
			var dtNumTarjeta = $("#mpRedCompra_numeroTarjeta").val();
			var dtCodAutorizacion = $("#mpRedCompra_codAutorizacion").val();
			var dtMonto = parseInt($("#mpRedCompra_monto").val());
			var dtTotal = parseInt($("#mpRedCompra_total").val());
			if(parseInt(dtMonto) > parseInt(dtTotal)){
				alert("No puede pagar más del total de la compra");
				$("#mpRedCompra_monto").val("");
				$("#mpRedCompra_monto").focus();
			}else if(dtNumTarjeta == "" || dtCodAutorizacion == "" || $("#mpRedCompra_monto").val() == ""){
				alert("Debe rellenar todos los campos para continuar");
				return false;
			}else{
				$("#mpRedCompra_aceptar").attr('disabled', false);
				$("#mpRedCompra_numeroTarjeta").attr('disabled', true);
				$("#mpRedCompra_codAutorizacion").attr('disabled', true);
				$("#mpRedCompra_monto").prop("readonly", true);
			}
		}else if(code == 113 && modalCreditoAbierto == false && modalDebitoAbierto == true && modalEfectivoAbierto == false ){ // SI PRESIONA F2 SE EJECUTA EL BOTON ACEPTAR se controla el credito por q es el que se abre con f2
			$("#mpRedCompra_aceptar").click();
			return false;
		}	
}