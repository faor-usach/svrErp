<?php
	session_start(); 
	//include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
		//if ($Detect->IsMobile()) {
		//	header("Location: http://simet.cl/mobil/");
		//}
	$maxCpo = '100%';
	include_once("conexionli.php");

		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$ultUF = $rowCli['valorUF'];
		}
		$link->close();

	if(isset($_GET['CAM'])) 		{	$CAM 	= $_GET['CAM']; 	}
	if(isset($_GET['RAM'])) 		{	$RAM 	= $_GET['RAM']; 	}
	if(isset($_GET['accion'])) 		{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 	}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 	}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; }
	
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		//header("Location: http://simet.cl");
		header("Location: index.php");
	}
	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
</head>

<body>
	<?php 
		include_once('head.php');
	?>
	<!-- <table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:5px;"> -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" rowspan="5" valign="top">
				<?php include_once('menulateral.php')?>
			</td>
			<td width="<?php echo $maxCpo; ?>" valign="top">
				<span id="resultadoAM"></span>
			</td>
	  	</tr>
	  	<tr>
			<td valign="top">
				<?php listaVentas(); ?>
			</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	</table>
	<div style="clear:both; "></div>
	<br>
</body>
</html>
<?php
function listaVentas(){

	$Orden = 'Asc';
	$nivelDetalle = 1;
	$Campo = 'fechaSolicitud';
	if(isset($_GET['Orden']))  	{ $Orden  	= $_GET['Orden']; 	}
	if(isset($_GET['Campo']))  	{ $Campo  	= $_GET['Campo']; 	}
	if($Orden == 'Asc'){
		$Orden = 'Desc';
	}else{
		$Orden = 'Asc';
	}
	?>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" style="margin-top:10px;">
		<tr>
			<td  width="10%" align="center" height="40"><strong>N°<br>Sol.  		</strong></td>
			<td  width="10%" align="center">			
				Proyecto
			</td>
			<td  width="10%" align="center">			
				<strong>
					<a href="vtas.php?IdProyecto=<?php echo isset($_GET['IdProyecto']); ?>&mesVta=<?php echo $_GET['mesVta']; ?>&ageVta=<?php echo $_GET['ageVta']; ?>&Orden=<?php echo $Orden; ?>&Campo=fechaSolicitud">
						Fecha<br> Solicitud	
					</a>
				</strong>
			</td>
			<td  width="10%" align="center">			
				<strong>
					<a href="vtas.php?IdProyecto=<?php echo isset($_GET['IdProyecto']); ?>&mesVta=<?php echo $_GET['mesVta']; ?>&ageVta=<?php echo $_GET['ageVta']; ?>&Orden=<?php echo $Orden; ?>&Campo=fechaFactura">
						Fecha<br> Factura
					</a>
				</strong>
			</td>
			<td  width="10%" align="center">
				<strong>
					<a href="vtas.php?IdProyecto=<?php echo isset($_GET['IdProyecto']); ?>&mesVta=<?php echo $_GET['mesVta']; ?>&ageVta=<?php echo $_GET['ageVta']; ?>&Orden=<?php echo $Orden; ?>&Campo=nFactura">
						Factura				
					</a>
				</strong>
			</td>
			<td  width="30%" align="center">			
				<strong>
					<a href="vtas.php?IdProyecto=<?php echo isset($_GET['IdProyecto']); ?>&mesVta=<?php echo $_GET['mesVta']; ?>&ageVta=<?php echo $_GET['ageVta']; ?>&Orden=<?php echo $Orden; ?>&Campo=RutCli">
						Cliente				
					</a>
				</strong>
			</td>
			<td  width="10%" align="center"> 			<strong>Valor<br>Venta		</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
			$tVentas = 0;
			$filtroSQL = " Where Estado = 'I' and Eliminado != 'on'";
			if(isset($_GET['mesVta'])) {
				if($_GET['vta'] == 'AgnoProy'){
					$filtroSQL .= " and  month(fechaSolicitud) <= '".$_GET['mesVta']."'";
				}else{
					$filtroSQL .= " and  month(fechaSolicitud) = '".$_GET['mesVta']."'";
				}
			}
			if(isset($_GET['ageVta'])) {
				$filtroSQL .= " and  year(fechaSolicitud) = '".$_GET['ageVta']."'";
			}
			if(isset($_GET['IdProyecto'])) {
				$IdProyecto = $_GET['IdProyecto'];
				if(!empty($IdProyecto)){
					$filtroSQL .= " and IdProyecto = '".$_GET['IdProyecto']."'";
				}
			}
			if(isset($_GET['nivelDetalle'])) {
				if($_GET['nivelDetalle'] == 2){
					$filtroSQL .= " and pagoFactura != 'on'";
				}
			}
			$link=Conectarse();

			$SQL = "SELECT * FROM SolFactura $filtroSQL Order By $Campo $Orden";
			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$cFree = 'NO';
					$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
					if($rowP=mysqli_fetch_array($bdPer)){
						if($rowP['cFree'] == 'on'){
							$cFree = 'on';
						}else{
							$cFree = 'off';
						}
					}
					
					if($cFree != 'on' and $cFree != 'NO'){
						$tr 	= "barraVerde";
						if($row['pagoFactura']=='on'){
							$tr = 'barraPagada';
						}else{
							$tr = 'barraAmarilla';
						}
						if($row['nFactura'] > 0){
							$tr 	= "barraVerde";
						}
						if($row['pagoFactura'] == 'on'){
							$tr = 'barraPagada';
						}
						?>
						
						<tr id="<?php echo $tr; ?>">
							<td width="10%" style="font-size:16px;" align="center">
								<?php echo $row['nSolicitud']; ?>
							</td>
							<td  width="10%" align="center">			
								<?php echo $row['IdProyecto']; ?>
							</td>
							<td width="10%" style="font-size:16px;">
								<?php 
									$fd = explode('-', $row['fechaSolicitud']);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
								?>
							</td>
							<td width="10%" style="font-size:16px;">
								<?php 
									if($row['fechaFactura'] != '0000-00-00'){
										$fd = explode('-', $row['fechaFactura']);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
									}
								?>
							</td>
							<td width="10%" style="font-size:16px;">
								<?php 
									if($row['nFactura'] > 0){
										echo $row['nFactura']; 
									}
								?>
							</td>
							<td width="30%">
								<?php
								$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									echo '<strong>'.$rowP['Cliente'].'</strong>';
								}
								?>
							</td>
							<td width="10%" align="center">
								<?php
									echo number_format($row['Neto'], 0, ',', '.');
									$tVentas += $row['Neto'];
								?>
							</td>
						</tr>
						<?php
						}
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close(); 
			?>
		</table>
		<table width="99%"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
			<tr>
				<td  width="10%" align="center" height="40">&nbsp;</td>
				<td  width="10%" align="center">&nbsp;</td>
				<td  width="10%" align="center">&nbsp;</td>
				<td  width="30%" align="center">&nbsp;</td>
				<td  width="10%" align="center"> 			
					<strong>
						<?php echo number_format($tVentas, 0, ',', '.'); ?>
					</strong>
				</td>
			</tr>
		</table>
		
	<?php
}
?>











