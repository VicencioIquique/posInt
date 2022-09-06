<?php 
	header("Access-Control-Allow-Origin:*");
	$ID =$_POST['ID'];
	$xml = simplexml_load_file('xmlrespuesta/'.$ID.'.xml');
	$respuesta = $xml->Respuesta->children();
	foreach ($respuesta as $key=>$resource){
	if($key=='Codigo'){
		@$res->Codigo =(string)$resource;
			}
	if($key=='Mensaje'){  
		$res->Mensaje = (string)$resource;
			}
	if($key=='Folio'){ 
		@$res->Folio =(string)$resource;
	}
	}
	$res = json_encode($res);
	echo($res);
?>
