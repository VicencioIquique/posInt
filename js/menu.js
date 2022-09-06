$(document).ready(function(){
	if(rol == '1'){
		$("#administracionBoletas").attr('disabled', false);
		$("#revisarBoletas").attr('disabled', false);
	}else{
		//$("#revisarBoletas").attr('disabled', true);
	}
	$("#abrirPeriodo").click(function(){
		var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
		//Generar XML para abrir periodo fiscal
		$.post("http://localhost/puntoVentaXml/crearXMLAbrirPeriodo.php",{},function(){});
		var interval = setInterval(function(){
				if(comprobacion){
					return;
				}
				$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'abrirPeriodo'},function(resXML){
						var resXML = $.parseJSON(resXML);
						comprobacion=true;
						var Codigo = resXML['Codigo'];
						var Mensaje = resXML['Mensaje'];
						var Folio = resXML['Folio'];
						if(Mensaje != '000'){
							alert(Mensaje);
						}else{
							alert("Periodo fiscal abierto correctamente");
						}	
					
				});
		},1000);
	});
	
	$("#cerrarPeriodo").click(function(){
		var mensaje = confirm("¿Está seguro que desea cerrar el periodo fiscal?");
		if (mensaje){
			var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
			$.post("http://localhost/puntoventaXML/crearXMLCerrarPeriodo.php",{},function(){});
			var interval = setInterval(function(){
					if(comprobacion){
						return;
					}
					$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'CerrarPeriodo'},function(resXML){
							var resXML = $.parseJSON(resXML);
							comprobacion=true; // parar el intervalo
							var Codigo = resXML['Codigo'];
							var Mensaje = resXML['Mensaje'];
							var Folio = resXML['Folio'];
							if(Mensaje != '000'){
								alert(Mensaje);
							}else{
								alert("Periodo fiscal cerrado correctamente");
							}	
					});
			},1000);
		}
	});
	
	$("#informeX").click(function(){
		var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
		$.post("http://localhost/puntoventaXml/crearXMLInformeX.php",{},function(){});
		var interval = setInterval(function(){
				if(comprobacion){
					return;
				}
				$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'informeX'},function(resXML){
					var resXML = $.parseJSON(resXML);
					comprobacion=true; // parar el intervalo
					var Codigo = resXML['Codigo'];
					var Mensaje = resXML['Mensaje'];
					var Folio = resXML['Folio'];
					if(Mensaje != '000'){
						alert(Mensaje);
					}else{
						alert("Informe X generado correctamente");
					}	
				});
		},1000);
	});
	
	
	$("#consultarStock").click(function(){
		$.post('detalleui/consultaStock.php', function(data) { //función POST para enviar montoPorPagar a efectivo.php
			//var win=window.open('about:blank','',"width=247, height=500");
				var win=window.open('Consulta de Stock globalizado',"","width=860, height=550");
				with(win.document){
					open();
					write(data);
					close();
				}
			});
	});

	// $("#menuIntegrado").click(function(){
	// 	$.post('detalleui/menuIntegrado.php', function(data) { //función POST para enviar montoPorPagar a efectivo.php
	// 		//var win=window.open('about:blank','',"width=247, height=500");
	// 			var win=window.open('Opciones POS Integrado',"","width=860, height=550");
	// 			with(win.document){
	// 				open();
	// 				write(data);
	// 				close();
	// 			}
	// 		});



		
	// 	// Transbank.POS.disconnect();
    //     // Transbank.POS.connect().then(function() {
    //     //     console.log('Conectado al cliente')
    //     //     swal({
	// 	// 		position: 'center',
	// 	// 		icon: 'warning',
	// 	// 		title: 'Conectando al Agente',
	// 	// 		showConfirmButton: false,
	// 	// 		timer: 2000
	// 	// 	})
    //     //     // Puedes usar Transbank.POS.getPorts() para obtener lista de puertos activos en el computador
    //     //     Transbank.POS.getPortStatus().then(function(puertos){
    //     //         let { connected, activePort } = puertos
    //     //         console.log(connected, activePort);
    //     //         if (!connected) {
    //     //             Transbank.POS.autoconnect().then((port) => {
    //     //                 if (port === false) {
    //     //                     swal('No se encontró ningún POS', '', 'error');
    //     //                     return;
    //     //                 }
    //     //                 // this.$emit("connected", port.path)
    //     //                 swal('Conectado', 'Dispositivo detectado y conectado: ' + port.path, 'success');
    //     //                 console.log('Puerto conectado correctamente')

    //     //             });
    //     //         } else {
    //     //             swal('Conectado', 'Dispositivo detectado y conectado: ' + activePort, 'success');
    //     //         }
    //     //     })
    //     // })


	// });
});