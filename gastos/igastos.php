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
	$Estado 	= "";
	$filtroSQL	= '';

	$Mes = array(
					'Enero', 
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				);

	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);
				
	$fd 		= explode('-', date('Y-m-d'));
	$Agno		= $fd[0];
	$MesGasto 	= $fd[1];
	if(isset($_GET['MesGasto'])) 	{ $MesGasto 	= $_GET['MesGasto']; }
	if(isset($_GET['Agno'])) 	 	{ $Agno 		= $_GET['Agno']; 	 }

	if(isset($_POST['MesGasto'])) 	{ $MesGasto 	= $_POST['MesGasto'];}
	if(isset($_POST['Agno'])) 	 	{ $Agno 		= $_POST['Agno']; 	 }
	//echo $MesGasto;
	
	$link=Conectarse();
	$sql = "SELECT * FROM MovGastos";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el n�mero de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: igastos.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM MovGastos";  // sentencia sql
		$result = $link->query($sql);
		$numero = $result->num_rows; // obtenemos el n�mero de filas
		$link->close();
		if($numero==0){
			header("Location: igastos.php");
		}
	}
	$nRegistros = 1000;
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

	<title>Gastos</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

</head>

<body ng-app="myApp" ng-controller="ctrlGastos">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<?php 
				$nomModulo = 'Informe de Gastos';
				include('menuIconos.php'); 
				include('barraOpciones.php'); 
			?>
			<form name"form" action="igastos.php" method="post">
			
			<div id="BarraFiltro">
				<img src="imagenes/data_filter_128.png" width="28" height="28">
					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){ 		$Items 		= $_GET['Items'];	}else{ $Items 	= "Gastos"; 		}
							if(isset($_GET['Recurso'])){ 	$Recurso 	= $_GET['Recurso']; }else{ $Recurso = "Recursos"; 		}
							echo "Entra";
							$Proyecto = "Proyectos";
							if(isset($_GET['Proyecto'])){
								$Proyecto = $_GET['Proyecto'];
								echo "<option selected value='igastos.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."&Estado=".$Estado."&MesGasto=".$MesGasto."'>".$Proyecto."</option>";
							}else{
								echo "<option selected value='igastos.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."&Estado=".$Estado."&MesGasto=".$MesGasto."'>".$Proyecto."</option>";
							}
							echo "<option value='igastos.php?Proyecto=Proyectos&Items=".$Items."&Recurso=".$Recurso."&Estado=".$Estado."&MesGasto=".$MesGasto."'>Proyectos</option>";
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if ($row=mysqli_fetch_array($bdPr)){
								DO{
			    					echo "	<option value='igastos.php?Proyecto=".$row['IdProyecto']."&Items=".$Items."&Recurso=".$Recurso."&Estado=".$Estado."&MesGasto=".$MesGasto."'>".$row['IdProyecto']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdPr));
							}
							$link->close();
						?>
					</select>

					<!-- Fin Filtro -->
					<!-- Fitra por Fecha -->
					<!-- Fitra A�o -->
	  					<select name='Agno' id='Agno'>
							<option selected value='<?php echo $Agno; ?>'><?php echo $Agno; ?></option>";
							<?php 
								for($i=$fd[0]; $i>=2014; $i--){?>
									<option value='<?php echo $i; ?>'><?php echo $i; ?></option>";
								<?php
								}
							?>
						</select>
					<!-- Fin Filtro -->
	  					<select name='MesGasto' id='MesGasto'>
							<option selected value='<?php echo $Mes[intval($MesGasto)-1]; ?>'><?php echo $Mes[intval($MesGasto)-1]; ?></option>
							<?php 
								for($i=1; $i<=12; $i++){?>
									<option value='<?php echo $i; ?>'><?php echo $Mes[$i-1]; ?></option>
								<?php 
								}
							?>
						</select>
						<button>
							Filtrar
						</button>
						
					<!-- Fin Filtro -->
					<div style="background-color:#FF0000; color:#FFFFFF; height:20px; width:50px; display:inline; padding:5px; ">Sin Reembolso</div>
					<div style="background-color:#0066CC; color:#FFFFFF; height:20px; width:50px; display:inline; padding:5px; ">Reembolsado</div>
			</div>
			</form>
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="10%"><strong>Empresa		</strong></td>';
				
				echo '			<td  width="10%"><strong>Documento		</strong></td>';
				echo '			<td  width="10%"><strong>Glosa			</strong></td>';
				
				echo '			<td  width="10%"><strong>Proyecto		</strong></td>';
				echo '			<td  width="10%"><strong>Neto			</strong></td>';
				echo '			<td  width="10%"><strong>IVA			</strong></td>';
				echo '			<td  width="10%"><strong>Bruto			</strong></td>';
				echo '			<td  width="20%"><strong>Procesos		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				
				$IdProyecto = "";
				$link=Conectarse();
				$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
				if($row=mysqli_fetch_array($bdPr)){
			    	$IdProyecto = $row['IdProyecto'];
					if($filtroSQL==""){
						$filtroSQL .= "Where IdProyecto='".$row['IdProyecto']."'"; 
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
				if($Estado=="I"){
					if($filtroSQL==""){
						$filtroSQL = "Where Estado ='".$Estado."'"; 
					}else{
						$filtroSQL .= "&& Estado ='".$Estado."'"; 
					}
				}else{
					if($filtroSQL==""){ 
						$filtroSQL = "Where 1"; 
						// $filtroSQL = "Where Estado != 'I'"; 
					}else{
						$filtroSQL .= "&& Estado != 'I'"; 
					}
				}



				//$filtroSQL = "Where FechaGasto = '".date("m")."'";
				//echo "Filtro : ".$filtroSQL;





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

				$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." and year(FechaGasto) = $Agno Order By  nInforme, FechaGasto Desc");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$n++;
						$fd 	= explode('-', $row['FechaGasto']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						if($fd[1]==$MesGasto){
						
						$tNeto	+= $row['Neto'];
						$tIva	+= $row['Iva'];
						$tBruto	+= $row['Bruto'];
/*						
						if($row['Estado'] == 'I'){
							echo '<tr id="barraVerde">';
						}else{
							echo '<tr id="barraVerde">';
						}
*/						
						$fechaHoy = date('Y-m-d');
						$fd 	= explode('-', $fechaHoy);

						$fdG 	= explode('-', $row['FechaGasto']);
						
						if($row['Reembolso'] == 'on'){
							echo '<tr id="barraAzul">';
						}else{
							if($row['Estado'] == 'I'){
								echo '<tr id="barraRoja">';
							}else{
								echo '<tr id="barraVerde">';
							}
						}
						echo '			<td width="10%" align="center">'.$Fecha;
						$link=Conectarse();
						$bdIt = $link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
						if ($rowIt=mysqli_fetch_array($bdIt)){
							$Items = $rowIt['Items'];
						}

						$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '".$row['IdRecurso']."'");
						if($rowRec=mysqli_fetch_array($bdRec)){
							$nRecurso = $rowRec['Recurso'];
						}
						echo '				<br>('.$nRecurso.')';
						echo '				<br>Re.'.$row['nInforme'];
						echo '			</td>';
						echo '			<td width="10%">'.$row['Proveedor'].'			</td>';
						echo '			<td width="10%">';
											if($row['TpDoc'] == 'F'){
												echo 'Factura';
											}
											if($row['TpDoc'] == 'B'){
												echo 'Boleta';
											}
						echo				'<br>'.$row['nDoc'];
						echo '			</td>';
						echo '			<td width="10%">'.$row['Bien_Servicio'].'		</td>';
						echo '			<td width="10%">'.$row['IdProyecto'].'			</td>';
						echo '			<td width="10%" align="right">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
						echo '			<td width="10%" align="right">'.number_format($row['Iva']  , 0, ',', '.').'				</td>';
						echo '			<td width="10%" align="right">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
	    				echo '			<td width="20%">
											<a href="registragastos.php?Proceso=2&nGasto='.$row['nGasto'].'&TpDoc='.$row['TpDoc'].'"><img src="imagenes/corel_draw_128.png" width="32" height="32" title="Editar"></a>
											<a href="registragastos.php?Proceso=3&nGasto='.$row['nGasto'].'&TpDoc='.$row['TpDoc'].'"><img src="imagenes/inspektion.png" width="32" height="32" title="Eliminar"></a>
										</td>';
						echo '		</tr>';
						}
					}WHILE ($row=mysqli_fetch_array($bdGto));
				}
				
				
				
				$bdGto=$link->query("SELECT * FROM Facturas ".$filtroSQL." and year(FechaFactura) = $Agno Order By  nInforme, FechaFactura Desc");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$n++;
						$fd 	= explode('-', $row['FechaFactura']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						if($fd[1]==$MesGasto){
						
						$tNeto	+= $row['Neto'];
						$tIva	+= $row['Iva'];
						$tBruto	+= $row['Bruto'];
						$fechaHoy = date('Y-m-d');
						$fd 	= explode('-', $fechaHoy);

						$fdG 	= explode('-', $row['FechaFactura']);
						
						if($row['Estado'] == 'P'){
							echo '<tr id="barraAzul">';
						}else{
							echo '<tr id="barraRoja">';
						}
						echo '			<td width="10%" align="center">'.$Fecha;
						$link=Conectarse();
						$bdIt = $link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
						if ($rowIt=mysqli_fetch_array($bdIt)){
							$Items = $rowIt['Items'];
						}

						$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '".$row['IdRecurso']."'");
						if($rowRec=mysqli_fetch_array($bdRec)){
							$nRecurso = $rowRec['Recurso'];
						}
						echo '				<br>('.$nRecurso.')';
						echo '				<br>Re.'.$row['nInforme'];
						echo '			</td>';
						echo '			<td width="10%">';
						$bdPr=$link->query("SELECT * FROM Proveedores Where RutProv = '".$row['RutProv']."'");
						if($rowPr=mysqli_fetch_array($bdPr)){
							echo $rowPr['Proveedor'];
						}
						echo '			</td>';
						echo '			<td width="10%">';
												echo 'Factura Sueldo';
						echo				'<br>'.$row['nFactura'];
						echo '			</td>';
						echo '			<td width="10%">'.$row['Descripcion'].'		</td>';
						echo '			<td width="10%">'.$row['IdProyecto'].'			</td>';
						echo '			<td width="10%" align="right">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
						echo '			<td width="10%" align="right">'.number_format($row['Iva']  , 0, ',', '.').'				</td>';
						echo '			<td width="10%" align="right">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
	    				echo '			<td width="20%">
											<a href="registragastos.php?Proceso=2&nGasto='.$row['nMov'].'&TpDoc=P"><img src="imagenes/corel_draw_128.png" width="32" height="32" title="Editar"></a>
											<a href="registragastos.php?Proceso=3&nGasto='.$row['nMov'].'&TpDoc=P"><img src="imagenes/inspektion.png" width="32" height="32" title="Eliminar"></a>
										</td>';
						echo '		</tr>';
						}
					}WHILE ($row=mysqli_fetch_array($bdGto));
				}

				
				
				$link->close();
				echo '	</table>';
				if($tBruto > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width="20%">&nbsp;</td>';
					echo '			<td width="20%">&nbsp;</td>';
					echo '			<td width="20%">Total Página</td>';
					echo '			<td width="10%" align="right">'.number_format($tNeto , 0, ',', '.').'			</td>';
					echo '			<td width="10%" align="right">'.number_format($tIva  , 0, ',', '.').'			</td>';
					echo '			<td width="10%" align="right">'.number_format($tBruto, 0, ',', '.').'			</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '	</table>';
				}

				if($n >= $nRegistros || $inicio > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td align="center">';
					echo '				<a href="igastos.php">Inicio</a> |';
					echo '				<a href="igastos.php?inicio='.$inicio.'">Anterior</a> |';
					echo '				<a href="igastos.php?limite='.$limite.'">Siguiente</a> |';
					echo '				<a href="igastos.php?ultimo=fin">Final</a>';
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
	<script src="../angular/angular.min.js"></script>
	<script src="moduloGastos.js"></script>

</body>
</html>