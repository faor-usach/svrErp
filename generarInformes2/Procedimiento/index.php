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
	
	$idEspecimen	= '';
	$Ancho			= '';
	$Espesor		= '';
	$cMax			= '';
	$MPa			= '';
	$PSI			= '';
	$ubiCarFrac		= '';
	
	$idEspecimenDoblado	= '';
	$TipoDo				= '';
	$ObservacionesDo	= '';
	$Condicion			= '';
	
	
	$Guardar = 'NO';
	if(isset($_POST['guardarDoblado'])){
		if(isset($_POST['CodInforme'])) 		{ $CodInforme			= $_POST['CodInforme']; 		}
		if(isset($_POST['idEspecimenDoblado'])) { $idEspecimenDoblado	= $_POST['idEspecimenDoblado']; }
		if(isset($_POST['TipoDo'])) 			{ $TipoDo				= $_POST['TipoDo']; 				}
		if(isset($_POST['ObservacionesDo'])) 	{ $ObservacionesDo		= $_POST['ObservacionesDo']; 	}
		if(isset($_POST['Condicion'])) 			{ $Condicion			= $_POST['Condicion']; 			}
		
		$link=Conectarse();
		$bdDo=mysql_query("Select * From regdobladosreal Where idItem = '".$idEspecimenDoblado."'");
		if($rowDo=mysql_fetch_array($bdDo)){
			if($rowDo['Tipo']) 			{ $TipoDo			= $rowDo['Tipo']; 			}
			if($rowDo['Observaciones'])	{ $ObservacionesDo 	= $rowDo['Observaciones'];	}
			if($rowDo['Condicion'])		{ $Condicion		= $rowDo['Condicion'];		}
		}
		$bdSptr=mysql_query("Select * From solregprocdo Where CodInforme = '".$CodInforme."' and idEspecimen = '".$idEspecimenDoblado."'");
		if($rowSptr=mysql_fetch_array($bdSptr)){
			$actSQL="UPDATE solregprocdo SET ";
			$actSQL.="Tipo				='".$TipoDo.			"',";
			$actSQL.="Observaciones		='".$ObservacionesDo.	"',";
			$actSQL.="Condicion			='".$Condicion.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."' and idEspecimen = '".$idEspecimenDoblado."'";
			$bdCot=mysql_query($actSQL);
		}else{
			mysql_query("insert into solregprocdo(
													CodInforme		,
													idEspecimen		,
													Tipo			,
													Observaciones		,
													Condicion
													)
											values 	
													(
													'$CodInforme'			,
													'$idEspecimenDoblado'	,
													'$TipoDo'					,
													'$ObservacionesDo'		,
													'$Condicion'
													)",
			$link);
		}
		mysql_close($link);
	}

	if(isset($_POST['guardarTraccion'])){
		if(isset($_POST['CodInforme'])) 	{ $CodInforme	= $_POST['CodInforme']; 	}
		if(isset($_POST['idEspecimen'])) 	{ $idEspecimen	= $_POST['idEspecimen']; 	}
		if(isset($_POST['Ancho'])) 			{ $Ancho		= $_POST['Ancho']; 			}
		if(isset($_POST['Espesor'])) 		{ $Espesor		= $_POST['Espesor']; 		}
		if(isset($_POST['cMax'])) 			{ $cMax			= $_POST['cMax']; 			}
		if(isset($_POST['ubiCarFrac'])) 	{ $ubiCarFrac	= $_POST['ubiCarFrac']; 	}
		
		$link=Conectarse();
		if($cMax > 0){
			if($Ancho > 0){
				if($Espesor > 0){
					$MPa	= intval(( ($cMax / ($Ancho * $Espesor) ) ) * 9.80665);
					$PSI	= intval($MPa) * 145.038;
				}
			}
		}
		$bdTr=mysql_query("Select * From regtraccion Where idItem = '".$idEspecimen."'");
		if($rowTr=mysql_fetch_array($bdTr)){
			$cMax 		= $rowTr['cMax'];
			$Ancho 		= $rowTr['Ancho'];
			$Espesor	= $rowTr['Espesor'];
			
			if($cMax > 0){
				if($Ancho > 0){
					if($Espesor > 0){
						$MPa	= intval(( ($rowTr['cMax'] / ($rowTr['Ancho'] * $rowTr['Espesor']) ) ) * 9.80665);
						$PSI	= intval($MPa) * 145.038;
					}
				}
			}
		}
		$bdSptr=mysql_query("Select * From solregproctr Where CodInforme = '".$CodInforme."' and idEspecimen = '".$idEspecimen."'");
		if($rowSptr=mysql_fetch_array($bdSptr)){
			$actSQL="UPDATE solregproctr SET ";
			$actSQL.="Ancho				='".$Ancho.		"',";
			$actSQL.="Espesor			='".$Espesor.	"',";
			$actSQL.="cMax				='".$cMax.		"',";
			$actSQL.="MPa				='".$MPa.		"',";
			$actSQL.="PSI				='".$PSI.		"',";
			$actSQL.="ubiCarFrac		='".$ubiCarFrac."'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."' and idEspecimen = '".$idEspecimen."'";
			$bdCot=mysql_query($actSQL);
		}else{
			mysql_query("insert into solregproctr(
													CodInforme		,
													idEspecimen		,
													Ancho			,
													Espesor			,
													cMax			,
													MPa				,
													PSI				,
													ubiCarFrac
													)
											values 	
													(
													'$CodInforme'	,
													'$idEspecimen'	,
													'$Ancho'		,
													'$Espesor'		,
													'$cMax'			,
													'$MPa'			,
													'$PSI'			,
													'$ubiCarFrac'
													)",
			$link);
		}
		mysql_close($link);
	}

	if(isset($_POST['Guardar'])){
		
		if(isset($_POST['fechaCreacion']))		{ $fechaCreacion 		= $_POST['fechaCreacion']; 		}
		if(isset($_POST['RespaldoId']))			{ $RespaldoId 			= $_POST['RespaldoId']; 		}
		if(isset($_POST['fechaEmision']))		{ $fechaEmision 		= $_POST['fechaEmision']; 		}
		if(isset($_POST['usrAutorizador']))		{ $usrAutorizador 		= $_POST['usrAutorizador']; 	}
		if(isset($_POST['Observaciones']))		{ $Observaciones 		= $_POST['Observaciones']; 		}
		if(isset($_POST['CodigoVerificacion']))	{ $CodigoVerificacion 	= $_POST['CodigoVerificacion']; }
		if(isset($_POST['imgQR']))				{ $imgQR 				= $_POST['imgQR']; 				}
		if(isset($_POST['fechaUp']))			{ $fechaUp 				= $_POST['fechaUp']; 			}
		if(!$CodigoVerificacion){
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;
		}
		$link=Conectarse();
		$bdSid=mysql_query("Select * From solIdSoldadura Where CodInforme = '".$CodInforme."'");
		if($rowSid=mysql_fetch_array($bdSid)){
			$actSQL="UPDATE solidsoldadura SET ";
			$actSQL.="Respaldo				='".$RespaldoId.		"',";
			$actSQL.="fechaCreacion			='".$fechaCreacion.		"',";
			$actSQL.="fechaEmision			='".$fechaEmision.		"',";
			$actSQL.="usrAutorizador		='".$usrAutorizador.	"',";
			$actSQL.="Observaciones			='".$Observaciones.		"',";
			$actSQL.="CodigoVerificacion	='".$CodigoVerificacion."',";
			$actSQL.="imgQR					='".$imgQR.				"',";
			$actSQL.="fechaUp				='".$fechaUp.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['procesoSold']))	{ $procesoSold 	= $_POST['procesoSold']; 	}
		if(isset($_POST['nNorma']))			{ $nNorma 		= $_POST['nNorma']; 		}
		if(isset($_POST['Tipo']))			{ $Tipo 		= $_POST['Tipo']; 			}
		
		$bdSid=mysql_query("Select * From solProcSoldadura Where CodInforme = '".$CodInforme."'");
		if($rowSid=mysql_fetch_array($bdSid)){
			$actSQL="UPDATE solProcSoldadura SET ";
			$actSQL.="procesoSold		='".$procesoSold.	"',";
			$actSQL.="nNorma			='".$nNorma.		"',";
			$actSQL.="Tipo				='".$Tipo.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['TipoUnion']))		{ $TipoUnion 	= $_POST['TipoUnion']; 		}
		if(isset($_POST['Soldadura']))		{ $Soldadura	= $_POST['Soldadura']; 		}
		if(isset($_POST['Respaldo']))		{ $Respaldo		= $_POST['Respaldo']; 		}
		if(isset($_POST['matRespaldo']))	{ $matRespaldo	= $_POST['matRespaldo']; 	}
		if(isset($_POST['aberturaRaiz']))	{ $aberturaRaiz	= $_POST['aberturaRaiz']; 	}
		if(isset($_POST['Talon']))			{ $Talon		= $_POST['Talon']; 			}
		if(isset($_POST['anguloCanal']))	{ $anguloCanal	= $_POST['anguloCanal']; 	}
		if(isset($_POST['Radio']))			{ $Radio		= $_POST['Radio']; 			}
		if(isset($_POST['intRaiz']))		{ $intRaiz		= $_POST['intRaiz']; 		}
		if(isset($_POST['Metodo']))			{ $Metodo		= $_POST['Metodo']; 		}
		
		$bdSid=mysql_query("Select * From solUnionUsado Where CodInforme = '".$CodInforme."'");
		if($rowSid=mysql_fetch_array($bdSid)){
			$actSQL="UPDATE solUnionUsado SET ";
			$actSQL.="Tipo				='".$TipoUnion.		"',";
			$actSQL.="Soldadura			='".$Soldadura.		"',";
			$actSQL.="Respaldo			='".$Respaldo.		"',";
			$actSQL.="matRespaldo		='".$matRespaldo.	"',";
			$actSQL.="aberturaRaiz		='".$aberturaRaiz.	"',";
			$actSQL.="Talon				='".$Talon.			"',";
			$actSQL.="anguloCanal		='".$anguloCanal.	"',";
			$actSQL.="Radio				='".$Radio.			"',";
			$actSQL.="intRaiz			='".$intRaiz.		"',";
			$actSQL.="Metodo			='".$Metodo.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}
		
		if(isset($_POST['especMaterialDe'])){ $especMaterialDe 	= $_POST['especMaterialDe']; }
		if(isset($_POST['especMaterialA']))	{ $especMaterialA	= $_POST['especMaterialA']; }
		if(isset($_POST['tpGradoDe']))		{ $tpGradoDe		= $_POST['tpGradoDe']; 		}
		if(isset($_POST['tpGradoA']))		{ $tpGradoA			= $_POST['tpGradoA']; 		}
		if(isset($_POST['espesorCanal']))	{ $espesorCanal		= $_POST['espesorCanal']; 	}
		if(isset($_POST['espesorFilete']))	{ $espesorFilete	= $_POST['espesorFilete']; 	}
		if(isset($_POST['diametroCaneria'])){ $diametroCaneria	= $_POST['diametroCaneria'];}
		if(isset($_POST['grupoDe']))		{ $grupoDe			= $_POST['grupoDe']; 		}
		if(isset($_POST['grupoA']))			{ $grupoA			= $_POST['grupoA']; 		}
		if(isset($_POST['numeroPde']))		{ $numeroPde		= $_POST['numeroPde']; 		}
		if(isset($_POST['numeroPa']))		{ $numeroPa			= $_POST['numeroPa']; 		}
		
		$bdSid=mysql_query("Select * From solMetalBase Where CodInforme = '".$CodInforme."'");
		if($rowSid=mysql_fetch_array($bdSid)){
			$actSQL="UPDATE solMetalBase SET ";
			$actSQL.="especMaterialDe	='".$especMaterialDe.	"',";
			$actSQL.="especMaterialA	='".$especMaterialA.	"',";
			$actSQL.="tpGradoDe			='".$tpGradoDe.			"',";
			$actSQL.="tpGradoA			='".$tpGradoA.			"',";
			$actSQL.="espesorCanal		='".$espesorCanal.		"',";
			$actSQL.="espesorFilete		='".$espesorFilete.		"',";
			$actSQL.="diametroCaneria	='".$diametroCaneria.	"',";
			$actSQL.="grupoDe			='".$grupoDe.			"',";
			$actSQL.="grupoA			='".$grupoA.			"',";
			$actSQL.="numeroPde			='".$numeroPde.			"',";
			$actSQL.="numeroPa			='".$numeroPa.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}
		
		if(isset($_POST['especAWSde']))		{ $especAWSde		= $_POST['especAWSde']; 	}
		if(isset($_POST['especAWSa']))		{ $especAWSa		= $_POST['especAWSa']; 		}
		if(isset($_POST['clasAWSde']))		{ $clasAWSde		= $_POST['clasAWSde']; 		}
		if(isset($_POST['clasAWSa']))		{ $clasAWSa			= $_POST['clasAWSa']; 		}
		if(isset($_POST['diametroElecDe']))	{ $diametroElecDe	= $_POST['diametroElecDe']; }
		if(isset($_POST['diametroElecA']))	{ $diametroElecA	= $_POST['diametroElecA']; 	}

		$bdSma=mysql_query("Select * From solMetalAporte Where CodInforme = '".$CodInforme."'");
		if($rowSma=mysql_fetch_array($bdSma)){
			$actSQL="UPDATE solMetalAporte SET ";
			$actSQL.="especAWSde		='".$especAWSde.		"',";
			$actSQL.="especAWSa			='".$especAWSa.			"',";
			$actSQL.="clasAWSde			='".$clasAWSde.			"',";
			$actSQL.="clasAWSa			='".$clasAWSa.			"',";
			$actSQL.="diametroElecDe	='".$diametroElecDe.	"',";
			$actSQL.="diametroElecA		='".$diametroElecA.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['fundente']))			{ $fundente				= $_POST['fundente']; 			}
		if(isset($_POST['gasClasificacion']))	{ $gasClasificacion		= $_POST['gasClasificacion']; 	}
		if(isset($_POST['composicion']))		{ $composicion			= $_POST['composicion']; 		}
		if(isset($_POST['flujo']))				{ $flujo				= $_POST['flujo']; 				}
		if(isset($_POST['tamTobera']))			{ $tamTobera			= $_POST['tamTobera']; 			}
		if(isset($_POST['claseFundenteElec']))	{ $claseFundenteElec	= $_POST['claseFundenteElec']; 	}

		$bdSpr=mysql_query("Select * From solProteccion Where CodInforme = '".$CodInforme."'");
		if($rowSpr=mysql_fetch_array($bdSpr)){
			$actSQL="UPDATE solProteccion SET ";
			$actSQL.="fundente			='".$fundente.			"',";
			$actSQL.="gasClasificacion	='".$gasClasificacion.	"',";
			$actSQL.="composicion		='".$composicion.		"',";
			$actSQL.="flujo				='".$flujo.				"',";
			$actSQL.="tamTobera			='".$tamTobera.			"',";
			$actSQL.="claseFundenteElec	='".$claseFundenteElec.	"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['preCalMin']))	{ $preCalMin	= $_POST['preCalMin']; 	}
		if(isset($_POST['interMin']))	{ $interMin		= $_POST['interMin']; 	}
		if(isset($_POST['interMax']))	{ $interMax		= $_POST['interMax']; 	}

		$bdSpc=mysql_query("Select * From solPreCalentamiento Where CodInforme = '".$CodInforme."'");
		if($rowSpc=mysql_fetch_array($bdSpc)){
			$actSQL="UPDATE solPreCalentamiento SET ";
			$actSQL.="preCalMin	='".$preCalMin.	"',";
			$actSQL.="interMin	='".$interMin.	"',";
			$actSQL.="interMax	='".$interMax.	"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['Canal']))				{ $Canal				= $_POST['Canal']; 				}
		if(isset($_POST['Filete']))				{ $Filete				= $_POST['Filete']; 			}
		if(isset($_POST['progresionVertical']))	{ $progresionVertical	= $_POST['progresionVertical']; }

		$bdSpo=mysql_query("Select * From solPosicion Where CodInforme = '".$CodInforme."'");
		if($rowSpo=mysql_fetch_array($bdSpo)){
			$actSQL="UPDATE solPosicion SET ";
			$actSQL.="Canal					='".$Canal.					"',";
			$actSQL.="Filete				='".$Filete.				"',";
			$actSQL.="progresionVertical	='".$progresionVertical.	"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}
		
		if(isset($_POST['modoTransferencia']))	{ 
			$modoTransferencia	= $_POST['modoTransferencia'];	
			switch ($_POST['modoTransferencia']) {
				case 'cortoCircuito':
					$cortoCircuito 	= 1;
					break;
				case 'Globular':
					$Globular 		= true;
					break;
				case 'Globular':
					$Spray 			= 1;
					break;
			}		
		}
		
		if(isset($_POST['corrientePolaridad']))	{ 
			$corrientePolaridad	= $_POST['corrientePolaridad'];	
			switch ($_POST['corrientePolaridad']) {
				case 'CA':
					$CA 		= 1;
					break;
				case 'CCEP':
					$CCEP 		= 1;
					break;
				case 'CCEN':
					$CCEN 		= 1;
					break;
			}		
		}

		if(isset($_POST['Otro']))				{ $Otro					= $_POST['Otro']; 				}
		if(isset($_POST['elecTunTam']))			{ $elecTunTam			= $_POST['elecTunTam']; 		}
		if(isset($_POST['elecTunTipo']))		{ $elecTunTipo			= $_POST['elecTunTipo']; 		}
		
		$bdSce=mysql_query("Select * From solCarElec Where CodInforme = '".$CodInforme."'");
		if($rowSce=mysql_fetch_array($bdSce)){
			$actSQL="UPDATE solCarElec SET ";
			$actSQL.="cortoCircuito			='".$cortoCircuito.	"',";
			$actSQL.="Globular				='".$Globular.		"',";
			$actSQL.="Spray					='".$Spray.			"',";
			$actSQL.="CA					='".$CA.			"',";
			$actSQL.="CCEP					='".$CCEP.			"',";
			$actSQL.="CCEN					='".$CCEN.			"',";
			$actSQL.="Otro					='".$Otro.			"',";
			$actSQL.="elecTunTam			='".$elecTunTam.	"',";
			$actSQL.="elecTunTipo			='".$elecTunTipo.	"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['Cordon']))			{ $Cordon			= $_POST['Cordon']; 		}
		if(isset($_POST['Pase']))			{ $Pase				= $_POST['Pase']; 			}
		if(isset($_POST['nElectrodos']))	{ $nElectrodos		= $_POST['nElectrodos']; 	}
		if(isset($_POST['Longitudinal']))	{ $Longitudinal		= $_POST['Longitudinal'];	}
		if(isset($_POST['Lateral']))		{ $Lateral			= $_POST['Lateral']; 		}
		if(isset($_POST['Angulo']))			{ $Angulo			= $_POST['Angulo']; 		}
		if(isset($_POST['Distancia']))		{ $Distancia		= $_POST['Distancia']; 		}
		if(isset($_POST['Martillado']))		{ $Martillado		= $_POST['Martillado']; 	}
		if(isset($_POST['Limpieza']))		{ $Limpieza			= $_POST['Limpieza']; 		}
		
		$bdSte=mysql_query("Select * From solTecnica Where CodInforme = '".$CodInforme."'");
		if($rowSte=mysql_fetch_array($bdSte)){
			$actSQL="UPDATE solTecnica SET ";
			$actSQL.="Cordon			='".$Cordon.		"',";
			$actSQL.="Pase				='".$Pase.			"',";
			$actSQL.="nElectrodos		='".$nElectrodos.	"',";
			$actSQL.="Longitudinal		='".$Longitudinal.	"',";
			$actSQL.="Lateral			='".$Lateral.		"',";
			$actSQL.="Angulo			='".$Angulo.		"',";
			$actSQL.="Distancia			='".$Distancia.		"',";
			$actSQL.="Martillado		='".$Martillado.	"',";
			$actSQL.="Limpieza			='".$Limpieza.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}

		if(isset($_POST['Temperatura'])){ $Temperatura		= $_POST['Temperatura']; 	}
		if(isset($_POST['Tiempo']))		{ $Tiempo			= $_POST['Tiempo']; 		}
		
		$bdStt=mysql_query("Select * From solTermico Where CodInforme = '".$CodInforme."'");
		if($rowStt=mysql_fetch_array($bdStt)){
			$actSQL="UPDATE solTermico SET ";
			$actSQL.="Temperatura			='".$Temperatura.		"',";
			$actSQL.="Tiempo				='".$Tiempo.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}
		mysql_close($link);
	}

	if(isset($_POST['agregarProc'])){
		$nCordon = 1;
		if(isset($_POST['CodInforme']))		{ $CodInforme 		= $_POST['CodInforme']; 	}
		if(isset($_POST['nCordon']))		{ $nCordon 			= $_POST['nCordon']; 		}
		if(isset($_POST['Proceso']))		{ $Proceso 			= $_POST['Proceso']; 		}
		if(isset($_POST['matClase']))		{ $matClase 		= $_POST['matClase']; 		}
		if(isset($_POST['matDiametro']))	{ $matDiametro 		= $_POST['matDiametro']; 	}
		if(isset($_POST['corrienteTipo']))	{ $corrienteTipo 	= $_POST['corrienteTipo']; 	}
		if(isset($_POST['corrienteAmp']))	{ $corrienteAmp 	= $_POST['corrienteAmp']; 	}
		if(isset($_POST['Volt']))			{ $Volt 			= $_POST['Volt']; 			}
		if(isset($_POST['Velocidad']))		{ $Velocidad 		= $_POST['Velocidad']; 		}
		
		$link=Conectarse();
		$bdReg=mysql_query("Select * From solRegProcSoldadura Where CodInforme = '".$CodInforme."' and nCordon = '".$nCordon."'");
		if($rowReg=mysql_fetch_array($bdReg)){
			$actSQL="UPDATE solRegProcSoldadura SET ";
			$actSQL.="Proceso			='".$Proceso.		"',";
			$actSQL.="matClase			='".$matClase.		"',";
			$actSQL.="matDiametro		='".$matDiametro.	"',";
			$actSQL.="corrienteTipo		='".$corrienteTipo.	"',";
			$actSQL.="corrienteAmp		='".$corrienteAmp.	"',";
			$actSQL.="Volt				='".$Volt.			"',";
			$actSQL.="Velocidad			='".$Velocidad.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."' and nCordon = '".$nCordon."'";
			$bdReg=mysql_query($actSQL);
		}
		mysql_close($link);

		if(isset($_POST['CodInforme']))		{ $CodInforme 		= $_POST['CodInforme']; 	}
		$link=Conectarse();
		$bdReg=mysql_query("Select * From solRegProcSoldadura Where CodInforme = '".$CodInforme."' Order By nCordon Desc");
		if($rowReg=mysql_fetch_array($bdReg)){
			$nCordon = $rowReg['nCordon'] + 1;
			mysql_query("insert into solRegProcsoldadura(
														CodInforme		,
														nCordon
														)
												values 	
														(
														'$CodInforme'	,
														'$nCordon'
														)",
			$link);
		}
		mysql_close($link);
	}
	
	if(isset($_POST['guardarProc'])){
		if(isset($_POST['CodInforme']))		{ $CodInforme 		= $_POST['CodInforme']; 	}
		if(isset($_POST['nCordon']))		{ $nCordon 			= $_POST['nCordon']; 		}
		if(isset($_POST['Proceso']))		{ $Proceso 			= $_POST['Proceso']; 		}
		if(isset($_POST['matClase']))		{ $matClase 		= $_POST['matClase']; 		}
		if(isset($_POST['matDiametro']))	{ $matDiametro 		= $_POST['matDiametro']; 	}
		if(isset($_POST['corrienteTipo']))	{ $corrienteTipo 	= $_POST['corrienteTipo']; 	}
		if(isset($_POST['corrienteAmp']))	{ $corrienteAmp 	= $_POST['corrienteAmp']; 	}
		if(isset($_POST['Volt']))			{ $Volt 			= $_POST['Volt']; 			}
		if(isset($_POST['Velocidad']))		{ $Velocidad 		= $_POST['Velocidad']; 		}
		
		$link=Conectarse();
		$bdReg=mysql_query("Select * From solRegProcSoldadura Where CodInforme = '".$CodInforme."' and nCordon = '".$nCordon."'");
		if($rowReg=mysql_fetch_array($bdReg)){
			echo $nCordon;
			$actSQL="UPDATE solRegProcSoldadura SET ";
			$actSQL.="nCordon			='".$nCordon.		"',";
			$actSQL.="Proceso			='".$Proceso.		"',";
			$actSQL.="matClase			='".$matClase.		"',";
			$actSQL.="matDiametro		='".$matDiametro.	"',";
			$actSQL.="corrienteTipo		='".$corrienteTipo.	"',";
			$actSQL.="corrienteAmp		='".$corrienteAmp.	"',";
			$actSQL.="Volt				='".$Volt.			"',";
			$actSQL.="Velocidad			='".$Velocidad.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."' and nCordon = '".intval($nCordon)."'";
			$bdReg=mysql_query($actSQL);
		}
		mysql_close($link);
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
	}else{
		$Rev	= 0;
		mysql_query("insert into solidsoldadura(
												RutCli			,
												CodInforme		,
												fechaCreacion	,
												usrResponsable
												)
										values 	
												(
												'$RutCli'		,
												'$CodInforme'	,
												'$fechaCreacion',
												'$usrResponsable'
												)",
		$link);
		
		$fdCod = explode('-',$CodInforme);
		$idSoldadura = $fdCod[0];
		
		mysql_query("insert into solprocsoldadura(
												CodInforme	,
												idSoldadura
												)
										values 	
												(
												'$CodInforme'	,
												'$idSoldadura'
												)",
		$link);

		mysql_query("insert into solUnionUsado		( CodInforme ) values ( '$CodInforme' )", $link);
		mysql_query("insert into solMetalBase		( CodInforme ) values ( '$CodInforme' )", $link);
		mysql_query("insert into solMetalAporte		( CodInforme ) values ( '$CodInforme' )", $link);
		mysql_query("insert into solProteccion		( CodInforme ) values ( '$CodInforme' )", $link);
		mysql_query("insert into solPreCalentamiento( CodInforme ) values ( '$CodInforme' )", $link);
		mysql_query("insert into solPosicion		( CodInforme ) values ( '$CodInforme' )", $link);
		mysql_query("insert into solCarElec			( CodInforme ) values (	'$CodInforme' )", $link);
		mysql_query("insert into solTecnica			( CodInforme ) values (	'$CodInforme' )", $link);
		mysql_query("insert into solTermico			( CodInforme ) values (	'$CodInforme' )", $link);
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
	<form name="form" action="index.php" method="post">
		<?php include_once('barraBotones.php'); ?>
		<?php include_once('formProcedimiento.php'); ?>
	</form>
</body>
</html>
