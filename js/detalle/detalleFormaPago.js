$(document).ready(function(){
	$.post('script/obtenerDetalleFormaPago.php', {bodega:bodega, workstation:workstation, numeroDocto: numeroDocto, tipoDocto: tipoDocto}, function(res){
		var resDetalleFP = $.parseJSON(res);
		var cuotas;
		var numTarjeta;
		var codAut;
		var tipoDoctoNombre;
		for(i=0;i<resDetalleFP.length;i++){
			var fechaSplit = resDetalleFP[i]['FechaDoc'].split(' ');
			if(resDetalleFP[i]['TipoDocto'] == 1){
				tipoDoctoNombre = 'Boleta Fiscal';
			}else if(resDetalleFP[i]['TipoDocto'] == 2){
				tipoDoctoNombre = 'Factura';
			}else if(resDetalleFP[i]['TipoDocto'] == 3){
				tipoDoctoNombre = 'Nota de crédito';
			}else if(resDetalleFP[i]['TipoDocto'] == 4){
				tipoDoctoNombre = 'Boleta Manual';
			}
			
			if(resDetalleFP[i]['TipoPago'] == 'CreditCard'){
				cuotas = resDetalleFP[i]['Cuotas'];
				numTarjeta = resDetalleFP[i]['NumTarjeta'];
				codAut = resDetalleFP[i]['CodAut'];
			}else if(resDetalleFP[i]['TipoPago'] == 'DebitCard'){
				cuotas = '-';
				numTarjeta = resDetalleFP[i]['NumTarjeta'];
				codAut = resDetalleFP[i]['CodAut'];
			}else{
				cuotas = '-';
				numTarjeta = '-';
				codAut = '-';		
			}
			$("#tablaDetFormaPago tbody tr:last").after(
				'<tr>'+
					'<td>'+resDetalleFP[i]['Secuencia']+'</td>'+
					'<td>'+tipoDoctoNombre+'</td>'+
					'<td>'+resDetalleFP[i]['NumeroDocto']+'</td>'+
					'<td>'+resDetalleFP[i]['TipoPago']+'</td>'+
					'<td>'+cuotas+'</td>'+
					'<td>'+fechaSplit[0]+'</td>'+
					'<td>'+resDetalleFP[i]['Monto']+'</td>'+
					'<td>'+numTarjeta+'</td>'+
					'<td>'+codAut+'</td>'+
				'</tr>'
				);
		}
	});
	
	$("#btnCerrar").click(function(){
		window.close();
	});
});