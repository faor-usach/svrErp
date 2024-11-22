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

	$Proyecto 	= '';
	$Items		= '';
	$Recurso	= '';

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
	if(isset($_GET['accion'])){
		if($_GET['accion'] == 'Borrar'){
			$link=Conectarse();
			$bdGto=$link->query("SELECT * FROM MovGastos WHERE nInforme = '".$_GET['nInforme']."'");
			if ($rowGto=mysqli_fetch_array($bdGto)){
				?>
					<script>
						alert('Existen Movimientos asociados al formulario...');
					</script>
				<?php
			}else{
				$bdGas=$link->query("DELETE FROM Formularios WHERE nInforme = '".$_GET['nInforme']."'");
				$bdGas=$link->query("DELETE FROM MovGastos 	WHERE nInforme = '".$_GET['nInforme']."'");
			}
			$link->close();
		}
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../angular/angular.min.js"></script>

</head>

<body ng-app="myApp" ng-controller="ctrlGastos">
	<?php include('head.php'); ?>
	<?php //include('../barramenuModulos.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			
			<?php 
				$nomModulo = 'Gastos';
				include('menuIconos.php'); 
				include('barraOpciones.php'); 
			?>
			
			
			<?php
				echo '<div align="center">';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" style="margin-top:10px;">';
				echo '		<tr>';
				echo '			<td  width="05%"><strong>N°				</strong></td>';
				echo '			<td  width="08%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="08%"><strong>Proyecto		</strong></td>';
				echo '			<td  width="05%"><strong>Form			</strong></td>';
				echo '			<td  width="23%"><strong>Concepto		</strong></td>';
				echo '			<td  width="05%"><strong>Docs.			</strong></td>';
				echo '			<td  width="11%"><strong>Total			</strong></td>';
				echo '			<td  width="10%"><strong>Correo			</strong></td>';
				echo '			<td  width="10%"><strong>Reembolso		</strong></td>';
				echo '			<td colspan="3"  width="15%" align="center"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;
/*
				If($Estado == 'I'){ // Muestra los Emitidos
					$filtroSQL = "Where Estado = 'I'";
				}
				If($Estado == 'N'){ // Muestra los Emitidos
					$filtroSQL = "Where Estado != 'I'";
				}
				If($Estado == 'TT'){ // Muestra Todos
					$filtroSQL = "Where ";
				}
*/				
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
				$bdGto=$link->query("SELECT * FROM Formularios Where Modulo = 'G' && Reembolso <> 'on' Order By Fecha Desc");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$n++;
						$tr = "barraBlanca";
						if($row['Fotocopia']=='on'){ $tr = 'barraAmarilla';}
						if($row['Reembolso']=='on'){ $tr = 'barraVerde';}
						
						$tBruto	+= $row['Bruto'];
/*
						if($row['Estado'] == 'I'){
							echo '<tr bgcolor="#FFFF66">';
						}else{
							echo '<tr>';
						}
*/
						echo '<tr id="'.$tr.'">';

						echo '			<td width=" 5%">'.$row['nInforme'].'			</td>';
						$fd 	= explode('-', $row['Fecha']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						echo '			<td width="08%">'.$Fecha.'					</td>';
						echo '			<td width="08%">'.$row['IdProyecto'].'		</td>';
						echo '			<td width="05%">';
											echo $row['Formulario'];
						echo '			</td>';
						echo '			<td width="23%">'.$row['Concepto'].'			</td>';
						echo '			<td width="05%">';
											$result  = $link->query("SELECT Count(*) as nDocAs FROM MovGastos WHERE nInforme = '".$row['nInforme']."'");
											$rowMov 	 = mysqli_fetch_array($result);
						echo 				number_format($rowMov['nDocAs'], 0, ',', '.');
						echo '			</td>';
						echo '			<td width="11%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
						echo '			<td width="10%">';
											if($row['Fotocopia'] == 'on'){
												$fd = explode('-', $row['fechaFotocopia']);
												echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
												echo $fd[2].'-'.$fd[1].'-'.$fd[0];
											}
						echo '			</td>';
						echo '			<td width="10%">';
											if($row['Reembolso'] == 'on'){
												$fd = explode('-', $row['fechaReembolso']);
												echo '<img src="../gastos/imagenes/Confirmation_32.png" width="14" height="14">';
												echo $fd[2].'-'.$fd[1].'-'.$fd[0];
											}
						echo '			</td>';
						echo '			<td width="05%"><a href="seguimientoGastos.php?nInforme='.$row['nInforme'].'"><img src="../gastos/imagenes/klipper.png" width="32" height="32" title="Seguimiento">					</a></td>';
    					echo '			<td width="05%"><a href="docFormulario.php?nInforme='.$row['nInforme'].'"><img src="imagenes/corel_draw_128.png" 		width="32" height="32" title="Documentos del Informe"     ></a></td>';
    					//echo '			<td width="05%"><a href="docFormulario.php?nInforme='.$row['nInforme'].'"><img src="imagenes/delete_32.png" 	 		width="32" height="32" title="Eliminar Informe"></a></td>';
    					echo '			<td width="05%"><a href="plataformaintranet.php?nInforme='.$row['nInforme'].'&accion=Borrar"><img src="imagenes/delete_32.png" 	 		width="32" height="32" title="Eliminar Informe"></a></td>';
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
	<script src="moduloGastos.js"></script>

</body>
</html>
