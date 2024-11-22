<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$res = '';

			$fechaInicio 		= $dato->fechaInicio;
			$dHabiles 			= $dato->dHabiles;
			$ft = $fechaInicio;
			$dh	= $dato->dHabiles - 1;

			$dd	= 0;
			for($i=1; $i<=$dh; $i++){
				$ft	= strtotime ( '+'.$i.' day' , strtotime ( $dato->fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
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


		$res.= '{"dHabiles":"'.				$dHabiles.							'",';
	   	$res.= '"fechaEstimadaTermino":"'. 	$fechaEstimadaTermino. 				'"}';
$link->close();	   	
echo $res;	
?>