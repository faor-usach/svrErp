<?php
//****************************************************************************
//Texto Tabla Factografía 
//****************************************************************************

$paragraphFiguras = array(
								'font' 		=> 'Arial',
								'fontSize'	=> 9,
								'textAlign'	=> 'center',
							);
$options = array(
					'src' 			=> $img,
					'imageAlign' 	=> 'center',
					'scaling' 		=> 100,
					'spacingTop' 	=> 0,
					'spacingBottom' => 0,
					'spacingLeft' 	=> 0,
					'spacingRight'	=> 0,
					'textWrap' 		=> 0,
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
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Figura '.$letraItem.'.1 ', 'bold' => true ); 
$text[] = array( 'text' => 'Imágenes del sector seleccionado para realizar la inspección.' ); 

$docx->addText($text, $paragraphFiguras);
			
?>