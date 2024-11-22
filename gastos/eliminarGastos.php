<?php
/*
	include_once("conexion.php");
	if($_GET['nSolicitud']) { $nSolicitud   = $_GET['nSolicitud']; }
					
	$link=Conectarse();
	$bdSol=mysql_query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
	if($row=mysql_fetch_array($bdSol)){
		$bdSol=mysql_query("DELETE FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
	}
	mysql_close($link);
*/
	header("Location: ipdf.php");
?>