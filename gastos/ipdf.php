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
	
	$Proceso = '';
	
	if(isset($_POST['borrarFormulario'])){
		$link=Conectarse();
		$bdFor=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$_POST['nInforme']."'");
		if($rowFor=mysqli_fetch_array($bdFor)){
			$bdFor=$link->query("DELETE FROM Formularios WHERE nInforme = '".$_POST['nInforme']."'");
			
			$bdGas=$link->query("SELECT * FROM MovGastos WHERE nInforme = '".$_POST['nInforme']."'");
			if($rowGas=mysqli_fetch_array($bdGas)){ 
				$Estado 		= ' ';
				$FechaBlanca 	= '0000-00-00';
				$nInforme 		= ' ';
				$Reembolso		= '';
				
				$actSQL="UPDATE MovGastos SET ";
				$actSQL.="Estado			='".$Estado."',";
				$actSQL.="FechaInforme		='".$FechaBlanca."',";
				$actSQL.="nInforme			='".$nInforme."',";
				$actSQL.="Reembolso			='".$Reembolso."',";
				$actSQL.="Fotocopia			='".$Estado."',";
				$actSQL.="fechaFotocopia	='".$FechaBlanca."',";
				$actSQL.="Reembolso			='".$Estado."',";
				$actSQL.="fechaReembolso	='".$FechaBlanca."'";
				$actSQL.="WHERE nInforme	= '".$nInforme."'";
				$bdVa=$link->query($actSQL);

				//$bdGas=$link->query("DELETE FROM MovGastos WHERE nInforme = '".$_POST['nInforme']."'");
			}
		}
		$link->close();
	}
	
	$Mes = array(
					1 => 'Enero		', 
					2 => 'Febrero	',
					3 => 'Marzo		',
					4 => 'Abril		',
					5 => 'Mayo		',
					6 => 'Junio		',
					7 => 'Julio		',
					8 => 'Agosto	',
					9 => 'Septiembre',
					10 => 'Octubre	',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);

	$MesNum = array(
					'Enero' 		=> 1, 
					'Febrero' 		=> 2,
					'Marzo' 		=> 3,
					'Abril' 		=> 4,
					'Mayo' 			=> 5,
					'Junio' 		=> 6,
					'Julio' 		=> 7,
					'Aosto' 		=> 8,
					'Septiembre'	=> 9,
					'Octubre' 		=> 10,
					'Noviembre' 	=> 11,
					'Diciembre' 	=> 12
				);

	/* Declaracion de Variables */
	$fd 	= explode('-', date('Y-m-d'));
	$MesGasto 	= $fd[1];
	$filtroSQL = "";
	$Proyecto = "Proyectos";

	/* Recive VAriables GET - POST */
	$Agno = date('Y');
	if(isset($_GET['MesGasto'])){ $MesGasto = $_GET['MesGasto']; }
	if(isset($_GET['Agno'])) 	{ $Agno 	= $_GET['Agno']; 	 }

	$link=Conectarse();
	$sql = "SELECT * FROM Formularios Where Modulo = 'G'";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el n�mero de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: ipdf.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM Formularios Where Modulo = 'G'";  // sentencia sql
		$result = $link->query($sql);
		$numero = $result->num_rows; // obtenemos el n�mero de filas
		$link->close();
		if($numero==0){
			header("Location: ipdf.php");
		}
	}
	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM Formularios Where Modulo = 'G'");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Intranet Simet</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

</head>

<body ng-app="myApp" ng-controller="ctrlGastos">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
				<?php 
					$nomModulo = 'Formularios Emitidos';
					include('menuIconos.php'); 
					include('barraOpciones.php')
				?>
			
			<div class="row bg-primary text-white p-2">
				<div class="col-sm-1"><img src="imagenes/data_filter_128.png" width="28" height="28"></div>
				<div class="col-sm-4">
					<!-- Fitra por Proyecto -->
					<select class="form-control" name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){ 		$Items 		= $_GET['Items'];	}else{ $Items 	= "Gastos"; 		}
							if(isset($_GET['Recurso'])){ 	$Recurso 	= $_GET['Recurso']; }else{ $Recurso = "Recursos"; 		}
	
							$Proyecto = "Proyectos";
							if(isset($_GET['Proyecto'])){
								$Proyecto = $_GET['Proyecto'];
								echo "<option selected value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$Agno."'>".$Proyecto."</option>";
							}else{
								echo "<option selected value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$Agno."'>".$Proyecto."</option>";
							}
							echo "<option value='ipdf.php?Proyecto=Proyectos&Items=".$Items."&MesGasto=".$MesGasto."&Agno=".$Agno."'>Proyectos</option>";
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							while ($row=mysqli_fetch_array($bdPr)){
								echo "	<option value='ipdf.php?Proyecto=".$row['IdProyecto']."&MesGasto=".$MesGasto."'>".$row['IdProyecto']."</option>";
							}
							$link->close();
						?>
					</select>
				</div>
				<div class="col-sm-3">
					<!-- Fitra por Fecha -->
					<select class="form-control" name='MesGasto' id='MesGasto' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
						<?php
							for($i=1; $i<=12; $i++){
								if($i == $MesGasto){
									echo "<option selected value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$i."&Agno=".$Agno."'>".$Mes[$i]."</option>";
								}else{
									echo "<option value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$i."&Agno=".$Agno."'>".$Mes[$i]."</option>";
								}
							}
							?>
					</select>
					<!-- Fin Filtro -->

				</div>
				<div class="col-sm-3">
					<!-- Fitra por A�o -->
					<select class="form-control" name='Agno' id='Agno' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
						<?php
							$AgnoAct = date('Y');
							for($a=2013; $a<=$AgnoAct; $a++){
								if($a == $Agno){
									echo "<option selected 	value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
								}else{
									echo "<option  			value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
								}
							}
						?>
					</select>
					<!-- Fin Filtro -->
				</div>
			</div>

			<div align="center">
				<table class="table table-dark table-hover">
					<thead>
						<tr>
							<th><strong>N°				</strong></th>
							<th><strong>Fecha 			</strong></th>
							<th><strong>Formulario		</strong></th>
							<th><strong>Proyecto		</strong></th>
							<th><strong>Impto.			</strong></th>
							<th><strong>N° Doc.		</strong></th>
							<th><strong>Concepto		</strong></th>
							<th><strong>Neto			</strong></th>
							<th><strong>IVA			</strong></th>
							<th><strong>Total			</strong></th>
							<th>	Acciones			</th>
						</tr>
					</thead>
					</tbody>

						<!-- <tr class="table-secondary text-dark" ng-repeat="x in dataSolicitudes">
							<td> {{x.nInforme}} 												</td>
							<td> {{x.Fecha | date:'dd/MM/yyyy'}} 								</td>
							<td> {{x.Formulario}} 												</td>
							<td> {{x.IdProyecto}} 												</td>
							<td> {{x.Impuesto}} 												</td>
							<td>  				</td>
							<td> {{x.Concepto}} 												</td>
							<td> <div ng-if="x.Neto > 0">	{{x.Neto 	| formatoNumero }}</div> </td>
							<td> <div ng-if="x.Iva > 0">	{{x.Iva 	| formatoNumero }}</div> </td>
							<td> <div ng-if="x.Bruto > 0">	{{x.Bruto 	| formatoNumero }}</div> </td>
							<td>
								<?php
							 		$ff = explode('(', '{{x.Formulario}}');
				 					$doc = $ff[0].'-'.$row['nInforme'].'.pdf';
				 					// $vDir = 'Y://AAA/Archivador-'.$Agno.'/Finanzas/Gastos/Reembolsos/';;
				 					$vDir = 'Y://AAA/LE/FINANZAS/'.$Agno.'/GASTOS/';;
				 					if($ff[0] == 'F7'){ 
				 						// $vDir = 'Y://AAA/Archivador-'.$Agno.'/Finanzas/Gastos/PagoFacturas/';;
				 						$vDir = 'Y://AAA/LE/FINANZAS/'.$Agno.'/GASTOS/';;
				 					}
				 					$vTmp = 'tmp/'.$doc;
				 					$vDoc = $vDir.$doc;
				 					if(file_exists($vDoc)){
										echo $doc;
										 ?>
				 						<!-- <a href="'.$vTmp.'" target="_blank"><?php //echo $doc; ?></a> -->
									<?php}else{?>
										<!-- <a href="formularios/F7.php?Concepto="{{x.Concepto}}"&nInforme="{{x.nInforme}}"&Formulario="{{x.Formulario}}"&IdProyecto="{{x.IdProyecto}}"&Impuesto="{{x.Impuesto"&Fecha="{{x.Fecha}}"><img src="imagenes/pdf.png" width="28" height="28" title="Imprimir Informe PDF"></a> -->
										<?php}?>
				 						<a href="ipdf.php?Proceso=5&nInforme='.$row['nInforme'].'&Formulario='.$tFormulario.'&IdProyecto='.$row['IdProyecto'].'"><img src="imagenes/del_128.png" width="28" height="28" title="Eliminar"></a>
										<?php
									}
								?>
							</td>
						</tr>
					</tbody>
				</table> -->
			<?php
				$n = 0;
				$tNeto 	= 0;
				$tIva	= 0;
				$tBruto	= 0;
				$link=Conectarse();

				$result  = $link->query("SELECT SUM(Neto) as tNeto, SUM(Iva) as tIva, SUM(Bruto) as tBruto FROM MovGastos WHERE Estado!='I'");  
				//$row   = mysqli_fetch_array($result, MYSQL_ASSOC);
				$row 	 = mysqli_fetch_array($result);
				$tNetos  = $row["tNeto"];
				$tIvas   = $row["tIva"];
				$tBrutos = $row["tBruto"];
				
				/* Genera Filtro SQL*/
				//$filtroSQL .= "Where (Formulario = 'F7' || Formulario = 'F3B(Itau)' || Formulario = 'F3B(AAA)') "; 


				$filtroSQL .= "Where Modulo = 'G' "; 
				if($Proyecto != "Proyectos"){
					$filtroSQL .= " && IdProyecto='".$Proyecto."'"; 
				}
				$bdGto=$link->query("SELECT * FROM Formularios ".$filtroSQL." Order By nInforme Desc, Fecha Desc");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$IdRecurso = '';
						$bdG=$link->query("SELECT * FROM MovGastos Where nInforme = '".$row['nInforme']."'");
						if($rowG=mysqli_fetch_array($bdG)){
							$IdRecurso = $rowG['IdRecurso'];
						}

						$tFormulario = '';
						$bdRec=$link->query("SELECT * FROM recursos Where IdRecurso = '".$IdRecurso."'");
						if($rowRec=mysqli_fetch_array($bdRec)){
							$tFormulario = $rowRec['Formulario'].'('.$rowRec['Recurso'].')';
						}
						
						$fd 	= explode('-', $row['Fecha']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						if($fd[1]==$MesGasto && $Agno == $fd[0]){
							$n++;
							$tNeto	+= $row['Neto'];
							$tIva	+= $row['Iva'];
							$tBruto	+= $row['Bruto'];
							echo '<tr class="table-secondary text-dark">';
							echo '			<td width=" 5%">'.$row['nInforme'].'		</td>';
							echo '			<td width=" 8%">'.$Fecha.'					</td>';
							echo '			<td width="15%">'.$tFormulario.'		</td>';
							echo '			<td width="5%">'.$row['IdProyecto'].'		</td>';
							echo '			<td width=" 6%">'.$row['Impuesto'].'		</td>';
							echo '			<td width=" 6%">'.$row['nDocumentos'].'		</td>';
							echo '			<td width="15%">'.$row['Concepto'].'		</td>';
							echo '			<td width="08%">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
							echo '			<td width="08%">'.number_format($row['Iva']	 , 0, ',', '.').'				</td>';
							echo '			<td width=" 9%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
	    					echo '			<td width="10%">';
												$ff = explode('(', $tFormulario);
												$doc = $ff[0].'-'.$row['nInforme'].'.pdf';
												// $vDir = 'Y://AAA/Archivador-'.$Agno.'/Finanzas/Gastos/Reembolsos/';;
												$vDir = 'Y://AAA/LE/FINANZAS/'.$Agno.'/GASTOS/';;
												if($ff[0] == 'F7'){ 
													$vDir = 'Y://AAA/LE/FINANZAS/'.$Agno.'/GASTOS/';
												}
												$vTmp = 'tmp/'.$doc;
												$vTmp = 'tmp/';
												//$vDoc = $vDir.$doc;
												$vDoc = $vTmp.$doc;
												//echo $vDoc;
												if(file_exists($vDoc)){
													//echo '<a href="'.$vTmp.'" target="_blank">'.$doc.'</a>'; 
													echo '<a href="'.$vDoc.'" target="_blank"><img src="../imagenes/informes.png"  width="32" style="margin: 2px;"></a>'; 
												}
												//echo substr($tFormulario,0,2);
												if(substr($tFormulario,0,2) == 'F7'){
													echo '<a href="formularios/F7Compilado.php?Concepto='.$row['Concepto'].'&nInforme='.$row['nInforme'].'&Formulario='.$tFormulario.'&IdProyecto='.$row['IdProyecto'].'&Impuesto='.$row['Impuesto'].'&Fecha='.$Fecha.'"><img src="imagenes/pdf.png" width="28" height="28" title="Reimprimir pago de Factura"></a>';
												}
												if(substr($tFormulario,0,2) == 'F3'){
													echo '<a href="formularios/F7Compilado.php?Concepto='.$row['Concepto'].'&nInforme='.$row['nInforme'].'&Formulario='.$tFormulario.'&IdProyecto='.$row['IdProyecto'].'&Impuesto='.$row['Impuesto'].'&Fecha='.$Fecha.'"><img src="imagenes/pdf.png" width="28" height="28" title="Reimprimir Gastos"></a>';
												}
												//window.location.href = 'formularios/F3BCompilado.php?Formulario='+$scope.Formulario+'&Iva='+$scope.cIva+'&IdProyecto='+$scope.IdProyecto+'&Concepto='+$scope.Concepto;

							echo '				<a href="ipdf.php?Proceso=5&nInforme='.$row['nInforme'].'&Formulario='.$tFormulario.'&IdProyecto='.$row['IdProyecto'].'"><img src="imagenes/del_128.png" width="28" height="28" title="Eliminar"></a>';
							echo '			</td>';
							echo '		</tr>';
						}
					}WHILE ($row=mysqli_fetch_array($bdGto));
				}
				$link->close();
			?>
					</tbody>
				</table>
		</div>
	</div>

<?php
				if(isset($_GET['Proceso']) == 5){
					?>
					<div class="boxEliminacion">
						<form name="form" action="ipdf.php" method="post">
							Seguro de borrar <b>Formulario</b>?
							<br><br>
							<hr>
							<table width="100%">
								<tr>
									<td width="24%">N° Formulario</td>
									<td>:
										<?php echo $_GET['nInforme']; ?>
										<input name="nInforme" type="hidden" value="<?php echo $_GET['nInforme']; ?>">
									</td>
								</tr>
								<tr>
									<td>Proyecto</td>
									<td>:
										<?php
											$link=Conectarse();
											$bdDet=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$_GET['nInforme']."'");
											if($rowDet=mysqli_fetch_array($bdDet)){
												$Fecha 		= $rowDet['Fecha'];
												$Concepto	= $rowDet['Concepto'];
												$IdProyecto	= $rowDet['IdProyecto'];
											}
											$link->close();
											echo $IdProyecto; 
										?>
										<input name="IdProyecto" type="hidden" value="<?php echo $_GET['IdProyecto']; ?>">
									</td>
								</tr>
								<tr>
									<td>Fecha Informe</td>
									<td>:
										<?php 
											$fd = explode('-', $Fecha);
											echo $fd[2].'-'.$fd[1].'-'.$fd[0];
										?>
									</td>
								</tr>
								<tr>
									<td>Concepto</td>
									<td>:
										<?php 
											echo $Concepto;
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
								<tr>
									<td colspan="2" align="right">							
										<button name="cancelarEliminacion" title="Cancelar">
											<img src="../gastos/imagenes/flecha_return.png" width="100" height="100">
										</button>
										<button name="borrarFormulario" title="Borrar Formulario">
											<img src="../gastos/imagenes/inspektion.png" width="100" height="100">
										</button>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<?php
				}
?>



	<div style="clear:both; "></div>
	<br>

	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="../angular/angular.min.js"></script>
	<script src="moduloGastosSolicitudes.js"></script>

</body>
</html>
