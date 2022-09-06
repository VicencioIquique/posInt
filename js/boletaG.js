var contaG4;
var contaG5;
var contaG6;
var contaG7;
var contaG8;
var contaNoG; // cantidad de items en la fial sin promocion


function itemsBoleta(){
	var tablaProdCantidadSplit = tablaProdCantidad.split(",");
	var tablaCantNoPromosSplit=tablaCantNoPromos.split(",");
	//alert("NO PROMOS = "+contaNoG+"PROMOS = ");
	contarPromos();
	itemProductos="";
	if(contaG4>0){
		itemProductos=itemProductos+ItemsG4();
	}
	if(contaG5>0){
		itemProductos=itemProductos+ItemsG5();
	}
	if(contaG6>0){
		itemProductos=itemProductos+ItemsG6();
	}
	if(contaG7>0){
		itemProductos=itemProductos+ItemsG7();
	}
	if(contaG8>0){
		itemProductos=itemProductos+ItemsG8();
	}
	if(contaNoG>0){
		for(var i=0;i<tablaProdCantidadSplit.length;i++){
			//alert("NO PROMOS = "+tablaCantNoPromosSplit[i]+"PROMOS = "+tablaCantPromosSplit[i]);
			if(tablaCantNoPromosSplit[i]>0){
				itemProductos = itemProductos+itemsNoG(i);
			}
		}
	}
return(itemProductos);
}
function itemsNoG(indiceT){
		var tablaItemTipoSplit = tablaItemTipo.split(",");
		var tablaCantPromosSplit=tablaCantPromos.split(",");
		var tablaCantNoPromosSplit=tablaCantNoPromos.split(",");
		var tablaProdDescSplit = tablaProdDesc.split(",");
		var tablaProdVOrigSplit = tablaProdVOrig.split(",");
		var tablaProdCantidadSplit = tablaProdCantidad.split(",");
		var tablaProdDsctoSplit = tablaProdDscto.split(",");
		var tablaProdVFinalSplit = tablaProdVFinal.split(",");
		var tablaProdALUSplit = tablaProdALU.split(",");
		var tablaProdMarcaSplit = tablaProdMarca.split(",");
	
//----------------------codigo para admitir el 50% --------------------Cuando un producto tenga mas del 50% de descuento la impresora fiscal lo mostrará como valor original, pero se insertara en el repo como descuento del 50 o mas
	var valorOriginalTotal = parseInt(tablaCantNoPromosSplit[indiceT]) * parseInt(tablaProdVOrigSplit[indiceT]);
	var porcentajeDescuento = ((parseInt(tablaProdVFinalSplit[indiceT]*100))/valorOriginalTotal);
	var descuentoProducto = tablaProdDsctoSplit[indiceT];
	var valorFinalProducto = tablaProdVFinalSplit[indiceT];
	var valorOriginalProducto = tablaProdVOrigSplit[indiceT];
	if (parseInt(porcentajeDescuento) <50 && parseInt(valorFinalProducto) > 10){
		
		descuentoProducto = 0;
		valorFinalProducto = tablaCantNoPromosSplit[indiceT]*tablaProdVOrigSplit[indiceT];
		valorOriginalProducto = (tablaProdVFinalSplit[indiceT]/tablaCantNoPromosSplit[indiceT]);
	}
//----------------------------------------------------FIN--------------------------------------------
	var itemProducto="";
		itemProducto = '<Item>'+'<Codigo></Codigo>'+
												'<Descripcion>'+tablaProdALUSplit[indiceT]+' '+tablaProdDescSplit[indiceT]+' '+tablaProdMarcaSplit[indiceT]+'</Descripcion>'+
												'<Precio>'+valorOriginalProducto+'</Precio>'+
												'<Cantidad>'+tablaCantNoPromosSplit[indiceT]+'</Cantidad>'+
												'<MonDescuento>'+descuentoProducto+'</MonDescuento>'+
												'<DesDescuento></DesDescuento>'+
												'<Total>'+valorFinalProducto+'</Total>'+
											    '</Item>';
												

	return(itemProducto);
		
}

function ItemsG4(){
	var itemsprodG4="";
	itemsprodG4 = itemsprodG4 + '<Item>'+
												'<Codigo></Codigo>'+
												'<Descripcion>'+generarDescripcionG4()+'</Descripcion>'+
												'<Precio>'+45000+'</Precio>'+
												'<Cantidad>'+contaG4/2+'</Cantidad>'+
												'<MonDescuento>0</MonDescuento>'+
												'<DesDescuento>'+'0'+'</DesDescuento>'+
												'<Total>'+45000*contaG4/2+'</Total>'+
											    '</Item>';

	return(itemsprodG4);
		
}
function ItemsG5(){
	var itemsprodG5="";
	itemsprodG5 = itemsprodG5 + '<Item>'+
												'<Codigo></Codigo>'+
												'<Descripcion>'+generarDescripcionG5()+'</Descripcion>'+
												'<Precio>'+35990+'</Precio>'+
												'<Cantidad>'+contaG5/2+'</Cantidad>'+
												'<MonDescuento>0</MonDescuento>'+
												'<DesDescuento>'+'0'+'</DesDescuento>'+
												'<Total>'+35990*contaG5/2+'</Total>'+
											    '</Item>';

	return(itemsprodG5);
		
}
function ItemsG6(){
	var itemsprodG6="";
	itemsprodG6 = itemsprodG6 + '<Item>'+
												'<Codigo></Codigo>'+
												'<Descripcion>'+generarDescripcionG6()+'</Descripcion>'+
												'<Precio>'+24990+'</Precio>'+
												'<Cantidad>'+contaG6/2+'</Cantidad>'+
												'<MonDescuento>0</MonDescuento>'+
												'<DesDescuento>'+'0'+'</DesDescuento>'+
												'<Total>'+24990*contaG6/2+'</Total>'+
											    '</Item>';

	return(itemsprodG6);
		
}
function ItemsG7(){
	var itemsprodG7="";
	itemsprodG7 = itemsprodG7 + '<Item>'+
												'<Codigo></Codigo>'+
												'<Descripcion>'+generarDescripcionG7()+'</Descripcion>'+
												'<Precio>'+21990+'</Precio>'+
												'<Cantidad>'+contaG7/3+'</Cantidad>'+
												'<MonDescuento>0</MonDescuento>'+
												'<DesDescuento>'+'0'+'</DesDescuento>'+
												'<Total>'+21990*contaG7/3+'</Total>'+
											    '</Item>';

	return(itemsprodG7);
		
}
function ItemsG8(){
	var itemsprodG8="";
	itemsprodG8 = itemsprodG8 + '<Item>'+
												'<Codigo></Codigo>'+
												'<Descripcion>'+generarDescripcionG8()+'</Descripcion>'+
												'<Precio>'+17990+'</Precio>'+
												'<Cantidad>'+contaG8/4+'</Cantidad>'+
												'<MonDescuento>0</MonDescuento>'+
												'<DesDescuento>'+'0'+'</DesDescuento>'+
												'<Total>'+17990*contaG8/4+'</Total>'+
											    '</Item>';

	return(itemsprodG8);
		
}
function contarPromos(){
	contaG4=0;	
	contaG5=0;	
	contaG6=0;	
	contaG7=0;	
	contaG8=0;
	contaNoG=0;
	var tablaItemTipoSplit = tablaItemTipo.split(",");
	var tablaCantPromosSplit=tablaCantPromos.split(",");
	var tablaCantNoPromosSplit=tablaCantNoPromos.split(",");
	for(i=0;i<tablaItemTipoSplit.length;i++){
		if(tablaItemTipoSplit[i]=='G4'){
		  contaG4=parseInt(contaG4)+parseInt(tablaCantPromosSplit[i]);
		}else if(tablaItemTipoSplit[i]=='G5'){
		  contaG5=parseInt(contaG5)+parseInt(tablaCantPromosSplit[i]);
		  
		}else if(tablaItemTipoSplit[i]=='G6'){
			contaG6=parseInt(contaG6)+parseInt(tablaCantPromosSplit[i]);
		}else if(tablaItemTipoSplit[i]=='G7'){
			contaG7=parseInt(contaG7)+parseInt(tablaCantPromosSplit[i]);
		}else if(tablaItemTipoSplit[i]=='G8'){
			contaG8=parseInt(contaG8)+parseInt(tablaCantPromosSplit[i]);
		}
		contaNoG=parseInt(contaNoG)+parseInt(tablaCantNoPromosSplit[i]);
	}
}




//-------------------------------------------------------------DSESCRIPCIONES BOLETAS ITEMS-----------------------------------------------------------------
function generarDescripcionG4(){
	var tablaProdCantidadSplit = tablaProdCantidad.split(",");
	var tablaProdALUSplit = tablaProdALU.split(",");
	var tablaItemTipoSplit = tablaItemTipo.split(",");
	var tablaCantPromosSplit=tablaCantPromos.split(",");
	if(contaG4>0){ // la cantidad de articulos que se le aplicaron promociones
	var cantidadG4=contaG4/2; // saber la cantidad de promociones que se vendieron
	var descripcionG4="PACK G4 : ";
	for(var j =0;j<tablaProdCantidadSplit.length;j++){
		if(tablaItemTipoSplit[j]=="G4"){
			descripcionG4 = descripcionG4 + tablaCantPromosSplit[j]+" X "+tablaProdALUSplit[j]+"/";
		}
	}
	}
	return(descripcionG4);
	
}
function generarDescripcionG5(){
	var tablaProdCantidadSplit = tablaProdCantidad.split(",");
	var tablaProdALUSplit = tablaProdALU.split(",");
	var tablaItemTipoSplit = tablaItemTipo.split(",");
	var tablaCantPromosSplit=tablaCantPromos.split(",");
	if(contaG5>0){ // la cantidad de articulos que se le aplicaron promociones
	var cantidadG5=contaG5/2; // saber la cantidad de promociones que se vendieron
	var descripcionG5="PACK G5 : ";
	for(var j =0;j<tablaProdCantidadSplit.length;j++){
		if(tablaItemTipoSplit[j]=="G5"){
			descripcionG5 = descripcionG5 + tablaCantPromosSplit[j]+" X "+tablaProdALUSplit[j]+"/";
		}
	}
	}
	return(descripcionG5);
	
}
function generarDescripcionG6(){
	var tablaProdCantidadSplit = tablaProdCantidad.split(",");
	var tablaProdALUSplit = tablaProdALU.split(",");
	var tablaItemTipoSplit = tablaItemTipo.split(",");
	var tablaCantPromosSplit=tablaCantPromos.split(",");
	if(contaG6>0){ // la cantidad de articulos que se le aplicaron promociones
	var cantidadG6=contaG6/2; // saber la cantidad de promociones que se vendieron
	var descripcionG6="PACK G6 : ";
	for(var j =0;j<tablaProdCantidadSplit.length;j++){
		if(tablaItemTipoSplit[j]=="G6"){
			descripcionG6 = descripcionG6 + tablaCantPromosSplit[j]+" X "+tablaProdALUSplit[j]+"/";
		}
	}
	}
	return(descripcionG6);	
}
function generarDescripcionG7(){
	var tablaProdCantidadSplit = tablaProdCantidad.split(",");
	var tablaProdALUSplit = tablaProdALU.split(",");
	var tablaItemTipoSplit = tablaItemTipo.split(",");
	var tablaCantPromosSplit=tablaCantPromos.split(",");
	if(contaG7>0){ // la cantidad de articulos que se le aplicaron promociones
	var cantidadG7=contaG7/3; // saber la cantidad de promociones que se vendieron
	var descripcionG7="PACK G7 : ";
	for(var j =0;j<tablaProdCantidadSplit.length;j++){
		if(tablaItemTipoSplit[j]=="G7"){
			descripcionG7 = descripcionG7 + tablaCantPromosSplit[j]+" X "+tablaProdALUSplit[j]+"/";
		}
	}
	}
	return(descripcionG7);	
}
function generarDescripcionG8(){
	var tablaProdCantidadSplit = tablaProdCantidad.split(",");
	var tablaProdALUSplit = tablaProdALU.split(",");
	var tablaItemTipoSplit = tablaItemTipo.split(",");
	var tablaCantPromosSplit=tablaCantPromos.split(",");
	if(contaG8>0){ // la cantidad de articulos que se le aplicaron promociones
	var cantidadG8=contaG8/4; // saber la cantidad de promociones que se vendieron
	var descripcionG8="PACK G8 : ";
	for(var j =0;j<tablaProdCantidadSplit.length;j++){
		if(tablaItemTipoSplit[j]=="G8"){
			descripcionG8 = descripcionG8 + tablaCantPromosSplit[j]+" X "+tablaProdALUSplit[j]+"/";
		}
	}
	}
	return(descripcionG8);
	
}
//------------------------------------------------------------//------------------------------------------------------------