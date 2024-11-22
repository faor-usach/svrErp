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
	if(isset($_GET['nInforme']))	{ $nInforme = $_GET['nInforme']; 	}
	if(isset($_POST['nInforme']))	{ $nInforme = $_POST['nInforme']; 	}
	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el n�mero de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: ingresocaja.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM MovGastos";  // sentencia sql
		$result = $link->query($sql);
		$numero = $result->num_rows; // obtenemos el n�mero de filas
		$link->close();
		if($numero==0){
			header("Location: registragastos.php");
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
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
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
<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
<script type="text/javascript" src="../angular/angular.js"></script>

<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

</head>

<body ng-app="myApp" ng-controller="CtrlGastos">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<span style="color:#FFFFFF; font-size:24px; ">Gastos</span>
				 <!-- <img src="imagenes/room_32.png" width="28" height="28"> -->
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="imagenes/preview_exit_32.png" width="28" height="28">
					</a>
				</div>
			</div>
			<?php include('barraOpciones.php'); ?>

			<div id="BarraFiltro">
				<!--
				<img src="imagenes/data_filter_128.png" width="28" height="28"> 
				-->
					<!-- Fitra por Proyecto
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){ 		$Items 		= $_GET['Items'];	}else{ $Items 	= "Gastos"; 		}
							if(isset($_GET['Recurso'])){ 	$Recurso 	= $_GET['Recurso']; }else{ $Recurso = "Recursos"; 		}

							$Proyecto = "Proyectos";
							if(isset($_GET['Proyecto'])){
								$Proyecto = $_GET['Proyecto'];
								echo "<option selected value='plataformaintranet.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."'>".$Proyecto."</option>";
							}else{
								echo "<option selected value='plataformaintranet.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."'>".$Proyecto."</option>";
							}
							echo "<option value='plataformaintranet.php?Proyecto=Proyectos&Items=".$Items."&Recurso=".$Recurso."'>Proyectos</option>";
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if ($row=mysqli_fetch_array($bdPr)){
								DO{
			    					echo "	<option value='plataformaintranet.php?Proyecto=".$row['IdProyecto']."&Items=".$Items."&Recurso=".$Recurso."'>".$row['IdProyecto']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdPr));
							}
							$link->close();
						?>
					</select>
					-->
					<!-- Fitra por Tipo de Gasto
	  				<select name="TpGasto" id="TpGasto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){
								$Items = $_GET['Items'];
								echo "<option selected value='plataformaintranet.php?Items=".$Items."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$Items."</option>";
							}else{
								echo "<option selected value='plataformaintranet.php?Items=".$Items."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$Items."</option>";
							}
							echo "<option value='plataformaintranet.php?Items=Gastos&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>Gastos</option>";
							$link=Conectarse();
							$bdIt=$link->query("SELECT * FROM ItemsGastos Order By Items");
							if ($row=mysqli_fetch_array($bdIt)){
								DO{
			    					echo "	<option value='plataformaintranet.php?Items=".$row['Items']."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$row['Items']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdIt));
							}
							$link->close();
						?>
					</select>
					-->
					<!-- Fin Filtro -->

					<!-- Fitra por Recurso
	  				<select name="TpGasto" id="TpGasto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$Recurso = "Recursos";
							if(isset($_GET['Recurso'])){
								$Recurso = $_GET['Recurso'];
								echo "<option selected value='plataformaintranet.php?Recurso=".$Recurso."&Proyecto=".$Proyecto."&Items=".$Items."'>".$Recurso."</option>";
							}else{
								echo "<option selected value='plataformaintranet.php?Recurso=".$Recurso."&Proyecto=".$Proyecto."&Items=".$Items."'>".$Recurso."</option>";
							}
							echo "<option value='plataformaintranet.php?Recurso=Recursos&Proyecto=".$Proyecto."&Items=".$Items."'>Recursos</option>";
							$link=Conectarse();
							$bdRec=$link->query("SELECT * FROM Recursos");
							if ($row=mysqli_fetch_array($bdRec)){
								DO{
			    					echo "	<option value='plataformaintranet.php?Recurso=".$row['Recurso']."&Proyecto=".$Proyecto."&Items=".$Items."'>".$row['Recurso']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdRec));
							}
							$link->close();
						?>
					</select>
					-->
					<!-- Fin Filtro -->

					<!-- Fitra por Historico
	  					<select name='Estado' id='Estado' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php 
							if($Estado=='N'){
								echo "	<option selected 	value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=N'>No Informados	</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=I'>Informados		</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=T'>Todos			</option>";
							}
							if($Estado=='I'){
								echo "	<option selected 	value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=I'>Informados		</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=N'>No Informados	</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=T'>Todos			</option>";
							}
							if($Estado=='T'){
								echo "	<option selected 	value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=T'>Todos			</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=N'>No Informados	</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=I'>Informados		</option>";
							}
							?>
						</select>
						-->
					<!-- Fin Filtro -->
					
			</div>
			
			<div class="row bg-secondary p-2" ng-init="loadSolicitud('<?php echo $nInforme; ?>')">
				<div class="col-md-1">
					<a href="regGtosAdd.php?nInforme=<?php echo $nInforme; ?>" class="btn btn-info" role="button">+ Gasto</a>
				</div>
				<div class="col-md-1">
					<span class="text-warning"><b>Concepto: </b></span>
				</div>
				<div class="col-md-5">
					<?php
						// $link=Conectarse();
						// $bdForm=$link->query("SELECT * FROM formularios WHERE nInforme = '".$nInforme."'");
						// if($rowForm=mysqli_fetch_array($bdForm)){
						// 	$Concepto = $rowForm['Concepto'];
						// }
						// $link->close();
					?>
					<input class="form-control" type="hidden" name="nInforme" ng-model="nInforme">
					<input class="form-control" type="text" name="Concepto" ng-model="Concepto"  require/>
				</div>
				<div class="col-md-1">
					<a href="#" ng-click="GuargarConcepto()" class="btn btn-info" role="button">Act. Concepto</a>
				</div>
				<div class="col-md-4">
					<input  id="archivosSeguimiento" ng-model="archivosSeguimiento" multiple type="file"> {{solicitud}}
					<button class="btn btn-warning" type="button" ng-click="enviarFormulario()">
						Reemplazar
					</button>
				</div>
			</div>


			<?php
				echo '<div align="center">';
				echo '	<table border="0" cellspacing="0" width=100% cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width=" 5%"><strong>N° Gto.		</strong></td>';
				echo '			<td  width=" 8%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="15%"><strong>Proveedor		</strong></td>';
				echo '			<td  width="10%"><strong>Tip.Doc.		</strong></td>';
				echo '			<td  width=" 7%"><strong>N° Doc.		</strong></td>';
				echo '			<td  width="15%"><strong>Bien o Servicio</strong></td>';
				echo '			<td  width=" 5%"><strong>Bruto			</strong></td>';
				echo '			<td  width="10%"><strong>Proyecto		</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				$n = 0;
				$IdProyecto = "";
				$link=Conectarse();
				$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
				if($row=mysqli_fetch_array($bdPr)){
			    	$IdProyecto = $row['IdProyecto'];
					if($filtroSQL==""){
						$filtroSQL .= "&&IdProyecto='".$row['IdProyecto']."'"; 
					}else{
						$filtroSQL .= "&&IdProyecto='".$row['IdProyecto']."'"; 
					}
				}

				$bdIt=$link->query("SELECT * FROM ItemsGastos Where Items = '".$Items."'");
				if($row=mysqli_fetch_array($bdIt)){
					if($filtroSQL==""){
						$filtroSQL = "Where nItem ='".$row['nItem']."'"; 
					}else{
						$filtroSQL .= "&&nItem ='".$row['nItem']."'"; 
					}
				}

				$bdRec=$link->query("SELECT * FROM Recursos Where Recurso = '".$Recurso."'");
				if($row=mysqli_fetch_array($bdRec)){
					if($filtroSQL==""){
						$filtroSQL = "Where IdRecurso ='".$row['IdRecurso']."'"; 
					}else{
						$filtroSQL .= "&&IdRecurso ='".$row['IdRecurso']."'"; 
					}
				}

				$link->close();
				// echo "Consulta SQL = ".$filtroSQL;

				
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

				//$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc Limit $inicio, $nRegistros");
				$bdGto=$link->query("SELECT * FROM MovGastos Where nInforme = '".$nInforme."' Order By FechaGasto Desc");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$n++;
						$tNeto	+= $row['Neto'];
						$tIva	+= $row['Iva'];
						$tBruto	+= $row['Bruto'];
/*
						if($row['Estado'] == 'I'){
							echo '<tr bgcolor="#FFFF66">';
						}else{
							echo '<tr>';
						}
*/
						echo '<tr id="barraVerde">';

						echo '			<td width=" 5%">'.$row['nGasto'].'			</td>';
						$fd 	= explode('-', $row['FechaGasto']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						echo '			<td width=" 8%">'.$Fecha.'		</td>';
						echo '			<td width="15%">'.$row['Proveedor'].'		</td>';
						echo '			<td width="10%">';
						if($row['TpDoc']=="B"){
							echo 'Boleta';
						}else{
							echo 'Factura';
						}
						echo '			</td>';
						echo '			<td width=" 7%">'.$row['nDoc'].'			</td>';
						echo '			<td width="15%">'.$row['Bien_Servicio'].'	</td>';
						echo '			<td width=" 5%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
						echo '			<td width="10%">'.$row['IdProyecto'].'			</td>';
    					echo '			<td><a href="registragastos.php?Proceso=2&nGasto='.$row['nGasto'].'"><img src="imagenes/corel_draw_128.png"   width="22" height="22" title="Editar Ficha"     ></a></td>';
    					echo '			<td><a href="registragastos.php?Proceso=3&nGasto='.$row['nGasto'].'"><img src="imagenes/delete_32.png" 		width="22" height="22" title="Eliminar Personal"></a></td>';
						echo '		</tr>';
					}while ($row=mysqli_fetch_array($bdGto));
				}
				$link->close();
				echo '	</table>';
				if($tBruto > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="13%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total Página</td>';
					echo '			<td width=" 5%">'.number_format($tBruto, 0, ',', '.').'			</td>';
					echo '			<td width="10%">&nbsp;</td>';
    				echo '			<td>&nbsp;</td>';
    				echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="13%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total No Informado</td>';
					echo '			<td width=" 5%">'.number_format($tNetos , 0, ',', '.').'			</td>';
					echo '			<td width=" 5%">'.number_format($tIvas  , 0, ',', '.').'			</td>';
					echo '			<td width=" 5%">'.number_format($tBrutos, 0, ',', '.').'			</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
    				echo '			<td>&nbsp;</td>';
    				echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '	</table>';
				}

				if($n >= $nRegistros || $inicio > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td align="center">';
					echo '				<a href="plataformaintranet.php">Inicio</a> |';
					echo '				<a href="plataformaintranet.php?inicio='.$inicio.'">Anterior</a> |';
					echo '				<a href="plataformaintranet.php?limite='.$limite.'">Siguiente</a> |';
					echo '				<a href="plataformaintranet.php?ultimo=fin">Final</a>';
					echo '			</td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>


		</div>
	</div>
	<div style="clear:both; "></div>
	<br>


	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="gastos.js"></script>


</body>
</html>
