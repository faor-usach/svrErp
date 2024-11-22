<?php
	session_start(); 
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: .../../index.php");
	}
	
	$accion 	= '';
	$CodInforme	= '';
	$RAM		= '';
	$RutCli		= '';
	
	if(isset($_GET['CodInforme']))		{ $CodInforme	 	= $_GET['CodInforme'];		}
	if(isset($_GET['accion'])) 			{ $accion 	 		= $_GET['accion']; 			}
	if(isset($_GET['RAM'])) 			{ $RAM 		 		= $_GET['RAM']; 			}
	if(isset($_GET['RutCli'])) 			{ $RutCli 	 		= $_GET['RutCli']; 			}

	if(isset($_POST['CodInforme']))		{ $CodInforme	 	= $_POST['CodInforme'];		}
	if(isset($_POST['accion'])) 		{ $accion 	 		= $_POST['accion']; 		}
	if(isset($_POST['RAM'])) 			{ $RAM 		 		= $_POST['RAM']; 			}
	if(isset($_POST['RutCli'])) 		{ $RutCli 	 		= $_POST['RutCli']; 		}
	
	$RespaldoId			= '';
	$fechaCreacion		= date('Y-m-d');
	$fechaEmision		= '0000-00-00';
	$fechaUp			= '0000-00-00';
	$usrResponsable		= $_SESSION['usr'];
	$usrAutorizador		= '';
	$Observaciones		= '';
	$CodigoVerificacion	= '';
	$imgQR				= '';
	
	$procesoSold		= '';
	$nNorma				= 0;
	$Tipo				= '';
	
	$TipoUnion 		= '';
	$Soldadura		= '';
	$Respaldo		= '';
	$matRespaldo	= '';
	$aberturaRaiz	= '';
	$Talon			= '';
	$anguloCanal	= '';
	$Radio			= '';
	$intRaiz		= '';
	$Metodo			= '';

	$especMaterialDe	= '';
	$especMaterialA		= '';
	$tpGradoDe			= '';
	$tpGradoA			= '';
	$espesorCanal		= '';
	$espesorFilete		= '';
	$diametroCaneria	= '';
	$grupoDe			= '';
	$grupoA				= '';
	$numeroPde			= '';
	$numeroPa			= '';
	
	$especAWSde			= '';
	$especAWSa			= '';
	$clasAWSde			= '';
	$clasAWSa			= '';
	$diametroElecDe		= '';
	$diametroElecA		= '';
	
	$fundente			= '';
	$gasClasificacion	= '';
	$composicion		= '';
	$flujo				= '';
	$tamTobera			= '';
	$claseFundenteElec	= '';
	
	$preCalMin			= '';
	$interMin			= '';
	$interMax			= '';
	
	$Canal				= '';
	$Filete				= '';
	$progresionVertical = '';
	
	//Declaracion de Variables
	
	$cortoCircuito	= 0;
	$Globular		= false;
	$Spray			= 0;
	$CA				= 0;
	$CCEP			= 0;
	$CCEN			= 0;
	$Otro			= '';
	$elecTunTam		= '';
	$elecTunTipo	= '';
	
	$Cordon			= '';
	$Pase			= '';
	$nElectrodos	= 1;
	$Longitudinal	= '';
	$Lateral		= '';
	$Angulo			= '';
	$Distancia		= '';
	$Martillado		= '';
	$Limpieza		= '';
	
	$Temperatura	= '';
	$Tiempo			= '';
	
	if(isset($_POST['UpImagen'])){
		$nombre_archivo = $_FILES['fotoMuestra']['name'];
		$tipo_archivo 	= $_FILES['fotoMuestra']['type'];
		$tamano_archivo = $_FILES['fotoMuestra']['size'];
		$desde 			= $_FILES['fotoMuestra']['tmp_name'];

		$directorio="imgUniones/".$CodInforme;
		if (!file_exists($directorio)){
			mkdir($directorio,0755);
		}

		if (($tipo_archivo == "image/jpeg" || $tipo_archivo == "image/png" || $tipo_archivo == "image/gif") ) { 
    		if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 

				$imgUnion = $nombre_archivo;
				$link=Conectarse();
				$bdImg=mysql_query("Select * From solImagenUnion Where CodInforme = '".$CodInforme."'");
				if($rowImg=mysql_fetch_array($bdImg)){
					$fichero = $directorio.'/'.$rowImg['imagenUnion'];
					unlink($fichero);
					$actSQL="UPDATE solImagenUnion SET ";
					$actSQL.="imagenUnion		='".$imgUnion.	"'";
					$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
					$bdCot=mysql_query($actSQL);
				}else{
					mysql_query("insert into solImagenUnion(
															CodInforme,
															imagenUnion
															) 
													values 	(	
															'$CodInforme',
															'$imgUnion'
								)",
					$link);
				}
				mysql_close($link);
				header("Location: index.php?CodInforme=".$CodInforme."&RAM=".$RAM);
    		}else{ 
   				$MsgUsr="Ocurrió algún error al subir el fichero ".$nombre_archivo." No pudo guardar.... ";
    		} 
		}else{
    		$MsgUsr="Se permite subir un documento JPEG o PNG <br> y el tamaño máximo es de 7Mb."; 
		}
	}
	
	$link=Conectarse();
	$bdSol=mysql_query("Select * From solIdSoldadura Where CodInforme = '".$CodInforme."'");
	if($rowSol=mysql_fetch_array($bdSol)){
		$RespaldoId 			= $rowSol['Respaldo'];
		$fechaCreacion 		= $rowSol['fechaCreacion'];
		$fechaEmision 		= $rowSol['fechaEmision'];
		$fechaUp 			= $rowSol['fechaUp'];
		$usrResponsable		= $rowSol['usrResponsable'];
		$usrAutorizador		= $rowSol['usrAutorizador'];
		$Rev				= $rowSol['Rev'];
		$Respaldo			= $rowSol['Respaldo'];
		$Observaciones		= $rowSol['Observaciones'];
		$CodigoVerificacion	= $rowSol['CodigoVerificacion'];
		$imgQR				= $rowSol['imgQR'];
	}
	mysql_close($link);
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Generaci&oacute;n de Informes</title>
	
	<link href="../../css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="../styles.css"			rel="stylesheet" type="text/css">

</head>

<body>
	<?php include('head.php'); ?>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../../imagenes/Tablas.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px;">
					Informes de Procedimiento  
					<?php 
						$link=Conectarse();
						$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							$bdCot=mysql_query("Select * From Cotizaciones Where RAM = '".$RAM."'");
							if($rowCot=mysql_fetch_array($bdCot)){
								$bdCon=mysql_query("Select * From contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$rowCot['nContacto']."'");
								if($rowCon=mysql_fetch_array($bdCon)){
									echo '<span style="font-size:18px;color:#000;">'.$CodInforme.'</span> - '.$rowCli['Cliente'].' ('.$rowCon['Contacto'].')'; 
								}else{
									echo '<span style="font-size:18px;color:#000;">'.$CodInforme.'</span> - '.$rowCli['Cliente']; 
								}
								echo '</span>';
							}
						}
						mysql_close($link);
					?>
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>
	<form action="upImagen.php" method="post" enctype="multipart/form-data">
		<?php include_once('barraBotonesUp.php'); ?>
		<?php include_once('Imagen.php'); ?>
	</form>
</body>
</html>
