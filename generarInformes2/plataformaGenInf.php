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
	
	$accion = '';
	$RAM 	= 0;
	
	if(isset($_GET['CodInforme']))	{	$CodInforme	= $_GET['CodInforme'];	}
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 		= $_GET['RAM']; 		}
	if(isset($_GET['RuCli'])) 		{	$RutCli 	= $_GET['RutCli']; 		}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Generaci&oacute;n de Informes</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
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
			url: 'muestraPAMs.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function subirInformePDF(accion, CodInforme){
		var parametros = {
			"accion" 		: accion,
			"CodInforme" 	: CodInforme
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'upInfoAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoSubir").html(response);
			}
		});
	}
	
	function registraInformes(CodInforme, RAM, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"RAM"			: RAM,
			"accion"		: accion
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'genInformes.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
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
					Generación de Informes
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php 
				include_once('listaPAMs.php');
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
				if($CodInforme == '' and $RAM > 0){
					?>
					<script>
						var CodInforme	= "<?php echo $CodInforme; 	?>" ;
						var RAM			= "<?php echo $RAM; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						registraInformes(CodInforme, RAM, accion);
					</script>
					<?php
				}
				if($accion == 'Modificar' and $RAM > 0){
					?>
					<script>
						var CodInforme	= "<?php echo $CodInforme; 	?>" ;
						var RAM			= "<?php echo $RAM; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						registraInformes(CodInforme, RAM, accion);
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
