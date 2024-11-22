<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
include_once("../inc/funciones.php");
$agnoAct = date('Y');
$mesAct = date('m');
$rCot	= 0;

$outp = "";

$link=Conectarse();

$SQLi = "SELECT * FROM tablaindicadores Where mesInd = '$mesAct' and agnoInd = '$agnoAct'"; 
$bdi=$link->query($SQLi);
if($rsi=mysqli_fetch_array($bdi)){ 
   	$rCot =	$rsi["rCot"];
}
$SQL = "Select * From cotizaciones Where  Estado = 'P' Order By RAM Asc";

if(isset($dato->usrCotizador)){
	if($dato->usrCotizador == 'Todos'){
		$SQL = "Select * From cotizaciones Where Estado = 'P' Order By  RAM Asc";
	}else{
		
		if($dato->usrCotizador == 'Baja'){
			$SQL = "Select * From cotizaciones Where Estado = 'C' and year(fechaCotizacion) = '$agnoAct' Order By RAM Asc";
		}else{
		
			$SQL = "Select * From cotizaciones Where usrResponzable = '$dato->usrCotizador' and Estado = 'P' Order By RAM Asc";
		}
	}
}


$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$Cliente = '';
	$Clasificacion = 0;
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']);
		$nFactPend = $rsc['nFactPend'];
		$Clasificacion 	= $rsc['Clasificacion'];
/*
		list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($rs['fechaInicio'],$rs['dHabiles'],$rs['horaPAM']);

		$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
		$fechaHoy = date('Y-m-d');
		$dsemana = date("w",strtotime($ftermino));
		$diaTermino = $dSem[$dsemana];
		$fechaTermino = $ftermino;
											
		$ft = $rs['fechaInicio'];
		$dh	= $rs['dHabiles']-1;
		$dd	= 0;
		for($i=1; $i<=$dh; $i++){
			$ft	= strtotime ( '+'.$i.' day' , strtotime ( $rs['fechaInicio'] ) );
			$ft	= date ( 'Y-m-d' , $ft );
			$dia_semana = date("w",strtotime($ft));
			if($dia_semana == 0 or $dia_semana == 6){
				$dh++;
				$dd++;
			}
		}
						
		$fechaHoy = date('Y-m-d');
		$start_ts 	= strtotime($fechaHoy); 
		$end_ts 	= strtotime($ft); 
										
		$tDias = 1;
		$nDias = $end_ts - $start_ts; 

		$nDias = round($nDias / 86400)+1; 
		if($ft < $fechaHoy){
			$nDias = $nDias - $dd;
		}
*/		
		$OTAM = 'NO';
		$bdm=$link->query("SELECT * FROM formRAM Where CAM = '".$rs['CAM']."' and RAM = '".$rs['RAM']."'");
		if($rsm=mysqli_fetch_array($bdm)){
			$OTAM = 'SI';
		}

		$sDeuda = 0;
		$fechaHoy = date('Y-m-d');
		$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
		$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
		$bdDe=$link->query("SELECT * FROM solfactura Where RutCli = '".$rsc['RutCli']."' and fechaPago = '0000-00-00'");
		while($rowDe=mysqli_fetch_array($bdDe)){
			if($rowDe['fechaFactura'] > '0000-00-00'){
				if($rowDe['fechaFactura'] < $fecha90dias){
					$sDeuda += $rowDe['Bruto'];
				}
			}
		}


		if ($outp != "") {$outp .= ",";}
		$outp .= '{"CAM":"'  . 				$rs["CAM"]. 				'",'; 
		$outp .= '"RAM":"'. 				$rs["RAM"]. 				'",';
		//$outp .= '"Descripcion":"'. 		trim($rs["Descripcion"]). 		'",';
		$outp .= '"tpEnsayo":"'. 			$rs["tpEnsayo"]. 			'",';
		$outp .= '"OFE":"'. 				$rs["OFE"]. 				'",';
		$outp .= '"Rev":"'. 				$rs["Rev"]. 				'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"enviadoCorreo":"'. 		$rs["enviadoCorreo"]. 		'",';
		$outp .= '"fechaInicio":"'. 		$rs["fechaInicio"]. 		'",';
		$outp .= '"fechaEnvio":"'. 			$rs["fechaEnvio"]. 			'",';
		$outp .= '"Validez":"'. 			$rs["Validez"]. 			'",';
		$outp .= '"usrPega":"'. 			$rs["usrPega"]. 			'",';
		//$outp .= '"fechaTermino":"'. 		$fechaTermino. 				'",';
		$outp .= '"OTAM":"'. 				$OTAM. 						'",';
		$outp .= '"nFactPend":"'. 			$nFactPend. 				'",';
		$outp .= '"proxRecordatorio":"'. 	$rs["proxRecordatorio"]. 	'",';
		//$outp .= '"nDias":"'. 				$nDias. 					'",';
		//$outp .= '"diaTermino":"'. 			$diaTermino. 				'",';
		//$outp .= '"dhf":"'. 				$dhf. 						'",';
		//$outp .= '"dha":"'. 				$dha. 						'",';
		$outp .= '"usrCotizador":"'. 		$rs["usrCotizador"]. 		'",';
		$outp .= '"usrResponzable":"'. 		$rs["usrResponzable"]. 		'",';
		$outp .= '"dHabiles":"'. 			$rs["dHabiles"]. 			'",';
		$outp .= '"fechaEstimadaTermino":"'.$rs["fechaEstimadaTermino"].'",';
		$outp .= '"fechaCotizacion":"'. 	$rs["fechaCotizacion"]. 	'",';
		$outp .= '"correoAutomatico":"'. 	$rs["correoAutomatico"]. 	'",';
		$outp .= '"RutCli":"'. 				$rs["RutCli"]. 				'",'; 
		$outp .= '"Moneda":"'. 				$rs["Moneda"]. 				'",';
		$outp .= '"pDescuento":"'. 			$rs["pDescuento"]. 			'",';
		$outp .= '"Neto":"'. 				$rs["Neto"]. 				'",';
		$outp .= '"NetoUF":"'. 				$rs["NetoUF"]. 				'",';
		$outp .= '"Bruto":"'. 				$rs["Bruto"]. 				'",';
		$outp .= '"BrutoUF":"'. 			$rs["BrutoUF"]. 			'",';
		$outp .= '"Fan":"'. 				$rs["Fan"]. 				'",';
		$outp .= '"Cliente":' 				.json_encode($Cliente, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"Clasificacion":' 		.json_encode($Clasificacion, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"rCot":"'. 				$rCot. 						'",';
	    $outp .= '"sDeuda":"'. 				$sDeuda. 			'"}';
	}
}
$outp ='{"records":['.$outp.']}';
$link->close();

/*
$json_string = $outp;
$file = 'PAM.json'; 
file_put_contents($file, $json_string);
*/

echo ($outp);
?>