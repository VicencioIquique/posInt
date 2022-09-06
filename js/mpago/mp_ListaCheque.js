function cancelar(){
	window.close();
};
$(document).ready(function(){
	$("#rutCliente").val(rutCliente);
	$("#nombreCliente").val(nombreCliente);	
	//Atajos
	$(document).keydown(function(e){
	var code = e.keyCode || e.which;
	if(code == 122){ //F11 - IMPRIMIR
		$("#mpListaCheque_imprimir").click();
		return false;
	}
	if(code == 114){ //F3 - CANCELAR
		$("#mpListaCheque_volver").click();
		return false;
	}
	});
	
	//Ingresar los datos a la tabla
	for(i=0;i<contVectorJS;i++){
			if(tipoPago[i]=='Payments' || tipoPago[i]=='Check'){
				if(tipoPago[i]=='Payments'){
					var tipoPagoC = 'Cheque a fecha';
				}else if(tipoPago[i]=='Check'){
					var tipoPagoC = 'Cheque al día';
				}
				fechaCheque[i] = fechaCheque[i].split(' ');
				$("#tablaCheques tr:last").after('<tr>'+
									'<td>'+desc1[i]+'</td>'+
									'<td>'+desc2[i]+'</td>'+
									'<td>'+numeroDoc[i]+'</td>'+
									'<td>'+fechaCheque[i][0]+'</td>'+
									'<td>'+monto[i]+'</td>'+
									'<td>'+desc3[i]+'</td>'+
									'<td>'+tipoPagoC+'</td>'+							
									'</tr>');		
			}
	}
	$("#mpListaCheque_volver").click(function(){
		cancelar();
	});
	$("#mpListaCheque_imprimir").click(function(){
		$("#printTabla").print(); // IMPRIMIR TABLA DE CHEQUES
	});
	
});