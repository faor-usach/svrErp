<?php
	session_start(); 
	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("conexionli.php");
	
	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
	$maxCpo = '81%';

	if(isset($_GET['CAM'])) 		{	$CAM 	= $_GET['CAM']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 	= $_GET['RAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion = $_GET['accion']; 		}
	
	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 		}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 		}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; 	}

?>
<!doctype html>
 
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccóon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Simet Ingeniería y Servicios Tecnológicos :: Laboratorio de Ensayos de Materiales</title>

	<link href="css/tpv.css" 		rel="stylesheet" type="text/css">
	<link href="css/stylesTv.css" 	rel="stylesheet" type="text/css">

	<script type="text/javascript" src="angular/angular.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="cssboot/bootstrap.min.css">
	<script type="text/javascript" src="jquery/jquery-1.11.0.min.js"></script>	

<script>
	function muestraResultados(){
		$.ajax({
			url: 'mPegasUsr.php',
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
<style>
.cajaDiasSemana {
	font-family			: Arial, Helvetica, sans-serif;
	width				: 15%;
	text-align  		: center;
	border				: 1px solid #000;
	padding				: 0.2px;
	background-color	: #ccc;
}
#cajaSemana {
	width		: 100%;
	font-family:Arial, Helvetica, sans-serif;
}
#divBlanco {
	background-color	: #fff; 
	border				: 1px solid #000; 
	padding				: 5px;
}
#divRojo {
	background-color	: #FE2E2E; 
	border				: 1px solid #000; 
	padding				: 5px;
	color				: #fff;
}
#divAmarillo {
	background-color	: #FFFF00; 
	border				: 1px solid #000; 
	padding				: 5px;
	color				: #000;
}
#divVerde {
	background-color	: #04B431; 
	border				: 1px solid #000; 
	padding				: 5px;
	color				: #000;
}
</style>
</head>

<body ng-app="myApp" ng-controller="CtrlPegasUsr">
<!--
    <table class="table table-hover table-bordered"> 
		<thead class="thead-dark text-center">
			<tr>
				<th ng-repeat="reg in regUsuarios">{{reg.usr}}		</th>
			</tr>
		</thead>
        <tbody class="table-striped">
			<tr ng-repeat="x in regPegas">
                <td>
                        {{x.usrResponzable}}
                </td>
            </tr>

	</table>
-->
  	<div id="info"></div>
	
	<script src="jsboot/bootstrap.min.js"></script>
    <script src="pegasusr.js"></script>

</body>
</html>

