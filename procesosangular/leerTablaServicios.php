<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");

$outp = "";
$link=Conectarse();
$SQL = "Select * From servicios Order By Servicio";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"nServicio":"'. 	$rs["nServicio"]. 			'",';
	$outp .= '"tpServicio":"'. 	$rs["tpServicio"]. 			'",';
	$outp .= '"Estado":"'. 		$rs["Estado"]. 				'",';
	$outp .= '"ValorUS":"'. 	$rs["ValorUS"]. 			'",';
	$outp .= '"ValorPesos":"'. 	$rs["ValorPesos"]. 			'",';
	$outp.= '"Servicio":' 		.json_encode($rs["Servicio"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';	
	$outp .= '"ValorUF":"'. 	$rs["ValorUF"]. 			'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>