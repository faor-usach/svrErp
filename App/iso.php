<?php
	include("conexion.php");
	echo 'Inicio Respaldo... <br>';
	$link	= Conectarse();
	$result  = mysql_query("SELECT * FROM Cotizaciones");
	if($row=mysql_fetch_array($result)){
		do{
			if($row['Atencion']){
				$CAM = $row['CAM'];
				$Obs = str_replace('Ã¡','�',$row['Atencion']);
				$Obs = str_replace('Ã³','�',$Obs);
				$Obs = str_replace('Ã�','�',$Obs);
				$Obs = str_replace('Ã³','�',$Obs);
				$Obs = str_replace('Ãº','�',$Obs);
				$Obs = str_replace('Ã±','�',$Obs);
				$Obs = str_replace('�','�',$Obs);
				$Obs = str_replace('�','�',$Obs);
				//echo 'Observacion : '.str_replace('Ã¡','�',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('Ã³','�',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('Ã�','�',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('Ã³','�',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('Ãº','�',$row['Observacion']).'<br>';
/*
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="Atencion	= '".$Obs."'";
				$actSQL.="WHERE CAM 	= '".$CAM."'";
				$bdInf=mysql_query($actSQL);
*/
				//echo 'Observacion : '.$Obs.'<br>';
				echo 'Observacion : '.$row['Atencion'].'<br>';
			}
		}while ($row=mysql_fetch_array($result));
	}
	mysql_close($link);
	echo 'Termino ...<br>';
?>