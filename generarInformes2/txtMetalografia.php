<?php
//****************************************************************************
//Texto Tabla Metalografia 
//****************************************************************************

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
$docx->addImage($options);

$espacioOpcion = array(
						'font' 				=> 'Arial',
						'fontSize'			=> 10,
						'lineSpacing'		=> 360,
						);

$textSpace = '';
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Figura '.$letraItem.'.1 ', 'bold' => true ); 
$text[] = array( 'text' => 'Imagen de los sectores seleccionados para la inspección metalográfica.' ); 

$paragraphFiguras = array(
								'font' 		=> 'Arial',
								'fontSize'	=> 9,
								'textAlign'	=> 'center',
							);

$docx->addText($text, $paragraphFiguras);
$docx->addText($textSpace, $espacioOpcion);

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
									);
			$text = array(); 
			$text[] = array( 'text' => 'La figura '.$letraItem.'.'.$n.' muestra una imagen sin ataque a 100 aumentos de la muestra, la cual ha sido tomada en el cuarto espesor de la muestra, en la figura se aprecian las inclusiones presentes en el material.' );
			
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);

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
$docx->addImage($options);

$espacioOpcion = array(
						'font' 				=> 'Arial',
						'fontSize'			=> 10,
						'lineSpacing'		=> 360,
						);

$textSpace = '';
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Figura '.$letraItem.'.1 ', 'bold' => true ); 
$text[] = array( 'text' => 'Imagen sin ataque a 100 aumentos.' ); 

$docx->addText($text, $paragraphFiguras);
$docx->addText($textSpace, $espacioOpcion);

			$text = array(); 
			$text[] = array( 'text' => 'La tabla '.$letraItem.'.'.$n.' presenta la descripción del tipo y nivel de inclusiones no metálicas (clasificables) encontradas en la muestra, según norma ASTM E45.' );
			
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);

?>