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
		header("Location: index.php");
	}
	$Concepto 	= "";
	$MsgUsr 	= "";
	$Formulario = "";
	$Iva		= "";
	$IdProyecto	= "";
	
	if(isset($_POST['Formulario']))	{ $Formulario 	= $_POST['Formulario']; }
	if(isset($_POST['Iva']))		{ $Iva 			= $_POST['Iva']; 		}
	if(isset($_POST['IdProyecto']))	{ $IdProyecto	= $_POST['IdProyecto']; }
	if(isset($_POST['Concepto']))	{ $Concepto		= $_POST['Concepto']; }
	
	if(isset($_POST['imprimirSolicitud'])){
		$ff = explode('(',$Formulario);
		$Recurso = substr($ff[1],0,strlen($ff[1])-1);

		$IdRecurso = 0;
		$link=Conectarse();
		$bdRec=$link->query("SELECT * FROM recursos Where Formulario = '".$ff[0]."' and Recurso = '".$Recurso."'");
		if($rowRec=mysqli_fetch_array($bdRec)){
			$IdRecurso = $rowRec['IdRecurso'];
		}
		$link->close();
		
		$filtroSQL = 'Where Estado != "I" ';
		if($Formulario){
			$filtroSQL .= " and IdRecurso = '".$IdRecurso."'";
		}
		if($IdProyecto != ''){
			$filtroSQL .= " and IdProyecto = '".$IdProyecto."'";
		}
		if($Iva != ''){
			if($Iva=="cIva"){ 
				$filtroSQL .= " and Iva > 0 and Neto > 0";
			}else{
				//$filtroSQL .= " and Iva = 0 and Neto = 0";
				$filtroSQL .= " and Iva = 0";
			}
		}

		if($Formulario != '' and $IdProyecto != '' and $Iva != ''){
			$link=Conectarse();
			$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL);
			if($row=mysqli_fetch_array($bdGto)){
				require_once('formularios/F3BNeww.php');
			}
			$link->close();
		}else{
			if($Formulario == '' or $Iva == '' or $IdProyecto == ''){
				?>
					<script>
						alert('<?php echo "DEBE SELECCIONAR TODAS LAS OPCINES: TIPO DE FORMULARIO, CON O SIN IVA Y PROYECTO..."; ?>');
					</script>
				<?php
			}
		}
	}

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Emisi&oacute;n de Formularios</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script language="javascript" src="validaciones.js"></script> 
	<script src="../jquery/jquery-1.6.4.js"></script>

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<script>
	function realizaProceso(IdProyecto, Iva, Formulario){
		var parametros = {
			"IdProyecto" : IdProyecto,
			"Iva" 		 : Iva,
			"Formulario" : Formulario
		};
		
		//Pasa Variables a Php Formulario
		document.form.Formulario.value 	= Formulario;
		document.form.Iva.value 		= Iva;
		document.form.IdProyecto.value 	= IdProyecto;

		//alert(Iva);

		$.ajax({
			data: parametros,
			url: 'muestraDocumentos.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	</script>
</head>

<body ng-app="myApp" ng-controller="ctrlGastos">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<?php 
				$nomModulo = 'Reembolsos y Pago de Facturas ';
				include('menuIconos.php'); 
				include('barraOpciones.php'); 
			?>

			
			<div class="container-fluid m-2">
				<!-- <form name="form" method="post" action="eformulariosAjax.php"> -->
Imprime
					<div class="row">
						<div class="col-sm-3" ng-show="dataConcepto">
							<label for="email" class="form-label">Concepto o motivo de los Gastos Realizados</label>
							<textarea class="form-control" ng-change="activaImpresion()" ng-model="Concepto" name="Concepto" cols="50" rows="5" title="Ingrese Concepto o motivo de el o los Gastos incurridos..." autofocus required /><?php echo $Concepto; ?></textarea>
						</div>
						<div class="col-sm-6" ng-show="docGastosUPs"> 
							<input id="archivosSeguimiento" ng-click="activaBtnGenera()" ng-model="archivosSeguimiento" multiple type="file"> {{pdf}}
							
							<button class="btn btn-success" type="button" ng-click="subirDocumentosSolicitud()">
								Subir Archivo
							</button>
							
						</div>
						<div class="col-sm-3" ng-show="docGastosUPs">  
								
							<button ng-click="imprimirSolicitud()" ng-show="btnGenera" id="Imprime" style="float:right;">
								<img src="imagenes/printer_128_hot.png" title="Generar Solicitud de Reembolso">
							</button>
<!--
							<a ng-click="imprimirSolicitud()" href="formularios/F3BCompilado.php?Formulario={{Formulario}}&Iva={{cIva}}&IdProyecto={{IdProyecto}}&Concepro={{Concepto}}" ng-show="btnGenera" id="Imprime" style="float:right;">
								<img src="imagenes/printer_128_hot.png" title="Generar Solicitud de Reembolso">
							</a>
-->
						</div>
					</div>
				

					
				<!-- </form> -->

				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
					<tr>
						<td id="CajaOpc" >
							Cuenta Receptora
						</td>
						<td id="CajaOpc" >
							Impuesto
						</td>
						<td id="CajaOpc" > 
							Proyecto
						</td>
					</tr>
					<tr>
						<td id="CajaOpcDatos" valign="top">
							<select ng-model	= "Formulario" 
									ng-change	= "docGastosUP()"
									name		= "Formulario" 
									id			= "Formulario" 
									class		= "form-control"
									required> 
									<!-- onChange	= "realizaProceso($('#IdProyecto').val(), $('#Iva').val(), $('#Formulario').val())"> -->
								<option></option>
								<?php
								$link=Conectarse();
								$bdRec=$link->query("SELECT * FROM recursos Order By nPos");
								while($rowRec=mysqli_fetch_array($bdRec)){
										$tForm = $rowRec['Formulario'].'('.$rowRec['Recurso'].')';
										?>
										<option value="<?php echo $tForm; ?>"><?php echo $tForm; ?></option>
									<?php
								}
								$link->close();
								?>
							</select>
						</td>
						<td id="CajaOpcDatos" valign="top">
							<select ng-change	= "docGastosUP()"
									ng-model	= "cIva"
									name		= "cIva" 
									class		= "form-control"
									id			= "cIva">
									<!-- onChange	= "realizaProceso($('#IdProyecto').val(), $('#Iva').val(), $('#Formulario').val())"> -->
								<option></option>
								<option value="cIva">Con Iva	</option>
								<option value="sIva" >Sin Iva	</option>
							</select>
						</td>
						<td id="CajaOpcDatos" valign="top">
							<select ng-model 	= "IdProyecto" 
									ng-change	= "docGastosUP()"
									name 		= "IdProyecto" 
									class		= "form-control"
									id			= "IdProyecto"> 
									<!-- onChange	= "realizaProceso($('#IdProyecto').val(), $('#Iva').val(), $('#Formulario').val())"> -->
								<option></option>
									<?php
										$link=Conectarse();
										$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
										while($row=mysqli_fetch_array($bdPr)){
											?>
												<option value="<?php echo $row['IdProyecto']; ?>"><?php echo $row['IdProyecto']; ?></option>
												<?php
										}
										$link->close();
									?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td colspan="3">
							<script>
								var IdProyecto 	= "<?php echo $IdProyecto; 	?>" ;
								var Iva 		= "<?php echo $Iva; 		?>" ;
								var Formulario 	= "<?php echo $Formulario; 	?>" ;
								realizaProceso(IdProyecto, Iva, Formulario);
							</script>
							<span id="resultado"></span>
						</td>
					<tr>
				</table>


				<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">#			</th>
								<th scope="col">Cuentas<br>Receptoras 	</th>
								<th scope="col">Fecha		</th>
								<th scope="col">Proveedor	</th>
								<th scope="col">Tp.Doc. 	</th>
								<th scope="col">Servicio 	</th>
								<th scope="col">Iva 		</th>
								<th scope="col">Costo 		</th>
								<th scope="col">Centro Costo</th>
								<th scope="col">Proyecto 	</th>
								<th scope="col">Acciones 	</th>
							</tr>
						</thead>
						<tbody>	
							<!-- <tr ng-repeat="x in dataGastos | filter: filtroTabla(Formulario, IdProyecto, cIva)  " class="table-success"> -->
							<tr ng-repeat="x in dataGastos" class="table-success">
								<td> {{x.nGasto}} 			</td>
								<td> {{x.Recurso}} 			</td>
								<td> {{x.FechaGasto}} 		</td>
								<td> {{x.Proveedor}} 		</td>
								<td>
									<div ng-if="x.TpDoc=='B'">Boleta {{x.nDoc}} </div>
									<div ng-if="x.TpDoc=='F'">Factura {{x.nDoc}} </div> 
								</td>
								<td> {{x.Bien_Servicio}} </td>
								<td> {{x.cIva}} </td>
								<td> 
									<div ng-if="x.TpDoc=='B'"> {{x.Bruto}} </div>
									<div ng-if="x.TpDoc=='F'"> {{x.Iva}} {{x.Bruto}} </div>
								</td>
								<td> {{x.Items}} 			</td>
								<td> {{x.IdProyecto}} 		</td>
								<td> Acciones </td> 
							</tr>
						</tbody>
				</table>			

			</div>
		</div>
	</div>

	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="../angular/angular.min.js"></script>
	<script src="moduloGastos.js"></script>

</body>
</html>