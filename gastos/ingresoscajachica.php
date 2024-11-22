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

	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$numero = $result->num_rows; // obtenemos el número de filas
	$link->close();

	if($numero==0){
		header("Location: ingresocaja.php?Proceso=1");
	}

	$nRegistros = 18;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 18;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		$inicio = ($_GET['inicio']-$nRegistros)+1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
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

	/* Recive VAriables GET - POST */
	$Agno = date('Y');
	if(isset($_GET['MesGasto'])){ $MesGasto = $_GET['MesGasto']; }
	if(isset($_GET['Agno'])) 	{ $Agno 	= $_GET['Agno']; 	 }
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<?php 
					$nomModulo = 'Ingresos';
					include('menuIconos.php'); 
				?>
				<div id="ImagenBarra">
					<a href="ingresocaja.php?Proceso=1" title="Registrar Nuevo Ingreso">
						<img src="imagenes/add_32.png" width="28" height="28">
					</a>
				</div>
				<?php
					include_once('mSaldos.php');
				?>				
			</div>
			<div id="BarraFiltro">
				<img src="imagenes/settings_32.png" width="28" height="28">
					<!-- Fitra por Fecha -->
	  					<select name='MesGasto' id='MesGasto' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
							for($i=1; $i<=12; $i++){
								if($i == $MesGasto){
									echo "<option selected value='ingresoscajachica.php?MesGasto=".$i."&Agno=".$Agno."'>".$Mes[$i]."</option>";
								}else{
									echo "<option value='ingresoscajachica.php?MesGasto=".$i."&Agno=".$Agno."'>".$Mes[$i]."</option>";
								}
							}
							?>
						</select>
					<!-- Fin Filtro -->
					
					<!-- Fitra por Año -->
	  					<select name='Agno' id='Agno' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								$AgnoAct = date('Y');
								for($a=2013; $a<=$AgnoAct; $a++){
									if($a == $Agno){
										echo "<option selected 	value='ingresoscajachica.php?MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
									}else{
										echo "<option  			value='ingresoscajachica.php?MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->
			</div>
<!--
			<div id="BarraFiltro">
				<img src="imagenes/data_filter_128.png" width="28" height="28">
			</div>
-->
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%"><strong>NÂ° 			</strong></td>';
				echo '			<td  width="55%"><strong>Detalle		</strong></td>';
				echo '			<td  width="10%"><strong>Ingresos		</strong></td>';
				echo '			<td  width="10%"><strong>Egresos		</strong></td>';
				echo '			<td  width="10%"><strong>&nbsp;			</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$tIngreso 	= 0;
				$link=Conectarse();
				$bdIng=$link->query("SELECT * FROM Ingresos Order By year(FechaIng) = $Agno Desc");
				if ($row=mysqli_fetch_array($bdIng)){
					do{
						$fi = explode('-', $row[FechaIng]);
						if($fi[2] == $MesGasto){
							$tIngreso = $tIngreso + $row['Ingreso'];
						}
					}while ($row=mysqli_fetch_array($bdIng));
				}
				if($tIngreso>0){
						$n++;
						echo '		<tr id="barraVerde" style="font-size:18px;">';
						echo '			<td width="05%">'.$n.'	</td>';
						echo '			<td width="55%">Ingresos</td>';
						echo '			<td width="10%">$ '.number_format($tIngreso, 0, ',', '.').'			</td>';
						echo '			<td width="10%">&nbsp;';
						echo '			</td>';
						echo '			<td width="10%">&nbsp;';
						echo '			</td>';
    					echo '			<td><a href="mostrarIngresos.php"><img src="imagenes/verification_128.png"   width="32" height="32" title="Ver Detalle de Ingresos"     ></a></td>';
						echo '		</tr>';
				}
				
				
				$tGastos 	= 0;
				$link=Conectarse();
				$bdIt=$link->query("SELECT * FROM ItemsGastos Order By nItem");
				if ($rowIt=mysqli_fetch_array($bdIt)){
					do{
						$sItem = 0;
						$bdIng=$link->query("SELECT * FROM MovGastos Where year(FechaGasto) = $Agno && IdRecurso = '1' && nItem = '".$rowIt['nItem']."' Order By FechaGasto Desc");
						if ($row=mysqli_fetch_array($bdIng)){
							do{
								$fi = explode('-', $row[FechaGasto]);
								if($fi[2] == $MesGasto){
									$sItem   += $row['Bruto'];
									$tGastos += $row['Bruto'];
								}
							}while ($row=mysqli_fetch_array($bdIng));
						}
						if($sItem>0){
							$n++;
							echo '		<tr id="barraVerde" style="font-size:18px;">';
							echo '			<td width="05%">'.$n.'	</td>';
							echo '			<td width="55%" align="right">'.$rowIt['Items'].'		</td>';
							echo '			<td width="10%"></td>';
							echo '			<td width="10%" align="right">$ '.number_format($sItem , 0, ',', '.').'			</td>';
							echo '			<td width="10%"></td>';
    						echo '			<td><a href="mostrarGastos.php?nItem='.$rowIt['nItem'].'"><img src="imagenes/verification_128.png"   width="32" height="32" title="Ver Detalle de Gastos de '.$rowIt['Items'].'"     ></a></td>';
							echo '		</tr>';
						}
					}while ($rowIt=mysqli_fetch_array($bdIt));
				}


				$sVales 	= 0;
				$link=Conectarse();
				$bdVa=$link->query("SELECT * FROM Vales Where Reembolso <> 'on'");
				if ($rowVa=mysqli_fetch_array($bdVa)){
					do{
						$sVales  += $rowVa['Egreso'];
						$tGastos += $rowVa['Egreso'];
					}while ($row=mysqli_fetch_array($bdIng));
				}
				if($sVales>0){
					$n++;
					echo '		<tr id="barraVerde" style="font-size:18px;">';
					echo '			<td width="05%">'.$n.'	</td>';
					echo '			<td width="55%" align="right">Vales		</td>';
					echo '			<td width="10%"></td>';
					echo '			<td width="10%" align="right">$ '.number_format($sVales , 0, ',', '.').'			</td>';
					echo '			<td width="10%"></td>';
    				echo '			<td><a href="registraVales.php"><img src="imagenes/verification_128.png"   width="32" height="32" title="Ver Detalle de Gastos de '.$rowIt['Items'].'"     ></a></td>';
					echo '		</tr>';
				}


				$link->close();
				echo '	</table>';

				if($tIngreso > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr style="font-size:16px; ">';
					echo '			<td width="40%" align="right">Totales&nbsp; 						</td>';
					echo '			<td width="10%">$ '.number_format($tIngreso , 0, ',', '.').'</td>';
					echo '			<td width="10%">$ '.number_format($tGastos , 0, ',', '.').'	</td>';
					echo '			<td width="10%">$ '.number_format(($tIngreso - $tGastos) , 0, ',', '.').'	</td>';
					echo '		</tr>';
					echo '	</table>';
				}

			?>

		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
<!--
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>
-->
</body>
</html>
