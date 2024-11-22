<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Servicios</title>
	
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="../jquery/libs/jquery/1/jquery.min.js"></script>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script type="text/javascript" src="../angular/angular-route.min.js"></script>

</script>

	<style type="text/css">
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
		.default-color:hover {
		  opacity 			: 0.5;
		  color 			: #000;
		}
	</style>


</head>

<body ng-app="myApp" ng-controller="CtrlServicios" ng-cloak>
	<?php include('head.php'); ?>
	<input ng-model="CAM" type="hidden" ng-init="loadCAM('<?php echo $CAM; ?>')">

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
	        		<li class="nav-item active">
	          			<a class="nav-link fas fa-paste" href="plataformaCotizaciones.php"> Procesos</a>
	        		</li>
	        		<li class="nav-item active" ng-if="CAM > 0">
	          			<a class="nav-link fas fa-at" href="formularios/subirEnviarPdf.php?CAM=<?php echo $CAM;?>&Rev=<?php echo $Rev;?>&Cta=<?php echo $Cta;?>" title="Enviar Cotización">
	          			 Enviar
	          			</a>
	        		</li>
	        		<li class="nav-item active" ng-if="CAM > 0">
	          			<a class="nav-link fas fa-at" href="formularios/iCAM.php?CAM=<?php echo $CAM;?>&Rev=<?php echo $Rev;?>&Cta=<?php echo $Cta;?>" title="Descargar Cotización">
	          			 Descarga
	          			</a>
	        		</li>
	        		<li class="nav-item active"  ng-if="CAM > 0">
	          			<a class="nav-link fas fa-toggle-on" href="#" ng-click="activaConfiguracionCotizacion()"> Editar</a>
	        		</li>
	        		<li class="nav-item active"  ng-if="CAM > 0 && OFE == 'on'">
	          			<a class="nav-link far fa-edit" href="ofe/index.php?OFE=<?php echo $CAM; ?>&accion=OFE" title="Oferta Económica"> OFE</a>
	        		</li>
	        		<li class="nav-item active"  ng-if="CAM > 0 && OFE == 'off'">
	          			<a class="nav-link far fa-edit" href="ofe/index.php?OFE=<?php echo $CAM; ?>&accion=OFE" title="Oferta Económica"> +OFE</a>
	        		</li>
	        		<li class="nav-item active" ng-if="CAM > 0 && Moneda != 'U'">
	          			<a class="nav-link fas fa-money-check-alt" href="#" ng-click="enUF()"> UF</a>
	        		</li>
	        		<li class="nav-item active" ng-if="CAM > 0 && Moneda != 'P'">
	          			<a class="nav-link fas fa-money-check-alt" href="#" ng-click="enPesos()"> Pesos</a>
	        		</li>
	        		<li class="nav-item active" ng-if="CAM > 0 && Moneda != 'D'">
	          			<a class="nav-link fas fa-money-check-alt" href="#" ng-click="enDollar()"> US$</a>
	        		</li>
					<li class="nav-item active">
						  <a class="nav-link fas fa-cart-plus" href="#" ng-click="nuevoServicio()"> Servicio
						  </a>
					</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>
	
	<div class="row" style="margin: 10px;">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-3">
							Servicios
						</div>
						<div class="col-9">
							<input ng-model="filtroServicios" class="form-control" type="text" id="filtroServicios">
						</div>
					</div>
				</div>
			  	<div class="card-body">
					<table class="table table-primary table-hover" ng-show="mServicios">
						<thead>
							<tr>
								<th> Cod. 		</th>
								<th> Servicios 	</th>
								<th> UF			</th>
								<th> $			</th>
								<th> $US		</th>
								<th>Acción		</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="Ser in dataServicios | filter: filtroServicios | orderBy: 'Servicio'" 
								ng-class="verColorLineaServicios(Ser.tpServicio, Ser.Estado)">
								<td>
								  	{{Ser.nServicio}}
								</td>
								<td>
								  	{{Ser.Servicio}}
								</td>
								<td>
									<input ng-model="Ser.ValorUF" type="text" size="6" maxlength="6" ng-change="actualizaCostoServicio(Ser.nServicio, 'U', Ser.ValorUF)">
								</td>
								<td>
									<input ng-model="Ser.ValorPesos" type="text" size="6" maxlength="6" ng-change="actualizaCostoServicio(Ser.nServicio, 'P', Ser.ValorPesos)">
								</td>
								<td>
									<input ng-model="Ser.ValorUS" type="text" size="6" maxlength="6" ng-change="actualizaCostoServicio(Ser.nServicio, 'D', Ser.ValorUS)">
								</td>
								<td>
									<button style="margin-top: 5px;" 
											class="btn btn-info" 
											type="button" 
											ng-click="editarServicio(Ser.nServicio)"  
											title="Editar Servicio">
											<i class="fas fa-edit"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div class="col-md-4" ng-show="newServicio">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col">
							<div ng_if="nServicio > 0">
								<b>Servicio {{nServicio}}</b>
							</div>
							<div ng_if="nServicio == 0">
								<b>Nuevo Servicio</b>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-4">Id. Servicio</div>
						<div class="col-8">
							<textarea class="form-control" ng-model="Servicio" rows="3" id="Servicio"></textarea>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-4">Valor UF</div>
						<div class="col-8">
							<input type="text" ng-model="ValorUF" class="form-control">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-4">Valor $</div>
						<div class="col-8">
							<input type="text" ng-model="ValorPesos" class="form-control">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-4">Valor US$</div>
						<div class="col-8">
							<input type="text" ng-model="ValorUS" class="form-control">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-4">Tipo Servicio</div>
						<div class="col-8">
							<select class="form-control" ng-model="tpServicio">
								<option value="">	 		</option>
								<option value="O">Opcional </option>
								<option value="E">Especial	</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-4">Estado Servicio</div>
						<div class="col-8">
							<select class="form-control" ng-model="Estado">
								<option value="on">Activo 		</option>
								<option value="off">Desactivado	</option>
							</select>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-primary" 	ng-click="agregarServicio()">Grabar</button>
					<button type="button" class="btn btn-danger" 	ng-click="borrarServicio()">Eliminar</button>
				</div>
			</div>
		</div>
	</div>

	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="servicios.js"></script>
	
</body>
</html>
