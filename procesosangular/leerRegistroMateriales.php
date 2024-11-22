<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$outp = "";
$link=Conectarse();

//$SQL = "SELECT * FROM registromuestras where RAM > 0 and RutCli = '$dato->RutCli'";
$SQL = "SELECT * FROM registromuestras where situacionMuestra = 'R' and RAM > 0 and RutCli = '$dato->RutCli'";
//$SQL = "SELECT * FROM registromuestras where situacionMuestra = 'R' and RAM > 0";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp.= '{"RAM":"'.				$rs["RAM"].					'",';
	$outp.= '"Fan":"'.				$rs["Fan"]. 				'",';
	$outp.= '"RutCli":"'.			$rs["RutCli"]. 				'",';
	$outp.= '"situacionMuestra":"'.	$rs["situacionMuestra"]. 	'",';
   	$outp.= '"CAM":"'. 				$rs["CAM"]. 				'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>