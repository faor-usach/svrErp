<?php
header('Content-Type: text/html; charset=utf-8');

$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
			);
require_once '../phpdocx/classes/CreateDocx.php';
include("../conexionli.php");
include("../conexioncert.php");

$version = 'Old';
if(isset($_GET['CodInforme'])) 	{ $CodInforme 	= $_GET['CodInforme']; 	};
if(isset($_GET['version']))		{ $version 		= $_GET['version']; 	};

$imgMuestra = '';
$link=Conectarse(); 
$bdInf=$link->query("SELECT * FROM amInformes Where CodInforme = '".$CodInforme."'");
if($rowInf=mysqli_fetch_array($bdInf)){
	$ingResponsable		= $rowInf['ingResponsable'];
	$cooResponsable		= $rowInf['cooResponsable'];
	$CodigoVerificacion = $rowInf['CodigoVerificacion'];
	$imgQR 				= $rowInf['imgQR'];
	$imgMuestra			= $rowInf['imgMuestra'];

	$fechaRecepcion	= $rowInf['fechaRecepcion'];
	$fd = explode('-',$fechaRecepcion);
	$fechaRecepcion	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	$fechaHoy 		= date('Y-m-d');
	$fechaHoy = $rowInf['fechaInforme'];
	$fd = explode('-',$fechaHoy);
	$fechaEmision	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	$TipoMuestra 	= $rowInf['tipoMuestra'];
	$nMuestras		= $rowInf['nMuestras'];
	if($nMuestras < 10){ $nMuestras = '0'.$nMuestras; }
	$tpEnsayo		= $rowInf['tpEnsayo'];
	$amEnsayo		= $rowInf['amEnsayo'];
	
	// Variables para Análisis de Falla
	$Titulo			= $rowInf['Titulo'];
	$palsClaves		= $rowInf['palsClaves'];
	$Objetivos		= $rowInf['Objetivos'];
	$Metodologia	= $rowInf['Metodologia'];
	$Comentarios	= $rowInf['Comentarios'];
	$Resumen		= $rowInf['Resumen'];
	$Antecedentes	= $rowInf['Antecedentes'];

	//$txtIntroduccion = htmlentities($txtIntroduccion);
	//$txtIntroduccion = TildesHtml($txtIntroduccion);

	
	$Autores		= '';
	
	$bdUs=$link->query("SELECT * FROM Usuarios Where usr = '".$ingResponsable."'");
	if($rowUs=mysqli_fetch_array($bdUs)){
		$Autores = $rowUs['usuario'];
	}

	$bdUs=$link->query("SELECT * FROM Usuarios Where usr = '".$cooResponsable."'");
	if($rowUs=mysqli_fetch_array($bdUs)){
		$Autores = $Autores.' y '.$rowUs['usuario'];
	}
	
	$bdTe=$link->query("SELECT * FROM tipoensayo Where tpEnsayo = '".$rowInf['tpEnsayo']."'");
	if($rowTe=mysqli_fetch_array($bdTe)){
		$TipoEnsayo = $rowTe['nomTipoEnsayo'];
	}
    $fd = explode('-',$fechaHoy);
    if($rowInf['fechaInforme'] != '0000-00-00'){
        $fd = explode('-',$rowInf['fechaInforme']);
    }
	$fechaInforme 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	$fechaInforme 		= $fd[2].'-'.$fd[1].'-'.$fd[0];
	$Rev 			= 00;
	$femite 		= $fd[2].'-'.$fd[1].'-'.$fd[0];
	
	$fdRAM = explode('-', $CodInforme);
	$RAM = $fdRAM[1];
	$nContacto = 0;
	$bdCAM = $link->query("SELECT * FROM cotizaciones Where RAM = '".$RAM."'");
	if($rowCAM=mysqli_fetch_array($bdCAM)){
		$nContacto = $rowCAM['nContacto'];
	}
	
	$bdCli = $link->query("SELECT * FROM Clientes Where RutCli = '".$rowInf['RutCli']."'");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$Cliente 	= $rowCli['Cliente'];
		$CLIENTE 	= $rowCli['Cliente'];
		$Direccion 	= $rowCli['Direccion'];
		$RutCli		= $rowCli['RutCli'];
	}	

	$bdCon = $link->query("SELECT * FROM contactoscli Where RutCli = '".$rowInf['RutCli']."' and nContacto = '".$nContacto."'");
	if($rowCon=mysqli_fetch_array($bdCon)){
		$Contacto 	= $rowCon['Contacto'];
		$Email 		= $rowCon['Email'];
	}	

}
$link->close();

$linkc=ConectarseCert();
$resultadoCertificacion = '';
$bd = $linkc->query("SELECT * FROM certificado Where CodInforme = '$CodInforme'");
if($rs=mysqli_fetch_array($bd)){
    if($rs['resultadoCertificacion'] == 'A'){ $resultadoCertificacion = 'Cumple'; }
    if($rs['resultadoCertificacion'] == 'R'){ $resultadoCertificacion = 'No Cumple'; }
}
$far = explode('-',$rs['CodCertificado']);
$ar = $far[0].'-'.$far[1];
$fechaInspeccion = '';
$bdar = $linkc->query("SELECT * FROM ar Where ar = '$ar'");
if($rsar=mysqli_fetch_array($bdar)){
    $fi = explode('-',$rsar['fechaInspeccion']);
    $fechaInspeccion = $fi[2].'-'.$fi[1].'-'.$fi[0];

}	
$bdctp = $linkc->query("SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'");
if($rsctp=mysqli_fetch_array($bdctp)){
}	

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter'); 
$docx = new CreateDocxFromTemplate('formatoInfOficial.docx');
$version = 'NewPortada';


$paragraphOptions = array(
	'font' 		=> 'Arial',
	'fontSize'	=> 7,
	'textAlign'	=> 'left',
	'underline'	=> 'single'
);

if($tpEnsayo == '5'){ $nomInforme = 'INFORME DE ENSAYO OFICIAL'; }

$text = '';
$docx->addText($text, $paragraphOptions);

$options = array(
	'target' 		=> 'header',
	'firstMatch' 	=> false,
	);

$docx->replaceVariableByText(array(
	'NumeroAM' 	        => $CodInforme,
	'NombreCliente' 	=> $Cliente,
    'FechaInforme'		=> $femite,
	), $options);


	$data = array(); 
	$link=Conectarse();
	$idItem = '';
	$bdMue=$link->query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
	if($rowMue=mysqli_fetch_array($bdMue)){
			$idMuestra = 'Se ha recibido una muestra, identificada por el cliente como: ';
			$idMuestra .= '"'.$rowMue['idMuestra'].'"';
			$idItem = $rowMue['idItem'];
			$data[] = array( 	'NumeroAM'      	    => $rowMue['idItem'],
								'IDMuestra'             => $rowMue['idMuestra'],
								// 'TipoProducto'		    => $rsctp['Producto'],
							);
	}
	$link->close();
	

$docx->replaceVariableByText(array(
    'NumeroAM' 		        => $CodInforme,
    'CodItems' 		        => $idItem,
    'NombreCliente' 	    => $Cliente,
	'DireccionCliente' 		=> $Direccion,
	'TipoDeMuestra'		    => $TipoMuestra,
	'NumeroDeMuestras'		=> $nMuestras,
	'TipoDeEnsayo'		    => $amEnsayo,
	'NombreSolicitante'		=> $Contacto,
	'amEnsayo'			    => $amEnsayo,
	'FechaRecepcion'		=> $fechaRecepcion,
	'FechaInforme'		    => $femite,
	'TipoDeProducto'		=> $rsctp['Producto'],
	'Dimensiones'		    => $rs['Dimension'],
	'Peso'		            => $rs['Peso'],
	'Lote'		            => $rs['Lote'],
	'FechaInspeccion'		=> $fechaInspeccion,
	'NumeroAR'		        => $rs['CodCertificado'],
	'Cumple'		        => $resultadoCertificacion,
	)
);


$docx->replaceTableVariable($data);

$letraItem = 'A';
$idEnsayo = '';
$link=Conectarse();
$bdEns=$link->query("SELECT * FROM amEnsayos Order By nEns");
while($rowEns=mysqli_fetch_array($bdEns)){
		$idItem   = '';
		$n 		  = 0;
		$Plural   = 'NO';
		$CR 	  = 'NO';
		$CREnsayo = $rowEns['idEnsayo'];
		$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."'");
		if($rowTabEns=mysqli_fetch_array($bdTabEns)){
			$Ref = $rowTabEns['Ref'];
			if($rowTabEns['Ref'] == 'CR' and $CR == 'NO'){
				$CR = 'SI';
			}
			$letraItem++;
			$tEnsayo = 'Ensayos ';
			if($rowTabEns['idEnsayo'] == 'Fr'){
				$tEnsayo = 'Análisis ';
			}
			if($rowTabEns['idEnsayo'] == 'Qu'){
				$tEnsayo = 'Análisis ';
			}
			if($rowTabEns['idEnsayo'] == 'Tr' or $rowTabEns['idEnsayo'] == 'Do' or $rowTabEns['idEnsayo'] == 'Du' or $rowTabEns['idEnsayo'] == 'Md' or $rowTabEns['idEnsayo'] == 'El'){
				$tEnsayo = 'Ensayos de ';
			}
			if($rowTabEns['idEnsayo'] == 'Mg' or $rowTabEns['idEnsayo'] == 'S'){
				$tEnsayo = '';
			}
			$tEnsayo = $tEnsayo.$rowEns['Ensayo'];
			if($rowTabEns['idEnsayo'] == 'Ch'){
				$tEnsayo = 'Ensayo de Impacto';
			}
			
			$docx->addText($textSpace, $espacioOpcion);
			$docx->addText($textSpace, $espacioOpcion);
			$text = array(); 
			$text[] = array( 'text' => $letraItem.'.- '.$tEnsayo.':', 'bold' => true ); 
			$paragraphOptions = array(
										'font' 		=> 'Arial',
										'fontSize'	=> 10,
										'textAlign'	=> 'left',
										'underline'	=> 'single',
									);
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);
			
			$nPlural = 0;
			$bdOt=$link->query("SELECT * FROM Otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."'");
			while($rowOt=mysqli_fetch_array($bdOt)){
				$nPlural++;
			}
			
			$n++;

			$style = array(
				'lineSpacing' 		=> 360,
				'indentFirstLine'	=> 300,
				);
			// create custom style
			$docx->createParagraphStyle('myStyle', $style);
			
			
			$paragraphOptions = array(
										'font' 		=> 'Arial',
										'fontSize'	=> 10,
										'textAlign'	=> 'both',
										'pStyle'	=> 'myStyle',
										'tab'		=> true
									);
			$text = array(); 
			if($rowTabEns['idEnsayo'] == 'Qu'){
					if($nPlural > 1){
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se muestran los valores resultantes de los análisis químicos, obtenidos mediante espectrometría de emisión óptica. El ensayo fue realizado según norma ASTM E415 (Standard test method for analysis of carbon and low-alloy steel by spark atomic emission spectrometry).' ); 
					}else{
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se muestra los valores resultantes del análisis químico, obtenido mediante espectrometría de emisión óptica. Los ensayos fueron realizados según norma ASTM E415 (Standard test method for analysis of carbon and low-alloy steel by spark atomic emission spectrometry).' ); 
					}
					$docx->addText($text, $paragraphOptions);
			}elseif($rowTabEns['idEnsayo'] == 'Tr'){
					if($nPlural > 1){
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de tracción realizado a las muestras recibidas. Los ensayos fueron realizados según norma NCh200 (Productos metálicos – Ensayo de tracción).' ); 
					}else{
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados del ensayo de tracción realizado a la muestra recibida. El ensayo fue realizado según norma NCh200 (Productos metálicos – Ensayo de tracción).' ); 
					}
					$docx->addText($text, $paragraphOptions);
			}elseif($rowTabEns['idEnsayo'] == 'Ch'){
					$bdTp=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."'");
					if($rowTp=mysqli_fetch_array($bdTp)){
						if($rowTp['Entalle'] == 'Con'){
							if($nPlural > 1){
								$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados del los ensayos de impacto realizados a las muestras recibidas. Los ensayos fueron realizados según norma NCh926. (Acero y otros metales - Ensayo de impacto sobre probeta con entalle, simplemente apoyada). Las probetas ensayadas poseen entalle en "V" y son de dimensiones estándar de '.$rowTp['mm'].' mm de ancho.');
							}else{
								$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizados a la muestra recibida. Los ensayos fueron realizados según norma NCh926. (Acero y otros metales - Ensayo de impacto sobre probeta con entalle, simplemente apoyada). Las probetas ensayadas poseen entalle en "V" y son de dimensiones estándar de '.$rowTp['mm'].' mm de ancho.');
							}
						}elseif($nPlural > 1){
							$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizado a las muestras recibidas. Los ensayos fueron realizados según norma NCh926. (Acero y otros metales - Ensayo de impacto sobre probeta con entalle, simplemente apoyada). Las probetas ensayadas poseen entalle en "V" y son de dimensiones estándar de '.$rowTp['mm'].' mm de ancho.');
						}else{
							$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizado a la muestra recibida. Los ensayos fueron realizados según norma NCh926. (Acero y otros metales - Ensayo de impacto sobre probeta con entalle, simplemente apoyada). Las probetas ensayadas poseen entalle en "V" y son de dimensiones estándar de '.$rowTp['mm'].' mm de ancho.');
						}
					}
					$docx->addText($text, $paragraphOptions);
			}elseif($rowTabEns['idEnsayo'] == 'Do'){
					if($nPlural > 1){
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se muestran los resultados obtenidos del ensayo de doblado realizados a las muestras recibidas y sus observaciones. El ensayo fue realizado según norma NCh201 (Acero- Ensayo de doblado de planchas de espesor superior o igual a 3 mm, barras y perfiles).' );
					}else{
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se muestran resultado obtenido del ensayo de doblado realizado a la muestra recibida y sus observaciones. El ensayo fue realizado según norma NCh201 (Acero- Ensayo de doblado de planchas de espesor superior o igual a 3 mm, barras y perfiles).' );
					}
					$docx->addText($text, $paragraphOptions);
			}elseif($rowTabEns['idEnsayo'] == 'Du'){
					if($rowTabEns['tpMedicion'] != 'Perf'){
						$tipoEnsayo = '';
						$bdTp=$link->query("SELECT * FROM amTpsMuestras Where tpMuestra = '".$rowTabEns['tpMuestra']."' and idEnsayo = '".$rowEns['idEnsayo']."'");
						if($rowTp=mysqli_fetch_array($bdTp)){
							$tipoEnsayo = $rowTp['tipoEnsayo'];
						}
						if($nPlural > 1){
							$text[] = array( 'text' => 'Las mediciones de durezas fue realizada en escala '.$tipoEnsayo.'. En las tablas '.$letraItem.'.'.$n.' muestran los resultados del ensayo realizados a las muestras recibidas.' ); 
						}else{
							$text[] = array( 'text' => 'La medición de dureza fue realizada en escala '.$tipoEnsayo.'. En la tabla '.$letraItem.'.'.$n.' muestra los resultados del ensayo realizado a la muestra recibida.' ); 
						}
						$docx->addText($text, $paragraphOptions);
                    }
					if($rowTabEns['tpMedicion'] == 'Perf'){
						$tipoEnsayo = '';
						$bdTp=$link->query("SELECT * FROM amTpsMuestras Where tpMuestra = '".$rowTabEns['tpMuestra']."' and idEnsayo = '".$rowEns['idEnsayo']."'");
						if($rowTp=mysqli_fetch_array($bdTp)){
							$tipoEnsayo = $rowTp['tipoEnsayo'];
						}
						if($nPlural > 1){
							$text[] = array( 'text' => 'Con el objetivo de comprobar una posible variación en la dureza del material, se procedió a realizar un perfil de dureza desde la superficie hasta el centro de la muestra. La medición de dureza fue realizada en escala '.$tipoEnsayo.'. En las tablas '.$letraItem.'.'.$n.' se muestran los resultados de los perfiles realizados a las muestras recibidas, desde la superficie externa hacia el centro de las muestras.' ); 
						}else{
							$text[] = array( 'text' => 'Con el objetivo de comprobar una posible variación en la dureza del material, se procedió a realizar un perfil de dureza desde la superficie hasta el centro de la muestra. La medición de dureza fue realizada en escala '.$tipoEnsayo.'. En la tabla '.$letraItem.'.'.$n.' se muestran los resultados del perfil realizado a la muestra recibida, desde la superficie externa hacia el centro de la muestra.' ); 
						}
						$docx->addText($text, $paragraphOptions);
                    }
			}else{
					$txtIntroduccion = $rowEns['txtIntroduccion'];
					$text = Array();
					$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' '.utf8_decode($txtIntroduccion).'.' ); 
					$docx->addText($txtIntroduccion, $paragraphOptions);
			}


			$docx->addText($textSpace, $espacioOpcion);
			$espacioOpcionTablas = array(
											'font' 				=> 'Arial',
											'fontSize'			=> 10,
											//'lineSpacing'		=> 100,
											);
			if($rowTabEns['idEnsayo'] == 'M'){
				include_once('txtMetalografia.php');
			}
			if($rowTabEns['idEnsayo'] == 'Mg'){
				include_once('txtMacrografico.php');
			}
			if($rowTabEns['idEnsayo'] == 'S'){
				include_once('txtMicroscopia.php');
			}
			if($rowTabEns['idEnsayo'] == 'Md'){
				include_once('txtMicrodureza.php');
			}
			if($rowTabEns['idEnsayo'] == 'El'){
				include_once('txtElectroquimico.php');
			}
			if($rowTabEns['idEnsayo'] == 'Fr'){
				include_once('txtFactografia.php');
			}

			if($rowTabEns['idEnsayo'] != 'Fr' and $rowTabEns['idEnsayo'] != 'Mg' and $rowTabEns['idEnsayo'] != 'S' and $rowTabEns['idEnsayo'] != 'Pl' and $rowTabEns['idEnsayo'] != 'Qv' and $rowTabEns['idEnsayo'] != 'Ot'){
				$text = array(); 
				$text[] = array( 'text' => 'Tabla '.$letraItem.'.'.$n, 'bold' => true ); 
				$text[] = array( 'text' => ' Resultados de '.$tEnsayo.'.' ); 
				$paragraphOptions = array(
											'font' 		=> 'Arial',
											'fontSize'	=> 9,
											'textAlign'	=> 'left'
										);
				$docx->addText($text, $paragraphOptions);
				//$docx->addText($textSpace, $espacioOpcion);
			}
		}


		$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."' Order By Otam";
		$bdOtam=$link->query($SQL);
		while($rowOtam=mysqli_fetch_array($bdOtam)){
			$text = $rowOtam['idEnsayo'].' '.$rowOtam['tpMuestra'];
			$Ref = 'SR';
			
			$bdCR=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['idItem']."' and idEnsayo = '".$rowEns['idEnsayo']."'");
			if($rowCR=mysqli_fetch_array($bdCR)){
				$Ref = $rowCR['Ref'];
				if($rowOtam['idEnsayo'] == 'Qu' and $rowOtam['tpMuestra'] == 'Ac'){
					require('expQuimicosAc.php'); 
				}
				if($rowOtam['idEnsayo'] == 'Qu' and $rowOtam['tpMuestra'] == 'Co'){
					require('expQuimicosCo.php');
				} 
				
				if($rowOtam['idEnsayo'] == 'Qu' and $rowOtam['tpMuestra'] == 'Al'){
					include('expQuimicosAl.php');
				}
				$Espesor = '';
				if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Re'){
					$OtamTr = $rowOtam['Otam'];
					include_once('expTraccionPlOfi.php');
				}
				if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Es'){
					include('expTraccionEs.php');
				}
				if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Pl'){
					$OtamTr = $rowOtam['Otam'];
					include_once('expTraccionPlOfi.php');
				}
				if($rowOtam['idEnsayo'] == 'Md'){
					include('expMicrodureza.php'); 
				}
				if($rowOtam['idEnsayo'] == 'M'){
					include('expMetalografia.php');
				}
				if($rowOtam['idEnsayo'] == 'Ch'){
					include('expCharpyRev.php');
				}
				if($rowOtam['idEnsayo'] == 'Du' and $rowOtam['tpMedicion'] != 'Perf'){
					//include('expDurezaRev.php'); Pendiente
				}
				if($rowOtam['idEnsayo'] == 'Du' and $rowOtam['tpMedicion'] == 'Perf'){
					include('expDurezaPerfiles.php');
				}
				if($rowOtam['idEnsayo'] == 'Do'){
					include('expDoblado.php');
				}
				if($rowOtam['idEnsayo'] == 'El'){
					include('expElectroquimico.php');
				}	
				
			}
			
		}


}
$link->close();

$docx->addText($textSpace, $espacioOpcion);

$letraItem++;
$tEnsayo = 'Evaluación Dimensional (espesor): ';
$text = array(); 
$text[] = array( 'text' => $letraItem.'.- '.$tEnsayo, 'bold' => true ); 
$paragraphOptions = array(
                            'font' 		=> 'Arial',
                            'fontSize'	=> 10,
                            'textAlign'	=> 'left',
                            'underline'	=> 'single',
                        );
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'En la tabla '.$letraItem.'.1 se presenta el resultado de la evaluación dimensional realizado a las muestras recibidas, la evaluación dimensional fue realizada según norma NCh703.1971 (Acero – Planchas gruesas de acero al carbono laminadas en caliente – Tolerancias).' ); 

$paragraphOptions = array(
    'font' 		=> 'Arial',
    'fontSize'	=> 10,
    'textAlign'	=> 'both',
    'pStyle'	=> 'myStyle',
    'tab'		=> true
);

$docx->addText($text, $paragraphOptions); // +++

$docx->addText($textSpace, $espacioOpcion);
$text = array(); 
$text[] = array( 'text' => 'Tabla '.$letraItem.'.1', 'bold' => true ); 
$text[] = array( 'text' => ' Resultados de la evaluación dimensional.' ); 
$paragraphOptions = array(
                            'font' 		=> 'Arial',
                            'fontSize'	=> 9,
                            'textAlign'	=> 'left'
                        );
$docx->addText($text, $paragraphOptions);

include('expEvaDimencional.php');

$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);
$letraItem++;

// Notas
$text = array(); 
$text[] = array( 'text' => $letraItem.'.- Observaciones:', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial', 
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'underline'	=> 'single'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$obsIng = 'No presenta.';
$link=Conectarse();
$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = 'Ch' Order By Otam";
$bdOtam=$link->query($SQL);
while($rowOtam=mysqli_fetch_array($bdOtam)){

	if($rowOtam['obsIng']){
		$obsIng = $rowOtam['obsIng'];
	}

	$text = array(); 
	$text[] = array( 'text' => $obsIng ); 
}
$link->close();
$paragraphOptions = array(
	'font' 		=> 'Arial',
	'fontSize'	=> 10,
	'textAlign'	=> 'both',
	'pStyle'	=> 'myStyle',
	'tab'		=> true
);

$docx->addText($text, $paragraphOptions);


$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);

$letraItem++;
$text = array(); 
$text[] = array( 'text' => $letraItem.'.- Comentarios:', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'underline'	=> 'single'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$link=Conectarse();
$SQLens = "SELECT * FROM amensayos Where nOrden > 0 Order By nOrden";
$bdens=$link->query($SQLens);
while($rsens=mysqli_fetch_array($bdens)){

	$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rsens['idEnsayo']."'";
	$bdOtam=$link->query($SQL);
	while($rowOtam=mysqli_fetch_array($bdOtam)){
		// $Comentarios = 'No presenta.';
		// $text = array(); 
		// $text[] = array( 'text' => $Comentarios ); 

		$text = array(); 

		if($rowOtam['idEnsayo'] == 'Ch'){
			$Comentarios = $rowOtam['Comentarios'];
			$text[] = array( 'text' => 'La muestra analizada ' ); 
			$text[] = array(
				'text' => 'cumple/no cumple ',
				'color' => 'F5340B',
			);
			$text[] = array( 'text' => 'con la energía absorbida establecida por el cliente.' );
		}
		if($rowOtam['idEnsayo'] == 'Tr'){
			$text[] = array( 'text' => 'La muestra analizada ' ); 
			$text[] = array(
				'text' => 'cumple/no cumple ',
				'color' => 'F5340B',
			);
			$text[] = array( 'text' => 'con las propiedades mecánicas indicadas en la' );
			$text[] = array(
				'text' => 'norma XXXX.',
				'color' => 'F5340B',
			);
		}
		if($rowOtam['idEnsayo'] == 'Qu'){
			$text[] = array( 'text' => 'La muestra analizada ' ); 
			$text[] = array(
				'text' => 'cumple/no cumple ',
				'color' => 'F5340B',
			);
			$text[] = array( 'text' => 'con la composición química indicadas en la ' );
			$text[] = array(
				'text' => 'norma XXXX.',
				'color' => 'F5340B',
			);
		}
		if($rowOtam['idEnsayo'] == 'Du'){
			$text[] = array( 'text' => 'La muestra analizada ' ); 
			$text[] = array(
				'text' => 'cumple/no cumple ',
				'color' => 'F5340B',
			);
			$text[] = array( 'text' => 'con la dureza indicada en la' );
			$text[] = array(
				'text' => 'norma XXXX.',
				'color' => 'F5340B',
			);
		}
		if($rowOtam['idEnsayo'] == 'Do'){
			$text[] = array( 'text' => 'La muestra analizada' ); 
			$text[] = array(
				'text' => 'cumple/no cumple ',
				'color' => 'F5340B',
			);
			$text[] = array( 'text' => 'con los requisitos de la' );
			$text[] = array(
				'text' => 'norma XXXX.',
				'color' => 'F5340B',
			);
		}

		$paragraphOptions = array(
								'font' 		=> 'Arial',
								'fontSize'	=> 10,
								'textAlign'	=> 'both',
								'pStyle'	=> 'myStyle',
								'tab'		=> true
							);
		$docx->addText($text, $paragraphOptions);

	}

}
$link->close();

$docx->addText($textSpace, $espacioOpcion);

$docx->addBreak(array('type' => 'page'));


$espacioOpcion = array(
	'font' 			=> 'Arial',
	'fontSize'		=> 7,
	'lineSpacing' 	=> 100,
);

$text = array(); 
$text[] = array( 'text' => 'NOTAS:', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 7,
							'textAlign'	=> 'left',
							'underline'	=> 'single'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);



$latinListOptions = array();
$latinListOptions[0]['type'] 		= 'ordinal';
$latinListOptions[0]['font'] 		= 'Arial';
$latinListOptions[0]['fontSize'] 	= 3;
$latinListOptions[0]['textAlign'] 	= 'both';

// create the list style with name: latin
$docx->createListStyle('latin', $latinListOptions);

$paragraphOptions = array(
	'font' 			=> 'Arial',
	'fontSize'		=> 7,
	'textAlign'		=> 'both',
	'indentLeft'	=> 500,
	// 'tab'			=> true,
);

$espacioOpcion = array(
	'font' 			=> 'Arial',
	'fontSize'		=> 7,
	'lineSpacing' 	=> 100,
);

$textSpace = '';


$text = array();
// list Químico
$link=Conectarse();
$bdNot=$link->query("SELECT * FROM regquimico where CodInforme = '$CodInforme'");
if($rowNot=mysqli_fetch_array($bdNot)){
	$fensayo = $rowNot['fechaRegistro'];
	if($rowNot['fechaRegistro'] == '0000-00-00'){
		$fensayo = $femite;
	}else{
		$fe = explode('-', $fensayo);
		$fensayo = $fe[2].'-'.$fe[1].'-'.$fe[0];

	}

	$text = array();
	$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7 ); 
	$text[] = array( 'text' => 'El análisis químico fue realizado el '.$fensayo.'.' ); 
	$docx->addText($text, $paragraphOptions);	

}
$link->close();

$link=Conectarse();
$bdNot=$link->query("SELECT * FROM regtraccion where CodInforme = '$CodInforme'");
if($rowNot=mysqli_fetch_array($bdNot)){
	// list Tracción
	$fensayo = $rowNot['fechaRegistro'];
	if($rowNot['fechaRegistro'] == '0000-00-00'){
		$fensayo = $femite;
	}else{
		$fe = explode('-', $fensayo);
		$fensayo = $fe[2].'-'.$fe[1].'-'.$fe[0];

	}
	$text = array();
	$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7 ); 
	$text[] = array( 'text' => 'El ensayo de tracción fue realizado el '.$fensayo.'.' ); 
	$docx->addText($text, $paragraphOptions);	

}
$link->close();

$link=Conectarse();
$bdNot=$link->query("SELECT * FROM regcharpy where CodInforme = '$CodInforme'");
if($rowNot=mysqli_fetch_array($bdNot)){
	// list Tracción
	$html = '<ul style="font-family: arial; font-size: 10.5px; text-align: justify;">';
	$fensayo = $rowNot['fechaRegistro'];
	if($rowNot['fechaRegistro'] == '0000-00-00'){
		$fensayo = $femite;
	}else{
		$fe = explode('-', $fensayo);
		$fensayo = $fe[2].'-'.$fe[1].'-'.$fe[0];

	}
	$text = array();
	$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7 ); 
	$text[] = array( 'text' => 'El ensayo de impacto fue realizado el '.$fensayo.'.' ); 
	$docx->addText($text, $paragraphOptions);	

}
$link->close();

$link=Conectarse();
$bdNot=$link->query("SELECT * FROM regdobladosreal where CodInforme = '$CodInforme'");
if($rowNot=mysqli_fetch_array($bdNot)){
	// list Tracción
	$fensayo = $rowNot['fechaRegistro'];
	if($rowNot['fechaRegistro'] == '0000-00-00'){
		$fensayo = $femite;
	}else{
		$fe = explode('-', $fensayo);
		$fensayo = $fe[2].'-'.$fe[1].'-'.$fe[0];

	}
	$text = array();
	$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7 ); 
	$text[] = array( 'text' => 'El ensayo de doblado fue realizado el '.$fensayo.'.' ); 
	$docx->addText($text, $paragraphOptions);	

}
$link->close();


$link=Conectarse();
$bdNot=$link->query("SELECT * FROM regdoblado where CodInforme = '$CodInforme'");
if($rowNot=mysqli_fetch_array($bdNot)){
	// list Tracción
	$fensayo = $rowNot['fechaRegistro'];
	if($rowNot['fechaRegistro'] == '0000-00-00'){
		$fensayo = $femite;
	}else{
		$fe = explode('-', $fensayo);
		$fensayo = $fe[2].'-'.$fe[1].'-'.$fe[0];
	}
	$text = array();
	$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7 ); 
	$text[] = array( 'text' => 'El ensayo de dureza fue realizado el '.$fensayo.'.' ); 
	$docx->addText($text, $paragraphOptions);	

}
$link->close();

// list items


$link=Conectarse();
$bdNot=$link->query("SELECT * FROM amNotas Order By nNota Asc");
while($rowNot=mysqli_fetch_array($bdNot)){
	if($rowNot['idEnsayo']){
		$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowNot['idEnsayo']."'");
		if($rowTabEns=mysqli_fetch_array($bdTabEns)){
			$text = array(); 
			$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7 ); 
			$text[] = array( 'text' => $rowNot['Nota'] ); 
			$docx->addText($text, $paragraphOptions);	
		}
	}else{
		$text = array(); 
		$text[] = array( 'text' => '• ', 'bold' => true, 'fontSize'		=> 7  ); 
		$text[] = array( 'text' => $rowNot['Nota'] ); 
		$docx->addText($text, $paragraphOptions);	
	}
}
$link->close();



/*
$itemList = array();
$html = '<ul style="font-family: arial; font-size: 10.5px; text-align: justify;">';
$link=Conectarse();
$bdNot=$link->query("SELECT * FROM amNotas Order By nNota Asc");
while($rowNot=mysqli_fetch_array($bdNot)){
		if($rowNot['idEnsayo']){
			$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowNot['idEnsayo']."'");
			if($rowTabEns=mysqli_fetch_array($bdTabEns)){
				$itemList[] = $rowNot['Nota']; 
				$html .= '<li>'.utf8_decode($rowNot['Nota']).'</li>';
				if($rowNot['idEnsayo'] == 'Me'){
					$html .= '<li>'.utf8_decode($rowNot['Nota']).'</li>';
					$itemList[]	= utf8_decode($rowNot['Nota']);
					$txtNota = utf8_decode($rowNot['Nota']);

				}
			}
		}else{
			$html .= '<li>'.utf8_encode($rowNot['Nota']).'</li>';
			$itemList[] = $rowNot['Nota'];
		}
}
$link->close();
*/

/*
$text = array(); 
$text[] = array( 'text' => $txtNota, 'bold' => true ); 
$docx->addText($text, $paragraphOptions);
*/

$html .= '</ul>';
$options = array(
					'font' 		=> 'Arial',
					'fontSize' 	=> 7,
					'textAlign'	=> 'both',
				);
//$docx->embedHTML($html);
// $docx->addList($itemList, 1, $options);
// $docx->addText($textSpace, $espacioOpcion);

$html  = '<li>Los ensayos de impacto son realizados en un péndulo de charpy Marca Time Modelo JB-S300 con 300 J de capacidad en KV8 según normas ASTM E23-16b, ASTM A370-17; Cláusula desde la 20 hasta la 30, NCh 926.E Of1972, AWS D1.1/D1M (2015); Parte D Cláusulas desde la 4.25 hasta la 4.30, ASME BPVC sección IX (2015); Cláusulas Qw-170 y Qw 171, API 1104 (2013) Cláusula A.3.4.2. (calibrado mediante procedimiento descrito en la norma ISO 148-2 Anexo B). Valor de la incertidumbre combinada expandida es de 2.1 J entre 0 y 58 J; y 5.6 J entre 58 y 300 J. </li>';
$html .= '<li>Los ensayos de impacto son realizados en un péndulo de charpy Marca Time Modelo JB-S300 con 300 J de capacidad en KV8 según normas ASTM E23-16b, ASTM A370-17; Cláusula desde la 20 hasta la 30, NCh 926.E Of1972, AWS D1.1/D1M (2015); Parte D Cláusulas desde la 4.25 hasta la 4.30, ASME BPVC sección IX (2015); Cláusulas Qw-170 y Qw 171, API 1104 (2013) Cláusula A.3.4.2. (calibrado mediante procedimiento descrito en la norma ISO 148-2 Anexo B). Valor de la incertidumbre combinada expandida es de 2.1 J entre 0 y 58 J; y 5.6 J entre 58 y 300 J. </li>';
$html .= '<li>Los ensayos de impacto son realizados en un péndulo de charpy Marca Time Modelo JB-S300 con 300 J de capacidad en KV8 según normas ASTM E23-16b, ASTM A370-17; Cláusula desde la 20 hasta la 30, NCh 926.E Of1972, AWS D1.1/D1M (2015); Parte D Cláusulas desde la 4.25 hasta la 4.30, ASME BPVC sección IX (2015); Cláusulas Qw-170 y Qw 171, API 1104 (2013) Cláusula A.3.4.2. (calibrado mediante procedimiento descrito en la norma ISO 148-2 Anexo B). Valor de la incertidumbre combinada expandida es de 2.1 J entre 0 y 58 J; y 5.6 J entre 58 y 300 J. </li>';
$html .= '<li>Los ensayos de impacto son realizados en un péndulo de charpy Marca Time Modelo JB-S300 con 300 J de capacidad en KV8 según normas ASTM E23-16b, ASTM A370-17; Cláusula desde la 20 hasta la 30, NCh 926.E Of1972, AWS D1.1/D1M (2015); Parte D Cláusulas desde la 4.25 hasta la 4.30, ASME BPVC sección IX (2015); Cláusulas Qw-170 y Qw 171, API 1104 (2013) Cláusula A.3.4.2. (calibrado mediante procedimiento descrito en la norma ISO 148-2 Anexo B). Valor de la incertidumbre combinada expandida es de 2.1 J entre 0 y 58 J; y 5.6 J entre 58 y 300 J. </li></ul>';

$docx->addText($textSpace, $espacioOpcion);



include('pieInforme.php');




$informe = $CodInforme;
$docx->createDocxAndDownload($informe, true);




function TildesHtml($cadena) 
    { 
        return str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                                         array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                                                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $cadena);     
    }
?>
	