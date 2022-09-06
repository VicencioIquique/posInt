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
	
	$cerrarPeriodo = $doc->createElement("CerrarPeriodo");
	$cerrarPeriodo = $comandos->appendChild($cerrarPeriodo);
	$textCerrarPeriodo = $doc->createTextNode(1);
	$textCerrarPeriodo = $cerrarPeriodo->appendChild($textCerrarPeriodo);
		
	$doc->save("docPendientes/CerrarPeriodo.xml");
}
?>