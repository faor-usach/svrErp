﻿<?php
	session_start(); 

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                      // Expira en fecha pasada 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");        // Siempre página modificada 
    header("Cache-Control: no-cache, must-revalidate");                   // HTTP/1.1 
    header("Pragma: no-cache");  
	date_default_timezone_set("America/Santiago");

	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ..index.php"); 
	}
	$CodCertificado = '';
	if (isset($_GET['CodCertificado'])){
		$CodCertificado = $_GET['CodCertificado'];
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tipos de Productos</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>

</head>

<body ng-app="myApp" ng-controller="CtrlClientes">
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-warning static-top">
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
	          			<a class="nav-link fa fa-home text-dark" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
						<?php if($CodCertificado){?>
							<a class="nav-link fas fa-address-card text-dark" href="../certProductos/mCertificados.php?CodCertificado=<?php echo $CodCertificado; ?>"> Volver</a>
							<?php
						}else{?>
							<a class="nav-link fas fa-address-card text-dark" href="../certrar/"> Volver</a>
						<?php
						}
						?>
	        		</li>
	        		<li class="nav-item">
						<?php if($CodCertificado){?>
							<a class="nav-link fas fa-address-card text-dark" href="mProductos.php?nProducto=0&CodCertificado=<?php echo $CodCertificado; ?>"> +Producto</a>
							<?php
						}else{?>
							<a class="nav-link fas fa-address-card text-dark" href="mProductos.php?nProducto=0"> +Producto</a>
						<?php
						}
						?>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off text-dark" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="row bg-info text-white m-1" style="padding: 10px;">
			<div class="col-2">
				Tipo Producto
			</div>
			<div class="col-2">
				<input 	class 		= "form-control" 
						ng-change	= "cargarProductos()"
						ng-model	= "bTipoProd" 
						type		= "text">
			</div>
			<div class="col-1">
			</div>
			<div class="col-5">
			</div>
	</div>

	<style type="text/css">
		.custom-class{
		  background-color: gray
		}
		.pasivo-class{
		  background-color: red
		}
		.default-color{
		  background-color: green
		}	
	</style>
	
	<div class="container" style="margin-top: 10px;">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
	  	<table class="table table-dark table-hover table-bordered" ng-show="tCertificados">
	    	<thead>
	      		<tr>
			        <th>#</th>
			        <th>Productos</th>
			        <th  class="text-center">Acciones</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in Productos | filter : bTipoProd"
	      			ng-class="{'pasivo-class': x.Estado == 'off', 'default-color': x.Estado == 'on'}">
			        <td  class="text-center"><b>{{x.nProducto}}</b></td>
			        <td><b>{{x.Producto}}</b></td>
			        <td  class="text-center">
			        	<a 	class="btn btn-warning" role="button"
	        				href="mProductos.php?nProducto={{x.nProducto}}&CodCertificado=<?php echo $CodCertificado; ?>" >Editar</a>
	        		</td>
	      		</tr>
	    	</tbody>
	  </table>

	</div>


	<div style="clear:both; "></div>
	<br>
	<script src="Productos.js"></script>

</body>
</html>
