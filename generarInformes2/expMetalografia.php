<?php
//****************************************************************************
//Tabla Metalografia 
//****************************************************************************

$trProperties = array();
$trProperties[0] = array(	'minHeight' 	=> 500, 
							'tableHeader' 	=> false,
							'font' 			=> 'Arial',
							'fontSize' 		=> 9,
							//'border'		=> 'double',
						);
$trProperties[0] = array(	'minHeight' 	=> 100, 
							'width'			=> 50000,
						);
						
$col_2_1 = array(	'value' 			=> $rowOtam['Otam'], // Dato
					'backgroundColor' 	=> 'ffffff',
					'rowspan' 			=> 2,
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
				);
$col_2_2 = array( 	'value' 			=> 'A (Sulfuros de Manganeso)', 
					'backgroundColor' 	=> 'ffffff',
					'cellMargin'		=> 100,
				);
$col_2_3 = array( 	'value' 			=> '1 Grueso', 
					'backgroundColor' 	=> 'ffffff',
					'borderRight'		=> 'double',
				);

$col_3_2 = array( 	'value' 			=> 'D (Óxidos globulares)', 
					'backgroundColor' 	=> 'ffffff',
					'cellMargin'		=> 100,
					'borderBottom'		=> 'double',
				);
$col_3_3 = array( 	'value' 			=> '2 Grueso', 
					'backgroundColor' 	=> 'ffffff',
					'borderRight'		=> 'double',
					'borderBottom'		=> 'double',
				);


//set teh global table properties
$options = array(	//'columnWidths' 		=> array(950,720,720,720,720,720,720,720,720,720,720), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					'tableAlign' 		=> 'center',
					//'float' 			=> array('align' 	=> 'center'	),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
				

$col1_1 = array(	'value' 			=> 'ID ITEM',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'cellMargin'		=> 100,
					'width'				=> 100,
				);
$col1_2 = array( 	'value' 			=> 'Tipo de inclusiones', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'cellMargin'		=> 100,
				);
$col1_3 = array( 	'value' 			=> 'Nivel', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
					'cellMargin'		=> 100,
				);
				
$valuesTr = array(	array($col1_1, $col1_2, $col1_3),
					array($col_2_1, $col_2_2, $col_2_3),
					array($col_3_2, $col_3_3),
);
$docx->addTable($valuesTr, $options, $trProperties);


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
			$text[] = array( 'text' => 'Para poder revelar las fases presentes en las muestras, se procedió a atacar químicamente las superficies con Nital al 3% (Ácido Nítrico 3%V/V) durante 4 segundos.' );

			$docx->addText($textSpace, $espacioOpcion);
			$docx->addText($text, $paragraphOptions);

			$text = array(); 
			$text[] = array( 'text' => 'Las figuras muestran imágenes atacadas a 50, 100, 200, 500 y 1000 aumentos respectivamente de la superficie de la fractura de la muestra, donde es posible ' );
			$text[] = array( 'text' => 'observar una microestructura compuesta por ferrita acicular y carburos. Adicionalmente, se aprecia que la superficie de fractura es irregular, debido a procesos de corrosión.' );

			$docx->addText($textSpace, $espacioOpcion);
			$docx->addText($text, $paragraphOptions);


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
$text[] = array( 'text' => 'Imagen con ataque a 50 aumentos, superficie de fractura.' ); 

$docx->addText($text, $paragraphFiguras);
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
$text[] = array( 'text' => 'Imagen con ataque a 100 aumentos, superficie de fractura.' ); 

$docx->addText($text, $paragraphFiguras);
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
$text[] = array( 'text' => 'Imagen con ataque a 200 aumentos, superficie de fractura.' ); 

$docx->addText($text, $paragraphFiguras);
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
$text[] = array( 'text' => 'Imagen con ataque a 500 aumentos, superficie de fractura.' ); 

$docx->addText($text, $paragraphFiguras);
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
$text[] = array( 'text' => 'Imagen con ataque a 1.000 aumentos, superficie de fractura.' ); 

$docx->addText($text, $paragraphFiguras);
$docx->addText($textSpace, $espacioOpcion);
			
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>