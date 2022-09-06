$(document).on('click', '#menuIntegrado',async  function () {
    console.log("Hola");
    $("#integradoModal").modal("show");
    $("#integradoModal").on('shown.bs.modal',async  function(event) { // funcion para cuando se abra el modal
        console.log("Modal Abierto");
    });

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
            console.log("puertos: ", connected)
        })
    })
    console.log("Conn: ", conn); 
    
    

});

$(document).on('click', '#cierre', async function () {

    Transbank.POS.closeDay().then(function(closeResponse) {
        console.log('resultado cierre: ', closeResponse)
    });

})

$(document).on('click', '#cargaLlaves', async function () {

    Transbank.POS.getKeys().then((response) => {
        console.log(response);
    })

})

$(document).on('click', '#detalle', async function () {

    Transbank.POS.getDetails(this.printOnPos).then((response) => {
        console.log(response);
    })

})


$(document).on('click', '#totalVentas', async function () {
    Transbank.POS.getTotals().then((response) => {
        console.log(response);
    })
})

$(document).on('click', '#ultimaVenta', async function () {
    Transbank.POS.getLastSale().then((response) => {
        console.log(response);
    })
})

$(document).on('click', '#modoNormal', async function () {
    Transbank.POS.setNormalMode().then((response) => {
        console.log(response);
    })
})

$(document).on('click', '#polling', async function () {
    Transbank.POS.poll().then((response) => {
        console.log(response);
    })
})

$(document).on('click', '#refund', async function () {

    let resInput = await Swal.fire({
        title: 'Desea Anular la venta?',
        input: 'text',
        inputLabel: 'Ingrese Numero de Operación',
        inputValue: "",
        inputValidator: (value) => {
            if (!value) {
            return 'Necesitas ingresar un valor'
            }
        }
        
    }).then(async (res) => {
        // await Swal.fire(res.value);
        return res;
        });
    console.log('Respuesta Anulación',resInput);

    Transbank.POS.refund(resInput.value).then((response) => {
        console.log(response);
    })
})