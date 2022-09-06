//Función para limpiar tabla
function limpiarTabla(){
	$("#tablaConStock").find("td").each(function() {
		
		   $("#tablaConStock").find("tr:gt(0)").remove();
		
	});
};
//Fin función limpiar

$(document).ready(function(){
	$("#codigoConsultaStock").focus();
	$("#codigoConsultaStock").keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 13){	
			limpiarTabla();		
			var codigo = $("#codigoConsultaStock").val();			
			$.post('script/consultaStockGen.php',{codigo:codigo}, function(res){
				var resStock = $.parseJSON(res);
				if(resStock == null){
					alert('El codigo ingresado no existe.');
					$("#codigoConsultaStock").val('');
					$("#codigoConsultaStock").focus();
				}else{
					for(i=0;i<resStock.length;i++){
						if(resStock[i]['bodega'] == '001'){
							var bodega = '1010';
						}else if(resStock[i]['bodega'] == '002'){
							var bodega = '1132';
						}else if(resStock[i]['bodega'] == '004'){
							var bodega = '184';
						}else if(resStock[i]['bodega'] == '005'){
							var bodega = '2002';
						}else if(resStock[i]['bodega'] == '006'){
							var bodega = '6115';
						}else if(resStock[i]['bodega'] == '007'){
							var bodega = '6130';
						}else if(resStock[i]['bodega'] == '008'){
							var bodega = '2077';
						}
						$("#tablaConStock tr:last").after('<tr><td>'+resStock[i]['articulo']+'</td>'+
																'<td>'+resStock[i]['codigo']+'</td>'+
																'<td>'+resStock[i]['descripcion']+'</td>'+
																'<td>'+resStock[i]['marca']+'</td>'+
																'<td>'+bodega+'</td>'+
																'<td>'+resStock[i]['cantidad']+'</td>'+
																'</tr>');
					}
					$("#codigoConsultaStock").val('');
				}
				
			});
		}
	});
	$("#btnCerrar").click(function(){
		window.close();
	});
});