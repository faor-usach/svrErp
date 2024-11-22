<?php 	
	include_once("../conexionli.php");
	$link=Conectarse();
			$fechaInicio = date('Y-m-d');;
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= 2 - 1;

			$dd	= 0;
			for($i=1; $i<=$dh; $i++){
				$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fechaInicio ) );
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
			echo $fechaEstimadaTermino;
?>