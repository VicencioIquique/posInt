


$(document).on('click', '#posIntegrado', async function () {
    
    let montoPorPagar = $("#montoPorPagar").val(); // Viene de la ventana 
	if(montoPorPagar <= 0){
		alert("Ya se ha cancelado todo el monto registrado en la venta.");
	}else{
        //console.log(montoPorPagar);
        try {
            await Transbank.POS.disconnect() 
            
        } catch (error) {
            console.error('No need disconnect!');
        }
        let conn = {}
        await Transbank.POS.connect().then(async function() {
            console.log('Conectado al cliente')
            await Swal.fire({
				position: 'center',
				icon: 'warning',
				title: 'Conectando al Agente',
				showConfirmButton: false,
				timer: 1000
			})
            // Puedes usar Transbank.POS.getPorts() para obtener lista de puertos activos en el computador
            await Transbank.POS.getPortStatus().then(async function(puertos){
                let { connected, activePort } = puertos
                console.log(connected, activePort);
                if (!connected) {
                    conn = await Transbank.POS.autoconnect().then(async (port) => {
                        if (port === false) {
                            await Swal.fire('No se encontró ningún POS', '', 'error');
                            
                            return port;
                        }
                        // this.$emit("connected", port.path)
                        await Swal.fire('Conectado', 'Dispositivo detectado y conectado: ' + port.path, 'success');
                        console.log('Puerto conectado correctamente')
                        connected = true;
                        return connected;
                    });
                }else {
                    conn = true;
                }
            })
            // console.log("puertos: ", connected)
        })
        console.log("Conn: ", conn); 
        
        if (conn) {
            
            const inputValue = montoPorPagar;
        
            let resInput = await Swal.fire({
                title: 'Desea pagar el total?',
                input: 'text',
                inputLabel: 'Monto a pagar',
                inputValue: inputValue,
                inputValidator: (value) => {
                    if (!value) {
                    return 'Necesitas ingresar un valor'
                    }
                }
                
            }).then(async (res) => {
                // await Swal.fire(res.value);
                return res;
                });
            console.log('Respuesta Input',resInput);
    
            if (resInput.isConfirmed) {
                
                
                let result = await Transbank.POS.doSale(resInput.value, 'ticket1234124').then(function(result) {
                    console.log('resultado venta: ', result)
                    Swal.fire({
                        title: result.responseMessage,
                        icon: 'success',
                        html:
                        '<b>Ultimos Digitos</b>: ' + result.last4Digits + '<br />' +
                        '<b>Codigo Autorizacion</b>: ' + result.authorizationCode + '<br />' +
                        '<b>Tipo de Tarjeta</b>: ' + result.cardType + '<br />' +
                        '<b>Monto Pagado</b>: ' + result.amount + '<br />' +
                        '<b>Cuotas</b>: ' + result.sharesNumber + '<br />',
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: false,
                        
                    })
                    return result;
                });
                // VARIABLES DESDE LA RESPUESTA DEL POS
                res = Object.entries(result)
                // console.log(result.last4Digits, result.authorizationCode, result.cardType, result.amount, result.sharesNumber);
                var dtNumTarjeta = result.last4Digits //$("#mpRedCompra_numeroTarjeta").val();
                var dtCodAutorizacion = result.authorizationCode //$("#mpRedCompra_codAutorizacion").val();
                var dtMonto = parseInt(result.amount) //parseInt($("#mpRedCompra_monto").val());
                var dtTotal = montoPorPagar
                var ctCdCuenta='Transb';
                var ctNumCuotas = result.sharesNumber;
                
                if (result.cardType == 'DB') {
                    actualizar((dtTotal-dtMonto),"3","RedCompra", dtMonto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
                    obtenerDatosPagos('DebitCard', "1", dtMonto, "redCom", dtNumTarjeta, dtCodAutorizacion, '1', "RedCom");
                } else if (result.cardType == 'CR') {
                    actualizar((dtTotal-dtMonto),"2","Credito", dtMonto); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
                    obtenerDatosPagos('CreditCard', ctNumCuotas, dtMonto, ctCdCuenta, dtNumTarjeta, dtCodAutorizacion, '2', ctCdCuenta);
                }
                // Imprimo la respuesta de la maquina por consola
                // for (let i = 0; i < res.length; i++) {
                    
                //     console.log(res[i]);
                // }
            }
        }
        
	}
    


})
