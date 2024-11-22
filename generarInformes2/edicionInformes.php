<?php
	session_start(); 
	include_once("../conexionli.php");
	include_once('../resize-class.php');
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
	if(isset($_POST['CodInforme']))		{ $CodInforme	 	= $_POST['CodInforme'];	}
	if(isset($_POST['accion'])) 		{ $accion 	 		= $_POST['accion']; 	}
	
	if(isset($_GET['RAM']))				{ $RAM	 			= $_GET['RAM'];			}
	if(isset($_GET['CodInforme']))		{ $CodInforme	 	= $_GET['CodInforme'];	}
	if(isset($_GET['idItem'])) 			{ $idIt 	 		= $_GET['idItem']; 		}
	if(isset($_GET['accion'])) 			{ $accion 	 		= $_GET['accion']; 		}

	$CAM = '';
	$link=Conectarse();
	$bd=$link->query("SELECT * FROM cotizaciones Where RAM = '$RAM'");
	if($rs=mysqli_fetch_array($bd)){
		$CAM = $rs['CAM'];
	}
	$link->close();
	
	if($CodInforme){
		// **************************************************************************
		// Crea carpetas tanto en AAA como en el Local si no existiesen
		// **************************************************************************
		$am = explode('-',$CodInforme);
		$ramAm = $am[1];
		$agnoActual = date('Y'); 

		$directorioAM = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$ramAm;
		if(!file_exists($directorioAM)){
			mkdir($directorioAM);
		}
		$directorioImpactosLocal = '../Archivador-AM';
		if(!file_exists($directorioImpactosLocal)){
			mkdir($directorioImpactosLocal);
			$directorioImpactosLocalRam = $directorioImpactosLocal.'/'.$ramAm;
			if(!file_exists($directorioImpactosLocalRam)){
				mkdir($directorioImpactosLocalRam);
			}
		}else{
			$directorioImpactosLocalRam = $directorioImpactosLocal.'/'.$ramAm;
			if(!file_exists($directorioImpactosLocalRam)){
				mkdir($directorioImpactosLocalRam);
			}
		}
	}

	//Chequeando
	$link=Conectarse();
	$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."'");
	while($rowTabEns=mysqli_fetch_array($bdTabEns)){
		$actSQL="UPDATE regtraccion SET ";
		$actSQL.="CodInforme 			='".$rowTabEns['CodInforme'].	"'";
		$actSQL.="WHERE idItem like '%".$rowTabEns['idItem']."%'";
		$bdRegDob=$link->query($actSQL);

		$bdTabQu=$link->query("SELECT * FROM regquimico Where CodInforme = '".$CodInforme."'");
		if($rsQu=mysqli_fetch_array($bdTabQu)){

		}else{
			$actSQL="UPDATE regquimico SET ";
			$actSQL.="CodInforme 			='".$rowTabEns['CodInforme'].	"'";
			$actSQL.="WHERE idItem like '%".$rowTabEns['idItem']."%'";
			$bdRegDob=$link->query($actSQL);
		}
	

		$actSQL="UPDATE regcharpy SET ";
		$actSQL.="CodInforme 			='".$rowTabEns['CodInforme'].	"'";
		$actSQL.="WHERE idItem like '%".$rowTabEns['idItem']."%'";
		$bdRegDob=$link->query($actSQL);

		$actSQL="UPDATE regdobladoreal SET ";
		$actSQL.="CodInforme 			='".$rowTabEns['CodInforme'].	"'";
		$actSQL.="WHERE idItem like '%".$rowTabEns['idItem']."%'";
		$bdRegDob=$link->query($actSQL);

		$actSQL="UPDATE regdoblado SET ";
		$actSQL.="CodInforme 			='".$rowTabEns['CodInforme'].	"'";
		$actSQL.="WHERE idItem like '%".$rowTabEns['idItem']."%'";
		$bdRegDob=$link->query($actSQL);

	}
	$link->close();

	//Fin Chequeo

	if(isset($_POST['actualizaTabMuestras'])){
		if(isset($_POST['idItem'])) 	{ $idItem 	 		= $_POST['idItem']; 	}
		if(isset($_POST['idEnsayo'])) 	{ $idEnsayo	 		= $_POST['idEnsayo']; 	}
		if(isset($_POST['tpMuestra'])) 	{ $tpMuestra 		= $_POST['tpMuestra']; 	}
		if(isset($_POST['Ref'])) 		{ $Ref 				= $_POST['Ref']; 		}
		if(isset($_POST['Ind'])) 		{ $Ind 				= $_POST['Ind']; 		}
		if(isset($_POST['Tem'])) 		{ $Tem 				= $_POST['Tem']; 		}
		if(isset($_POST['accion'])) 	{ $accion 	 		= $_POST['accion']; 	}

		$link=Conectarse();
		$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$idEnsayo."' and tpMuestra = '".$tpMuestra."' and Ref = '".$Ref."'");
		if($rowTabEns=mysqli_fetch_array($bdTabEns)){
			$cEnsayos = $rowTabEns['cEnsayos'];
		}
		$link->close();
		if($idEnsayo == 'Qu') { $idE = 'Q'; }
		if($idEnsayo == 'Tr') { $idE = 'T'; }
		if($idEnsayo == 'Ch') { $idE = 'Ch'; }
		if($idEnsayo == 'Du') { $idE = 'D'; }
		
		// Si $idE = Qu entonce $idE = Q
		// $idE = ('Qu') ? 'Q': '';



		// Inicio Dureza
		if($idEnsayo == 'Du'){
			for($i=1; $i<=$cEnsayos; $i++){
				$ta = explode('-',$CodInforme);
				$tq = $ta[1].'-'.$idE.$i;
				if($i<10){ $tq = $ta[1].'-'.$idE.'0'.$i; }
	
				$campoidItem 	= 'idItem'.$tq;

				if(isset($_POST[$campoidItem]))	{ $campoidItem	= $_POST[$campoidItem];	}
					
				for($in=1; $in<=$Ind; $in++) { 
					$el_nIndenta 	= 'nIndenta_'.$in.'-'.$tq;
					$el_vIndenta	= 'vIndenta_'.$in.'-'.$tq;
					if(isset($_POST[$el_nIndenta]))		{ $el_nIndenta		= $_POST[$el_nIndenta];		}
					if(isset($_POST[$el_vIndenta]))		{ $el_vIndenta		= $_POST[$el_vIndenta];		}
					$link=Conectarse();
					$bdRegDob=$link->query("SELECT * FROM regDoblado Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nIndenta = '".$in."'");
					if($rowRegDob=mysqli_fetch_array($bdRegDob)){
						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="vIndenta 			='".$el_vIndenta.	"'";
						$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nIndenta = '".$in."'";
						$bdRegDob=$link->query($actSQL);
					}else{
						$link->query("insert into regDoblado(
																CodInforme,
																idItem,
																tpMuestra,
																nIndenta,
																vIndenta
																) 
														values 	(	
																'$CodInforme',
																'$campoidItem',
																'$tpMuestra',
																'$in',
																'$el_vIndenta'
								)");
					}
					$link->close();
				}
			}
		}
		// Fin Dureza


		// Inicio Charpy
		if($idEnsayo == 'Ch'){
			for($i=1; $i<=$cEnsayos; $i++){
				$ta = explode('-',$CodInforme);
				$tq = $ta[1].'-'.$idE.$i;
				if($i<10){ $tq = $ta[1].'-'.$idE.'0'.$i; }
	
				$campoidItem 	= 'idItem'.$tq;

				if(isset($_POST[$campoidItem]))	{ $campoidItem	= $_POST[$campoidItem];	}
					
				for($in=1; $in<=$Ind; $in++) { 
					$el_nImpacto 	= 'nImpacto_'.$in.'-'.$tq;
					$el_vImpacto	= 'vImpacto_'.$in.'-'.$tq;
					if(isset($_POST[$el_nImpacto]))		{ $el_nImpacto		= $_POST[$el_nImpacto];		}
					if(isset($_POST[$el_vImpacto]))		{ $el_vImpacto		= $_POST[$el_vImpacto];		}
					$link=Conectarse();
					$bdRegCh=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nImpacto = '".$in."'");
					if($rowRegCh=mysqli_fetch_array($bdRegCh)){
						$actSQL="UPDATE regCharpy SET ";
						$actSQL.="vImpacto 			='".$el_vImpacto.	"'";
						$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nImpacto = '".$in."'";
						$bdRegDob=$link->query($actSQL);
					}else{
						$link->query("insert into regCharpy(
																CodInforme,
																idItem,
																tpMuestra,
																nImpacto,
																vImpacto
																) 
														values 	(	
																'$CodInforme',
																'$campoidItem',
																'$tpMuestra',
																'$in',
																'$el_vImpacto'
								)");
					}
					$link->close();
				}
			}
		}
		// Fin Charpy



		// Qu�mico				
		if($idEnsayo == 'Qu'){
			for($i=1; $i<=$cEnsayos; $i++){
				$ta = explode('-',$CodInforme);
				$tq = $ta[1].'-'.$idE.$i;
				if($i<10){ $tq = $ta[1].'-'.$idE.'0'.$i; }
	
				$campoidItem 	= 'idItem'.$tq;
				$el_cC 			= 'cC'.$tq;
				$el_cSi			= 'cSi'.$tq;
				$el_cMn			= 'cMn'.$tq;
				$el_cP			= 'cP'.$tq;
				$el_cS			= 'cS'.$tq;
				$el_cCr			= 'cCr'.$tq;
				$el_cNi			= 'cNi'.$tq;
				$el_cMo			= 'cMo'.$tq;
				$el_cAl			= 'cAl'.$tq;
				$el_cCu			= 'cCu'.$tq;
				$el_cCo			= 'cCo'.$tq;
				$el_cTi			= 'cTi'.$tq;
				$el_cNb			= 'cNb'.$tq;
				$el_cV			= 'cV'.$tq;
				$el_cW			= 'cW'.$tq;
				$el_cSn			= 'cSn'.$tq;
				$el_cB			= 'cB'.$tq;
				$el_cFe			= 'cFe'.$tq;
			
				$el_cZn 		= 'cZn'.$tq;
				$el_cPb 		= 'cPb'.$tq;
				$el_cMg 		= 'cMg'.$tq;
				$el_cTe 		= 'cTe'.$tq;
				$el_cAs 		= 'cAs'.$tq;
				$el_cSb 		= 'cSb'.$tq;
				$el_cCd 		= 'cCd'.$tq;
				$el_cBi 		= 'cBi'.$tq;
				$el_cAg 		= 'cAg'.$tq;
				$el_cAi 		= 'cAi'.$tq;
				$el_cZr 		= 'cZr'.$tq;
				$el_cAu 		= 'cAu'.$tq;
				$el_cSe 		= 'cSe'.$tq;
	
				if(isset($_POST[$campoidItem]))	{ $campoidItem	= $_POST[$campoidItem];	}
				if(isset($_POST[$el_cC]))		{ $el_cC		= $_POST[$el_cC];		}
				if(isset($_POST[$el_cSi]))		{ $el_cSi		= $_POST[$el_cSi];		}
				if(isset($_POST[$el_cMn]))		{ $el_cMn		= $_POST[$el_cMn];		}
				if(isset($_POST[$el_cP]))		{ $el_cP		= $_POST[$el_cP];		}
				if(isset($_POST[$el_cS]))		{ $el_cS		= $_POST[$el_cS];		}
				if(isset($_POST[$el_cCr]))		{ $el_cCr		= $_POST[$el_cCr];		}
				if(isset($_POST[$el_cNi]))		{ $el_cNi		= $_POST[$el_cNi];		}
				if(isset($_POST[$el_cMo]))		{ $el_cMo		= $_POST[$el_cMo];		}
				if(isset($_POST[$el_cAl]))		{ $el_cAl		= $_POST[$el_cAl];		}
				if(isset($_POST[$el_cCu]))		{ $el_cCu		= $_POST[$el_cCu];		}
				if(isset($_POST[$el_cCo]))		{ $el_cCo		= $_POST[$el_cCo];		}
				if(isset($_POST[$el_cTi]))		{ $el_cTi		= $_POST[$el_cTi];		}
				if(isset($_POST[$el_cNb]))		{ $el_cNb		= $_POST[$el_cNb];		}
				if(isset($_POST[$el_cV]))		{ $el_cV		= $_POST[$el_cV];		}
				if(isset($_POST[$el_cW]))		{ $el_cW		= $_POST[$el_cW];		}
				if(isset($_POST[$el_cSn]))		{ $el_cSn		= $_POST[$el_cSn];		}
				if(isset($_POST[$el_cB]))		{ $el_cB		= $_POST[$el_cB];		}
				if(isset($_POST[$el_cFe]))		{ $el_cFe		= $_POST[$el_cFe];		}
				
				if(isset($_POST[$el_cZn]))		{ $el_cZn		= $_POST[$el_cZn];		};
				if(isset($_POST[$el_cPb]))		{ $el_cPb		= $_POST[$el_cPb];		};
				if(isset($_POST[$el_cMg]))		{ $el_cMg		= $_POST[$el_cMg];		};
				if(isset($_POST[$el_cTe]))		{ $el_cTe		= $_POST[$el_cTe];		};
				if(isset($_POST[$el_cAs]))		{ $el_cAs		= $_POST[$el_cAs];		};
				if(isset($_POST[$el_cSb]))		{ $el_cSb		= $_POST[$el_cSb];		};
				if(isset($_POST[$el_cCd]))		{ $el_cCd		= $_POST[$el_cCd];		};
				if(isset($_POST[$el_cBi]))		{ $el_cBi		= $_POST[$el_cBi];		};
				if(isset($_POST[$el_cAg]))		{ $el_cAg		= $_POST[$el_cAg];		};
				if(isset($_POST[$el_cAi]))		{ $el_cAi		= $_POST[$el_cAi];		};
				if(isset($_POST[$el_cZr]))		{ $el_cZr		= $_POST[$el_cZr];		};
				if(isset($_POST[$el_cAu]))		{ $el_cAu		= $_POST[$el_cAu];		};
				if(isset($_POST[$el_cSe]))		{ $el_cSe		= $_POST[$el_cSe];		};
				if($tpMuestra == 'Ac'){
					$el_cZn 		= '';
					$el_cPb 		= '';
					$el_cMg 		= '';
					$el_cTe 		= '';
					$el_cAs 		= '';
					$el_cSb 		= '';
					$el_cCd 		= '';
					$el_cBi 		= '';
					$el_cAg 		= '';
					$el_cAi 		= '';
					$el_cZr 		= '';
					$el_cAu 		= '';
					$el_cSe 		= '';
				}
				if($tpMuestra == 'Co'){
					$el_cC  		= '';
					$el_cMo 		= '';
					$el_cAl 		= '';
					$el_cNb 		= '';
					$el_cV 			= '';
					$el_cW 			= '';
					$el_cTa 		= '';
					$el_cCa 		= '';
					$el_cCe 		= '';
					$el_cLa 		= '';
					$el_cN  		= '';
				}
				if($tpMuestra == 'Al'){
					$el_cC  		= '';
					$el_cMo 		= '';
					$el_cNb 		= '';
					$el_cV 			= '';
					$el_cW 			= '';
					$el_cTa 		= '';
					$el_cCa 		= '';
					$el_cCe 		= '';
					$el_cLa 		= '';
					$el_cN  		= '';
					$el_cP  		= '';
					$el_cS  		= '';
					$el_cCo  		= '';
					$el_cB  		= '';
					$el_cSb  		= '';
					$el_cAs  		= '';
					$el_cSe  		= '';
					$el_cTe  		= '';
					$el_cCd  		= '';
					$el_cAg  		= '';
					$el_cAu  		= '';
					$el_cAi  		= '';
				}
				$link=Conectarse();
				$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'");
				if($rowRegQui=mysqli_fetch_array($bdRegQui)){
					$actSQL="UPDATE regQuimico SET ";
					$actSQL.="cZn 		='".$el_cZn.	"',";
					$actSQL.="cPb 		='".$el_cPb.	"',";
					$actSQL.="cMg 		='".$el_cMg.	"',";
					$actSQL.="cTe 		='".$el_cTe.	"',";
					$actSQL.="cAs 		='".$el_cAs.	"',";
					$actSQL.="cSb 		='".$el_cSb.	"',";
					$actSQL.="cCd 		='".$el_cCd.	"',";
					$actSQL.="cBi 		='".$el_cBi.	"',";
					$actSQL.="cAg 		='".$el_cAg.	"',";
					$actSQL.="cAi 		='".$el_cAi.	"',";
					$actSQL.="cZr 		='".$el_cZr.	"',";
					$actSQL.="cAu 		='".$el_cAu.	"',";
					$actSQL.="cSe 		='".$el_cSe.	"',";
					$actSQL.="cC		='".$el_cC.		"',";
					$actSQL.="cSi		='".$el_cSi.	"',";
					$actSQL.="cMn		='".$el_cMn.	"',";
					$actSQL.="cP		='".$el_cP.		"',";
					$actSQL.="cS		='".$el_cS.		"',";
					$actSQL.="cCr		='".$el_cCr.	"',";
					$actSQL.="cNi		='".$el_cNi.	"',";
					$actSQL.="cMo		='".$el_cMo.	"',";
					$actSQL.="cAl		='".$el_cAl.	"',";
					$actSQL.="cCu		='".$el_cCu.	"',";
					$actSQL.="cCo		='".$el_cCo.	"',";
					$actSQL.="cTi		='".$el_cTi.	"',";
					$actSQL.="cNb		='".$el_cNb.	"',";
					$actSQL.="cV		='".$el_cV.		"',";
					$actSQL.="cW		='".$el_cW.		"',";
					$actSQL.="cSn		='".$el_cSn.	"',";
					$actSQL.="cB		='".$el_cB.		"',";
					$actSQL.="cFe		='".$el_cFe.	"'";
					$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'";
					$bdRegQui=$link->query($actSQL);
				}else{
					$link->query("insert into regQuimico(
															CodInforme,
															idItem,
															tpMuestra,
															cZn,
															cPb,
															cMg,
															cTe,
															cAs,
															cSb,
															cCd,
															cBi,
															cAg,
															cAi,
															cZr,
															cAu,
															cSe,
															cC,
															cSi,
															cMn,
															cP,
															cS,
															cCr,
															cNi,
															cMo,
															cAl,
															cCu,
															cCo,
															cTi,
															cNb,
															cV,
															cW,
															cSn,
															cB,
															cFe
															) 
													values 	(	
															'$CodInforme',
															'$campoidItem',
															'$tpMuestra',
															'$el_cZn',
															'$el_cPb',
															'$el_cMg',
															'$el_cTe',
															'$el_cAs',
															'$el_cSb',
															'$el_cCd',
															'$el_cBi',
															'$el_cAg',
															'$el_cAi',
															'$el_cZr',
															'$el_cAu',
															'$el_cSe',
															'$el_cC',
															'$el_cSi',
															'$el_cMn',
															'$el_cP',
															'$el_cS',
															'$el_cCr',
															'$el_cNi',
															'$el_cMo',
															'$el_cAl',
															'$el_cCu',
															'$el_cCo',
															'$el_cTi',
															'$el_cNb',
															'$el_cV',
															'$el_cW',
															'$el_cSn',
															'$el_cB',
															'$el_cFe'
							)");
				
				}
				$link->close();
			}
		}
		// Fin Qu�micos

		// Fin Tracci�n
		if($idEnsayo == 'Tr'){
			for($i=1; $i<=$cEnsayos; $i++){
				$ta = explode('-',$CodInforme);
				$tq = $ta[1].'-'.$idE.$i;
				if($i<10){ $tq = $ta[1].'-'.$idE.'0'.$i; }
	
				$campoidItem 	= 'idItem'.$tq;
				$el_aIni 	= 'aIni'.$tq;
				$el_cFlu	= 'cFlu'.$tq;
				$el_cMax	= 'cMax'.$tq;
				$el_tFlu	= 'tFlu'.$tq;
				$el_tMax	= 'tMax'.$tq;
				$el_aSob	= 'aSob'.$tq;
				$el_rAre	= 'rAre'.$tq;
			
				if(isset($_POST[$campoidItem]))	{ $campoidItem	= $_POST[$campoidItem];	}
				if(isset($_POST[$el_aIni]))		{ $el_aIni		= $_POST[$el_aIni];		}
				if(isset($_POST[$el_cFlu]))		{ $el_cFlu		= $_POST[$el_cFlu];		}
				if(isset($_POST[$el_cMax]))		{ $el_cMax		= $_POST[$el_cMax];		}
				if(isset($_POST[$el_tFlu]))		{ $el_tFlu		= $_POST[$el_tFlu];		}
				if(isset($_POST[$el_tMax]))		{ $el_tMax		= $_POST[$el_tMax];		}
				if(isset($_POST[$el_aSob]))		{ $el_aSob		= $_POST[$el_aSob];		}
				if(isset($_POST[$el_rAre]))		{ $el_rAre		= $_POST[$el_rAre];		}

				if($tpMuestra == 'Pl'){
					$el_rAre 		= '';
				}
				$link=Conectarse();
				$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'");
				if($rowRegTra=mysqli_fetch_array($bdRegTra)){
					$actSQL="UPDATE regTraccion SET ";
					$actSQL.="aIni 		='".$el_aIni.	"',";
					$actSQL.="cFlu 		='".$el_cFlu.	"',";
					$actSQL.="cMax 		='".$el_cMax.	"',";
					$actSQL.="tFlu 		='".$el_tFlu.	"',";
					$actSQL.="tMax 		='".$el_tMax.	"',";
					$actSQL.="aSob 		='".$el_aSob.	"',";
					$actSQL.="rAre 		='".$el_rAre.	"'";
					$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'";
					$bdRegTra=$link->query($actSQL);
				}else{
					$link->query("insert into regTraccion(
															CodInforme,
															idItem,
															tpMuestra,
															aIni,
															cFlu,
															cMax,
															tFlu,
															tMax,
															aSob,
															rAre
															) 
													values 	(	
															'$CodInforme',
															'$campoidItem',
															'$tpMuestra',
															'$el_aIni',
															'$el_cFlu',
															'$el_cMax',
															'$el_tFlu',
															'$el_tMax',
															'$el_aSob',
															'$el_rAre'
							)");
				
				}
				$link->close();
			}
		}
		// Fin Traccion
		
	}	


	if(isset($_POST['subirGuardarFoto'])){
		$nombre_archivo = $_FILES['fotoMuestra']['name'];
		$tipo_archivo 	= $_FILES['fotoMuestra']['type'];
		$tamano_archivo = $_FILES['fotoMuestra']['size'];
		$desde 			= $_FILES['fotoMuestra']['tmp_name'];

		$directorio="imgMuestras/".$CodInforme;
		if (!file_exists($directorio)){
			mkdir($directorio,0755);
		}

		if (($tipo_archivo == "image/jpeg" || $tipo_archivo == "image/png" || $tipo_archivo == "image/gif") ) { 
    		if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 

				$imgMuestra = $nombre_archivo;
				$link=Conectarse();
				$actSQL="UPDATE amInformes SET ";
				$actSQL.="imgMuestra		='".$imgMuestra.		"'";
				$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
				$bdCot=$link->query($actSQL);
				$link->close();

				$foto 		= $directorio.'/'.$nombre_archivo;
				$size 		= getimagesize("$foto");
				$anchura	= $size[0]; 
				$altura		= $size[1];
				$tamanoMax 	= 450;
				if($anchura > $tamanoMax){
					$resizeObj = new resize($directorio.'/'.$nombre_archivo);
					$largo 	= $anchura;
					$alto 	= $altura;
					$factor = $anchura / 450;
					//$resizeObj -> resizeImage($largo, $alto, 'crop');
					$largo 	= intval($anchura/$factor);
					$alto 	= intval($altura/$factor);

					$resizeObj -> resizeImage($largo, $alto, 'crop');
					$resizeObj -> saveImage($foto, 100);
				}
				
    		}else{ 
   				$MsgUsr="Ocurri� alg�n error al subir el fichero ".$nombre_archivo." No pudo guardar.... ";
    		} 
		}else{
    		$MsgUsr="Se permite subir un documento JPEG o PNG <br> y el tamaño máximo es de 20Mb."; 
		}
		
		
		?>
		<?php
	}
	
	if(isset($_POST['guardaIdMuestra'])){
		if(isset($_POST['CodInforme']))	{ $CodInforme	 	= $_POST['CodInforme'];	}
		if(isset($_POST['idItem']))		{ $idItem	 		= $_POST['idItem'];		}
		if(isset($_POST['idMuestra']))	{ $idMuestra	 	= $_POST['idMuestra'];	}
		$link=Conectarse();
		$actSQL="UPDATE amMuestras SET ";
		$actSQL.="idMuestra			='".$idMuestra.			"'";
		$actSQL.="WHERE CodInforme	= '".$CodInforme."' and idItem = '".$idItem."'";
		$bdMue=$link->query($actSQL);
		$link->close();
		$accion = "";
	
	}
	if(isset($_POST['guardaEnsayo'])){
		if(isset($_POST['CodInforme']))		{ $CodInforme	 	= $_POST['CodInforme'];	}
		if(isset($_POST['idEnsayo']))		{ $idEnsayo	 		= $_POST['idEnsayo'];	}
		if(isset($_POST['tpMuestra']))		{ $tpMuestra	 	= $_POST['tpMuestra'];	}
		if(isset($_POST['Ref']))			{ $Ref	 			= $_POST['Ref'];		}
		if(isset($_POST['cEnsayos']))		{ $cEnsayos	 		= $_POST['cEnsayos'];	}
		if(isset($_POST['cTem']))			{ $cTem	 			= $_POST['cTem'];		}
		
		$link=Conectarse();
		$bdTabEns=$link->query("Select * From amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$idEnsayo."' and tpMuestra = '".$tpMuestra."' and Ref = '".$Ref."'");
		if($rowTabEns=mysqli_fetch_array($bdTabEns)){
			
		}else{
			$link->query("insert into amTabEnsayos(
													CodInforme,
													idEnsayo,
													tpMuestra,
													Ref,
													cEnsayos,
													Tem
													) 
											values 	(	
													'$CodInforme',
													'$idEnsayo',
													'$tpMuestra',
													'$Ref',
													'$cEnsayos',
													'$cTem'
						)");
		}
		$link->close();
	}
	
	if(isset($_POST['actualizaInforme'])){ 
		if(isset($_POST['CodInforme'])){ $CodInforme	= $_POST['CodInforme'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			if(isset($_POST['nMuestras']))		{ $nMuestras	 	= $_POST['nMuestras'];		}
			if(isset($_POST['tipoMuestra']))	{ $tipoMuestra	 	= $_POST['tipoMuestra'];	}
			if(isset($_POST['fechaRecepcion']))	{ $fechaRecepcion 	= $_POST['fechaRecepcion'];	}
			if(isset($_POST['tpEnsayo']))		{ $tpEnsayo 		= $_POST['tpEnsayo'];		}
			if(isset($_POST['amEnsayo']))		{ $amEnsayo	 		= $_POST['amEnsayo'];		}
			if(isset($_POST['fechaInforme']))	{ $fechaInforme 	= $_POST['fechaInforme'];	}
			$Estado		= 'P';
			$actSQL="UPDATE amInformes SET ";
			$actSQL.="nMuestras			='".$nMuestras.			"',";
			$actSQL.="tipoMuestra		='".$tipoMuestra.		"',";
			$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
			$actSQL.="tpEnsayo			='".$tpEnsayo.			"',";
			$actSQL.="amEnsayo			='".$amEnsayo.			"',";
			$actSQL.="fechaInforme		='".$fechaInforme.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=$link->query($actSQL);
		}
	}

	if(isset($_POST['guardarInforme'])){
		$link=Conectarse();
		$bdCot=$link->query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			if(isset($_POST['nMuestras']))		{ $nMuestras	 	= $_POST['nMuestras'];		}
			if(isset($_POST['tipoMuestra']))	{ $tipoMuestra	 	= $_POST['tipoMuestra'];	}
			if(isset($_POST['fechaRecepcion']))	{ $fechaRecepcion 	= $_POST['fechaRecepcion'];	}
			if(isset($_POST['tpEnsayo']))		{ $tpEnsayo 		= $_POST['tpEnsayo'];		}
			if(isset($_POST['amEnsayo']))		{ $amEnsayo	 		= $_POST['amEnsayo'];		}
			if(isset($_POST['fechaInforme']))	{ $fechaInforme 	= $_POST['fechaInforme'];	}
			
			$Estado		= 'P';
			$actSQL="UPDATE amInformes SET ";
			$actSQL.="nMuestras			='".$nMuestras.			"',";
			$actSQL.="tipoMuestra		='".$tipoMuestra.		"',";
			$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
			$actSQL.="tpEnsayo			='".$tpEnsayo.			"',";
			$actSQL.="amEnsayo			='".$amEnsayo.			"',";
			$actSQL.="fechaInforme		='".$fechaInforme.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=$link->query($actSQL);
			
			$nUltMuestra = 0;
			$cInf = explode('-', $CodInforme);
			$CodInformeCorto = $cInf[0].'-'.$cInf[1];
			$bdMue=$link->query("Select * From amMuestras Where CodInforme Like '%".$CodInformeCorto."%' Order By idItem Desc");
			if($rowMue=mysqli_fetch_array($bdMue)){
				$uIt = explode('-',$rowMue['idItem']);
				$nUltMuestra = $uIt[1];
			}else{
				$nUltMuestra = 0;
			}
			$nUltMuestra++;
			$tMuestras = $nUltMuestra + $nMuestras;
			
			for($i=$nUltMuestra; $i<$tMuestras; $i++){
				$Ra  = explode('-', $CodInforme);
				$cIt = $i;
				if($cIt < 10) { 
					$cIt = '0'.$cIt; 
				}
				
				$idItem = $Ra[1].'-'.$cIt;
				$bdMue=$link->query("Select * From amMuestras Where CodInforme = '".$CodInforme."' and idItem = '".$idItem."'");
				if($rowMue=mysqli_fetch_array($bdMue)){
				
				}else{
					$link->query("insert into amMuestras(
													CodInforme,
													idItem
													) 
											values 	(	
													'$CodInforme',
													'$idItem'
						)");
				}
			}
		}
		$link->close();
		$accion = '';
	}
	$link=Conectarse();
	$bdCot=$link->query("Select * From amInformes Where CodInforme Like '%".$CodInforme."%'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$RutCli = $rowCot['RutCli'];
	}
	$link->close();

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>M&oacute;dulo Generaci&oacute;n de Informes</title>
	
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>	

	<link href="styles.css"		rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script src="../angular/angular.min.js"></script>

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

<body ng-app="myApp" ng-controller="controlInformes">
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../procesos/plataformaCotizaciones.php"> Procesos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../otamsajax/pOtams.php?RAM=<?php echo $RAM; ?>&CAM=<?php echo $CAM; ?>"> Volver</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div id="linea"></div>

					<?php 
						$Ra 	= explode('-', $CodInforme);
						$RAM 	= $Ra[1];
						$link=Conectarse();
						$bdCli=$link->query("Select * From Clientes Where RutCli = '".$RutCli."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							$bdCot=$link->query("Select * From Cotizaciones Where RAM = '".$RAM."'");
							if($rowCot=mysqli_fetch_array($bdCot)){
								$bdCon=$link->query("Select * From contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$rowCot['nContacto']."'");
								if($rowCon=mysqli_fetch_array($bdCon)){
									//echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli['Cliente'].' ('.$rowCon['Contacto'].')'; 
								}else{
									//echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli['Cliente']; 
								}
								//echo '</span>';
							}
						}
						$link->close();   
					?>


	<?php include_once('botoneraInforme.php');?>
	<div style="clear:both;"></div>

	<br>
	<script src="../jquery/jquery-3.3.1.js"></script>
	<script src="../datatables/datatables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="informes.js"></script>

	
</body>
</html>
