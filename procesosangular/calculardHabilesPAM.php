<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$res = '';

			$fechaInicio 			= $dato->fechaInicio;
			$fechaEstimadaTermino 	= $dato->fechaEstimadaTermino;
/*			
			$fechaInicio 			= '2020-01-14';
			$fechaEstimadaTermino 	= '2020-01-24';
*/
			$ft = $fechaInicio;
			$dh	= 0;

			$i = 0;
			while($ft<$fechaEstimadaTermino){
				$i++;
				$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dh++;
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh--;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh--;
				}
			}
			$dHabiles = $dh;

		//$dHabiles = 30;
		$res.= '{"dHabiles":"'.				$dHabiles.					'",';
	   	$res.= '"fechaEstimadaTermino":"'. 	$fechaEstimadaTermino. 		'"}';
$link->close();	   	
echo $res;	
?>