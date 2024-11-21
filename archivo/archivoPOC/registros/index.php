<?php
	session_start(); 
	include_once("../../../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: http://erp.simet.cl/");
	}
	$accion 	= '';
	$nDocGes	= '';
	$Formulario = '';
	$IOC		= '';
	$Registro 	= 0;
	
	if(isset($_GET['accion'])) 		{ $accion  		= $_GET['accion']; 		}
	if(isset($_GET['nDocGes'])) 	{ $nDocGes  	= $_GET['nDocGes']; 	}
	if(isset($_GET['Formulario'])) 	{ $Formulario  	= $_GET['Formulario']; 	}
	if(isset($_GET['IOC'])) 		{ $IOC  		= $_GET['IOC']; 		}

	if(isset($_POST['accion'])) 	{ $accion  	= $_POST['accion']; 	}
	if(isset($_POST['nDocGes'])) 	{ $nDocGes  = $_POST['nDocGes']; 	}
	
	$link=Conectarse();
	$bdDoc=$link->query("SELECT * FROM documentacion WHERE nDocGes = '".$nDocGes."'");
	if ($rowDoc=mysqli_fetch_array($bdDoc)){
		$Referencia	= $rowDoc['Referencia'];
		$Documento	= $rowDoc['Documento'];
	}
	$link->close();
	
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
	<link href="../../../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function subirPDF(accion, nDocGes){
		var parametros = {
			"accion" 	: accion,
			"nDocGes" 	: nDocGes
		};
		alert(nDocGes);
		$.ajax({
			data: parametros,
			url: 'upPDF.php',
			type: 'get',
			success: function (response) {
				$("#resultadoSubir").html(response);
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
				<img src="../../../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php 
						$link=Conectarse();
						if($Formulario > 0){
							$bdDoc=$link->query("SELECT * FROM docFormPOC WHERE nDocGes = '".$nDocGes."' and Formulario = '".$Formulario."'");
							if ($rowDoc=mysqli_fetch_array($bdDoc)){
								echo $Referencia.' '.$Documento.'(Registros de Reg-'.$rowDoc['Formulario'].')'; 
							}
						}
						if($IOC > 0){
							$bdDoc=$link->query("SELECT * FROM documentacionIOC WHERE nDocGes = '".$nDocGes."' and IOC = '".$IOC."'");
							if ($rowDoc=mysqli_fetch_array($bdDoc)){
								echo $Referencia.' '.$Documento.'(Registros de IOC-'.$rowDoc['IOC'].')'; 
							}
						}
						$link->close();
					?>
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('mostrarRegistros.php'); ?>
		</div>
		<div style="clear:both;"></div>
		<div id="resultadoSubir"></div>
	</div>
	<br>
	
	
</body>
</html>
