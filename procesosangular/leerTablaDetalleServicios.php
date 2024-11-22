<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");

$outp = "";
$valorUF = 0;
$valorUS = 0;

$link=Conectarse();

$SQLc = "Select * From cotizaciones Where CAM = '$dato->CAM'";
$bdc=$link->query($SQLc);
if($rsc = mysqli_fetch_array($bdc)){
	$valorUF = $rsc['valorUF'];
	$valorUS = $rsc['valorUS'];
}

$SQL = "Select * From dcotizacion Where CAM = '$dato->CAM' Order By nLin";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$Servicios = '';
	$SQLs = "Select * From servicios Where nServicio = '".$rs['nServicio'] ."'";
	$bds=$link->query($SQLs);
	if($rss = mysqli_fetch_array($bds)){
		$Servicios = $rss["Servicio"];
	}
	$unitarioP = $rs["unitarioUF"] * $valorUF;
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"nLin":"'. 		$rs["nLin"]. 				'",';
	$outp .= '"Cantidad":"'. 	$rs["Cantidad"]. 			'",';
	$outp .= '"nServicio":"'. 	$rs["nServicio"]. 			'",';
	$outp .= '"unitarioUF":"'. 	$rs["unitarioUF"]. 			'",';
	$outp .= '"unitarioUS":"'. 	$rs["unitarioUS"]. 			'",';
	$outp .= '"unitarioP":"'. 	$unitarioP. 			'",';
	$outp.= '"Servicio":' 		.json_encode($rss["Servicio"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';	
	$outp .= '"Neto":"'. 		$rs["Neto"]. 				'",';
	$outp .= '"Iva":"'. 		$rs["Iva"]. 				'",';
	$outp .= '"Bruto":"'. 		$rs["Bruto"]. 				'",';
	$outp .= '"NetoUS":"'. 		$rs["NetoUS"]. 				'",';
	$outp .= '"IvaUS":"'. 		$rs["IvaUS"]. 				'",';
	$outp .= '"TotalUS":"'. 	$rs["TotalUS"]. 			'",';
	$outp .= '"IvaUF":"'. 		$rs["IvaUF"]. 				'",';
	$outp .= '"TotalUF":"'. 	$rs["TotalUF"]. 			'",';
	$outp .= '"NetoUF":"'. 		$rs["NetoUF"]. 			'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>