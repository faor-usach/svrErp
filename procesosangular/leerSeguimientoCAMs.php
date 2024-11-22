<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');

$outp = "";

$link=Conectarse();


$SQL = "Select * From cotizacionessegimiento Where CAM = '$dato->CAM' Order By proxRecordatorio Desc";

$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){

		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 						'",';
		$outp .= '"fechaContacto":"'. 		$rs["fechaContacto"]. 				'",';
		$outp .= '"proxRecordatorio":"'. 	$rs["proxRecordatorio"]. 			'",';
	    $outp .= '"contactoRecordatorio":"'.trim($rs["contactoRecordatorio"]). 	'"}';

}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>