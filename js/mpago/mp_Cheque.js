//FUNCION ACTUALIZAR DATOS USUARIO CHEQUE
function actualizarDatosChequeCheque(rut, nombres){
	$("#rutCliente").val(rut);
	$("#nombreCliente").val(nombres);
	$("#rutCliente").css('width','100%');
	$("#mpCheque_agregarCliente").hide();
	opener.actualizarDatosCheque(rut, nombres);
}
//FIN ACTUALIZAR DATOS

//FUNCION AGREGAR DIRECCION
function agregarDireccion(){
		$("#mpCheque_agregarCliente").unbind("click").click(function(){
			//Abrir ventana para agregar usuario
			$.post('mpagoui/usuarioCheque.php', function(data) {
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('AgregarUsuario',"","width=800, height=650");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
			//Fin ventana agregar usuario
		});
		$("#mpCheque_cantCheques").focus();
};
//FIN FUNCION AGERGAR DIRECCION
function calcularCheque(cantidad,totalCheque){
	var potencia =0;
	var resto=0;
	var potencia=0;
	while (resto==0){
		resto=totalCheque%10;
		if(resto==0){
			totalCheque=totalCheque/10;
			potencia++;
		}
	}
	if(potencia==1){
		return Math.pow(10,potencia);
	}else{
		return Math.pow(10,potencia-1);
	}
}
//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
		//Comprobar si el cliente tiene una dirección registrada.
		var rut = $("#rutCliente").val();
		$.post('script/buscarUsuario.php', {rut:rut}, function(res){
			var usuario = $.parseJSON(res);
			if(usuario['rut'] == null){
				alert("El cliente no está registrado, por favor registrelo presionando la tecla '+'");
				$("#rutCliente").css('width','79%');
				$("#mpCheque_agregarCliente").show();
				$("#nombreCliente").val('');
				agregarDireccion();
			}
			else if(usuario['direccion'] == ""){
				alert("Para realizar correctamente el cheque debe ingresar la dirección del cliente. Preione en la tecla '+' para modificar al cliente.");
				$("#rutCliente").css('width','79%');
				$("#mpCheque_agregarCliente").show();
				agregarDireccion(); //Cargar funcion para agregar dirección en el caso que el cliente no la tengo o agregar cliente si no existe
			}else{
				var monto = $("#mpCheque_totalCheque").val(); 
				opener.actualizar((montoPorPagar-monto),"4","Cheque", monto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
				var cantCheques = $("#mpCheque_cantCheques").val();
					for(i=0;i<cantCheques;i++){
						var NumeroDoc=$("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(4).html();
						var Monto= parseInt($("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(6).html());
						var desc1=$("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(1).html();
						var desc2=$("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(3).html();
						var desc3=$("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(7).text();
						var desc4="";
						var fecha = $("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(5).text();
						var fechaSplit = fecha.split(" ");
						var fechaFinal = fechaSplit[0].split('-');
						//var fechaFormat = fechaFinal[2]+'-'+fechaFinal[1]+'-'+fechaFinal[0]+' 00:00:00';
						var fechaFormat = fechaFinal[2]+'-'+fechaFinal[1]+'-'+fechaFinal[0];					
						var fechaComprobar = fechaFinal[2]+'-'+fechaFinal[1]+'-'+fechaFinal[0];
						var hoy = new Date();
							dia = hoy.getDate(); 
							mes = hoy.getMonth()+1;
						var fechaActual = hoy.getFullYear() +'-'+ (mes<10 ? '0' : '') + mes + '-'+(dia<10 ? '0' : '') + dia;
						if(fechaComprobar == fechaActual){
							var tipoPago="Check";
							var CdCuenta="02";
						}else if (fechaComprobar > fechaActual){
							var tipoPago="Payments";
							var CdCuenta="01";
						}
						
						opener.obtenerDatosPagos(tipoPago, NumeroDoc, Monto, desc1, desc2, desc3, desc4, CdCuenta,fechaFormat);
					}
				window.close(); //cerrar ventana actual
			}
		});
		
	//Fin comprobación
};
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
function agregarFechaCheque(){
	$(".fechaCheque").datepicker();
};
//FUncion comprobar cliente
function comprobarCliente(){
	var rut = $("#rutCliente").val();
	$.post('script/buscarUsuario.php', {rut:rut}, function(res){
		var usuario = $.parseJSON(res);
		if(usuario['nombres'] != null){
			$("#nombreCliente").val(usuario['nombres']);
			$("#rutCliente").css('width','100%');
			$("#mpCheque_agregarCliente").hide();
			opener.actualizarDatosCheque(rut,usuario['nombres']);
		}else{
			$("#nombreCliente").val('');
			$("#rutCliente").css('width','79%');
			$("#mpCheque_agregarCliente").show();
			agregarDireccion();
		}
	});
};
$(document).ready(function(){
	$("#rutCliente").focus();
	$(document).keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 113){ //F2 - Guardar
		$("#mpCheque_finalizar").click();
		return false;
		}
		if(code == 114){ //F3 - CANCELAR
		$("#mpCheque_cancelar").click();
		return false;
		}
	});	
	
	$("#mpCheque_totalCheque").val(0);
	//Cargar listas de bancos en SELECT 
	$.post('script/cargarBanco.php',function(res){
		var resBanco = $.parseJSON(res);
		for(i=0;i<resBanco.length;i++){
			$("#mpCheque_nombreBanco").append(
				'<option value="'+resBanco[i]['codigo']+'">'+resBanco[i]['banco']+'</option>'
			);
		}
	});
	
	if(clienteRut == '1-9' || clienteRut == ''){
		$("#rutCliente").css('width','83%'); //Ancho de campo rutCliente para ajustar campo y botón en la misma línea
		$("#mpCheque_agregarCliente").show();
	}else{
		$("#rutCliente").css('width','100%');
		$("#mpCheque_agregarCliente").hide();
	}
		
	//Fin comprobación
	//Cargar nombre de usuario si ya existe en la BD
	$("#rutCliente").focusout(function(){
		comprobarCliente();
	});
	$("#rutCliente").keydown(function (e){
		var code = e.keyCode || e.which;
		if(code == 13){
			comprobarCliente();
		}	
	});
	
	var bloqueo=false;      //esta variable sera la que controle el ingreso de cheques a la tabla
	//Definir formato e idioma de DATEPICKER
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		dateFormat: 'dd-mm-yy',
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
	
	//Asignar variables que vienen de medioPago.js
	$("#mpCheque_total").val(montoPorPagar);
	$("#rutCliente").val(clienteRut);
	$("#nombreCliente").val(clienteNombre);
	$("#mpCheque_fecha").datepicker();
	//Controlar si el usuario es distinto de 1-9 para desbloquear los campos
	if(clienteRut != "1-9"){
		$("#cantCheques").attr('disabled',false);
		$("#numeroCheques").attr('disabled',false);
		$("#fecha").attr('disabled',false);
		$("#monto").attr('disabled',false);
		$("#cantCheques").focus();
	}else{
		$("#rutCliente").focus();
		$("#mpCheque_agregarCliente").show();
		$("#mpCheque_agregarCliente").click(function(){
			//Abrir ventana para agregar usuario
			$.post('mpagoui/usuarioCheque.php', function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('AgregarUsuario',"","width=800, height=650");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
			//Fin ventana agregar usuario
		});
	}
	
	$("#mpCheque_agregarCheque").click(function(){
		
			
		// comprobar si la fecha ingresada es menor a la del dia actual
			var fecha = $("#mpCheque_fecha").val();
			var fechaSplit = fecha.split(" ");
			var fechaFinal = fechaSplit[0].split('-');
			//var fechaFormat = fechaFinal[2]+'-'+fechaFinal[1]+'-'+fechaFinal[0]+' 00:00:00';
			var fechaFormat = fechaFinal[2]+'-'+fechaFinal[0]+'-'+fechaFinal[1];			
			var fechaComprobar = fechaFinal[2]+'-'+fechaFinal[1]+'-'+fechaFinal[0];
			var hoy = new Date();
			dia = hoy.getDate(); 
			mes = hoy.getMonth()+1;
			var fechaActual = hoy.getFullYear() +'-'+ (mes<10 ? '0' : '') + mes + '-'+(dia<10 ? '0' : '') + dia;
			if(fechaComprobar < fechaActual){
					alert("La fecha del cheque no puede ser menor a la del dia de hoy");
					 $("#mpCheque_fecha").val("");
			}else if(fecha.length != 10){
				alert("Ingrese una fecha valida");
			}
			else{	
			var banco =$("#mpCheque_nombreBanco").val();
			var localidad =$("#mpCheque_localidad").val();
			var cCorriente =$("#mpCheque_cuentaCorriente").val();
			var cantCheque =$("#mpCheque_cantCheques").val();
			var numCheque =$("#mpCheque_numeroCheques").val();
			var banco =$("#mpCheque_nombreBanco").val();
			var campoFecha =$("#mpCheque_fecha").val();
			var montoinput =$("#mpCheque_mpCheque_monto").val();
		if(banco==""||localidad==""||cCorriente==""||cantCheque==""||numCheque==""||banco==""||campoFecha==""|| montoinput==""){
			alert("Complete todos los campos antes de ingresar un cheque");
		}else{		
			if(parseInt($("#mpCheque_monto").val()) <= $("#mpCheque_total").val() && 
				bloqueo==false && parseInt($("#mpCheque_monto").val())/parseInt($("#mpCheque_cantCheques").val())>=10000){
				var resto=0;
				var result=0;
				var cantCheques = $("#mpCheque_cantCheques").val();
				var numeroCheque = $("#mpCheque_numeroCheques").val();
				var codigoBanco = $("#mpCheque_nombreBanco").val();
				var localidad = $("#mpCheque_localidad option:selected").text();
				var cuentaCorriente = $("#mpCheque_cuentaCorriente").val();
				var fechaCheque = $("#mpCheque_fecha").val();	
				var monto = $("#mpCheque_monto").val();
				var fechaFinalCheque; //variable global para operar las otras fechas
				var numeroChequeSum; //variable para la sumatoria de los números de cheques
				$('#mpCheque_agregarCheque').attr("disabled", true);
				
				//Se establecio que por cada unidad de cheque el monto debe ser mayor a $10000 y todos estos montos no deben ser decimales 
				//algoritmo para insertar en cada fila el valor del cheque correspondiente
				var Pow = calcularCheque(cantCheques,monto);
				resto=(monto/Pow)%cantCheques;
				result=((monto/Pow)/cantCheques);
				Math.floor(result);
				//fin algoritmo (los valores que se obtubieron estan divididos por 10 por lo tanto al hacer la insercion en la tabla hay que volver a multiplicarlos para que de el valor real)
				for(i=0;i<cantCheques;i++){
					var valInsercion=0;
					// Codigo para que compruebe, y que inserte el resto + el valor entero de la division en la primera fila, despues de esta fila los demas valores solo seran el entero de la division
					if(i==0){
						valInsercion=Math.floor(result)*Pow+resto*Pow;
						fechaFinalCheque = fechaCheque;
						numeroChequeSum = parseInt(numeroCheque);
					}else{
						valInsercion=Math.floor(result)*Pow;
						//Incrementar 30 días a la última fecha de cheque 
						var fechaSplitFH = fechaFinalCheque.split(' ');
						var fechaSplitF = fechaSplitFH[0].split('-');
						var fechaActualCheque = new Date(fechaSplitF[2],(fechaSplitF[1]-1),fechaSplitF[0]);
						var fechaActualChequeAux = new Date(fechaActualCheque);
						fechaActualChequeAux.setDate(fechaActualChequeAux.getDate() + 30);
						var fechaFinal = new Date(fechaActualChequeAux); 
						//var fechaFinalCheque = fechaFinal.toLocaleFormat('%d-%m-%Y');
						
						//var fechaFinalCheque= fechaFinal.getDate()+'-'+(fechaFinal.getMonth()+1)+'-'+fechaFinal.getFullYear();
						var fechaFinalCheque= (fechaFinal.getDate()<10 ? '0' : '') + fechaFinal.getDate() + '-' + ((fechaFinal.getMonth()+1)<10 ? '0' : '') + (fechaFinal.getMonth()+1) + '-' + fechaFinal.getFullYear()
						numeroChequeSum = parseInt(numeroChequeSum) + 1;
					}
						$("#tablaCheques tr:last").after('<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td>'+codigoBanco+'</td>'+
							'<td>'+localidad+'</td>'+
							'<td>'+cuentaCorriente+'</td>'+
							'<td contenteditable="true">'+numeroChequeSum+'</td>'+
							'<td contenteditable="true" class="fechaCheque">'+fechaFinalCheque+'</td>'+
							'<td contenteditable="true">'+valInsercion+'</td>'+
							'<td contenteditable="true"></td>'+
							'</tr>');	
							
						agregarFechaCheque();
						$("#mpCheque_totalCheque").val(parseInt($("#mpCheque_totalCheque").val())+valInsercion);
				}
			$("#mpCheque_finalizar").attr("disabled",false);
			bloqueo=true;
			$('#mpCheque_agregarCheque').attr("disabled", true);	
			}else if(parseInt($("#mpCheque_monto").val()) <= $("#mpCheque_total").val() && bloqueo==true){
				alert("Ya ha ingresado un conjunto de cheques, por favor eliminelos con el boton Limpiar para ingresar nuevamente.");
			}else if(parseInt($("#mpCheque_monto").val()) > $("#mpCheque_total").val() && bloqueo==false){
				alert("El monto ingresado no puede ser mayor al valor a pagar");
			}else{
				alert("El monto de cada cheque debe ser mayor a $10.000");
			}
		}
	}
	});
	
	$("#mpCheque_finalizar").click(function(){
		// comprobar si las sumas de los cheques no son mayores a al total ingresado
		//comprobar si hay cheques sin condigo
		var montoAcumulado=0;
		var cantChequesSinCodigo=0;
		var cant =$("#mpCheque_cantCheques").val();
		for(i=0;i<cant;i++){
			montoAcumulado=parseInt($("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(6).html())+montoAcumulado;
			if($("#tablaCheques tr:eq("+(i+1)+")").find("td").eq(7).text() == ""){
				cantChequesSinCodigo++;
			}
			else{
			}
		}
		var cantFilas = $("#tablaCheques tr").length;
		if(cantFilas <= 1){
			alert('Primero debe ingresar al menos un cheque.');
		}else{
			if(montoAcumulado!=parseInt($("#mpCheque_totalCheque").val())){
			alert("La suma del monto de los cheques debe coincidir con el total de los cheques");
			}else{
				if(cantChequesSinCodigo>0){
					alert("Ingrese todos los codigos de Autorización");
				}else if (cantChequesSinCodigo==0){
					aceptar();
				}
			}
		}
	});
	
	$("#mpCheque_cancelar").click(function(){
		window.close();
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
	
	$("#rutCliente").keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 13){
			if($("#rutCliente").val() == "1-9"){
				$("#mpCheque_agregarCliente").show();
			}
		}
		
	});
	$("#mpCheque_limpiar").click(function(){
		$("#tablaCheques").find("td").each(function() {
			   $(this).fadeOut("normal", function(){
               $("#tablaCheques").find("tr:gt(0)").remove();
			   bloqueo=false; 
		});
        });
		
	
		$("#mpCheque_totalCheque").val(0);
		$('#mpCheque_agregarCheque').attr("disabled", false);
		$("#mpCheque_finalizar").attr("disabled",true);
	});

	$("#mpCheque_monto").keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 13){
			$("#mpCheque_agregarCheque").click();
		}		
	});
	$("#mpCheque_cantCheques").keydown(function(e){
		var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
	});
	$("#mpCheque_numeroCheques").keydown(function(e){
		var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
	});	
	$("#mpCheque_fecha").keydown(function(e){
		var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
	});	
	$("#mpCheque_monto").keydown(function(e){
		var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
	});
		$("#mpCheque_cuentaCorriente").keydown(function(e){
		var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
	});	
		$("#tablaCheques").keydown(function(e){
			var num  = soloNumerosYGuion(e);
			if(num == -1){
				return false;
			}
	});
 
});