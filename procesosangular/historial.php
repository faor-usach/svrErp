<?php
	//ini_set("session.cookie_lifetime","36000");
	//ini_set("session.gc_maxlifetime","36000");
	date_default_timezone_set("America/Santiago");
	header('Content-Type: text/html; charset=utf-8');
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$usuario = $_SESSION['usuario'];
	$idPreCAM = '';
	if(isset($_GET['idPreCAM'])) 	{	$idPreCAM 				= $_GET['idPreCAM']; 	}

	$CAM 	= 0;
	$Rev 	= 0;
	$Cta	= 0;
	$CAMRAM = '';
	$ultAgno = date('Y');
	$bFecha  = '';

	$accion	= '';
	unset($_SESSION['empFiltro']);
	if(isset($_GET['CAM'])) 		{	$CAM 					= $_GET['CAM']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 					= $_GET['RAM']; 		}
	if(isset($_GET['CAMRAM'])) 		{	$CAMRAM 				= $_GET['CAMRAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion 				= $_GET['accion']; 		}
	if(isset($_GET['usrFiltro'])) 	{	$_SESSION['usrFiltro'] 	= $_GET['usrFiltro']; 	}
	if(isset($_GET['bFecha'])) 		{	$bFecha 				= $_GET['bFecha']; 		}
	
	if(isset($_GET['empFiltro'])) 	{
		$empFiltro = $_GET['empFiltro'];
		unset($_SESSION['empFiltro']);
		if($empFiltro){
			$_SESSION['empFiltro'] 	= $_GET['empFiltro']; 
		}
	}
	/* Verificar Cirerre de CAM con 60 D�as */

	$fechaHoy = date('Y-m-d');
	$fecha60dias 	= strtotime ( '-60 day' , strtotime ( $fechaHoy ) );
	$fecha60dias	= date ( 'Y-m-d' , $fecha60dias );
	$Estado 		= 'C';

	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 	}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 	}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; 	}

	if(isset($_POST['cerrarCAM'])){
		$CAM 			= $_POST['CAM'];
		$RAM 			= $_POST['RAM'];
		$Estado			= 'C';
		$fechaCierre 	= date('Y-m-d');
		$link=Conectarse();
		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="fechaCierre	='".$fechaCierre.	"',";
		$actSQL.="Estado		='".$Estado.		"'";
		$actSQL.="WHERE CAM 	= '".$CAM."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$CAM 	= '';
		$accion	= '';
	}
	if(isset($_POST['activarCAM'])){
		$CAM 			= $_POST['CAM'];
		$RAM 			= $_POST['RAM'];
		$Estado			= 'E';
		$fechaCotizacion= date('Y-m-d');
		$fechaCierre 	= '0000-00-00';
		$link=Conectarse();
		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="fechaCotizacion	='".$fechaCotizacion.	"',";
		$actSQL.="fechaCierre		='".$fechaCierre.		"',";
		$actSQL.="Estado			='".$Estado.			"'";
		$actSQL.="WHERE CAM 		= '".$CAM."'";
		$bdCot=$link->query($actSQL);
		$link->close();
		$CAM 	= '';
		$accion	= '';
	}
	if(isset($_POST['guardarSeguimiento'])){
		$oCompra 	= '';
		$oMail		= '';
		$oCtaCte	= '';
		$proxRecordatorio = '0000-00-00';
		
		if(isset($_POST['CAM'])) 					{ $CAM 			 		= $_POST['CAM'];					}
		if(isset($_POST['RAM'])) 					{ $RAM 			 		= $_POST['RAM'];					}
		if(isset($_POST['Rev'])) 					{ $Rev 			 		= $_POST['Rev'];					}
		if(isset($_POST['Cta'])) 					{ $Cta 			 		= $_POST['Cta'];					}
		if(isset($_POST['Estado'])) 				{ $Estado 		 		= $_POST['EstadoCot'];				}
		if(isset($_POST['oCompra'])) 				{ $oCompra 		 		= $_POST['oCompra'];				}
		if(isset($_POST['oMail'])) 					{ $oMail	 		 	= $_POST['oMail'];					}
		if(isset($_POST['oCtaCte'])) 				{ $oCtaCte 		 		= $_POST['oCtaCte'];				}
		if(isset($_POST['dHabiles'])) 				{ $dHabiles		 		= $_POST['dHabiles'];				}
		if(isset($_POST['fechaEstimadaTermino'])) 	{ $fechaEstimadaTermino	= $_POST['fechaEstimadaTermino'];	}
		if(isset($_POST['nOC'])) 					{ $nOC 		 	 		= $_POST['nOC'];					}
		if(isset($_POST['usrResponzable'])) 		{ $usrResponzable	 	= $_POST['usrResponzable'];			}
		if(isset($_POST['contactoRecordatorio'])) 	{ $contactoRecordatorio = $_POST['contactoRecordatorio'];	}
		if(isset($_POST['Descripcion'])) 			{ $Descripcion		 	= $_POST['Descripcion'];			}
		if(isset($_POST['accion'])) 				{ $accion			 	= $_POST['accion'];					}
		if(isset($_POST['correoInicioPAM'])) 		{ $correoInicioPAM		= $_POST['correoInicioPAM'];		}
		if(isset($_POST['tpEnsayo'])) 				{ $tpEnsayo				= $_POST['tpEnsayo'];				}
		
		$fechaAceptacion = '0000-00-00';
		if(isset($_POST['fechaAceptacion'])){ $fechaAceptacion = $_POST['fechaAceptacion']; }

		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$fd = explode('-', $fechaAceptacion);
			//if($fechaAceptacion != '0000-00-00' or $fd[0] > 0){
			$Estado = 'E';
			$oldRAM = $rowCot['RAM'];
			if($fd[0] > 0){
				if($RAM){
					if($oCompra == 'on' or $oMail == 'on' or $oCtaCte == 'on'){
						$Estado = 'A';
					}
				}
			}else{
				if($rowCot['fechaEnvio'] != '0000-00-00'){
					$Estado = 'E';
				}
			}
			$fechaInicio = '0000-00-00';
			if($RAM > 0){
				if($oCompra == 'on' or $oMail == 'on' or $oCtaCte == 'on'){
					$Estado 	 = 'P';
					$fechaInicio = date('Y-m-d');
				}
			}else{
				$oCompra 	= '';
				$oMail		= '';
				$oCtaCta	= '';
			}
			if($rowCot['proxRecordatorio'] <= date('Y-m-d')){
				if($contactoRecordatorio){
					$fechaHoy = date('Y-m-d');
					$proxRecordatorio 	= strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
					$proxRecordatorio 	= date ( 'Y-m-d' , $proxRecordatorio );
				}
			}
			if($contactoRecordatorio){
				$link->query("insert into CotizacionesSegimiento	(
														CAM,
														fechaContacto,
														contactoRecordatorio,
														proxRecordatorio
													)	 
										  values 	(	'$CAM',
										  				'$fechaHoy',
														'$contactoRecordatorio',
														'$proxRecordatorio'
										  			)");
			}

			$dSem = array('Dom.','Lun.','Mar.','Mi�.','Jue.','Vie.','S�b.');
			$fechaHoy 	= date('Y-m-d');
			$fecha 		= date('Y-m-d');

			$dd	= 0;
			$finSemana = 0;
			
			while($fecha <= $fechaEstimadaTermino){
				$fecha		= strtotime ( '+1 day' , strtotime ( $fecha ) );
				$fecha		= date ( 'Y-m-d' , $fecha );
				$dia_semana = date("w",strtotime($fecha));
				if($dia_semana == 0 or $dia_semana == 6){
					$finSemana++;
				}else{
					$dd++;
				}
			}
			$dHabiles = $dd;
			
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RAM	 			 	='".$RAM.					"',";
			$actSQL.="fechaAceptacion	 	='".$fechaAceptacion.		"',";
			$actSQL.="fechaInicio	 	 	='".$fechaInicio.			"',";
			$actSQL.="correoInicioPAM 		='".$correoInicioPAM.		"',";
			$actSQL.="dHabiles		 	 	='".$dHabiles.				"',";
			$actSQL.="fechaEstimadaTermino 	='".$fechaEstimadaTermino.	"',";
			$actSQL.="usrResponzable 	 	='".$usrResponzable.		"',";
			$actSQL.="contactoRecordatorio 	='".$contactoRecordatorio.	"',";
			$actSQL.="Descripcion		 	='".$Descripcion.			"',";
			$actSQL.="proxRecordatorio 		='".$proxRecordatorio.		"',";
			$actSQL.="oCompra			 	='".$oCompra.				"',";
			$actSQL.="oMail				 	='".$oMail.					"',";
			$actSQL.="oCtaCte			 	='".$oCtaCte.				"',";
			$actSQL.="nOC			 	 	='".$nOC.					"',";
			$actSQL.="tpEnsayo		 	 	='".$tpEnsayo.				"',";
			$actSQL.="Estado			 	='".$Estado.				"'";
			$actSQL.="WHERE CAM 			= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
			if($Estado == 'P'){
				if($correoInicioPAM == 'on'){
					//enviaCorreoPAM($RAM, $CAM);
				}
			}
			
			if($RAM > 0){
				$situacionMuestra 	= 'B';
				if($Estado == 'P'){
					$situacionMuestra 	= 'P';
				}
				if($Estado == 'E'){
					$situacionMuestra 	= 'R';
				}
				$actSQL="UPDATE registroMuestras SET ";
				$actSQL.="CAM	 			 	='".$CAM.				"',";
				$actSQL.="situacionMuestra	 	='".$situacionMuestra.	"'";
				$actSQL.="WHERE RAM 			= '".$RAM."'";
				$bdRAM=$link->query($actSQL);
			}
			
			
		}
		/* Enviar Correo desde el Hosting */
		if($Estado == 'P'){
			if($correoInicioPAM == 'on'){
				enviaCorreoPAM($RAM, $CAM);
			}
		}
		$link->close();
		$CAM 	= '';
		$accion	= '';
	}

	if(isset($_POST['guardarSeguimientoRAM'])){
		$CAM 			 = $_POST['CAM'];
		$RAM 			 = $_POST['RAM'];
		$Rev 			 = $_POST['Rev'];
		$Cta 			 = $_POST['Cta'];
		$Estado 		 = $_POST['EstadoCot'];
		$dHabiles 		 = $_POST['dHabiles'];
		$fechaTermino	 = $_POST['fechaTermino'];
		$Descripcion	 = $_POST['Descripcion'];
		$usrResponzable	 = $_POST['usrResponzable'];
		$accion			 = $_POST['accion'];
		$tpEnsayo		 = $_POST['tpEnsayo'];
		
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$fd = explode('-', $fechaTermino);
			//if($fechaAceptacion != '0000-00-00' or $fd[0] > 0){
/*
			if($fd[0] > 0){
				$Estado = 'T';
			}
*/			
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RAM			 	='".$RAM.			"',";
			$actSQL.="dHabiles		 	='".$dHabiles.		"',";
			$actSQL.="fechaTermino	 	='".$fechaTermino.	"',";
			$actSQL.="Descripcion	 	='".$Descripcion.	"',";
			$actSQL.="usrResponzable 	='".$usrResponzable."',";
			$actSQL.="tpEnsayo 			='".$tpEnsayo.		"',";
			$actSQL.="Estado			='".$Estado.		"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
	}

	if(isset($_POST['volverCAM'])){
		$CAM 				= $_POST['CAM'];
		$Rev 				= $_POST['Rev'];
		$Cta 				= $_POST['Cta'];
		$oCompra			= '';
		$oMail				= '';
		$oCtaCte			= '';
		$fechaInicio		= '0000-00-00';
		$fechaTermino		= '0000-00-00';
		$fechaCierre		= '0000-00-00';
		$fechaAceptacion	= '0000-00-00';
		$Estado 			= 'E';
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="fechaInicio		='".$fechaInicio.		"',";
			$actSQL.="fechaTermino		='".$fechaTermino.		"',";
			$actSQL.="fechaCierre		='".$fechaCierre.		"',";
			$actSQL.="fechaAceptacion	='".$fechaAceptacion.	"',";
			$actSQL.="oCompra			='".$oCompra.			"',";
			$actSQL.="oMail				='".$oMail.				"',";
			$actSQL.="oCtaCte			='".$oCtaCte.			"',";
			$actSQL.="Estado	 		='".$Estado.			"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
/*
			$bdRAM=$link->query("Select * From registroMuestras Where CAM = '".$CAM."'");
			if($rowRAM=mysqli_fetch_array($bdRAM)){
				$situacionMuestra = 'P';
				$actSQL="UPDATE registroMuestras SET ";
				$actSQL.="situacionMuestra	='".$situacionMuestra."'";
				$actSQL.="WHERE CAM 	= '".$CAM."'";
				$bdRAM=$link->query($actSQL);
			}
*/			
		}
		$link->close();
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
		
	}

	if(isset($_POST['guardarSeguimientoAM'])){
		$CAM 			 	= $_POST['CAM'];
		$RAM 			 	= $_POST['RAM'];
		$Rev 			 	= $_POST['Rev'];
		$Cta 			 	= $_POST['Cta'];
		$informeUP 		 	= $_POST['informeUP'];
		$fechaInformeUP	 	= $_POST['fechaInformeUP'];
		$Facturacion 	 	= $_POST['Facturacion'];
		$fechaFacturacion 	= $_POST['fechaFacturacion'];
		$Archivo	 	 	= $_POST['Archivo'];
		$fechaArchivo	 	= $_POST['fechaArchivo'];
		$accion			 	= $_POST['accion'];
		if($informeUP != 'on') 		{ $fechaInformeUP 	= '0000-00-00'; }
		if($Facturacion != 'on') 	{ $fechaFacturacion = '0000-00-00'; }
		if($Archivo != 'on') 		{ $fechaArchivo 	= '0000-00-00'; }
		
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){

			$fd = explode('-', $fechaArchivo);
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="informeUP	 		='".$informeUP.			"',";
			$actSQL.="fechaInformeUP	='".$fechaInformeUP.	"',";
			$actSQL.="Facturacion	 	='".$Facturacion.		"',";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="Archivo		 	='".$Archivo.			"',";
			$actSQL.="fechaArchivo		='".$fechaArchivo.		"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
	}
	$fechaHoy = date('Y-m-d');
	$link=Conectarse();
	$bdUf=$link->query("Select * From UF Where fechaUF = '".$fechaHoy."'");
	if($rowUf=mysqli_fetch_array($bdUf)){
		$ValorUF = $rowUf['ValorUF'];
	}
	$link->close();

function enviaCorreoPAM($RAM, $CAM){
	$fechaHoy = date('Y-m-d');
	
	$bdCAM=$link->query("Select * From Cotizaciones Where RAM = '".$RAM."'");
	if($rowCAM=mysqli_fetch_array($bdCAM)){
		$bdEmp=$link->query("Select * From Clientes Where RutCli = '".$rowCAM['RutCli']."'");
		if($rowEmp=mysqli_fetch_array($bdEmp)){

			$EmailContacto = $rowEmp['Email'];
			$bdCc=$link->query("Select * From contactosCli Where RutCli = '".$rowCAM['RutCli']."' and nContacto = '".$rowCAM['nContacto']."'");
			if($rowCc=mysqli_fetch_array($bdCc)){
				$EmailContacto = $rowCc['Email'];
			}
			
			///////Configuraci�n/////
			//$mail_destinatario = 'alfredo.artigas@usach.cl';
			$mail_destinatario = $EmailContacto;
			//$mail_destinatario = 'francisco.olivares.rodriguez@gmail.com';
			///////Fin configuraci�n//
		
			$horaPAM 	= date('H:i');
			$fechaHoy 	= date('Y-m-d');
			
			$fd = explode('-', $rowCAM['fechaInicio']);
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $rowCAM['fechaInicio'];

			if($horaPAM >= '12:00'){
				$dh	= $rowCAM['dHabiles']+1;
			}else{
				$dh	= $rowCAM['dHabiles'];
			}
			$dHabiles = $dh;
			
			$dd	= 0;
			for($i=1; $i<=$dh; $i++){
				$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fechaHoy ) );
				$ft	= date ( 'Y-m-d' , $ft );
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
			}
			$fe = explode('-', $ft);

			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="horaPAM				='".$horaPAM.	"',";
			$actSQL.="dHabiles				='".$dHabiles.	"',";
			$actSQL.="fechaEstimadaTermino	='".$ft.		"'";
			$actSQL.="WHERE CAM 			= '".$CAM."'";
			$bdCot=$link->query($actSQL);
			
			$Descripcion = '';
			$bdRA=$link->query("Select * From registroMuestras Where RAM = '".$RAM."'");
			if($rowRA=mysqli_fetch_array($bdRA)){
				$Descripcion = $rowRA['Descripcion'];
			}
			
			$msgCorreo  = 'Estimados: <br>';
						
			$msgCorreo .= '<b>'.$rowEmp['Cliente'].'</b><br><br>';

			$msgCorreo .= 'En estos momentos con fecha '.$fd[2].'-'.$fd[1].'-'.$fd[0].', hora '.$horaPAM.' ha sido ingresado a ';
			$msgCorreo .= 'proceso su requerimiento con el siguiente detalle:<br><br>';

			$msgDetalle = '<table width="100%" cellpadding="0" cellspacing="0">
								<tr bgcolor="#F8F8F8">
									<td width="40%" style="padding:10px; border-bottom:1px solid #fff;">Número de requerimiento </td>
									<td style="padding:10px; border-bottom:1px solid #fff;">'.$RAM.'</td>
								</tr>
								<tr bgcolor="#F8F8F8">
									<td width="40%" style="padding:10px; border-bottom:1px solid #fff;">Número de cotización </td>
									<td style="padding:10px; border-bottom:1px solid #fff;">'.$CAM.'</td>
								</tr>
								<tr bgcolor="#F8F8F8">
									<td style="padding:10px; border-bottom:1px solid #fff;">Fecha estimada de entrega: </td>
									<td style="padding:10px; border-bottom:1px solid #fff;">'.$fe[2].'-'.$fe[1].'-'.$fe[0].'</td>
								</tr>
							</table>
							<br>';			

			$msgNota = '<b>Nota:</b>';
			$msgNota .= '<ul>';
			$msgNota .= '	<li>Si el ingreso del trabajo se realiza posterior a las 12:00 hrs, la fecha es calculada según el dia hábil siguiente</li>';
			$msgNota .= '	<li>Este e-mail se genera de manera automática, favor no contestar.</li>';
			$msgNota .= '</ul>';
			$msgNota .= '<br><br>';

			$msgPie = "<span style='color:#006699'>";
			$msgPie .= 'Laboratorio SIMET-USACH, Acreditado NCh-ISO 17.025<br>';
			$msgPie .= 'Departamento de Ingeniería  Metalúrgica<br>';
			$msgPie .= 'Facultad de Ingeniería<br>';
			$msgPie .= 'Universidad de Santiago de Chile';
			$msgPie .= '</span>';
/*
			$msgCorreo .= 'N�mero de requerimiento : '.$RAM.'<br>';
			$msgCorreo .= 'N�mero de cotizaci�n : '.$CAM.'<br>';
			$msgCorreo .= 'Fecha estimada de entrega : '.$fe[2].'-'.$fe[1].'-'.$fe[0].'<br>';
*/
			$cabeceras  = "MIME-Version: 1.0\n";
			$cabeceras .= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabeceras .= "X-Priority: 3\n";
			$cabeceras .= "X-MSMail-Priority: Normal\n";
			$cabeceras .= "X-Mailer: php\n";
			
			$Lab 	= 'SIMET-USACH';
			$Correo = 'simet@usach.cl';
			
			$cabeceras .= "From: \"".$Lab."\" <".$Correo.">\n";

			$bdCorreo=$link->query("Select * From Usuarios Where usr = '".$rowCAM['usrCotizador']."'");
			if($rowCorreo=mysqli_fetch_array($bdCorreo)){
				$emailCotizador = $rowCorreo['email'];
			}
						
			$copiasOcultas = 'francisco.olivares.rodriguez@gmail.com, alfredo.artigas@usach.cl, '.$emailCotizador;
			//$copiasOcultas = 'francisco.olivares.rodriguez@gmail.com, ';
			
			$cabeceras .= "Bcc: ".$copiasOcultas." \r\n"; 
	
			$titulo = 'SIMET-USACH Estado de Requerimiento';
			//$loc = "Location: http://erp.simet.cl/cotizaciones/enviarCorreo2.php?mail_destinatario=$mail_destinatario&titulo=$titulo&emailCotizador=$emailCotizador&msgCorreo=$msgCorreo&msgDetalle=$msgDetalle&msgNota=$msgNota&msgPie=$msgPie";
			$Cliente = $rowEmp['Cliente'];
			$fInicio = $rowCAM['fechaInicio'];
			$Descripcion = $rowCAM['Descripcion'];
			$loc = "Location: http://erp.simet.cl/cotizaciones/enviarCorreo2.php?mail_destinatario=$mail_destinatario&Cliente=$Cliente&RAM=$RAM&CAM=$CAM&fInicio=$fInicio&horaPAM=$horaPAM&fTermino=$ft&emailCotizador=$emailCotizador&Descripcion=$Descripcion";
			header($loc);
						
			//mail($mail_destinatario, $titulo, stripcslashes ($msgCorreo), $cabeceras );
		}
	}
}
?>
<!doctype html>
 
<html lang="es">
<head>
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<!-- <link href="../css/tpv.css" rel="stylesheet" type="text/css"> -->
	<link href="styles.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(dBuscar){
		var parametros = {
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraCotizacion.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'regCotizacion.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function buscarContactos(Cliente){
		var parametros = {
			"Cliente" 	: Cliente
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'listaContactos.php',
			type: 'get',
			success: function (response) {
				$("#resultadoContacto").html(response);
			}
		});
	}
	
	function datosContactos(Cliente, Atencion){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion
		};
		//alert(Atencion);
		$.ajax({
			data: parametros,
			url: 'datosDelContacto.php',
			type: 'get',
			success: function (response) {
				$("#rDatosContacto").html(response);
			}
		});
	}

	function seguimientoCAM(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'segCAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function seguimientoRAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segRAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function seguimientoAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function cambiarMoneda(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segCAMvalores.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function verObservaciones(Descripcion, Observaciones){
		var parametros = {
			"Descripcion"	: Descripcion,
			"Observaciones" : Observaciones
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'verDesObs.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function verDeuda(RutCli){
		var parametros = {
			"RutCli"	: RutCli
		};
		//alert(RutCli);
		$.ajax({
			data: parametros,
			url: 'consultaDeuda.php',
			type: 'get',
			success: function (response) {
				$("#registroDeudas").html(response);
			}
		});
	}
	
	</script>

</head>

<body onLoad="cambiar()">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/other_48.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Historial de Procesos (CAM) 
					<?php
						$empFiltro = '';
						if(isset($_GET['empFiltro'])){
							echo $_GET['empFiltro'];
							$empFiltro = $_GET['empFiltro']; 
						}
					?>
				</strong>
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaHistorialCotizacion.php');?>
			<?php include_once('muestraHistorialCotizacion.php'); ?>
		</div>
		<div style="clear:both;"></div>
	</div>
	<br>
</body>
</html>