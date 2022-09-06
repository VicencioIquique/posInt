var indiceRevisar;
var bodegaRevisar;
var workstationRevisar;
var numeroDoctoRevisar;
var tipoDoctoRevisar;

function limpiarTabla(){
	$("#tablaRevisarBoletas").parents("tr").fadeOut("normal", function(){ //efecto para eliminar con un fadeout
		$(this).remove(); //eliminar elemento de la tabla
	});
}
function hasClass(elem, className) {
	return elem.className.split(' ').indexOf(className) > -1;
}	
$(document).ready(function(){
	$("#loading").hide(); 
	var ano, mes;
	//Definir formato e idioma de DATEPICKER
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		dateFormat: 'yy-mm',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
	//$("#fecha").datepicker();
	
	$("#fecha").datepicker({
				dateFormat: 'mm-yy',
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				onChangeMonthYear: function(year, month, widget) {
					setTimeout(function() {
						$(".ui-datepicker-calendar").hide();
						$(".ui-datepicker-next").hide();
						$(".ui-datepicker-prev").hide();
					});
				},
				onClose: function(dateText, inst) {
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					mes = parseInt(month) + 1;
					ano = year;
					$(this).val($.datepicker.formatDate('mm-yy', new Date(year, month, 1)));
				}
			});
	
	$("#fecha").click(function(){
		setTimeout(function() {
			$(".ui-datepicker-calendar").hide();
			$(".ui-datepicker-next").hide();
			$(".ui-datepicker-prev").hide();
		});
	});
	
	
	//Seleccionar automaticamente los valores para no revisar ventas de otros módulos
	$('#local option[value="'+bodega+'"]').attr('selected','selected');
	$('#caja option[value="'+workstation+'"]').attr('selected','selected');
	
	if(rol == 1){
		$('#local').attr('disabled',false);
		$('#caja').attr('disabled',false);
	}else{
		$('#local').attr('disabled',true);
		//$('#caja').attr('disabled',true);
	}
	
	$("#btnBuscar").click(function(){
		$("#tablaRevisarBoletas tbody tr").empty();
		bodega = $("#local").val();
		workstation = $("#caja").val();
		var numDocto = $("#numeroDocto").val();
		$("#loading").show(); 
		$.post('script/cargarBoletas.php',{bodega:bodega, workstation:workstation, ano:ano, mes:mes, numDocto:numDocto}, function(res){
			var resTablaBoletas = $.parseJSON(res);
			if(resTablaBoletas == null){
				$("#loading").hide(); 
			}else{
				for(i=0;i<resTablaBoletas.length;i++){
					if(resTablaBoletas[i]['tipoDocto'] == '1'){
						var tipoDocto = 'Boleta fiscal';
					}else if(resTablaBoletas[i]['tipoDocto'] == '2'){
						var tipoDocto = 'Factura';
					}else if(resTablaBoletas[i]['tipoDocto'] == '3'){
						var tipoDocto = 'Nota de credito';
					}else if(resTablaBoletas[i]['tipoDocto'] == '4'){
						var tipoDocto = 'Boleta manual';
					}
					$("#tablaRevisarBoletas tr:last").after('<tr>'+
							'<td class="seleccionarVenta">'+resTablaBoletas[i]['bodega']+'</td>'+
							'<td class="seleccionarVenta">'+resTablaBoletas[i]['workstation']+'</td>'+
							'<td class="seleccionarVenta">'+tipoDocto+'</td>'+
							'<td class="seleccionarVenta">'+resTablaBoletas[i]['numeroDocto']+'</td>'+
							'<td class="seleccionarVenta">'+resTablaBoletas[i]['fechaDocto']+'</td>'+
							'<td class="seleccionarVenta">'+resTablaBoletas[i]['tipoPago']+'</td>'+
							'<td class="seleccionarVenta">'+resTablaBoletas[i]['monto']+'</td>'+
						'</tr>');
				}
				$("#loading").hide(); 
			}
		});
	});
	//DISPARADOR DE EVENTOS DINÁMICOS
	document.addEventListener('click', function (e) {
		if (hasClass(e.target, 'seleccionarVenta')) {
			var indice = $(e.target).parents("tr").index();
			indiceRevisar = indice;
			$(".table").find('tr').each(function(){
				$(this).css('background-color','#fffff');
				$(this).css('color','#000');
			});
			$(e.target).parents("tr").css('background-color','#2E64FE');
			$(e.target).parents("tr").css('color','#eeeeee');
			$("#btnFormaPago").attr('disabled',false);
			$("#btnDetalleVenta").attr('disabled',false);
		}
	},false);
	$("#btnFormaPago").click(function(){
		bodegaRevisar = $("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(0).html();
		workstationRevisar = $("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(1).html();
		
		if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Boleta fiscal'){
			tipoDoctoRevisar = '1';
		}else if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Factura'){
			tipoDoctoRevisar = '2';
		}else if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Nota de credito'){
			tipoDoctoRevisar = '3';
		}else if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Boleta manual'){
			tipoDoctoRevisar = '4';
		}
		
		numeroDoctoRevisar = $("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(3).html();
		
		var jsonDetalleFormaPago = {
			bodega: bodegaRevisar,
			workstation: workstationRevisar,
			tipoDocto: tipoDoctoRevisar,
			numeroDocto: numeroDoctoRevisar
		};
		//Mostrar información
		$.post('detalleui/detalleFormaPago.php',{jsonDetalleFormaPago:jsonDetalleFormaPago},function(data) {
			var win=window.open('MedioPagoEfectivo',"","width=1150, height=350");
			with(win.document){
				open();
				write(data);
				close();
			}
		});
	});
	
	$("#btnDetalleVenta").click(function(){
		bodegaRevisar = $("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(0).html();
		workstationRevisar = $("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(1).html();
		
		if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Boleta fiscal'){
			tipoDoctoRevisar = '1';
		}else if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Factura'){
			tipoDoctoRevisar = '2';
		}else if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Nota de credito'){
			tipoDoctoRevisar = '3';
		}else if($("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(2).html() == 'Boleta manual'){
			tipoDoctoRevisar = '4';
		}
		
		numeroDoctoRevisar = $("#tablaRevisarBoletas tbody tr:eq("+indiceRevisar+")").find('td').eq(3).html();
		
		var jsonDetalleVenta = {
			bodega: bodegaRevisar,
			workstation: workstationRevisar,
			tipoDocto: tipoDoctoRevisar,
			numeroDocto: numeroDoctoRevisar
		};
		//Mostrar información
		$.post('detalleui/detalleVenta.php',{jsonDetalleVenta:jsonDetalleVenta},function(data) {
			var win=window.open('MedioPagoEfectivo',"","width=1600, height=600");
			with(win.document){
				open();
				write(data);
				close();
			}
		});
	});
	
	$("#cerrarSesion").click(function(){
		var session_destroy = '<?php session_destroy();?>';
		location.href='index.php';
	});
	
});