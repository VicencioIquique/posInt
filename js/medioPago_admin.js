//VARIABLES GLOBALES
//Cabecera - Valores provenientes de index.php (datos cliente, vendedor, total)
var clienteRut, clienteNombre;
var vendedorNumero, vendedorNombre;

//Detalle
//Cargados en medioPago.php - valores provenientes de index.php (Tabla de productos)

//Pagos
var itemTipo = [];
var itemDescripcion = [];
var itemMonto = [];

//Arreglos con datos de pagos para insertarBoleta
var TipoPagoIns = [];
var NumeroDocIns = [];
var MontoIns = [];
var desc1Ins = [];
var desc2Ins = [];
var desc3Ins = [];
var desc4Ins = [];
var CdCuentaIns = [];
var fechaChequeIns = [];

//FIN VARIABLES GLOBALES

//Variable para FechaDoctoRef de Nota de crédito
var fechaDoctoRefSplit;

//Arreglos para almacenar tipoPago y Monto para ticket de NC
var tipoPagoTNC = [];
var montoPagoTNC = [];
var numTarjetaTNC = [];
var codAutorizacionTNC = [];
var numCoutasTNC = [];

//FUNCION ACTUALIZAR DATOS CLIENTE EN CASO DE COMPRA CON CHEQUE
function actualizarDatosCheque(rut, nombre){
	clienteRut = rut;
	clienteNombre = nombre;
}
// FIN FUNCION ACTUALIZAR DATOS CLIENTE CHEQUE

//FUNCION ELIMINAR ITEM DE LISTA DE MEDIOS DE PAGO
function eliminarMedioPago(){
	$(".btnEliminarMedioPago").click(function(){
		var vuelto = $("#tablaMediosPago tfoot tr:eq(0)").find("td").eq(2).html(); //valor vuelto
		$(this).parents("tr").fadeOut("normal", function(){ //efecto para eliminar con un fadeout
           	var indice = $(this).index();
			var total = $(this).find("td").eq(2).html(); //obtener el valor del medio de pago
			for(i=indice-1;i<itemTipo.length;i++){
				itemTipo[i] = itemTipo[i+1];
				itemDescripcion[i] = itemDescripcion[i+1];
				itemMonto[i] = itemMonto[i+1];
			}
			$("#montoPorPagar").val(parseInt($("#montoPorPagar").val()) + (parseInt(total) - parseInt(vuelto)));			
			itemTipo.pop();
			itemDescripcion.pop();
			itemMonto.pop();
			
			var tipo = $(this).find("td").eq(0).html(); //obtener el tipo del medio de pago
			var contEliminados = 0; //Variable para contar cuantos registros se eliminar y hacer los pop correspondientes
			console.log("Cantidad eliminados: "+contEliminados);
			if(tipo == '1'){
				tipo = 'Cash';
			}else if(tipo == '2'){
				tipo = 'CreditCard';
			}else if(tipo == '3'){
				tipo = 'DebitCard';
			}else if(tipo == '4'){
				tipo = 'Check';
			}
			for(j=0;j<TipoPagoIns.length;j++){
				console.log("Tipo Pago Ins: "+TipoPagoIns[j]);
				if(TipoPagoIns[j] == tipo){
					TipoPagoIns[j] = TipoPagoIns[j+1];
					NumeroDocIns[j] = TipoPagoIns[j+1];
					MontoIns[j] = TipoPagoIns[j+1];
					desc1Ins[j] = TipoPagoIns[j+1];
					desc2Ins[j] = TipoPagoIns[j+1];
					desc3Ins[j] = TipoPagoIns[j+1];
					desc4Ins[j] = TipoPagoIns[j+1];
					CdCuentaIns[j] = TipoPagoIns[j+1]; 
					fechaChequeIns[j] = fechaChequeIns[j+1];
					contEliminados++;
					console.log("Cantidad eliminados: "+contEliminados);
				}else if (TipoPagoIns[j] == 'Payments'){
						TipoPagoIns[j] = TipoPagoIns[j+1];
						NumeroDocIns[j] = TipoPagoIns[j+1];
						MontoIns[j] = TipoPagoIns[j+1];
						desc1Ins[j] = TipoPagoIns[j+1];
						desc2Ins[j] = TipoPagoIns[j+1];
						desc3Ins[j] = TipoPagoIns[j+1];
						desc4Ins[j] = TipoPagoIns[j+1];
						CdCuentaIns[j] = TipoPagoIns[j+1]; 
						fechaChequeIns[j] = fechaChequeIns[j+1];
						contEliminados++;
				}
			}
			//Eliminar de pagos para insertarBoleta
			for(k=0;k<contEliminados;k++){
				TipoPagoIns.pop();
				NumeroDocIns.pop();
				MontoIns.pop();
				desc1Ins.pop();
				desc2Ins.pop();
				desc3Ins.pop();
				desc4Ins.pop();
				CdCuentaIns.pop();
				fechaChequeIns.pop();
			}
			$(this).remove(); //eliminar elemento de la tabla
		});
		$("#tablaMediosPago tfoot tr:eq(0)").find("td").eq(2).html(0) //Reasignar vuelto si se elimina el efectivo 
	});
};
//FIN ELIMINAR ITEM DE MEDIOS DE PAGO

//FUNCION BUSCAR COINCIDENCIA EN TIPO DE PAGO
function buscarTipoPagoRepetido(tipo){
	var tipoEncontrado = 0;
	for(j=0;j<itemTipo.length;j++){
		if(itemTipo[j] == tipo){
			tipoEncontrado = j;
		}else{
			tipoEncontrado = -1;
		}
	}
	return tipoEncontrado;
}

//FUNCIÓN QUE RECIBE Y ACTUALIZA EL VALOR QUE VIENE DEL MEDIO DE PAGO (POP UP)
function actualizar(valor, tipo, desc, monto){
	console.log(valor+' '+tipo+' '+desc+' '+monto);
	
	if(valor < 0){
		$("#montoPorPagar").val(0);
		var vueltoActual = parseInt($("#tablaMediosPago tfoot tr:eq(0)").find("td").eq(2).html());
		$("#tablaMediosPago tfoot tr:eq(0)").find("td").eq(2).html(vueltoActual + (valor*-1)); //Agregar vuelto a la tabla tablaMediosPago / Multiplicar por -1 para obtener valor positivo
	}else{
		$("#montoPorPagar").val(valor);
	}
	//Primer inserción libre de control
	if(itemTipo.length == 0){
		$("#tablaMediosPago tr:last").after('<tr>'+
								'<td>'+tipo+'</td>'+
								'<td>'+desc+'</td>'+
								'<td>'+monto+'</td>'+
								'<td><input class="btn btn-danger btnEliminarMedioPago" type="button" value="X"/></td>'
							+'</tr>');
		itemTipo.push(tipo);
		itemDescripcion.push(desc);
		itemMonto.push(parseInt(monto));	
	}else if(itemTipo.length > 0){
		var resBuscar = buscarTipoPagoRepetido(tipo);
		if(resBuscar == -1){
			$("#tablaMediosPago tr:last").after('<tr>'+
									'<td>'+tipo+'</td>'+
									'<td>'+desc+'</td>'+
									'<td>'+monto+'</td>'+
									'<td><input class="btn btn-danger btnEliminarMedioPago" type="button" value="X"/></td>'
								+'</tr>');
				itemTipo.push(tipo);
				itemDescripcion.push(desc);
				itemMonto.push(parseInt(monto));	
		}else{
			var sumaTipoPagoMonto = parseInt(itemMonto[resBuscar]) + parseInt(monto);
			itemMonto[resBuscar] = sumaTipoPagoMonto;
			$("#tablaMediosPago tbody tr:eq("+(resBuscar+1)+")").find("td").eq(2).html(sumaTipoPagoMonto); 
		}
	}
	eliminarMedioPago();
}
//FUN FUNCION QUE RECIBE Y ACTUALIZA VALOR

function obtenerDatosPagos(TipoPago, NumeroDoc, Monto, desc1, desc2, desc3, desc4, CdCuenta, fechaCheque){
	TipoPagoIns.push(TipoPago);
	NumeroDocIns.push(NumeroDoc);
	MontoIns.push(Monto);
	desc1Ins.push(desc1);
	desc2Ins.push(desc2);
	desc3Ins.push(desc3);
	desc4Ins.push(desc4);
	CdCuentaIns.push(CdCuenta);
	fechaChequeIns.push(fechaCheque);
	
	for(i=0;i<MontoIns.length;i++){
		console.log(TipoPagoIns[i]);
		console.log(NumeroDocIns[i]);
		console.log(MontoIns[i]);
		console.log(desc1Ins[i]);
		console.log(desc2Ins[i]);
		console.log(desc3Ins[i]);
		console.log(desc4Ins[i]);
		console.log(CdCuentaIns[i]);
		console.log(fechaChequeIns[i]);
	}
}

/*FUNCION PARA GENERAR DESCARGABLE .xml*/
function download(filename, text) {
	var pom = document.createElement('a'); //Creación de elemento 'a' para incorporar atributos para descargar
	pom.setAttribute('href', 'data:text/xml;charset=utf-8,' + encodeURIComponent(text)); // agregar atributo href con el contenido del tipo MIME de xml y la estructura en sí
	pom.setAttribute('download', filename+'.xml'); //agregar atributo de tipo download y el nombre del archivo que se desea
	if (document.createEvent) { //creación de evento para la inicalización del elemento 'a'
		var event = document.createEvent('MouseEvents');
		event.initEvent('click', true, true);
		pom.dispatchEvent(event);
	}
	else {
		pom.click();
	}
}
/*FUNCION PARA DESCARGABLE*/

/*FUNCTIÓN PARA CREAR XML PARA IMPRIMIR BOLETA*/
function imprimirBoleta(){
		fechaDoctoRefSplit = fechaDoctoRef.split(' ');
		$("#imprimirBoleta").attr('disabled',true);
		var subtotal=0, mondescuento=0, total=0;
	
		var montoPorPagar = $("#montoPorPagar").val(); //Obtener monto por pagar para comprobar si se ha cancelado la totalidad de la venta
		var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
		
		/*FUNCION PARA CARGAR LA FECHA ACTUAL DEL EQUIPO*/
		var d = new Date(); //obtener fecha y hora del host
		var mes = d.getMonth()+1; //obtener mes actual
		var dia = d.getDate(); //obtener dia
		var fechaActual = d.getFullYear() + (mes<10 ? '0' : '') + mes + (dia<10 ? '0' : '') + dia;
		/*FIN FUNCION PARA CARGAR LA FECHA*/
		//FUNCION PARA CARGAR LA HORA
		var hora = d.getHours(); //obtener hora
		var minuto = d.getMinutes(); //obtener minuto
		var segundo = d.getSeconds(); //obtener segundo
		var time = (hora<10 ? '0' : '') + hora + (minuto<10 ? '0' : '')+ minuto + (segundo<10 ? '0' : '') + segundo;
		//FIN FUNCION CARGAR HORA
		
		var parser = new DOMParser();
		
		var tablaProdDescSplit = tablaProdDesc.split(",");
		var tablaProdVOrigSplit = tablaProdVOrig.split(",");
		var tablaProdCantidadSplit = tablaProdCantidad.split(",");
		var tablaProdDsctoSplit = tablaProdDscto.split(",");
		var tablaProdVFinalSplit = tablaProdVFinal.split(",");
		var tablaProdALUSplit = tablaProdALU.split(",");
		var tablaProdMarcaSplit = tablaProdMarca.split(",");
		//Acumular totales si se encuentran medios de pagos repetidos
		var acumTipoEfectivoTotal = 0;
		var acumTipoCreditoTotal = 0;
		var acumTipoDebitoTotal = 0;
		var acumTipoChequeTotal = 0;
		//Calcular valores para boleta
		for(k=0;k<tablaProdDescSplit.length;k++){
			subtotal = subtotal + parseInt(tablaProdVFinalSplit[k]);
			//mondescuento = mondescuento + parseInt(tablaProdDsctoSplit[k]);
			total = total + parseInt(tablaProdVFinalSplit[k]);
		}
		//Fin calcular valores para boleta
		
		//CONTROLAR EL TIPO DE DOCUMENTO PARA REALIZAR LA ACCIÓN NECESARIA
	if(boletaTipoDocto == '1'){				//Boleta fiscal
		if(montoPorPagar == 0){ //La venta está pagada completamente, se puede generar la boleta
			var ItemsProductos = "";
			var ItemsPagos = "";
			
			var Folio = folioVPMedioPago;
			console.log("Folio: "+Folio)
						
			$("#imprimirBoleta").attr('disabled',true);
			var ID =boletaTipoDocto+workstation+bodega+Folio+fechaActual+time;
			
			var tablaProdAluSplit = tablaProdALU.split(',');
			var tablaProdCantidadSplit = tablaProdCantidad.split(",");
			var tablaProdDsctoSplit = tablaProdDscto.split(",");
			var tablaProdVOrigSplit = tablaProdVOrig.split(",");
			var tablaProdVendedorSplit = tablaProdVendedor.split(",");
			var tablaProdVFinalSplit = tablaProdVFinal.split(",");
			var tablaProdNumSplit = tablaProdNum.split(",");
			var tablaProdIDPreventaSplit = tablaProdIDPreventa.split(",");
			
			
			//Obtener Fecha del sistema
			var fechaVPSplit = fechaVP.split('-');
			var fechaLocal = fechaVPSplit[2]+'-'+fechaVPSplit[1]+'-'+fechaVPSplit[0] + ' ' + horaVP;
			
			/*Obtener total neto y total*/
			var acumTotal = 0;
			for(i=0;i<tablaProdVOrig.length;i++){
				acumTotal = acumTotal + tablaProdVOrig[i];
			}
			if(vendedorNumero == ""){
				vendedorNumero = cajeroNumero;
			}
			var jsonBoletaDetalle = {
				tablaProdAluSplit:tablaProdAluSplit,
				bodega:bodega,
				tablaProdCantidadSplit:tablaProdCantidadSplit,
				boletaTipoDocto:boletaTipoDocto,
				tipoDocto:boletaTipoDocto,
				numeroDocto:Folio,
				tablaProdDsctoSplit:tablaProdDsctoSplit,
				tablaProdVOrigSplit:tablaProdVOrigSplit,
				tablaProdVendedorSplit:tablaProdVendedorSplit,
				tablaProdVFinalSplit:tablaProdVFinalSplit,
				factor:0,
				workstation:workstation,
				ID:ID,
				numListaPrecio: 1,
				tablaProdNumSplit:tablaProdNumSplit,
				codigoBarra:tablaProdAluSplit,
				tablaProdIDPreventaSplit:tablaProdIDPreventaSplit,
				totalImpuesto:'Taxable',
				porcentajeImpuesto:0,
				aux:0,
				attr:'',
				codPromo:0							
			};
			if(clienteRut == '1-9'){
				var rutFinal = '';
			}else{
				var rutFinal = clienteRut;
			}
			var jsonBoletaCabecera = {
				bodega:bodega,
				workstation:workstation,
				tipoDocto:boletaTipoDocto,
				numeroDocto:Folio,
				fechaDocto:fechaLocal,
				totNeto:total, //Total tablaProdVFinalSplit
				totDescuento:0,
				totIva:0,
				total:total, //Total tablaProdVFinalSplit
				rutCliente:rutFinal,
				rutDespacho:rutFinal,
				cajera: cajeroNumero,
				//retencionDL18219 -> Calculado en insertarBoleta.php
				//tipoCambio -> Obtenido en insertarBoleta.php
				//CIF -> Calculado en insertarBoleta.php
				//totNetoRetencion -> Calcular insertarBoleta.php (Total - RetencionDL)
				vendedorNumero:vendedorNumero, //Vendedor único asignado en vprincipal (en la cabecera no se necesita el arreglo de vendedores)
				estado:0,
				numeroDoctoRef: '',
				fechaDoctoRef: '',
				ID:ID,
				//fechaCreacion -> Obtenida en insertarBoleta.php
				//serie -> Equivalencia de SAP
				retencionCarnes:0,
				netoRetencionCarnes:0,
				//shipToAdress2 -> Pendiente
				billToCompany:'',
				//shipToFName -> Pendiente
				type:0,
				Status:2,
				baseEntry:''
			};
			var jsonBoletaPagos = {
				bodega:bodega,
				tipoDocto:boletaTipoDocto,
				numeroDocto:Folio,
				//secuencia: calculada en insertarBoleta.php
				tipoPago:TipoPagoIns,
				NumeroDoc:NumeroDocIns ,
				fechaDoc:fechaLocal,
				monto:MontoIns,
				desc1:desc1Ins,
				desc2:desc2Ins,
				desc3:desc3Ins,
				desc4:desc4Ins,
				CdCuenta:CdCuentaIns,
				workstation:workstation,
				ID:ID,
				fechaCheque:fechaChequeIns
			};
			
			//alert(JSON.stringify(jsonBoletaCabecera));
			
			$.post("script/insertarBoletaLog.php",{jsonBoletaDetalle:jsonBoletaDetalle, jsonBoletaCabecera: jsonBoletaCabecera, jsonBoletaPagos:jsonBoletaPagos},function(res){
				$.post("script/insertarBoleta_admin.php",{jsonBoletaDetalle:jsonBoletaDetalle, jsonBoletaCabecera: jsonBoletaCabecera, jsonBoletaPagos:jsonBoletaPagos},function(res){
					if(res == 0){
						alert("El número de documento ya existe en este local y caja, por favor intente con otro");
					}else if(res == 1){
						location.href="administracionBoletas.php"; 
					}else{
						alert(res);
						$("#imprimirBoleta").attr('disabled',false);
					}
				});
			});
			
			
		}else{ //Aún queda monto por pagar en la venta
			alert("Primero debe cancelar la totalidad de la venta antes de generar la boleta");
			$("#imprimirBoleta").attr('disabled',false);
		}
	}else if(boletaTipoDocto == '3'){		//Nota de crédito
		if(montoPorPagar == 0){
				var Folio = folioVPMedioPago;
				var ID =boletaTipoDocto+workstation+bodega+Folio+fechaActual+time;
						
				var tablaProdAluSplit = tablaProdALU.split(',');
				var tablaProdCantidadSplit = tablaProdCantidad.split(",");
				var tablaProdDsctoSplit = tablaProdDscto.split(",");
				var tablaProdVOrigSplit = tablaProdVOrig.split(",");
				var tablaProdVendedorSplit = tablaProdVendedor.split(",");
				var tablaProdVFinalSplit = tablaProdVFinal.split(",");
				var tablaProdNumSplit = tablaProdNum.split(",");
				var tablaProdIDPreventaSplit = tablaProdIDPreventa.split(",");
				
				//Obtener Fecha del sistema
				var fechaVPSplit = fechaVP.split('-');
				var fechaLocal = fechaVPSplit[2]+'-'+fechaVPSplit[1]+'-'+fechaVPSplit[0] + ' ' + horaVP;
						
				/*Obtener total neto y total*/
				var acumTotal = 0;
				for(i=0;i<tablaProdVOrig.length;i++){
					acumTotal = acumTotal + tablaProdVOrig[i];
				}
				if(vendedorNumero == ""){
					vendedorNumero = slpCode;
				}
				var jsonBoletaDetalle = {
					tablaProdAluSplit:tablaProdAluSplit,
					bodega:bodega,
					tablaProdCantidadSplit:tablaProdCantidadSplit,
					boletaTipoDocto:boletaTipoDocto,
					tipoDocto:boletaTipoDocto,
					numeroDocto:Folio,
					tablaProdDsctoSplit:tablaProdDsctoSplit,
					tablaProdVOrigSplit:tablaProdVOrigSplit,
					tablaProdVendedorSplit:tablaProdVendedorSplit,
					tablaProdVFinalSplit:tablaProdVFinalSplit,
					factor:0,
					workstation:workstation,
					ID:ID,
					numListaPrecio: 1,
					tablaProdNumSplit:tablaProdNumSplit,
					codigoBarra:tablaProdAluSplit,
					tablaProdIDPreventaSplit:tablaProdIDPreventaSplit,
					totalImpuesto:'Taxable',
					porcentajeImpuesto:0,
					aux:0,
					attr:'',
					codPromo:0							
				};
				if(clienteRut == '1-9'){
					var rutFinal = '';
				}else{
					var rutFinal = clienteRut;
				}
				var jsonBoletaCabecera = {
					numeroDoctoNC:numeroDoctoNC,
					tipoDoctoNC:tipoDoctoNC,
					bodega:bodega,
					workstation:workstation,
					tipoDocto:boletaTipoDocto,
					numeroDocto:Folio,
					fechaDocto:fechaLocal,
					totNeto:total, //Total tablaProdVFinalSplit
					totDescuento:0,
					totIva:0,
					total:total, //Total tablaProdVFinalSplit
					rutCliente:rutFinal,
					rutDespacho:rutFinal,
					cajera: slpCode,
					//retencionDL18219 -> Calculado en insertarBoleta.php
					//tipoCambio -> Obtenido en insertarBoleta.php
					//CIF -> Calculado en insertarBoleta.php
					//totNetoRetencion -> Calcular insertarBoleta.php (Total - RetencionDL)
					vendedorNumero:vendedorNumero, //Vendedor único asignado en vprincipal (en la cabecera no se necesita el arreglo de vendedores)
					estado:0,
					numeroDoctoRef: boletaTipoDocto+workstationNC+bodegaNC+numeroDoctoNC,
					fechaDoctoRef: fechaDoctoRefSplit[0],
					ID:ID,
					//fechaCreacion -> Obtenida en insertarBoleta.php
					//serie -> Equivalencia de SAP
					retencionCarnes:0,
					netoRetencionCarnes:0,
					//shipToAdress2 -> Pendiente
					billToCompany:'',
					//shipToFName -> Pendiente
					type:0,
					Status:2,
					baseEntry:''
				};
				var jsonBoletaPagos = {
					bodega:bodega,
					tipoDocto:boletaTipoDocto,
					numeroDocto:Folio,
					//secuencia: calculada en insertarBoleta.php
					tipoPago:TipoPagoIns,
					NumeroDoc:NumeroDocIns ,
					fechaDoc:fechaLocal,
					monto:MontoIns,
					desc1:desc1Ins,
					desc2:desc2Ins,
					desc3:desc3Ins,
					desc4:desc4Ins,
					CdCuenta:CdCuentaIns,
					workstation:workstation,
					ID:ID,
					fechaCheque:fechaChequeIns
				};
				//alert(TipoPagoIns.length);
				$.post("script/insertarBoletaLogNC.php",{jsonBoletaDetalle:jsonBoletaDetalle, jsonBoletaCabecera: jsonBoletaCabecera, jsonBoletaPagos:jsonBoletaPagos, workstationNC:workstationNC},function(res){
					$.post("script/insertarBoleta_adminNC.php",{jsonBoletaDetalle:jsonBoletaDetalle, jsonBoletaCabecera: jsonBoletaCabecera, jsonBoletaPagos:jsonBoletaPagos, workstationNC:workstationNC},function(res){
						if(res == 0){
							alert("El número de documento ya existe en este local y caja, por favor intente con otro");
						}else if(res == 1){
							//IMPRIMIR COMENTARIOS DE VENTA PARA NOTA DE CREDITO
							alert("Nota de crédito generada con éxito");
							location.href="administracionBoletas.php"; 
						}else{
							alert(res);
							$("#imprimirBoleta").attr('disabled',false);
						}
					});
				});
				
		}else{ //Aún queda monto por pagar en la venta
			alert("Primero debe cancelar la totalidad de la venta antes de generar la boleta");
			$("#imprimirBoleta").attr('disabled',false);
		}
	}
	
	//alert(xml);
};
/*FIN FUNCION CREAR XML*/
$(document).ready(function(){
	//TipoDocto es 3 / NOTA DE CREDITO
	if(boletaTipoDocto == '3'){
		$("#mpCredito").attr('disabled', true);
		$("#mpDebito").attr('disabled', true);
		$("#mpCheque").attr('disabled', true);
		$("#mpListaCheques").attr('disabled', true);
		$.post('script/obtenerNotaCreditoPagos.php', {numeroDocto:numeroDoctoNC, bodega:bodegaNC, workstation:workstationNC}, function(res){
			var resPagos = $.parseJSON(res);
			for(j=0;j<resPagos.length;j++){
				
				tipoPagoTNC.push(resPagos[j]['TipoPago']);
				montoPagoTNC.push(resPagos[j]['Monto']);
				numTarjetaTNC.push(resPagos[j]['desc2']);
				codAutorizacionTNC.push(resPagos[j]['desc3']);
				numCoutasTNC.push(resPagos[j]['NumeroDoc']);
				
				var fechaDoc = resPagos[j]['FechaDoc']; //Fecha documento
				var fechaDocSplit = fechaDoc.split(' '); // Fecha documento sin hora
				var fechaDocSplitF = fechaDocSplit[0].split('-');
				var fechaDocFinal = fechaDocSplitF[0]+'-'+fechaDocSplitF[2]+'-'+fechaDocSplitF[1]; //Cambiar formato de Fecha que tiene la tabla Pagos de RP (Mes por dia)
				var hoy = new Date();
					dia = hoy.getDate(); 
					mes = hoy.getMonth()+1;
				var fechaActual = hoy.getFullYear() +'-'+(dia<10 ? '0' : '') + dia + '-' + (mes<10 ? '0' : '') + mes ;
				
				var tipoPago;
				var tipoPagoBD;
				var descPago;
				var CdCuenta;
				//if(resPagos[j]['TipoPago'] == 'Cash' && fechaActual == fechaDocFinal){ //Se cambia porque se definió que sin importar el día si el pago es en cash la devolución también.
				if(resPagos[j]['TipoPago'] == 'Cash'){
					tipoPago= '1';
					descPago = 'Efectivo';
					//fechaDoc='';
					tipoPagoBD = 'Cash';
					CdCuenta = '00';
				}else{
					tipoPago= '5';
					descPago='CreditoTienda';
					//fechaDoc='';
					tipoPagoBD='CreditStore';
					CdCuenta='03'
				}
				actualizar(0, tipoPago, descPago, resPagos[j]['Monto']);
				obtenerDatosPagos(tipoPagoBD, resPagos[j]['NumeroDoc'], resPagos[j]['Monto'], '', '', 
					'', '', CdCuenta, fechaDoc);
			}
		});
	}else{
		$("#mpCreditoTienda").attr('disabled', true);
	}
	
	/*Totales provenientes de vprincipal.js*/
	$("#total").val(totalMPago); 
	$("#montoPorPagar").val(totalMPago);
	/*FIN Totales provenientes de vprincipal.js*/
	
	//Cargar valores en los campos hidden para mandar a vprincipal en caso de necesitar volver
	$("#hidden").val(ID); //input oculto que contiene información de o los ID de preventas o productos escaneados en la etapa anterior para devolver en caso de presionar el boton Volver
	$("#clienteRutP").val(clienteRut);
	$("#clienteNombreP").val(clienteNombre);
	//Fin carga de valores en campos hidden
	
	/*INICIO BOTONES MEDIOS DE PAGO*/
	//INICIO BOTON EFECTIVO
	$("#mpEfectivo").click(function(){ // Evento Click boton 'EFECTIVO'
		//FUNCIÓN PARA ABRIR OTRA VENTANA Y ENVIARLE DATOS POR POST AJAX
		var montoPorPagar = $("#montoPorPagar").val();
		if(montoPorPagar <= 0){
			alert("Ya se ha cancelado todo el monto registrado en la venta.");
		}else{
			$.post('mpagoui/efectivo.php', {montoPorPagar:montoPorPagar}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('MedioPagoEfectivo',"","width=530, height=550");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
		}
	});
	//FIN BOTON EFECTIVO
	
	//INICIO BOTON CREDITO
	$("#mpCredito").click(function(){ // Evento Click boton 'CREDITO'
		//FUNCIÓN PARA ABRIR OTRA VENTANA Y ENVIARLE DATOS POR POST AJAX
		var montoPorPagar = $("#montoPorPagar").val();
		if(montoPorPagar <= 0){
			alert("Ya se ha cancelado todo el monto registrado en la venta.");
		}else{
			$.post('mpagoui/credito.php', {montoPorPagar:montoPorPagar, folio:folioVPMedioPago}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('MedioPagoEfectivo',"","width=560, height=710");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
		}
	});

	//FIN BOTON CREDITO
	
	//INICIO BOTON RED COMPRA
	$("#mpDebito").click(function(){ // Evento Click boton 'RED COMPRA'
		//FUNCIÓN PARA ABRIR OTRA VENTANA Y ENVIARLE DATOS POR POST AJAX
		var montoPorPagar = $("#montoPorPagar").val();
		if(montoPorPagar <= 0){
			alert("Ya se ha cancelado todo el monto registrado en la venta.");
		}else{
			$.post('mpagoui/redcompra.php', {montoPorPagar:montoPorPagar, folio:folioVPMedioPago}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('MedioPagoEfectivo',"","width=560, height=660");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
		}
	});

	//FIN BOTON RED COMPRA
	
	//INICIO BOTON CREDITO TIENDA
	$("#mpCreditoTienda").click(function(){ // Evento Click boton 'CREDITO TIENDA'
		//FUNCIÓN PARA ABRIR OTRA VENTANA Y ENVIARLE DATOS POR POST AJAX
		var montoPorPagar = $("#montoPorPagar").val();
		if(montoPorPagar <= 0){
			alert("Ya se ha cancelado todo el monto registrado en la venta.");
		}else{
			$.post('mpagoui/creditotienda.php', {montoPorPagar:montoPorPagar}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('MedioPagoEfectivo',"","width=530, height=550");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
		}
	});

	//FIN BOTON CREDITO TIENDA
	
	//INICIO BOTON CHEQUE
	$("#mpCheque").click(function(){ // Evento Click boton 'CREDITO'
		//FUNCIÓN PARA ABRIR OTRA VENTANA Y ENVIARLE DATOS POR POST AJAX
		var montoPorPagar = $("#montoPorPagar").val();
		if(montoPorPagar <= 0){
			alert("Ya se ha cancelado todo el monto registrado en la venta.");
		}else{
			$.post('mpagoui/cheque.php', {montoPorPagar:montoPorPagar, clienteRut:clienteRut, clienteNombre:clienteNombre}, function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('MedioPagoEfectivo',"","width=1600, height=800");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
		}
	});
	//FIN BOTON CHEQUE
	
	//INICIO BOTON LISTA CHEQUE
	$("#mpListaCheques").click(function(){ // Evento Click boton 'CREDITO'
		//FUNCIÓN PARA ABRIR OTRA VENTANA Y ENVIARLE DATOS POR POST AJAX
			var contVector = MontoIns.length;
						var jsonCheques = {
							rut:clienteRut,
							nombre:clienteNombre,
							tipoPago:TipoPagoIns,
							numeroDoc:NumeroDocIns ,
							monto:MontoIns,
							desc1:desc1Ins,
							desc2:desc2Ins,
							desc3:desc3Ins,
							fechaCheque:fechaChequeIns,
							contVector:contVector
						};
	$.post('mpagoui/listacheques.php',{jsonCheques:jsonCheques},function(data) {
				var win=window.open('MedioPagoEfectivo',"","width=1600, height=800");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
	});
	//FIN BOTON LISTA CHEQUE
	/*FIN BOTONES MEDIOS DE PAGO*/
	
	$("#imprimirBoleta").click(function(){ // Evento Click boton 'imprimirBoleta'
		imprimirBoleta(); //función imprimir boleta
	});
	$("#agregarXML").click(function(){
		
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
		if(code == 112){ //F1 - EFECTIVO
			$("#mpEfectivo").click();
			return false;
		}
		if(code == 113){ //F2 - CREDITO
			$("#mpCredito").click();
			return false;
		}
		if(code == 114){ //F3 - RED COMPRA
			$("#mpDebito").click();
			return false;
		}
		if(code == 115){ //F4 - CHEQUE
			$("#mpCheque").click();
			return false;
		}
		//AGREGAR F5 -- CREDITO TIENDA
		if(code == 116){ //F6 - CREDITO TIENDA
			$("#mpCreditoTienda").click();
			return false;
		}
		if(code == 117){ //F6 - LISTA CHEQUE
			$("#mpListaCheques").click();
			return false;
		}
		if(code == 122){ //F11 - GENERAR BOLETA
			$("#imprimirBoleta").click();
			return false;
		}		
	});
	/*FIN FUNCION PARA CAPTURAR TECLAS*/
});