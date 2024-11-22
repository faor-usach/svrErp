<?php
	session_start();
	include_once("../conexionli.php");
	if(isset($_GET['fechaSigSemana'])){ 
		$_SESSION['fechaSigSemana'] = $_GET['fechaSigSemana'];
		$_SESSION['fechaAntSemana'] = $_GET['fechaSigSemana'];
		$_SESSION['fechaHoy'] = date('Y-m-d');
	}else{
		$_SESSION['fechaHoy'] = date('Y-m-d');
		unset($_SESSION['fechaSigSemana']);
	}
	if(isset($_GET['fechaAntSemana'])){ 
		$_SESSION['fechaAntSemana'] = $_GET['fechaAntSemana'];
		$_SESSION['fechaSigSemana'] = $_GET['fechaAntSemana'];
		$_SESSION['fechaHoy'] = date('Y-m-d');
	}else{
		$_SESSION['fechaHoy'] = date('Y-m-d');
		unset($_SESSION['fechaAntSemana']);
	}

	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("../conexionli.php");

	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta content="30" http-equiv="REFRESH"> </meta> -->

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccóon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Simet: Taller TV</title>

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>
	<script src="../jsboot/bootstrap.min.js" type="text/javascript"></script>

<script>
	function muestraResultados(){
		$.ajax({
			url: 'mTallerboot.php',
			beforeSend: function () {
				$("#resultado").html("<div id='tablaDatosAjax'><img src='img/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#info").html(response);
			}
		});
	}
</script>
<script type="text/javascript">
	var int=self.setInterval("refresh()",5000);
	function refresh()
	{
		muestraResultados();
	}	
</script>
</head>

<body>
	<div id="info"></div>
	<script>muestraResultados()</script>
	<div style="clear:both; "></div>

	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="../datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	

</body>
</html>

