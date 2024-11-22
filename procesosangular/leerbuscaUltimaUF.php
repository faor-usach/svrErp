<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();

$SQL = "SELECT * FROM solfactura Where valorUF > 0 Order By nSolicitud Desc";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
	

		$res.= '{"nSolicitud":"'.			$rs["nSolicitud"].					'",';
	    $res.= '"fechaSolicitud":"'.		$rs["fechaSolicitud"]. 			    '",';
	   	$res.= '"valorUF":"'. 				$rs["valorUF"]. 					'"}';


}
//$outp ='{"records":['.$outp.']}';
$link->close();
//$res ='{"records":['.$res.']}';
echo $res;	
?>