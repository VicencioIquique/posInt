<?php
header("Access-Control-Allow-Origin:*");
$boleta = "<?xml version='1.0' encoding='utf-8'?><Documento><Fiscal Copias='2'>'".$_POST['xml'];
$ID = $_POST['ID'];
echo boleta;
$doc = new SimpleXMLElement($boleta);
$dom=new DOMDocument;
$dom->loadXML($doc->asXML()); 
$dom->save("docPendientes/".$ID.".xml");
?>