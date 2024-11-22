<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");

$res = "";

$link=Conectarse();


$SQL = "Select * From cotizaciones Where CAM = '$dato->CAM'";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente    = trim($rsc['Cliente']);
		$HES        = $rsc['HES'];
		$res .= '{"CAM":"'  . 			$rs["CAM"]. 				'",';
		$res .= '"RAM":"'. 				$rs["RAM"]. 				'",';
		$res .= '"HES":"'. 				$HES. 				        '",';
	    $res .= '"Cliente":"'. 			trim($Cliente). 			'"}';
	}
}
$link->close();
echo $res;
?>