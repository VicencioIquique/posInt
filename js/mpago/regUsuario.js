$(document).ready(function(){
	$( "#regUsuario_RUT" ).focusout(function() {
	var rut = $( "#regUsuario_RUT" ).val();
	if(validaRut(rut)){
	}else{
		alert("Rut Invalido, Por favor Ingrese un Rut Valido");
		$( "#regUsuario_RUT" ).val("");		
	}
	});
	
	//Función para validación de datos de formulario
	$('#formUsuario').bootstrapValidator({
        feedbackIcons: {
            required: 'glyphicon glyphicon-asterisk',
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nombre: {
                selector: '#regUsuario_nombre',
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese un valor a este campo.'
                    }
                }
            },
			
			mail:{
				selector: '#regUsuario_correo',
				validators: {
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'Esta no es una dirección de correo válida.'
                    }
                }
			}
        },
        onSuccess: function (e) { 
			/*Respuestas Usuario
				1: Usuario ya existente en BD - agregarUsuario.php
				2: Usuario actualizado correctamente - actualizarUsuario.php
				3: Problema al actualizar usuario - actualizarUsuario.php
				4: Usuario agregado correctamente - agregarUsuario.php
				5: Problema al agregar usuario - agregarUsuario.php
			*/
            e.preventDefault();
			var RUT = $("#regUsuario_RUT").val(); 
			var nombre = $("#regUsuario_nombre").val();
			
			//Agregar acá función para insertar en BD
			$.post('script/agregarUsuario.php', {rut:RUT, nombre:nombre}, function(res){
				if(res == 1){
					var rut = $("#regUsuario_RUT").val();
					var nombres = $("#regUsuario_nombre").val();
					var direccion = $("#regUsuario_direccion").val();
					var ciudad = $('#regUsuario_ciudad option:selected').text();
					var telefono = $("#regUsuario_telefono").val();
					var email = $("#regUsuario_correo").val();
					
					var jsonUsuario = {
						rut:rut,
						nombres:nombres,
						direccion:direccion,
						ciudad:ciudad,
						telefono:telefono,
						email:email
					};
					console.log("El usuario que está ingresando ya existe en la base de datos de clientes");
					$.post('script/actualizarUsuario.php', {jsonUsuario:jsonUsuario}, function(resAc){
						if(resAc == 2){
							alert("Usuario actualizado correctamente");
							opener.actualizarInfoUsuario(rut,nombres); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
							window.close();
						}else if(resAc== 3){
							alert("Problema al actualizar el usuario, por favor inténtelo de nuevo");
						}
					});
				}else{
					if(res == 4){
						alert("Usuario agregado correctamente");
						opener.actualizarInfoUsuario(rut,nombres); //funcion opener para llegar al padre y actualizar médoto contenido en el padre
						window.close();
					}else if(res == 5){
						alert("Problema al agregar el usuario, por favor inténtelo de nuevo");
					}
				}
				//FIN FUNCION PARA ENTERVAR VALOR A LA VENTANA PADRE
				
				//window.close(); //cerrar ventana actual
			});
			$("#regUsuario_aceptar").attr('disabled',false);
        }
    });
	
	
	$("#regUsuario_RUT").focus();
	
	
	/*FUNCIÓN PARA CAPTURAR TECLAS DE ATAJOS PARA EL SISTEMA*/
	/*Lista keyCode 
		F1:		112
		F2: 	113
		F3: 	114
		F4: 	115
		F5: 	116
		F6: 	117
		F7: 	118
		F8: 	119
		F9: 	120
		F10: 	121
		F11:	122
		F12:	123
	*/
	
	
	//Botón cancelar
	$("#regUsuario_cancelar").click(function(){
		window.close();
	});
	
	//Cargar usuario si ya existe en la base de datos
	$("#regUsuario_RUT").focusout(function(){
		var rut = $("#regUsuario_RUT").val();
		$.post('script/buscarUsuario.php', {rut:rut}, function(res){
			var usuario = $.parseJSON(res);
			if(usuario){
				$("#regUsuario_nombre").val(usuario['nombres']);
				$("#regUsuario_direccion").val(usuario['direccion']);
				$('#regUsuario_ciudad option:selected').text(usuario['ciudad']);
				$("#regUsuario_telefono").val(usuario['telefono']);
				$("#regUsuario_correo").val(usuario['email'])
				$("#regUsuario_empresa").val(usuario['empresa'])
			}else{
				$("#regUsuario_RUT").val(rut);
			}
		});
	});
	
	$(document).keydown(function(e){
		var code = e.keyCode || e.which;
		if(code == 113){
			$("#mpEfectivo_aceptar").click();
		}		
	});
	/*FIN FUNCION PARA CAPTURAR TECLAS*/
	
	//CONTROLAR SOLO NUMEROS
	$("#regUsuario_telefono").keydown(function(e){
		var num  = soloNumeros(e);
		if(num == -1){
			return false;
		}
	});
	
});