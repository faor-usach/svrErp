<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();

$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM' and (Estado = 'E' or Estado = 'P' or Estado = 'C')";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
	
	$Cliente = '';
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$Cliente  = trim($rsc['Cliente']);
		$nContacto = $rs['nContacto'];
		$Contacto = '';
		$SQLcc = "SELECT * FROM contactoscli where RutCli = '".$rs['RutCli']."' and nContacto = '".$rs['nContacto']."'";
		$bdcc=$link->query($SQLcc);
		if($rscc = mysqli_fetch_array($bdcc)){
			$Contacto = $rscc['Contacto'];
		}
		$correoInicioPAM = 'off';
		if($rs['correoInicioPAM']){
			$correoInicioPAM = $rs['correoInicioPAM'];
		}
		//if($rs['fechaEstimadaTermino'] == '0000-00-00'){
			//$fechaEstimadaTermino = date('Y-m-d');

			$fechaHoy = date('Y-m-d');
			$fechaInicio = $fechaHoy;
			$fechaAceptacion = $fechaHoy;
			$ft = $fechaInicio;
			$dh	= $rs['dHabiles'] - 1;

			$dd	= 0;
			for($i=1; $i<=$dh; $i++){
				$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaEstimadaTermino = $ft;



		//}else{
			//$fechaEstimadaTermino = $rs['fechaEstimadaTermino'];
		//}
		$exentoIva = false;
		if($rs["exentoIva"] == 'on'){
			$exentoIva = true;
		}

		$res.= '{"CAM":"'.					$rs["CAM"].							'",';
	    $res.= '"RAM":"'.					$rs["RAM"]. 						'",';
	    $res.= '"Fan":"'.					$rs["Fan"]. 						'",';
	    $res.= '"Rev":"'.					$rs["Rev"]. 						'",';
	    $res.= '"Fan":"'.					$rs["Fan"]. 						'",';
	    $res.= '"usrCotizador":"'.			$rs["usrCotizador"]. 				'",';
	    $res.= '"usrResponzable":"'.		$rs["usrResponzable"]. 				'",';
	    $res.= '"nContacto":"'.				$rs["nContacto"]. 					'",';
	    $res.= '"tpEnsayo":"'.				$rs["tpEnsayo"]. 					'",';
	    $res.= '"Estado":"'.				$rs["Estado"]. 						'",';
	    $res.= '"Observacion":' 			.json_encode($rs["Observacion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $res.= '"Descripcion":' 			.json_encode($rs["Descripcion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $res.= '"obsServicios":' 			.json_encode($rs["obsServicios"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $res.= '"contactoRecordatorio":"'.	trim($rs["contactoRecordatorio"]). 	'",';
	    $res.= '"RutCli":"'.				$rs["RutCli"]. 						'",';
	    $res.= '"fechaCotizacion":"'.		$rs["fechaCotizacion"]. 			'",';
	    //res.= '"fechaAceptacion":"'.		$rs["fechaAceptacion"]. 			'",';
	    $res.= '"fechaInicio":"'.			$fechaInicio. 					'",';
	    $res.= '"fechaAceptacion":"'.		$fechaAceptacion. 					'",';
	    $res.= '"fechaPega":"'.				$rs["fechaPega"]. 					'",';
	    $res.= '"usrPega":"'.				$rs["usrPega"]. 					'",';
	    $res.= '"oCompra":"'.				$rs["oCompra"]. 					'",';
	    $res.= '"oMail":"'.					$rs["oMail"]. 						'",';
	    $res.= '"oCtaCte":"'.				$rs["oCtaCte"]. 					'",';
	    $res.= '"fechaEstimadaTermino":"'.	$fechaEstimadaTermino.				'",';
	    $res.= '"fechaTermino":"'.			$rs["fechaTermino"].				'",';
	    $res.= '"OFE":"'.					$rs["OFE"].							'",';
	    $res.= '"Moneda":"'.				$rs["Moneda"].						'",';
	    $res.= '"fechaUF":"'.				$rs["fechaUF"].						'",';
	    $res.= '"valorUF":"'.				$rs["valorUF"].						'",';
	    $res.= '"valorUS":"'.				$rs["valorUS"].						'",';
	    $res.= '"NetoUS":"'.				$rs["NetoUS"].						'",';
	    $res.= '"IvaUS":"'.					$rs["IvaUS"].						'",';
	    $res.= '"BrutoUS":"'.				$rs["BrutoUS"].						'",';
	    $res.= '"NetoUF":"'.				$rs["NetoUF"].						'",';
	    $res.= '"IvaUF":"'.					$rs["IvaUF"].						'",';
	    $res.= '"BrutoUF":"'.				$rs["BrutoUF"].						'",';
	    $res.= '"Neto":"'.					$rs["Neto"].						'",';
	    $res.= '"Iva":"'.					$rs["Iva"].							'",';
	    $res.= '"Bruto":"'.					$rs["Bruto"].						'",';
	    $res.= '"pDescuento":"'.			$rs["pDescuento"].					'",';
	    $res.= '"exentoIva":"'.				$exentoIva.							'",';
	    $res.= '"dHabiles":"'.				$rs["dHabiles"].					'",';
	    $res.= '"Validez":"'.				$rs["Validez"].						'",';
	    $res.= '"correoInicioPAM":"'.		$correoInicioPAM. 					'",';
	    $res.= '"nOC":"'.					$rs["nOC"]. 						'",';
	   	$res.= '"Contacto":"'. 				trim($Contacto). 					'",';
	   	$res.= '"Cliente":"'. 				trim($Cliente). 					'"}';


	}
}
//$outp ='{"records":['.$outp.']}';
$link->close();
//$res ='{"records":['.$res.']}';
echo $res;	
?>