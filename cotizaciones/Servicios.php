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
	$nEnc 	= '';
	$accion	= '';
	
	if(isset($_GET['nServicio']))  	{	$nServicio 	= $_GET['nServicio'];  	}
	if(isset($_GET['accion'])) 	 	{	$accion 	= $_GET['accion']; 	 	}

	//  Toma los Datos si viene de Cotización
	if(isset($_GET['CAM'])) 	 	 {	$CAM 		= $_GET['CAM']; 	 	}
	if(isset($_GET['Rev'])) 	 	 {	$Rev 		= $_GET['Rev']; 	 	}
	if(isset($_GET['Cta'])) 	 	 {	$Cta 		= $_GET['Cta']; 	 	}
	//  Fin Toma los Datos si viene de Cotización
	
	if(isset($_POST['nServicio'])) 	{	$nServicio 	= $_POST['nServicio']; 	}
	if(isset($_POST['accion'])) 	{	$accion 	= $_POST['accion']; 	}
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		//$bdEnc=$link->query("Delete From Servicios Where nServicio = '".$nServicio."'");
		$Estado = 'off';
		$actSQL="UPDATE Servicios SET ";
		$actSQL.="Estado			='".$Estado."'";
		$actSQL.="WHERE nServicio	= '".$nServicio."'";
		$bdEnc=$link->query($actSQL);
		
		$link->close();
		$nServicio 	= '';
		$accion		= '';
	}
	if(isset($_POST['confirmarGuardar'])){
		$Estado = 'on';
		
		if(isset($_POST['Servicio'])) 	{ $Servicio 	= $_POST['Servicio']; 	}
		if(isset($_POST['ValorUF'])) 	{ $ValorUF 		= $_POST['ValorUF'];	}
		if(isset($_POST['ValorPesos'])) { $ValorPesos	= $_POST['ValorPesos'];	}
		if(isset($_POST['tpServicio'])) { $tpServicio	= $_POST['tpServicio'];	}
		if(isset($_POST['Estado'])) 	{ $Estado		= $_POST['Estado'];		}

		$link=Conectarse();
		$bdEnc=$link->query("Select * From Servicios Where nServicio = '".$nServicio."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$actSQL="UPDATE Servicios SET ";
			$actSQL.="Servicio			='".$Servicio."',";
			$actSQL.="ValorUF			='".$ValorUF."',";
			$actSQL.="tpServicio		='".$tpServicio."',";
			$actSQL.="Estado			='".$Estado."'";
			$actSQL.="WHERE nServicio	= '".$nServicio."'";
			$bdEnc=$link->query($actSQL);
		}else{
			$link->query("insert into Servicios(	nServicio,
												Servicio,
												ValorUF,
												tpServicio,
												Estado
												) 
									values 	(	'$nServicio',
												'$Servicio',
												'$ValorUF',
												'$tpServicio',
												'$Estado'
			)");
			$nServicio 	= '';
			$accion	= '';
		}
		$link->close();
		$nServicio 	= '';
		$accion		= '';
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraServicios.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nServicio, accion){
		var parametros = {
			"nServicio" : nServicio,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regServicio.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div style='position:absolute; left:159px; top:66px; width:470px; height:187px; z-index:1; border: 5px solid #000; background-color: #fff; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 0px 5px 0px; '><img src='../imagenes/ajax-loader.gif'></div>");
			},
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
				<img src="../imagenes/consulta.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Cotizaciones - Mantención de Servicios
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Agregar Servicio" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/add_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaServicios.php'); 
			if(isset($_GET['nServicio'])) {
				if($nServicio){?>
					<script>
						var nServicio 	= "<?php echo $nServicio; ?>" ;
						var accion 		= "<?php echo $accion; ?>" ;
						registraEncuesta(nServicio, accion);
					</script>
					<?php
				}
			}
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>