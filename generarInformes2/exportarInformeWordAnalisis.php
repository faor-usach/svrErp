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
	$Descripcion = 'Descripción';
	$bdCAM = $link->query("SELECT * FROM cotizaciones Where RAM = '".$RAM."'");
	if($rowCAM=mysqli_fetch_array($bdCAM)){
		$nContacto = $rowCAM['nContacto'];
	}

	$bdRAM = $link->query("SELECT * FROM registromuestras Where RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		$Descripcion = $rowRAM['Descripcion'];
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

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter'); 
$docx = new CreateDocxFromTemplate('InformesPortada.docx');
$version = 'NewPortada';


$paragraphOptions = array(
	'font' 		=> 'Arial',
	'fontSize'	=> 7,
	'textAlign'	=> 'left',
	'underline'	=> 'single'
);

if($tpEnsayo == '1'){ $nomInforme = 'INFORME DE CARACTERIZACIÓN'; }
if($tpEnsayo == '2'){ $nomInforme = 'ANÁLISIS DE FALLA'; }
if($tpEnsayo == '3'){ $nomInforme = 'CERTIFICADO DE ENSAYOS'; }
if($tpEnsayo == '4'){ $nomInforme = 'INFORME DE RESULTADOS'; }

$text = '';
$docx->addText($text, $paragraphOptions);

$options = array(
	'target' 		=> 'header',
	'firstMatch' 	=> false,
	);

$docx->replaceVariableByText(array(
	'CODINFORME' 	=> $CodInforme,
	'CLIENTE' 		=> $Cliente,
	'FECHAINF' 		=> $fechaInforme,
	// 'Descripcion' 	=> $Descripcion,
	'INFORME' 		=> $nomInforme,
	'REV' 			=> $Rev,
	), $options);

$docx->replaceVariableByText(array(
		'Clientes' 			=> $Cliente,
		'Direccion' 		=> $Direccion,
		//'RutCli' 			=> $RutCli,
		//'Email' 			=> $Email,
		//'OfertaEconomica' 	=> $tituloOferta,
		//'Atencion' 			=> $Contacto,
		//'Ofe' 				=> $CAM,
		//'Elaborado'			=> $Elaborado,
		//'Cargo'				=> $cargoUsr,
		//'NetoUF'			=> $NetoUF,
		//'Validez'			=> $Validez,
		//'dHabiles'			=> $dHabiles,
		//'Revisado'			=> $Revisado,
		//'fechaElaboracion'	=> $fechaElaboracion,
		//'fechaEmision'		=> $fechaEmision,
		//'fechaAprobacion'	=> $fechaAprobacion,
		//'ObjetivoGeneral'	=> $objetivoGral,
		'Descripcion'		=> $Descripcion,
		'TipoMuestra'		=> $TipoMuestra,
		'Cantidad'			=> $nMuestras,
		'TipoEnsayo'		=> $TipoEnsayo,
		'amEnsayo'			=> $amEnsayo,
		'Rec'				=> $fechaRecepcion,
		'Contacto'			=> $Contacto,
		'Emi'				=> $femite,
		//'Titulo'			=> $Titulo,
		//'Autores'			=> $Autores,
		//'PalabrasClaves'	=> $palsClaves,
		'CODINFORME' 		=> $CodInforme,
		'INFORME' 		=> $nomInforme,
	)
);

$data = array(); 
$link=Conectarse();
$bdMue=$link->query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
while($rowMue=mysqli_fetch_array($bdMue)){
		//$idMuestra = 'Se ha recibido una muestra, identificada por el cliente como: ';
		$idMuestra = $rowMue['idMuestra'];

		$data[] = array( 	'ITEM' 		=> $rowMue['idItem'],
							'REFERENCE' => $idMuestra,
						);
}
$link->close();

$docx->replaceTableVariable($data);


$img = 'imgMuestras/muestraImg.jpg';

if($imgMuestra){
	$img = 'imgMuestras/'.$CodInforme.'/'.$imgMuestra;
}

$options = array(
					'src' 			=> $img,
					'imageAlign' 	=> 'center',
					'scaling' 		=> 100,
					'spacingTop' 	=> 0,
					'spacingBottom' => 0,
					'spacingLeft' 	=> 0,
					'spacingRight'	=> 0,
					'textWrap' 		=> 0,
					//'borderStyle' => 'lgDash',
					//'borderWidth' => 6,
					//'borderColor' => 'FF0000',
				);
//$docx->addImage($options);

$espacioOpcion = array(
						'font' 				=> 'Arial',
						'fontSize'			=> 10,
						'lineSpacing'		=> 360,
						);

$textSpace = '';
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);

$paragraphOptions = array(
	'font' 		=> 'Arial',
	'fontSize'	=> 9,
	'textAlign'	=> 'center',
);


$text = array(); 
$text[] = array( 'text' => 'Figura A.1 ', 'bold' => true ); 
$text[] = array( 'text' => 'Imagen de la muestra recibida.' ); 

$paragraphOptions = array(
	'font' 		=> 'Arial',
	'fontSize'	=> 9,
	'textAlign'	=> 'center',
);

$docx->addText($text, $paragraphOptions);


$letraItem = 'A';
if($tpEnsayo == '2'){
	$letraItem++;
	$text = array(); 
	$text[] = array( 'text' => $letraItem.'.- Antecedentes:', 'bold' => true ); 
	$paragraphOptions = array(
								'font' 		=> 'Arial',
								'fontSize'	=> 10,
								'textAlign'	=> 'left',
								'underline'	=> 'single'
							);
	$docx->addText($text, $paragraphOptions);
	$docx->addText($textSpace, $espacioOpcion);

	//$docx->embedHTML('<div style="font-family:Arial; font-size:12px; line-height:150%; ">'.$Antecedentes.'</div>');
	$docx->addText($textSpace, $espacioOpcion);
	
}

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
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se muestran los valores resultantes de los análisis químicos, obtenidos mediante espectrometría de emisión óptica utilizando la metodología establecida por la norma ASTM E415.' ); 
					}else{
						$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se muestra los valores resultantes del análisis químico, obtenido mediante espectrometría de emisión óptica utilizando la metodología establecida por la norma ASTM E415.' ); 
					}
					$docx->addText($text, $paragraphOptions);
			}else{
				if($rowTabEns['idEnsayo'] == 'Tr'){
						if($nPlural > 1){
							$text[] = array( 'text' => 'El ensayo de tracción fue realizado mediante la metodología establecida por la norma'); 
							$text[] = array(
								'text' => 'ASTM E8/E8M',
								'color' => 'F5340B',
							);
							$text[] = array( 'text' => '. En la tabla '.$letraItem.'.'.$n.' se presentan los resultados del ensayo de tracción realizado a la muestra recibida.' ); 
						}else{
							$text[] = array( 'text' => 'El ensayo de tracción fue realizado mediante la metodología establecida por la norma'); 
							$text[] = array(
								'text' => 'ASTM E8/E8M',
								'color' => 'F5340B',
							);
							$text[] = array( 'text' => '. En la tabla '.$letraItem.'.'.$n.' se presentan los resultados del ensayo de tracción realizado a la muestra recibida.' ); 
						}
						$docx->addText($text, $paragraphOptions);
				}else{
					if($rowTabEns['idEnsayo'] == 'Ch'){
							$bdTp=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."'");
							if($rowTp=mysqli_fetch_array($bdTp)){
								//$tipoEnsayo = $rowTp['tipoEnsayo'];
								if($rowTp['Entalle'] == 'Con'){
									if($nPlural > 1){
										$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizados a las muestras recibidas, según ' ); 
										$text[] = array(
											'text' => 'ASTM E23. ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => 'Las probetas ensayadas ' );
										$text[] = array(
											'text' => 'poseen entalle en "V" ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' y son de dimensiones ' );
										$text[] = array(
											'text' => 'estándar de '.number_format($rowTp['mm'], 1, ',', '.').' mm ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' de ancho.' );

									}else{										
										$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizados a las muestras recibidas, según ' ); 
										$text[] = array(
											'text' => 'ASTM E23. ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => 'Las probetas ensayadas ' );
										$text[] = array(
											'text' => 'poseen entalle en "V" ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' y son de dimensiones ' );
										$text[] = array(
											'text' => 'estándar de '.number_format($rowTp['mm'], 1, ',', '.').' mm ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' de ancho.' );
									}
								}else{
									if($nPlural > 1){
										$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizados a las muestras recibidas, según ' ); 
										$text[] = array(
											'text' => 'ASTM E23. ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => 'Las probetas ensayadas ' );
										$text[] = array(
											'text' => 'no poseen entalle ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' y son de dimensiones ' );
										$text[] = array(
											'text' => 'estándar de '.number_format($rowTp['mm'], 1, ',', '.').' mm ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' de ancho.' );
									}else{
										$text[] = array( 'text' => 'En la tabla '.$letraItem.'.'.$n.' se presentan los resultados de los ensayos de impacto realizados a las muestras recibidas, según ' ); 
										$text[] = array(
											'text' => 'ASTM E23. ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => 'Las probetas ensayadas ' );
										$text[] = array(
											'text' => 'no poseen entalle ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' y son de dimensiones ' );
										$text[] = array(
											'text' => 'estándar de '.number_format($rowTp['mm'], 1, ',', '.').' mm ',
											'color' => 'F5340B',
										);
										$text[] = array( 'text' => ' de ancho.' );
									}
								}
							}
							$docx->addText($text, $paragraphOptions);








							
					}else{
						if($rowTabEns['idEnsayo'] == 'Do'){
								if($nPlural > 1){
									$text[] = array( 'text' => 'Para la realización del ensayo de doblado se utilizó la metodología del ensayo basado en la norma' ); 
									$text[] = array(
										'text' => 'AWS D1 1/D1 1M',
										'color' => 'F5340B',
									);
									$text[] = array( 'text' => '. En la tabla '.$letraItem.'.'.$n.' se muestran los resultados obtenidos de los ensayos y sus observaciones.' ); 
								}else{
									$text[] = array( 'text' => 'Para la realización del ensayo de doblado se utilizó la metodología del ensayo basado en la norma' ); 
									$text[] = array(
										'text' => 'AWS D1 1/D1 1M',
										'color' => 'F5340B',
									);
									$text[] = array( 'text' => '. En la tabla '.$letraItem.'.'.$n.' se muestran los resultados obtenidos de los ensayos y sus observaciones.' ); 
								}
								$docx->addText($text, $paragraphOptions);
						}else{
							if($rowTabEns['idEnsayo'] == 'Du'){
							    if($rowTabEns['tpMedicion'] != 'Perf'){
									$tipoEnsayo = '';
									$bdTp=$link->query("SELECT * FROM amTpsMuestras Where tpMuestra = '".$rowTabEns['tpMuestra']."' and idEnsayo = '".$rowEns['idEnsayo']."'"); 
									if($rowTp=mysqli_fetch_array($bdTp)){
										$tipoEnsayo = $rowTp['tipoEnsayo'];
									}
									if($nPlural > 1){
										$text[] = array( 'text' => 'Las mediciones de durezas fue realizada en escala '.$tipoEnsayo.', utilizando la metodología establecida por la norma ASTM E18. En las tablas '.$letraItem.'.'.$n.' muestran los resultados del ensayo realizados a las muestras recibidas.' ); 
									}else{
										$text[] = array( 'text' => 'La medición de dureza fue realizada en escala '.$tipoEnsayo.', utilizando la metodología establecida por la norma ASTM E18. En la tabla '.$letraItem.'.'.$n.' muestra los resultados del ensayo realizado a la muestra recibida.' ); 
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
						}
					}
				}
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
				if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Re'){
					include('expTraccionRe.php'); 
				}
				if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Es'){
					include('expTraccionEs.php');
				}
				if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Pl'){
					include('expTraccionPl.php');
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
				if($rowOtam['idEnsayo'] == 'Du' and $rowOtam['tpMedicion'] == 'Medi'){
					include('expDureza.php');
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

// ESPERANDO CONFIRMACIÓN OJO
$obsIng = 'No presenta.';
$link=Conectarse();
$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = 'Ch' Order By Otam";
$bdOtam=$link->query($SQL);
while($rowOtam=mysqli_fetch_array($bdOtam)){

	// $SQLe = "SELECT * FROM amensayos Where idEnsayo = '".$rowOtam['idEnsayo']."'";
	// $bde=$link->query($SQLe);
	// if($rse=mysqli_fetch_array($bde)){
	// 	$obsIng = 'Ensayo '.$rse['Ensayo'].' no presenta observaciones.';
	// }

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
	