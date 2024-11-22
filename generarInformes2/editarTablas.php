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
	if(isset($_POST[CodInforme]))		{ $CodInforme	 	= $_POST[CodInforme];	}
	if(isset($_POST[idItem])) 			{ $idItem 	 		= $_POST[idItem]; 		}
	if(isset($_POST[idEnsayo])) 		{ $idEnsayo	 		= $_POST[idEnsayo]; 	}
	if(isset($_POST[tpMuestra])) 		{ $tpMuestra 		= $_POST[tpMuestra]; 	}
	if(isset($_POST[Ref])) 				{ $Ref 				= $_POST[Ref]; 			}
	if(isset($_POST[accion])) 			{ $accion 	 		= $_POST[accion]; 		}
	
	if(isset($_GET[CodInforme]))		{ $CodInforme	 	= $_GET[CodInforme];	}
	if(isset($_GET[idItem])) 			{ $idItem 	 		= $_GET[idItem]; 		}
	if(isset($_GET[idEnsayo])) 			{ $idEnsayo	 		= $_GET[idEnsayo]; 		}
	if(isset($_GET[tpMuestra])) 		{ $tpMuestra 		= $_GET[tpMuestra]; 	}
	if(isset($_GET[Ref])) 				{ $Ref 				= $_GET[Ref]; 			}
	if(isset($_GET[accion])) 			{ $accion 	 		= $_GET[accion]; 		}


	$link=Conectarse();
	$bdCot=$link->query("Select * From amInformes Where CodInforme Like '%".$CodInforme."%'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$RutCli = $rowCot[RutCli];
	}
	$link->close();

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Generaci&oacute;n de Informes</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css"		rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(CodInforme, dBuscar, Proyecto, Estado, MesFiltro, Agno){
		var parametros = {
			"CodInforme" 	: CodInforme,
			"dBuscar" 		: dBuscar,
			"Proyecto" 		: Proyecto,
			"Estado"		: Estado,
			"MesFiltro"		: MesFiltro,
			"Agno"			: Agno
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'muestraInformes.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function bajarInformeWord(CodInforme, accion){
		var parametros = {
			"CodInforme" 	: CodInforme,
			"accion" 		: accion
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'exportarInforme.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function titularInforme(CodInforme, RAM, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"RAM"			: RAM,
			"accion"		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'regInformes.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function editarInforme(CodInforme, idItem, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"idItem"		: idItem,
			"accion"		: accion
		};
		//alert(idItem);
		$.ajax({
			data: parametros,
			url: 'regMuestra.php',
			type: 'get',
			success: function (response) {
				$("#resultadoEdicionMuestra").html(response);
			}
		});
	}

	function agregarEnsayo(CodInforme, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"accion"		: accion
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'regEnsayo.php',
			type: 'get',
			success: function (response) {
				$("#resultadoEdicionMuestra").html(response);
			}
		});
	}

	function llenarTabMuestras(tpMuestra){
		var parametros = {
			"tpMuestra"	: tpMuestra
		};
		alert(tpMuestra);
		$.ajax({
			data: parametros,
			url: 'tablaMuestras.php',
			type: 'get',
			success: function (response) {
				$("#resultadoTabMuestras").html(response);
			}
		});
	}

	function subirFotoMuestra(CodInforme, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"accion"		: accion
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'upFotoAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoEdicionMuestra").html(response);
			}
		});
	}
	
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/Tablas.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Informe de Resultado  
					<?php 
						$Ra 	= explode('-', $CodInforme);
						$RAM 	= $Ra[1];
						$link=Conectarse();
						$bdCli=$link->query("Select * From Clientes Where RutCli = '".$RutCli."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							$bdCot=$link->query("Select * From Cotizaciones Where RAM = '".$RAM."'");
							if($rowCot=mysqli_fetch_array($bdCot)){
								$bdCon=$link->query("Select * From contactosCli Where RutCli = '".$rowCli[RutCli]."' and nContacto = '".$rowCot[nContacto]."'");
								if($rowCon=mysqli_fetch_array($bdCon)){
									echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli[Cliente].' ('.$rowCon[Contacto].')'; 
								}else{
									echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli[Cliente]; 
								}
								echo '</span>';
							}
						}
						$link->close();
					?>
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
			</div>
			<?php 
				include_once('botoneraTablas.php');
				if($accion == 'SubirPdf'){?>
					<script>
						var accion 		= "<?php echo $accion;?>";
						var CodInforme 	= "<?php echo $CodInforme;?>";
						subirInformePDF(accion, CodInforme);
					</script>
					<?php
				}
			?>
			<?php
				if($accion == 'Titular'){
					?>
					<script>
						var CodInforme	= "<?php echo $CodInforme; 	?>" ;
						var RAM 		= "<?php echo $RAM; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						titularInforme(CodInforme, RAM, accion);
					</script>
					<?php
				}
				if($accion == 'EditarMuestra'){
					?>
					<script>
						var CodInforme	= "<?php echo $CodInforme; 	?>" ;
						var idItem 		= "<?php echo $idIt; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						editarInforme(CodInforme, idItem, accion);
					</script>
					<?php
				}
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
