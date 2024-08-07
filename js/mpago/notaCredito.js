//FUNCIÓN PARA ENTREGAR VALOR A LA VENTANA PADRE con la info actual
function aceptar(){
	var bodega = $("#bodega").val();
	var workstation = $("#workstation").val();
	var numeroDocto = $("#numeroDocto").val();
	var tipoDocto = $("#tipoDocto").val();
	if ($("#cmbNcRazon").val()=='Otras'){
		var razonNCredito = $("#txtNcRazon").val();
	}else{
		var razonNCredito = $("#cmbNcRazon").val();
	}
	if(bodega != '' && workstation != '' && numeroDocto != '' && tipoDocto != ''){
		opener.notaCreditoValores(numeroDocto, bodega, workstation,tipoDocto,razonNCredito);
		window.close();
	}else{
		alert("Primero complete todos los campos antes de continuar.");
		return false;
	}
	
}
function cancelar(){
	window.close();
};
//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
$(document).ready(function(){
$("#txtNcRazon").hide();
	$("#bodega").change(function(){
		var bodega = $("#bodega").val();
		if(bodega == '001'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
		}else if(bodega == '002'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
			$("#workstation").append('<option value="3">3</option>');
			$("#workstation").append('<option value="4">4</option>');
			$("#workstation").append('<option value="5">5</option>');
			$("#workstation").append('<option value="6">6</option>');
			$("#workstation").append('<option value="7">7</option>');
			$("#workstation").append('<option value="8">8</option>');
		}else if(bodega == '004'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
		}else if(bodega == '005'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
			$("#workstation").append('<option value="3">3</option>');
		}else if(bodega == '006'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
		}else if(bodega == '007'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
		}else if(bodega == '008'){
			$("#workstation").empty();
			$("#workstation").append('<option value=""> </option>');
			$("#workstation").append('<option value="1">1</option>');
			$("#workstation").append('<option value="2">2</option>');
			$("#workstation").append('<option value="3">3</option>');
		}
	});
	$("#cmbNcRazon").change(function(){
		if ($("#cmbNcRazon").val()=='Otras'){
			$("#txtNcRazon").show();
		}else{
			$("#txtNcRazon").hide();
		}
	});
	
	$("#aceptar").click(function(){
		aceptar();
	});
	
	$("#cancelar").click(function(){
		cancelar();
	});
	
	$("#numeroDocto").keydown(function(e){
		var code = e.keyCode || e.which;                               
		if(code == 13){ 
			aceptar();
		}else{
			var num  = soloNumeros(e);
			if(num == -1){
				return false;
			}
		}
	});
});