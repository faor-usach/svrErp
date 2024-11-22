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
	<?php //include('../barramenuModulos.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<?php 
				$nomModulo = 'Vales';
				include('menuIconos.php'); 
			?>
			<div id="ImagenBarra" style="margin:0px 20px;">
				<a href="vales.php?Proceso=1&nVale=0" title="Registrar Vale">
					<img src="imagenes/AgregarVale.png" width="40" height="40">
				</a>
			</div>
			<div id="BarraFiltro">
				<img src="imagenes/centrotrabajo.png" width="40" height="40">
			</div>
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center"><strong>N°				</strong></td>';
				echo '			<td  width="13%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="33%"><strong>Descripción	</strong></td>';
				echo '			<td  width="13%"><strong>Egreso			</strong></td>';
				echo '			<td  width="13%"><strong>Reembolso		</strong></td>';
				echo '			<td  width="13%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$filtroSQL = "Where Estado != 'I' && TpDoc = 'F'";
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

				//$result  = $link->query("SELECT SUM(Neto) as tNeto, SUM(Iva) as tIva, SUM(Bruto) as tBruto FROM MovGastos WHERE Estado!='I'");  
				//$row   = mysqli_fetch_array($result, MYSQL_ASSOC);
				//$row 	 = mysqli_fetch_array($result);

				//$bdGto=$link->query("SELECT * FROM Vales ".$filtroSQL." Order By FechaGasto Limit $inicio, $nRegistros");
				$bdGto=$link->query("SELECT * FROM Vales where Reembolso <> 'on'  Order By fechaVale");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$n++;
						$Ingresos	+= $row['Ingreso'];
						$Egresos	+= $row['Egreso'];
						echo '		<tr>';
						echo '			<td width="05%" align="center">'.$row['nVale'].'			</td>';
						$fd 	= explode('-', $row['fechaVale']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						echo '			<td width="13%">'.$Fecha.'		</td>';
						echo '			<td width="33%">'.$row['Descripcion'].'		</td>';
						echo '			<td width="13%">'.number_format($row['Egreso']	 , 0, ',', '.').'				</td>';
						echo '			<td width="13%">';
										if($row['Reembolso']=='on'){
											echo '<img src="imagenes/Confirmation_32.png" width="22" height="22">';
										}
						echo '			</td>';
						echo '			<td width="13%">';
										if($row['Reembolso']=='on'){
											$fd 		= explode('-', $row['fechaReembolso']);
											$Fecha 		= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
											echo $Fecha;
										}
						echo '			</td>';
    					echo '			<td><a href="vales.php?Proceso=2&nVale='.$row['nVale'].'"><img src="imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Comprobante"  ></a></td>';
						echo '		</tr>';
					}WHILE ($row=mysqli_fetch_array($bdGto));
				}
				$link->close();
				echo '	</table>';
				if($Egresos > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width="14%">Total en Vales</td>';
					echo '			<td width="13%">'.number_format($Egresos , 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '	</table>';
				}

				echo '</div>';
			?>


		</div>
	</div>
	<div style="clear:both; "></div>

</body>
</html>
