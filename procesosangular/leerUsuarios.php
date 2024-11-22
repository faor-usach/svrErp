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
//$SQL = "Select * From Usuarios where responsableinforme = 'on' and usr != 'Alfredo.Artigas'";
$SQL = "Select * From Usuarios where responsableInforme = 'on' and  nPerfil = 1 and usr != 'Alfredo.Artigas'";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"usr":"'  . 				$rs["usr"]. 				'",';
	$outp .= '"usuario":"'. 			$rs["usuario"]. 			'",';
	$outp .= '"nPerfil":"'. 			$rs["nPerfil"]. 			'",';
	$outp .= '"email":"'. 				$rs["email"]. 				'",';
	$outp .= '"cargoUsr":"'. 			$rs["cargoUsr"]. 			'",';
	$outp .= '"responsableInforme":"'. 	$rs["responsableInforme"]. 	'",';
	$outp .= '"apruebaOfertas":"'. 		$rs["apruebaOfertas"]. 		'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>