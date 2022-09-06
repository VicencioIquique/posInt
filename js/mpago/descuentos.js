//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
};
function cancelar(){
	window.close();
};
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
$(document).ready(function(){
	if(bodegaD=='006'){
		$("#20").attr('disabled',false);
		$("#30").attr('disabled',false);
		$("#40").attr('disabled',false);
		$("#50").attr('disabled',false);
	}
	$(".btnDescuento").click(function(){
		var descuento = parseInt($(this).html());
		if(descuento == 0){
			valorDescuento = 0;
		}else{
			var valorDescuento = ((valorDescontar * descuento) / 100);
		}
		opener.recibirDescuento(descuento, valorDescuento, indice);
		window.close();
	});
	
	$("#cancelar").click(function(){
		cancelar();
	});
});