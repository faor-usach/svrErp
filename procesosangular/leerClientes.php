<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');
$outp = "";
$rCot = 0;

$link=Conectarse();
$SQL = "Select * From clientes where Estado = 'on' Order By Cliente"; 
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
	$outp .= '"Cliente":' 				.json_encode($rs["Cliente"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	$outp .= '"Giro":' 					.json_encode($rs["Giro"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	$outp .= '"Direccion":' 			.json_encode($rs["Direccion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	/*
	EL ERROR ES POR QUE SEGURAMENTE EL CAMPO YA SEA Cliente, Giro, Direccion
	LO MAS PROBABLE ES QUE TENGA UNAS COMILLAS, QUE ESTA BIEN PERO LA INSTRUCCION DEBIA PONER json_encode(.....)
	COMO ESTA ARRIBA Y ESTABA COMO EN LA SIGUIENTE LINEA:

	$outp .= '"Direccion":"'. 				$rs["Direccion"]. 				'",';

	Y ESO DEBE TENERLO EN TODOS LOS CAMPOS QUE CONTIENEN TEXTO Descripcion, Observacion, etc.
	lo correcto para esos campos es agregar json_encode como en la linea siguiente

	$outp .= '"Direccion":' 			.json_encode($rs["Direccion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';


	*/

	$outp .= '"cFree":"'. 				$rs["cFree"]. 				'",';
	$outp .= '"Docencia":"'. 			$rs["Docencia"]. 			'",';
	$outp .= '"Clasificacion":"'. 		$rs["Clasificacion"]. 		'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>