<?php
	//ini_set("session.cookie_lifetime","36000");
	//ini_set("session.gc_maxlifetime","36000");
	session_start(); 
	/*
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                      // Expira en fecha pasada 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");        // Siempre p�gina modificada 
    header("Cache-Control: no-cache, must-revalidate");                   // HTTP/1.1 
    header("Pragma: no-cache");  
    */
	date_default_timezone_set("America/Santiago");

	include_once("../conexionli.php");  
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}


	$ultUF = 0;
	$link=Conectarse();
	$bdr=$link->query("SELECT * FROM tablaregform");
	if($rowr=mysqli_fetch_array($bdr)){
		$ultUF = $rowr['valorUFRef'];
	}
	$link->close();
	$CAM = '';
	$RAM = '';
	if(isset($_GET['CAM'])) 	{	$CAM 				= $_GET['CAM']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 				= $_GET['RAM']; 	}
	$enviarCorreo = 'NO';


	if(isset($_GET['enviarCorreo'])){
		$enviarCorreo = $_GET['enviarCorreo'];
		if($enviarCorreo == 'SI'){

			$link=Conectarse();
			$SQL = "SELECT * FROM cotizaciones Where CAM = '$CAM' and RAM = '$RAM'";  
			$bd=$link->query($SQL);
			if($row=mysqli_fetch_array($bd)){ 
			   $bdCl=$link->query("Select * From clientes Where RutCli = '".$row['RutCli']."'");
			   if($rowCl=mysqli_fetch_array($bdCl)){
					$mail_destinatario = $rowCl['Email'];
					$Cliente = $rowCl['Cliente'];
			
					$bdCc=$link->query("Select * From contactoscli Where RutCli = '".$row['RutCli']."' and nContacto = '".$row['nContacto']."'");
					if($rowCc=mysqli_fetch_array($bdCc)){
						$mail_destinatario = $rowCc['Email'];
					}        
				}
				$fInicio    = $row['fechaInicio'];
				if($fInicio = '0000-00-00'){
					$fInicio = date('Y-m-d');
				}
				$horaPAM    = date('H:i');
				$fd = explode('-', $fInicio);
				$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
				$ft = $row['fechaInicio'];
				if($horaPAM >= '12:00'){
					$dh = $row['dHabiles']+1;
				}else{
					$dh = $row['dHabiles'];
				}
				$dHabiles = $dh;
				$fechaHoy   = date('Y-m-d');
						
				$dd = 0;
				for($i=1; $i<=$dh; $i++){
					$ft = strtotime ( '+'.$i.' day' , strtotime ( $fechaHoy ) );
					$ft = date ( 'Y-m-d' , $ft );
					$dia_semana = date("w",strtotime($ft));
					if($dia_semana == 0 or $dia_semana == 6){
						$dh++;
						$dd++;
					}
				}
				$fe = explode('-', $ft);
			
				$bdCorreo=$link->query("Select * From usuarios Where usr = '".$row['usrCotizador']."'");
				if($rowCorreo=mysqli_fetch_array($bdCorreo)){
					$emailCotizador = $rowCorreo['email'];
				}
				$Descripcion = utf8_decode($row['Descripcion']);
			
				//$mail_destinatario  = 'francisco.olivares.rodriguez@gmail.com';
				//$emailCotizador     = "francisco.olivares@liceotecnologico.cl";
			
				
				$loc = "Location: https://erp.simet.cl/cotizaciones/enviarCorreo2.php?mail_destinatario=$mail_destinatario&Cliente=$Cliente&RAM=$RAM&CAM=$CAM&fInicio=$fInicio&horaPAM=$horaPAM&fTermino=$ft&emailCotizador=$emailCotizador&Descripcion=$Descripcion";
				header($loc);
				
			}
				
			
				// Fin correo
			
			$link->close();
			


		}
	}

/*
	$usuario = $_SESSION['usuario'];
	$idPreCAM = '';
	if(isset($_GET['idPreCAM'])) 	{	$idPreCAM 				= $_GET['idPreCAM']; 	}
	if($idPreCAM){
		$link=Conectarse();
		$Estado = 'off';
		$actSQL="UPDATE precam SET ";
		$actSQL.="Estado			='".$Estado.	"'";
		$actSQL.="WHERE idPreCAM 	= '".$idPreCAM."'";
		$bdCot=$link->query($actSQL);
		$link->close();
	}
	$CAM 	= 0;
	$Rev 	= 0;
	$Cta	= 0;
	$accion	= '';
	unset($_SESSION['empFiltro']);
	if(isset($_GET['CAM'])) 		{	$CAM 					= $_GET['CAM']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 					= $_GET['RAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion 				= $_GET['accion']; 		}
	if(isset($_GET['usrFiltro'])) 	{	$_SESSION['usrFiltro'] 	= $_GET['usrFiltro']; 	}
	if(isset($_GET['empFiltro'])) 	{
		$empFiltro = $_GET['empFiltro'];
		unset($_SESSION['empFiltro']);
		if($empFiltro){
			$_SESSION['empFiltro'] 	= $_GET['empFiltro']; 
		}
	}

	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 	}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 	}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; 	}
*/	

?>
<!doctype html>
 
<html lang="es">
<head>
<title>Intranet Simet</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="../jquery/jquery-1.11.0.min.js"></script> 
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<!-- <script type="text/javascript" src="../jquery/libs/jquery/1/jquery.min.js"></script>	-->

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


	<script type="text/javascript" src="../angular/angular.js"></script>


	<style type="text/css">
		* {
  			box-sizing: border-box;
		}
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>


</head>

<body ng-app="myApp" ng-controller="CtrlCotizaciones" ng-cloak>
	<?php include('head.php'); ?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>


	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>
	<?php include_once('listaCotizacion.php');?>  

	<div ng-show="Exito" class="m-2">
		<div class="alert alert-warning">
    		<strong>Información al Usuario!</strong> Se agregó nueva cotización <a href="#" class="btn btn-info" ng-click="CambiaEstado()">Actualizar</a>
  		</div>
	</div>

	<?php include_once('muestraProcesos.php'); ?>
	
	<div ng-include="'modalSeguimiento.php'"></div>
	<div ng-include="'modalSeguimientoPAM.php'"></div>
	<div ng-include="'modalCotizacion.php'"></div>
	<div ng-include="'modalBorrar.php'"></div>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="../jquery/jquery-3.3.1.min.js"></script>
<!--	
	<script src="../datatables/datatables.min.js"></script>
	<script>
		$(document).ready(function() {
		    $('#example').DataTable();
		} );		
	</script>
-->	
	<script src="cotizaciones.js"></script>

</body>
</html>
