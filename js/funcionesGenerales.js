function soloNumeros(e){
	var key = window.event ? e.keyCode : e.which;
	if (e.keyCode === 8 || e.keyCode === 46
	 || e.keyCode === 37 || e.keyCode === 39
	 || e.keyCode === 107 || e.keyCode === 9) {
		return 1;
	}else if(e.keyCode === 48 || e.keyCode === 49
			|| e.keyCode === 50 || e.keyCode === 51
			|| e.keyCode === 52 || e.keyCode === 53
			|| e.keyCode === 54 || e.keyCode === 55
			|| e.keyCode === 56 || e.keyCode === 57
			|| e.keyCode === 96 || e.keyCode === 97
			|| e.keyCode === 98 || e.keyCode === 99
			|| e.keyCode === 100 || e.keyCode === 101
			|| e.keyCode === 102 || e.keyCode === 103
			|| e.keyCode === 104 || e.keyCode === 105
			|| e.keyCode === 106){
		return 1;
	}else{
		return -1;
	} 
}
//funcion para registrar fecha actual y darle formato datetime sqlserver
	function formatoFechaActual(){
		var fecha=[];
		var fechaInicio= new Date();
		var fechaAnoDiaMes=[fechaInicio.getFullYear(),fechaInicio.getMonth()+1,fechaInicio.getDate()];
		var HoraMinutoSegundo=[fechaInicio.getHours(),fechaInicio.getMinutes(),fechaInicio.getSeconds()];
		var Milisegundos=[fechaInicio.getMilliseconds()];
		fecha=fechaAnoDiaMes.join("-")+" "+HoraMinutoSegundo.join(":")+"."+Milisegundos;
		return (fecha);
	}
//FIN funcion fechaformato

function validaRut(campo){
	if ( campo.length == 0 & campo != "1-9"){ return false; }
	if ( campo.length < 8 & campo != "1-9"){ return false; }

	campo = campo.replace('-','')
	campo = campo.replace(/\./g,'')

	var suma = 0;
	var caracteres = "1234567890kK";
	var contador = 0;    
	for (var i=0; i < campo.length; i++){
	u = campo.substring(i, i + 1);
	if (caracteres.indexOf(u) != -1)
		contador ++;
	}
	if ( contador==0 ) { return false }
												
	var rut = campo.substring(0,campo.length-1)
	var drut = campo.substring( campo.length-1 )
	var dvr = '0';
	var mul = 2;
												
	for (i= rut.length -1 ; i >= 0; i--) {
	suma = suma + rut.charAt(i) * mul
		if (mul == 7) 	mul = 2
		else	mul++
		}
	res = suma % 11
	if (res==1)		dvr = 'k'
		else if (res==0) dvr = '0'
	else {
		dvi = 11-res
		dvr = dvi + ""
	}
	if ( dvr != drut.toLowerCase() ) { return false; }
	else { return true; 
	alert("valido");}
	}