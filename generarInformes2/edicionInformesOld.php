<?php
	session_start(); 
	include_once("conexion.php");
	include_once('../resize-class.php');
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
	if(isset($_POST[CodInforme]))		{ $CodInforme	 	= $_POST[CodInforme];	}
	if(isset($_POST[accion])) 			{ $accion 	 		= $_POST[accion]; 		}
	
	if(isset($_GET[CodInforme]))		{ $CodInforme	 	= $_GET[CodInforme];	}
	if(isset($_GET[idItem])) 			{ $idIt 	 		= $_GET[idItem]; 		}
	if(isset($_GET[accion])) 			{ $accion 	 		= $_GET[accion]; 		}
	
	if(isset($_POST[actualizaTabMuestras])){
		if(isset($_POST[idItem])) 			{ $idItem 	 		= $_POST[idItem]; 		}
		if(isset($_POST[idEnsayo])) 		{ $idEnsayo	 		= $_POST[idEnsayo]; 	}
		if(isset($_POST[tpMuestra])) 		{ $tpMuestra 		= $_POST[tpMuestra]; 	}
		if(isset($_POST[Ref])) 				{ $Ref 				= $_POST[Ref]; 			}
		if(isset($_POST[Ind])) 				{ $Ind 				= $_POST[Ind]; 			}
		if(isset($_POST[Tem])) 				{ $Tem 				= $_POST[Tem]; 			}
		if(isset($_POST[accion])) 			{ $accion 	 		= $_POST[accion]; 		}

		$link=Conectarse();
		$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$idEnsayo."' and tpMuestra = '".$tpMuestra."' and Ref = '".$Ref."'");
		if($rowTabEns=mysql_fetch_array($bdTabEns)){
			$cEnsayos = $rowTabEns[cEnsayos];
		}
		mysql_close($link);
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
					$bdRegDob=mysql_query("SELECT * FROM regDoblado Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nIndenta = '".$in."'");
					if($rowRegDob=mysql_fetch_array($bdRegDob)){
						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="vIndenta 			='".$el_vIndenta.	"'";
						$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nIndenta = '".$in."'";
						$bdRegDob=mysql_query($actSQL);
					}else{
						mysql_query("insert into regDoblado(
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
								)",
						$link);
					}
					mysql_close($link);
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
					$bdRegCh=mysql_query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nImpacto = '".$in."'");
					if($rowRegCh=mysql_fetch_array($bdRegCh)){
						$actSQL="UPDATE regCharpy SET ";
						$actSQL.="vImpacto 			='".$el_vImpacto.	"'";
						$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."' and nImpacto = '".$in."'";
						$bdRegDob=mysql_query($actSQL);
					}else{
						mysql_query("insert into regCharpy(
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
								)",
						$link);
					}
					mysql_close($link);
				}
			}
		}
		// Fin Charpy



		// Químico				
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
				$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'");
				if($rowRegQui=mysql_fetch_array($bdRegQui)){
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
					$bdRegQui=mysql_query($actSQL);
				}else{
					mysql_query("insert into regQuimico(
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
							)",
					$link);
				
				}
				mysql_close($link);
			}
		}
		// Fin Químicos

		// Fin Tracción
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
				$bdRegTra=mysql_query("SELECT * FROM regTraccion Where CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'");
				if($rowRegTra=mysql_fetch_array($bdRegTra)){
					$actSQL="UPDATE regTraccion SET ";
					$actSQL.="aIni 		='".$el_aIni.	"',";
					$actSQL.="cFlu 		='".$el_cFlu.	"',";
					$actSQL.="cMax 		='".$el_cMax.	"',";
					$actSQL.="tFlu 		='".$el_tFlu.	"',";
					$actSQL.="tMax 		='".$el_tMax.	"',";
					$actSQL.="aSob 		='".$el_aSob.	"',";
					$actSQL.="rAre 		='".$el_rAre.	"'";
					$actSQL.="WHERE CodInforme = '".$CodInforme."' and idItem = '".$campoidItem."' and tpMuestra = '".$tpMuestra."'";
					$bdRegTra=mysql_query($actSQL);
				}else{
					mysql_query("insert into regTraccion(
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
							)",
					$link);
				
				}
				mysql_close($link);
			}
		}
		// Fin Traccion
		
	}	


	if(isset($_POST[subirGuardarFoto])){
		$nombre_archivo = $_FILES['fotoMuestra']['name'];
		$tipo_archivo 	= $_FILES['fotoMuestra']['type'];
		$tamano_archivo = $_FILES['fotoMuestra']['size'];
		$desde 			= $_FILES['fotoMuestra']['tmp_name'];

		$directorio="imgMuestras/".$CodInforme;
		if (!file_exists($directorio)){
			mkdir($directorio,0755);
		}

		// echo "Tamaño Archivo: ".$tamano_archivo;
		if (($tipo_archivo == "image/jpeg" || $tipo_archivo == "image/png" || $tipo_archivo == "image/gif") ) { 
    		if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 

				$imgMuestra = $nombre_archivo;
				$link=Conectarse();
				$actSQL="UPDATE amInformes SET ";
				$actSQL.="imgMuestra		='".$imgMuestra.		"'";
				$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
				$bdCot=mysql_query($actSQL);
				mysql_close($link);

				$foto 		= $directorio.'/'.$nombre_archivo;
				$size 		= GetImageSize("$foto");
				$anchura	= $size[0]; 
				$altura		= $size[1];
				$tamanoMax 	= 450;
				if($anchura > $tamanoMax){
					$resizeObj = new resize($directorio.'/'.$nombre_archivo);
					$largo 	= $anchura;
					$alto 	= $altura;
					$factor = $anchura / 450;
/*					
					while ($largo > $tamanoMax){
						$largo 	= $largo - 1;
						$alto 	= $alto - 1;
					}
*/					
					//$resizeObj -> resizeImage($largo, $alto, 'crop');
					$largo 	= intval($anchura/$factor);
					$alto 	= intval($altura/$factor);

					$resizeObj -> resizeImage($largo, $alto, 'crop');
					$resizeObj -> saveImage($foto, 100);
				}
				
    		}else{ 
   				$MsgUsr="Ocurrió algún error al subir el fichero ".$nombre_archivo." No pudo guardar.... ";
    		} 
		}else{
    		$MsgUsr="Se permite subir un documento JPEG o PNG <br> y el tamaño máximo es de 7Mb."; 
		}
		
		
		?>
		<?php
	}
	
	if(isset($_POST[guardaIdMuestra])){
		if(isset($_POST[CodInforme]))	{ $CodInforme	 	= $_POST[CodInforme];	}
		if(isset($_POST[idItem]))		{ $idItem	 		= $_POST[idItem];		}
		if(isset($_POST[idMuestra]))	{ $idMuestra	 	= $_POST[idMuestra];	}
		$link=Conectarse();
		$actSQL="UPDATE amMuestras SET ";
		$actSQL.="idMuestra			='".$idMuestra.			"'";
		$actSQL.="WHERE CodInforme	= '".$CodInforme."' and idItem = '".$idItem."'";
		$bdMue=mysql_query($actSQL);
		mysql_close($link);
		$accion = "";
	
	}
	if(isset($_POST[guardaEnsayo])){
		if(isset($_POST[CodInforme]))		{ $CodInforme	 	= $_POST[CodInforme];	}
		if(isset($_POST[idEnsayo]))			{ $idEnsayo	 		= $_POST[idEnsayo];		}
		if(isset($_POST[tpMuestra]))		{ $tpMuestra	 	= $_POST[tpMuestra];	}
		if(isset($_POST[Ref]))				{ $Ref	 			= $_POST[Ref];			}
		if(isset($_POST[cEnsayos]))			{ $cEnsayos	 		= $_POST[cEnsayos];		}
		if(isset($_POST[cTem]))				{ $cTem	 			= $_POST[cTem];			}
		
		$link=Conectarse();
		$bdTabEns=mysql_query("Select * From amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$idEnsayo."' and tpMuestra = '".$tpMuestra."' and Ref = '".$Ref."'");
		if($rowTabEns=mysql_fetch_array($bdTabEns)){
			
		}else{
			mysql_query("insert into amTabEnsayos(
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
						)",
			$link);
		}
		mysql_close($link);
	}
	
	if(isset($_POST[actualizaInforme])){
		if(isset($_POST[CodInforme])){ $CodInforme	= $_POST[CodInforme];	}

		$link=Conectarse();
		$bdCot=mysql_query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			if(isset($_POST[nMuestras]))		{ $nMuestras	 	= $_POST[nMuestras];		}
			if(isset($_POST[tipoMuestra]))		{ $tipoMuestra	 	= $_POST[tipoMuestra];		}
			if(isset($_POST[fechaRecepcion]))	{ $fechaRecepcion 	= $_POST[fechaRecepcion];	}
			if(isset($_POST[tpEnsayo]))			{ $tpEnsayo 		= $_POST[tpEnsayo];			}
			if(isset($_POST[fechaInforme]))		{ $fechaInforme 	= $_POST[fechaInforme];		}
			
			$Estado		= 'P';
			$actSQL="UPDATE amInformes SET ";
			$actSQL.="nMuestras			='".$nMuestras.			"',";
			$actSQL.="tipoMuestra		='".$tipoMuestra.		"',";
			$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
			$actSQL.="tpEnsayo			='".$tpEnsayo.			"',";
			$actSQL.="fechaInforme		='".$fechaInforme.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
		}
		$bdEns=mysql_query("SELECT * FROM amEnsayos Order By nEns");
		if($rowEns=mysql_fetch_array($bdEns)){
			do{
				
				$idEnsayo		= $rowEns[idEnsayo];
				$campoTpMuestra = 'tpMuestra'.$rowEns[idEnsayo];
				$campoRef 		= 'Ref'.$rowEns[idEnsayo];
				$campocEnsayos	= 'cEnsayos'.$rowEns[idEnsayo];
				$campoInd		= 'Ind'.$rowEns[idEnsayo];
				$campoTem		= 'Tem'.$rowEns[idEnsayo];
				
				if(isset($_POST[$campoTpMuestra]))	{ $campoTpMuestra	= $_POST[$campoTpMuestra];	}
				if(isset($_POST[$campoRef]))		{ $campoRef	 		= $_POST[$campoRef];		}
				if(isset($_POST[$campocEnsayos]))	{ $campocEnsayos	= $_POST[$campocEnsayos];	}
				if(isset($_POST[$campoInd]))		{ $campoInd			= $_POST[$campoInd];		}
				if(isset($_POST[$campoTem]))		{ $campoTem			= $_POST[$campoTem];		}
				
				if($idEnsayo == 'Ch'){
					if($campoInd == 0) { $campoInd = 3; }
				}
				if($idEnsayo == 'Du'){
					if($campoInd == 0) { $campoInd = 1; }
				}
/*				
				$bdTabEns=mysql_query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$idEnsayo."'");
				if($rowTabEns=mysql_fetch_array($bdTabEns)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="tpMuestra			='".$campoTpMuestra.	"',";
					$actSQL.="Ref				='".$campoRef.			"',";
					$actSQL.="cEnsayos			='".$campocEnsayos.		"',";
					$actSQL.="Ind				='".$campoInd.			"',";
					$actSQL.="Tem				='".$campoTem.			"'";
					$actSQL.="WHERE CodInforme	= '".$CodInforme."' and idEnsayo = '".$idEnsayo."'";
					$bdCot=mysql_query($actSQL);
				}else{
					if($campocEnsayos > 0){
						mysql_query("insert into amTabEnsayos(
																CodInforme,
																idEnsayo,
																tpMuestra,
																Ref,
																cEnsayos,
																Ind,
																Tem
																) 
														values 	(	
																'$CodInforme',
																'$idEnsayo',
																'$campoTpMuestra',
																'$campoRef',
																'$campocEnsayos',
																'$campoInd',
																'$campoTem'
									)",
						$link);
					}
				}
				
*/				
			}while($rowEns=mysql_fetch_array($bdEns));
		}
	}
/*
	if(isset($_POST[guardarInforme])){
		$link=Conectarse();
		$bdCot=mysql_query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			if(isset($_POST[nMuestras]))		{ $nMuestras	 	= $_POST[nMuestras];		}
			if(isset($_POST[tipoMuestra]))		{ $tipoMuestra	 	= $_POST[tipoMuestra];		}
			if(isset($_POST[fechaRecepcion]))	{ $fechaRecepcion 	= $_POST[fechaRecepcion];	}
			if(isset($_POST[tpEnsayo]))			{ $tpEnsayo 		= $_POST[tpEnsayo];			}
			if(isset($_POST[fechaInforme]))		{ $fechaInforme 	= $_POST[fechaInforme];		}
			
			$Estado		= 'P';
			$actSQL="UPDATE amInformes SET ";
			$actSQL.="nMuestras			='".$nMuestras.			"',";
			$actSQL.="tipoMuestra		='".$tipoMuestra.		"',";
			$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
			$actSQL.="tpEnsayo			='".$tpEnsayo.			"',";
			$actSQL.="fechaInforme		='".$fechaInforme.		"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=mysql_query($actSQL);
			
			$nUltMuestra = 0;
			$cInf = explode('-', $CodInforme);
			$CodInformeCorto = $cInf[0].'-'.$cInf[1];
			$bdMue=mysql_query("Select * From amMuestras Where CodInforme Like '%".$CodInformeCorto."%' Order By idItem Desc");
			if($rowMue=mysql_fetch_array($bdMue)){
				$uIt = explode('-',$rowMue[idItem]);
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
				$bdMue=mysql_query("Select * From amMuestras Where CodInforme = '".$CodInforme."' and idItem = '".$idItem."'");
				if($rowMue=mysql_fetch_array($bdMue)){
				
				}else{
					mysql_query("insert into amMuestras(
													CodInforme,
													idItem
													) 
											values 	(	
													'$CodInforme',
													'$idItem'
						)",
					$link);
				}
			}
		}
		mysql_close($link);
		$accion = '';
	}
*/	
	$link=Conectarse();
	$bdCot=mysql_query("Select * From amInformes Where CodInforme Like '%".$CodInforme."%'");
	if($rowCot=mysql_fetch_array($bdCot)){
		$RutCli = $rowCot[RutCli];
	}
	mysql_close($link);

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
						$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							$bdCot=mysql_query("Select * From Cotizaciones Where RAM = '".$RAM."'");
							if($rowCot=mysql_fetch_array($bdCot)){
								$bdCon=mysql_query("Select * From contactosCli Where RutCli = '".$rowCli[RutCli]."' and nContacto = '".$rowCot[nContacto]."'");
								if($rowCon=mysql_fetch_array($bdCon)){
									echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli[Cliente].' ('.$rowCon[Contacto].')'; 
								}else{
									echo '<span style="font-size:24px;color:#000;">'.$CodInforme.'</span> - '.$rowCli[Cliente]; 
								}
								echo '</span>';
							}
						}
						mysql_close($link);
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
				include_once('botoneraInforme.php');
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
