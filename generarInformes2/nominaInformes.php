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
	$nroInformes = 0;
	
	if(isset($_GET['CodInforme']))		{ $CodInforme	 	= $_GET['CodInforme'];		}
	if(isset($_GET['accion'])) 			{ $accion 	 		= $_GET['accion']; 			}
	if(isset($_GET['RAM'])) 			{ $RAM 		 		= $_GET['RAM']; 			}
	if(isset($_GET['RutCli'])) 			{ $RutCli 	 		= $_GET['RutCli']; 			}
	if(isset($_GET['nroInformes'])) 	{ $nroInformes 		= $_GET['nroInformes']; 	}
	if(isset($_GET['fechaRecepcion']))	{ $fechaRecepcion 	= $_GET['fechaRecepcion'];	}
	if(isset($_GET['ingResponsable']))	{ $ingResponsable 	= $_GET['ingResponsable'];	}
	if(isset($_GET['cooResponsable']))	{ $cooResponsable 	= $_GET['cooResponsable'];	}

	if(isset($_GET['RegenerarInformes'])){
		$link=Conectarse();
		$bdCot=$link->query("Select * From amInformes Where CodInforme Like '%".$CodInforme."%'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$CodInformeOld  = $rowCot['CodInforme'];
			$nroInformesOld = $rowCot['nroInformes'];
			
			$tInformes 	= $nroInformes;
			if($nroInformes<10){
				$tInformes = '0'.$nroInformes;
			}

			$tInformesOld 	= $nroInformesOld;
			if($nroInformesOld<10){
				$tInformesOld = '0'.$nroInformesOld;
			}

			$cInforme 	= $CodInforme;

			if($nroInformes == $rowCot['nroInformes']){
				$actSQL="UPDATE amInformes SET ";
				$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
				$actSQL.="cooResponsable	='".$cooResponsable.	"'";
				$actSQL.="WHERE CodInforme	Like '%".$CodInforme."%'";
				$bdCot=$link->query($actSQL);
				}
			if($nroInformes < $rowCot['nroInformes']){
				for($i=1; $i<=$nroInformes; $i++){
					$de = $i;
					if($i<10){
						$de = '0'.$i;
					}
					$CodInforme 	= $cInforme.'-'.$de.$tInformes;
					$CodInformeOld 	= $cInforme.'-'.$de.$tInformesOld;
					$bdCot=$link->query("Select * From amInformes Where CodInforme = '".$CodInformeOld."'");
					if($rowCot=mysqli_fetch_array($bdCot)){
						$Estado		= 'P';
						$actSQL="UPDATE amInformes SET ";
						$actSQL.="CodInforme		='".$CodInforme.		"',";
						$actSQL.="nroInformes		='".$nroInformes.		"',";
						$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
						$actSQL.="Estado			='".$Estado.			"',";
						$actSQL.="ingResponsable	='".$ingResponsable.	"',";
						$actSQL.="cooResponsable	='".$cooResponsable.	"',";
						$actSQL.="RutCli			='".$RutCli.			"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);

						$fe = explode('-', $fechaRecepcion);
						
						$actSQL="UPDATE informes SET ";
						$actSQL.="CodInforme		='".$CodInforme.		"',";
						$actSQL.="nInforme			='".$nroInformes.		"',";
						$actSQL.="DiaInforme		='".$fe[2].				"',";
						$actSQL.="MesInforme		='".$fe[1].				"',";
						$actSQL.="AgnoInforme		='".$fe[0].				"',";
						$actSQL.="Estado			='".$Estado.			"',";
						$actSQL.="RutCli			='".$RutCli.			"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);
						
						$actSQL="UPDATE amMuestras SET ";
						$actSQL.="CodInforme		= '".$CodInforme.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="CodInforme		= '".$CodInforme.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regCharpy SET ";
						$actSQL.="CodInforme		= '".$CodInforme.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="CodInforme		= '".$CodInforme.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regQuimico SET ";
						$actSQL.="CodInforme		= '".$CodInforme.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regTraccion SET ";
						$actSQL.="CodInforme		= '".$CodInforme.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
						$bdCot=$link->query($actSQL);
					}
				}
				for($i=$nroInformes+1; $i<=$nroInformesOld; $i++){
					$de = $i;
					if($i<10){
						$de = '0'.$i;
					}
					$CodInforme 	= $cInforme.'-'.$de.$tInformesOld;

					$bdSol=$link->query("DELETE FROM amInformes WHERE CodInforme = '".$CodInforme."'");
					$bdSol=$link->query("DELETE FROM informes 	WHERE CodInforme = '".$CodInforme."'");
					
						$CodEspacio = '';
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="CodInforme		= '".$CodEspacio.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regCharpy SET ";
						$actSQL.="CodInforme		= '".$CodEspacio.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="CodInforme		= '".$CodEspacio.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regQuimico SET ";
						$actSQL.="CodInforme		= '".$CodEspacio.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
						$bdCot=$link->query($actSQL);

						$actSQL="UPDATE regTraccion SET ";
						$actSQL.="CodInforme		= '".$CodEspacio.	"'";
						$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
						$bdCot=$link->query($actSQL);

				}
			}else{
				if($nroInformes > $rowCot['nroInformes']){
					for($i=1; $i<=$nroInformes; $i++){
						$de = $i;
						if($i<10){
							$de = '0'.$i;
						}
						$CodInforme 	= $cInforme.'-'.$de.$tInformes;
						$CodInformeOld 	= $cInforme.'-'.$de.$tInformesOld;
						
						$bdCot=$link->query("Select * From amInformes Where CodInforme = '".$CodInformeOld."'");
						if($rowCot=mysqli_fetch_array($bdCot)){
							$Estado		= 'P';
							$actSQL="UPDATE amInformes SET ";
							$actSQL.="CodInforme		='".$CodInforme.		"',";
							$actSQL.="nroInformes		='".$nroInformes.		"',";
							$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
							$actSQL.="Estado			='".$Estado.			"',";
							$actSQL.="ingResponsable	='".$ingResponsable.	"',";
							$actSQL.="cooResponsable	='".$cooResponsable.	"',";
							$actSQL.="RutCli			='".$RutCli.			"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
							
							$fe = explode('-', $fechaRecepcion);
							
							$actSQL="UPDATE informes SET ";
							$actSQL.="CodInforme		='".$CodInforme.		"',";
							$actSQL.="nInforme			='".$nroInformes.		"',";
							$actSQL.="DiaInforme		='".$fe[2].				"',";
							$actSQL.="MesInforme		='".$fe[1].				"',";
							$actSQL.="AgnoInforme		='".$fe[0].				"',";
							$actSQL.="Estado			='".$Estado.			"',";
							$actSQL.="RutCli			='".$RutCli.			"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);

							$actSQL="UPDATE amMuestras SET ";
							$actSQL.="CodInforme		= '".$CodInforme.	"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
	
							$actSQL="UPDATE OTAMs SET ";
							$actSQL.="CodInforme		= '".$CodInforme.	"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
	
							$actSQL="UPDATE regCharpy SET ";
							$actSQL.="CodInforme		= '".$CodInforme.	"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
	
							$actSQL="UPDATE regDoblado SET ";
							$actSQL.="CodInforme		= '".$CodInforme.	"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
	
							$actSQL="UPDATE regQuimico SET ";
							$actSQL.="CodInforme		= '".$CodInforme.	"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
	
							$actSQL="UPDATE regTraccion SET ";
							$actSQL.="CodInforme		= '".$CodInforme.	"'";
							$actSQL.="WHERE CodInforme	= '".$CodInformeOld."'";
							$bdCot=$link->query($actSQL);
						}else{
							$link->query("insert into amInformes(
															CodInforme,
															nroInformes,
															fechaRecepcion,
															ingResponsable,
															cooResponsable,
															Estado,
															RutCli
															) 
													values 	(	
															'$CodInforme',
															'$nroInformes',
															'$fechaRecepcion',
															'$ingResponsable',
															'$cooResponsable',
															'$Estado',
															'$RutCli'
								)");
								
							$fe = explode('-', $fechaRecepcion);
							
							$link->query("insert into informes(
															CodInforme,
															nInforme,
															DiaInforme,
															MesInforme,
															AgnoInforme,
															Estado,
															RutCli
															) 
													values 	(	
															'$CodInforme',
															'$nroInformes',
															'$fe[2]',
															'$fe[1]',
															'$fe[0]',
															'$Estado',
															'$RutCli'
								)");
						}
					}
				}
			}
		}
		$link->close();
		$accion = '';
	}
	if(isset($_GET['generarInformes'])){	
		$link=Conectarse();
		$tpEnsayo = 1;
		$bdCot=$link->query("Select * From Cotizaciones Where RAM Like '%".$RAM."%'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$tpEnsayo = $rowCot['tpEnsayo'];
		}
		
		$bdCot=$link->query("Select * From amInformes Where CodInforme Like '%".$CodInforme."%'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Estado		= 'P';
			$actSQL="UPDATE amInformes SET ";
			$actSQL.="nroInformes		='".$nroInformes.		"',";
			$actSQL.="tpEnsayo			='".$tpEnsayo.			"',";
			$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
			$actSQL.="Estado			='".$Estado.			"',";
			$actSQL.="ingResponsable	='".$ingResponsable.	"',";
			$actSQL.="cooResponsable	='".$cooResponsable.	"',";
			$actSQL.="RutCli			='".$RutCli.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=$link->query($actSQL);
		}else{
			$Estado		= 'P';
			$cInforme 	= $CodInforme;
			$tInformes 	= $nroInformes;
			if($nroInformes<10){
				$tInformes = '0'.$nroInformes;
			}
			for($i=1; $i<=$nroInformes; $i++){
				$de = $i;
				if($i<10){
					$de = '0'.$i;
				}
				$CodInforme = $cInforme.'-'.$de.$tInformes;
				$link->query("insert into amInformes(
												CodInforme,
												nroInformes,
												tpEnsayo,
												fechaRecepcion,
												ingResponsable,
												cooResponsable,
												Estado,
												RutCli
												) 
										values 	(	
												'$CodInforme',
												'$nroInformes',
												'$tpEnsayo',
												'$fechaRecepcion',
												'$ingResponsable',
												'$cooResponsable',
												'$Estado',
												'$RutCli'
					)");

				// Tabla Informes
				$fdInf = explode('-',$fechaRecepcion);
				$DiaInforme  = $fdInf[2];
				$MesInforme  = $fdInf[1];
				$AgnoInforme = $fdInf[0];
				$IdProyecto  = 'IGT-1118';
				$MesInforme  = 1;
				$AgnoInforme = 2015;
				$link->query("insert into Informes(
												IdProyecto,
												RutCli,
												CodInforme,
												DiaInforme,
												MesInforme,
												AgnoInforme
												) 
										values 	(	
												'$IdProyecto',
												'$RutCli',
												'$CodInforme',
												'$DiaInforme',
												'$MesInforme',
												'$AgnoInforme'
					)");
				
			}
		}
		$link->close();
	}
	if(isset($_POST['generarInformes'])){	
		if(isset($_POST['CodInforme']))	{	$CodInforme	= $_POST['CodInforme'];	}
		if(isset($_POST['accion'])) 	{	$accion 	= $_POST['accion']; 	}
		if(isset($_POST['RAM'])) 		{	$RAM 		= $_POST['RAM']; 		}
		if(isset($_POST['RutCli'])) 	{	$RutCli 	= $_POST['RutCli']; 	}
	}
	$link=Conectarse();
	$bdCot=$link->query("Select * From amInformes Where CodInforme Like '%".$CodInforme."%'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$RutCli = $rowCot['RutCli'];
	}
	$bdCot=$link->query("Select * From Cotizaciones Where RAM Like '%".$RAM."%'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$CAM = $rowCot['CAM'];
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
	function realizaProceso(CodInforme, RAM){
		var parametros = {
			"CodInforme" 	: CodInforme,
			"RAM" 			: RAM
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
	function registraInformes(CodInforme, RAM, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"RAM"			: RAM,
			"accion"		: accion
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'genInformes2.php',
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
					Informes de Resultados de 
					<?php 
						$link=Conectarse();
						$bdCli=$link->query("Select * From Clientes Where RutCli = '".$RutCli."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							$bdCot=$link->query("Select * From Cotizaciones Where RAM = '".$RAM."'");
							if($rowCot=mysqli_fetch_array($bdCot)){
								$bdCon=$link->query("Select * From contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$rowCot['nContacto']."'");
								if($rowCon=mysqli_fetch_array($bdCon)){
									echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli['Cliente'].' ('.$rowCon['Contacto'].')'; 
								}else{
									echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli['Cliente']; 
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
			</div>
			<?php 
				include_once('listaInformes.php');
				if($accion == 'ReEditar'){?>
					<script>
						var accion 		= "<?php echo $accion;?>";
						var RAM 		= "<?php echo $RAM;?>";
						var CodInforme 	= "<?php echo $CodInforme;?>";
						registraInformes(CodInforme, RAM, accion);
					</script>
					<?php
				}
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
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
