<?php
	include_once("conexion.php"); 
	$Cliente 	= $_GET['Cliente'];
	$Publicar 	= $_GET['Publicar'];
	$RutCli 	= $_GET['RutCli'];
	$Logo 		= $_GET['Logo'];
	$Sitio 		= $_GET['Sitio'];
	$link=Conectarse();
	$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$_GET['RutCli']."'");
	if($rowCli=mysql_fetch_array($bdCli)){
		$actSQL="UPDATE Clientes SET ";
		$actSQL.="Cliente				= '".$Cliente.	"',";
		$actSQL.="Logo					= '".$Logo.		"',";
		$actSQL.="Sitio					= '".$Sitio.		"',";
		$actSQL.="Publicar				= '".$Publicar.	"'";
		$actSQL.="WHERE RutCli 		= '".$_GET['RutCli']."'";
		$bdInf=mysql_query($actSQL);
	}else{
		mysql_query("insert into Clientes(	RutCli,
							Cliente,
							Sitio,
							Publicar,
							Logo
						) 
				values 		(	'$RutCli',
							'$Cliente',
							'$Sitio',
							'$Publicar',
							'$Logo'
						)",$link);
	}
	mysql_close($link);
	$loc = "Location: http://servidorerp/erp/clientes/mClientes.php?Proceso=2&RutCli=$RutCli";
	header($loc);
?>
