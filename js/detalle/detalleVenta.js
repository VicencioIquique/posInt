$(document).ready(function(){
	$.post('script/obtenerDetalleVenta.php', {bodega:bodega, workstation:workstation, numeroDocto: numeroDocto, tipoDocto: tipoDocto}, function(res){
		var resDetalleV = $.parseJSON(res);
		var cuotas;
		var tipoDoctoNombre;
		var acumPrecioFinal = 0;
		for(i=0;i<resDetalleV.length;i++){
			if(resDetalleV[i]['TipoDocto'] == 1){
				tipoDoctoNombre = 'Boleta Fiscal';
			}else if(resDetalleV[i]['TipoDocto'] == 2){
				tipoDoctoNombre = 'Factura';
			}else if(resDetalleV[i]['TipoDocto'] == 3){
				tipoDoctoNombre = 'Nota de crédito';
			}else if(resDetalleV[i]['TipoDocto'] == 4){
				tipoDoctoNombre = 'Boleta Manual';
			}
			
			$("#tablaDetVenta tbody tr:last").after(
				'<tr>'+
					'<td>'+resDetalleV[i]['Secuencia']+'</td>'+
					'<td>'+tipoDoctoNombre+'</td>'+
					'<td>'+resDetalleV[i]['NumeroDocto']+'</td>'+
					'<td>'+resDetalleV[i]['ProductoID']+'</td>'+
					'<td>'+resDetalleV[i]['Sku']+'</td>'+
					'<td>'+resDetalleV[i]['Descripcion']+'</td>'+
					'<td>'+resDetalleV[i]['Cantidad']+'</td>'+
					'<td>'+resDetalleV[i]['Descuento']+'</td>'+
					'<td>'+resDetalleV[i]['PrecioOriginal']+'</td>'+
					'<td>'+resDetalleV[i]['PrecioFinal']+'</td>'+
					'<td>'+resDetalleV[i]['Vendedor']+'</td>'+
				'</tr>'
				);
			acumPrecioFinal = acumPrecioFinal + parseInt(resDetalleV[i]['PrecioFinal']);
		}
		$("#tablaDetVenta tfoot tr:last").after(
			'<tr>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td><strong>Total</strong></td>'+
				'<td><strong>'+acumPrecioFinal+'</strong></td>'+
				'<td></td>'+
			'</tr>'
			);
	});
	
	$("#btnCerrar").click(function(){
		window.close();
	});
});