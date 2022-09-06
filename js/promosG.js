var contadorG4;
var contadorG5;
var contadorG6;
var contadorG7;
var contadorG8;
var cantPromosG4;
var cantPromosG5;
var cantPromosG6;
var cantPromosG7;
var cantPromosG8;
var cantNoPromosG4;
var cantNoPromosG5;
var cantNoPromosG6;
var cantNoPromosG7;
var cantNoPromosG8;
var totalMonto;
function cambiarFilasDecimales(indice1,indice2){
		
	//-----------------------------------------------------------------------------------------------------------
		var filaDecimal1=parseInt($("#tabla tbody tr:eq("+((indice1)+1)+")").find("td").eq(11).html()); // se redondea hacia abajo
		var filaNoDecimal1=parseInt($("#tabla tbody tr:eq("+((indice1)+1)+")").find("td").eq(13).html());
		var filaDecimal2=Math.floor(parseInt($("#tabla tbody tr:eq("+((indice2)+1)+")").find("td").eq(11).html())); // se le suma 1
		filaDecimal2=parseInt(filaDecimal2)+1;
		var filaNoDecimal2=parseInt($("#tabla tbody tr:eq("+((indice2)+1)+")").find("td").eq(13).html());
		var precioFinal1=filaDecimal1+parseInt(filaNoDecimal1);
		var precioFinal2=filaDecimal2+parseInt(filaNoDecimal2);
		$("#tabla tbody tr:eq("+((indice1)+1)+")").find("td").eq(11).html(filaDecimal1); // asignar el nuevo precio de promo
		$("#tabla tbody tr:eq("+((indice2)+1)+")").find("td").eq(11).html(filaDecimal2); //asignar el nuevo precio promo a la segunda fila
		$("#tabla tbody tr:eq("+((indice1)+1)+")").find("td").eq(8).html(precioFinal1);
		$("#tabla tbody tr:eq("+((indice2)+1)+")").find("td").eq(8).html(precioFinal2);
		tablaProdVFinal[indice1]=precioFinal1;
		tablaProdVFinal[indice2]=precioFinal2;
	//-------------------------------------------------------------------------------------------------------------
}
function cambiarDecimales(){
	var vectorIndicesConDecimales=[];
	var contador=0;
	for(var t=0;t<tablaProdNum.length;t++){                   // contar cuantos decimales hay en las filas
		var colPromocion=parseFloat($("#tabla tbody tr:eq("+(t+1)+")").find("td").eq(11).html());
		if(tablaItemTipo[t]=='G8' && colPromocion%1 != 0){			// SOLO EN G8 PARA este caso
			vectorIndicesConDecimales.push(t);                  // almacena los indices con decimales
		}
	}
	for(var t=0;t<vectorIndicesConDecimales.length;t=t+2){
		cambiarFilasDecimales(vectorIndicesConDecimales[t],vectorIndicesConDecimales[t+1]);
	}
}

function CalcularTotalMonto(){
	totalMonto=0;
	for(var t=0;t<tablaProdNum.length;t++){
		totalMonto=parseInt(totalMonto)+parseInt(tablaProdVFinal[t]);
	}
	$("#totalMPago").val(totalMonto); //asignar el valor de la variable total al input hidden #totalMPago para enviarlo a medio de pago
	$("#total").val(totalMonto); //Asignar el valor sumado en el acumulador 'total' y asignarlo al campo TOTAL
}
function contarG(){
	for(i=0;i<tablaProdNum.length;i++){
		if(tablaItemTipo[i]=='G4'){
		  contadorG4=parseInt(contadorG4)+parseInt(tablaProdCantidad[i]);
		}
		else if(tablaItemTipo[i]=='G5'){
		  contadorG5=parseInt(contadorG5)+parseInt(tablaProdCantidad[i]);
		}else if(tablaItemTipo[i]=='G6'){
			contadorG6=parseInt(contadorG6)+parseInt(tablaProdCantidad[i]);
		}else if(tablaItemTipo[i]=='G7'){
			contadorG7=parseInt(contadorG7)+parseInt(tablaProdCantidad[i]);
		}else if(tablaItemTipo[i]=='G8'){
			contadorG8=parseInt(contadorG8)+parseInt(tablaProdCantidad[i]);
		}
	}
	calcularCantPromos();
}
function calcularCantPromos(){
	//-------------------------------------------------------
	cantPromosG4=Math.floor(contadorG4/2);
	cantPromosG4 = cantPromosG4*2;
	cantNoPromosG4= contadorG4%2;
	//-------------------------------------------------------
	cantPromosG5=Math.floor(contadorG5/2);
	cantPromosG5 = cantPromosG5*2;
	cantNoPromosG5= contadorG5%2;
	//-------------------------------------------------------
	cantPromosG6=Math.floor(contadorG6/2);
	cantPromosG6 = cantPromosG6*2;
	cantNoPromosG6= contadorG6%2;
	//-------------------------------------------------------
	cantPromosG7=Math.floor(contadorG7/3)
	cantPromosG7 = cantPromosG7*3;
	cantNoPromosG7= contadorG7%3;
	//-------------------------------------------------------
	cantPromosG8=Math.floor(contadorG8/4)
	cantPromosG8 = cantPromosG8*4;
	cantNoPromosG8= contadorG8%4;
}

//---------------------------------------------------------------------APLICAR LA PROMOCION G4 (2 x 45000)------------------------------
function aplicarG4(cantidad,valorOriginal){
	var precioTotal=0;
	var valorG4=22500; // unitario 
	var itemAplicarPromo=0;
	var itemValorOriginal=0;
	if(cantidad<=cantPromosG4){
		itemAplicarPromo=cantidad;
		precioTotal=(parseInt(itemAplicarPromo*valorG4))
		
	}else{
		itemAplicarPromo=cantPromosG4; // se les aplicara a los items las promociones que falten;
		itemValorOriginal=cantidad-itemAplicarPromo; // cantidad de items que se aplicara el valor original
		precioTotal=(parseInt(itemAplicarPromo*valorG4))+(parseInt(itemValorOriginal*valorOriginal));
	}		
	
	return(precioTotal+"-"+itemAplicarPromo+'-'+itemValorOriginal+'-'+valorG4);	
}
//-------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------APLICAR LA PROMOCION G5 (2 x 35990)------------------------------
function aplicarG5(cantidad,valorOriginal){
	var precioTotal=0;
	var valorG5=17995; // unitario 
	var itemAplicarPromo=0;
	var itemValorOriginal=0;
	if(cantidad<=cantPromosG5){
		itemAplicarPromo=cantidad;
		precioTotal=(parseInt(itemAplicarPromo*valorG5))
		
	}else{
		itemAplicarPromo=cantPromosG5; // se les aplicara a los items las promociones que falten;
		itemValorOriginal=cantidad-itemAplicarPromo; // cantidad de items que se aplicara el valor original
		precioTotal=(parseInt(itemAplicarPromo*valorG5))+(parseInt(itemValorOriginal*valorOriginal));
	}		
	
	return(precioTotal+"-"+itemAplicarPromo+'-'+itemValorOriginal+'-'+valorG5);
}
//-------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------APLICAR LA PROMOCION G6 (2 x 24990)------------------------------
function aplicarG6(cantidad,valorOriginal){
	var precioTotal=0;
	var valorG6=12495; // unitario 
	var itemAplicarPromo=0;
	var itemValorOriginal=0;
	if(cantidad<=cantPromosG6){
		itemAplicarPromo=cantidad;
		precioTotal=(parseInt(itemAplicarPromo*valorG6))
		
	}else{
		itemAplicarPromo=cantPromosG6; // se les aplicara a los items las promociones que falten;
		itemValorOriginal=cantidad-itemAplicarPromo; // cantidad de items que se aplicara el valor original
		precioTotal=(parseInt(itemAplicarPromo*valorG6))+(parseInt(itemValorOriginal*valorOriginal));
	}		
	
	return(precioTotal+"-"+itemAplicarPromo+'-'+itemValorOriginal+'-'+valorG6);
}
//-------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------APLICAR LA PROMOCION G7 (3 x 21990)------------------------------
function aplicarG7(cantidad,valorOriginal){
	var precioTotal=0;
	var valorG7=7330; // unitario 
	var itemAplicarPromo=0;
	var itemValorOriginal=0;
	if(cantidad<=cantPromosG7){
		itemAplicarPromo=cantidad;
		precioTotal=(parseInt(itemAplicarPromo*valorG7))
		
	}else{
		itemAplicarPromo=cantPromosG7; // se les aplicara a los items las promociones que falten;
		itemValorOriginal=cantidad-itemAplicarPromo; // cantidad de items que se aplicara el valor original
		precioTotal=(parseInt(itemAplicarPromo*valorG7))+(parseInt(itemValorOriginal*valorOriginal));
	}		
	
	return(precioTotal+"-"+itemAplicarPromo+'-'+itemValorOriginal+'-'+valorG7);	
}
//-------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------APLICAR LA PROMOCION G7 (4 x 17990)------------------------------
function aplicarG8(cantidad,valorOriginal){
	var precioTotal=0;
	var valorG8=4497.5; // unitario
	var itemAplicarPromo=0;
	var itemValorOriginal=0;
	if(cantidad<=cantPromosG8){
		itemAplicarPromo=cantidad;
		precioTotal=(parseInt(itemAplicarPromo*valorG8))
		
	}else{
		itemAplicarPromo=cantPromosG8; // se les aplicara a los items las promociones que falten;
		itemValorOriginal=cantidad-itemAplicarPromo; // cantidad de items que se aplicara el valor original
		precioTotal=(parseInt(itemAplicarPromo*valorG8))+(parseInt(itemValorOriginal*valorOriginal));
	}		
	
	return(precioTotal+"-"+itemAplicarPromo+'-'+itemValorOriginal+'-'+valorG8);	
}
//-------------------------------------------------------------------------------------------------------------------------------------
function actualizarG(){	// NOTA : LAS FILAS DE LA TABLA ESTAN DADOS POR DEL 1 Y LAS COLUMNAS ESTAN DEL 0 AL 13 XD QLS QUE NO MANTIENEN LA WEA	
	contadorG4 =0;
	contadorG5 =0;
	contadorG6 =0;
	contadorG7 =0;
	contadorG8 =0;
	cantPromosG4=0;
	cantPromosG5=0;
	cantPromosG6=0;
	cantPromosG7=0;
	cantPromosG8=0;
	cantNoPromosG4=0;
	cantNoPromosG5=0;
	cantNoPromosG6=0;
	cantNoPromosG7=0;
	cantNoPromosG8=0;
	
	var tamTabla = $("#tabla tbody tr").length;
	totalMonto=0;
	contarG();// CONTAR LAS CANTIDADES DE ARTICULOS CON G5 G6 G7 G8 
	
	for(var i=1;i<tamTabla;i++){
		var cantidad = $("#tabla tbody tr:eq("+i+")").find("td").eq(4).html();// asignar a la variable cantidad de la tabla cant en la posicion del for
		var valorOriginal = $("#tabla tbody tr:eq("+i+")").find("td").eq(7).html(); // asignar a la variable valorOriginal de la tabla cant en la posicion del for
		var descuento= parseInt($("#tabla tbody tr:eq("+i+")").find("td").eq(5).html());
		var descPorcentual= parseInt($("#tabla tbody tr:eq("+i+")").find("td").eq(6).html());
		//--------------------------------------------------------------------------------------------------------------------------		
		if(contadorG4 > 0 && tablaItemTipo[i-1]=='G4'){	
			vectorPromocion = aplicarG4(cantidad,valorOriginal).split('-');
			precioExtendido=vectorPromocion[0], cantidadPromo=vectorPromocion[1],cantidadNoPromo = vectorPromocion[2],precioPromo = vectorPromocion[3];
			descuento=0;
			descPorcentual=0;
			//alert("fila : "+i+ " quedan por aplicar : "+cantPromosG7+" y faltan por aplicar valor original a :"+cantNoPromosG7+"precioExtendido ="+precioExtendido);
			cantPromosG4=cantPromosG4-cantidadPromo;
			cantNoPromosG4=cantNoPromosG4-cantidadNoPromo;		
		}else if(contadorG5 > 0 && tablaItemTipo[i-1]=='G5'){	
			vectorPromocion = aplicarG5(cantidad,valorOriginal).split('-');
			precioExtendido=vectorPromocion[0], cantidadPromo=vectorPromocion[1],cantidadNoPromo = vectorPromocion[2],precioPromo = vectorPromocion[3];
			descuento=0;
			descPorcentual=0;
			//alert("fila : "+i+ " quedan por aplicar : "+cantPromosG7+" y faltan por aplicar valor original a :"+cantNoPromosG7+"precioExtendido ="+precioExtendido);
			cantPromosG5=cantPromosG5-cantidadPromo;
			cantNoPromosG5=cantNoPromosG5-cantidadNoPromo;		
		}else if(contadorG6 > 0 && tablaItemTipo[i-1]=='G6'){	
			vectorPromocion = aplicarG6(cantidad,valorOriginal).split('-');
			precioExtendido=vectorPromocion[0], cantidadPromo=vectorPromocion[1],cantidadNoPromo = vectorPromocion[2],precioPromo = vectorPromocion[3];
			descuento=0;
			descPorcentual=0;
			//alert("fila : "+i+ " quedan por aplicar : "+cantPromosG7+" y faltan por aplicar valor original a :"+cantNoPromosG7+"precioExtendido ="+precioExtendido);
			cantPromosG6=cantPromosG6-cantidadPromo;
			cantNoPromosG6=cantNoPromosG6-cantidadNoPromo;		
		}else if(contadorG7 > 0 && tablaItemTipo[i-1]=='G7'){	
			vectorPromocion = aplicarG7(cantidad,valorOriginal).split('-');
			precioExtendido=vectorPromocion[0], cantidadPromo=vectorPromocion[1],cantidadNoPromo = vectorPromocion[2],precioPromo = vectorPromocion[3];
			descuento=0;
			descPorcentual=0;
			//alert("fila : "+i+ " quedan por aplicar : "+cantPromosG7+" y faltan por aplicar valor original a :"+cantNoPromosG7+"precioExtendido ="+precioExtendido);
			cantPromosG7=cantPromosG7-cantidadPromo;
			cantNoPromosG7=cantNoPromosG7-cantidadNoPromo;		
		}else if(contadorG8 > 0 && tablaItemTipo[i-1]=='G8'){	
			vectorPromocion = aplicarG8(cantidad,valorOriginal).split('-');
			precioExtendido=vectorPromocion[0], cantidadPromo=vectorPromocion[1],cantidadNoPromo = vectorPromocion[2],precioPromo = vectorPromocion[3];
			descuento=0;
			descPorcentual=0;
			//alert("fila : "+i+ " quedan por aplicar : "+cantPromosG7+" y faltan por aplicar valor original a :"+cantNoPromosG7+"precioExtendido ="+precioExtendido);
			cantPromosG8=cantPromosG8-cantidadPromo;
			cantNoPromosG8=cantNoPromosG8-cantidadNoPromo;		
		}						
		else{ // productos sin promociones navideñas
			precioExtendido = parseInt($("#tabla tbody tr:eq("+i+")").find("td").eq(8).html());
			var cantidadPromo =0;
			var precioPromo =0;
			var cantidadNoPromo=cantidad;			
		}
//------------------------------------------------------------------------------------------------------------------------------------------------------------
		$("#tabla tbody tr:eq("+i+")").find("td").eq(5).html(descuento);
		$("#tabla tbody tr:eq("+i+")").find("td").eq(6).html(descPorcentual);
		$("#tabla tbody tr:eq("+i+")").find("td").eq(7).html(tablaProdVOrig[i-1]);
		$("#tabla tbody tr:eq("+i+")").find("td").eq(8).html(precioExtendido);
		$("#tabla tbody tr:eq("+i+")").find("td").eq(10).html(cantidadPromo).hide();
		$("#tabla tbody tr:eq("+i+")").find("td").eq(11).html(precioPromo*cantidadPromo).hide();
		$("#tabla tbody tr:eq("+i+")").find("td").eq(12).html(cantidadNoPromo).hide();
		$("#tabla tbody tr:eq("+i+")").find("td").eq(13).html(parseInt(cantidadNoPromo * valorOriginal)).hide();
			
		// ACTUALIZAR VECTORES
		tablaCantPromos[i-1] = cantidadPromo;
		tablaCantNoPromos[i-1] = cantidadNoPromo;
		tablaProdVFinal[i-1] = precioExtendido;
		
		//-------------------------------------------------
	}
			cambiarDecimales();
			CalcularTotalMonto();
};
