<?php
header("Access-Control-Allow-Origin:*");
CrearXML();
function CrearXML() {
	$doc = new DOMDocument('1.0');
	$doc->formatOutput = true;
	$raiz = $doc->createElement("Documento");
	$raiz = $doc->appendChild($raiz);
	$comandos = $doc->createElement("Comandos");
	$comandos = $raiz->appendChild($comandos);
	
	$abrirPeriodo = $doc->createElement("AbrirPeriodo");
	$abrirPeriodo = $comandos->appendChild($abrirPeriodo);
	$textAbrirPeriodo = $doc->createTextNode(1);
	$textAbrirPeriodo = $abrirPeriodo->appendChild($textAbrirPeriodo);
		
	$doc->save("docPendientes/abrirPeriodo.xml");
}
?>