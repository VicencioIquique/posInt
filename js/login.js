$(document).ready(function(){
	$("#btn_login").click(function(){
		var usuario = $("#usuario").val();
		var pass = $("#pass").val();
		alert(usuario);
		alert(pass);
		$.post("script/obtenerUsuario.php",{usuario:usuario,pass:pass},function(res){
			if(res == 1){
				location.href = "menu.php";
			}else{
				alert("Usuario o Contraseña Invalida");
			}
			alert(res);	
		});// primer argumento archivo php segundo los datos que se enviaran por esta funcion tercero respuesta de php
	});
	
	$("#pass").keydown(function(e){
		var code = e.keyCode || e.which;                              
		if(code == 13){
			$("#btn_login").click();
		}
		
	});
	$("#usuario").keydown(function(e){
		var code = e.keyCode || e.which;                              
		if(code == 13){
			$("#btn_login").click();
		}
		
	});
});