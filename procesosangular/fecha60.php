<?php
	$fechaHoy = date('Y-m-d');
	$fecha60dias 	= strtotime ( '-60 day' , strtotime ( $fechaHoy ) );
	$fecha60dias	= date ( 'Y-m-d' , $fecha60dias );
	echo $fecha60dias;
?>