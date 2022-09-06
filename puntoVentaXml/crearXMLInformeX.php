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
	
	$informeX = $doc->createElement("InformeX");
	$informeX = $comandos->appendChild($informeX);
	$textInformeX = $doc->createTextNode(1);
	$textInformeX = $informeX->appendChild($textInformeX);
	
	$doc->save("docPendientes/informeX.xml");
}
?>