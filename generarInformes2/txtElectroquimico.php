<?php
//****************************************************************************
//Texto Tabla Metalografia 
//****************************************************************************

$paragraphOptions = array(
										'font' 		=> 'Arial',
										'fontSize'	=> 10,
										'textAlign'	=> 'left',
										'underline'	=> 'single'
									);

$text = array(); 
$text[] = array( 'text' => $letraItem.'.1.- Metodología ', 'bold' => true ); 

$docx->addText($text, $paragraphOptions);

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
			$text[] = array( 'text' => 'Para la realización de los ensayos, se procedió a preparar "cupones" de los tipos de materiales, posteriormente se aisló el material, dejando al descubierto 1 cm2.' );
			
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);

			$text = array(); 
			$text[] = array( 'text' => 'Las muestras preparadas fueron inmersas en la solución preparada, de manera tal que puedan ser evaluadas como electrodos de trabajo y enfrentadas a un electrodo de grafito el cual actuó como contra-electrodo. Además, en la celda se instaló un electrodo de referencia (electrodo saturado de calomelano), tal como se muestra en el esquema representado en la figura B.1, utilizando un montaje equivalente al propuesto en la norma ASTM G5.' );
			
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);

			$text = array(); 
			$text[] = array( 'text' => 'Las pruebas se realizaron utilizando un potenciostato con un sistema de análisis de datos digital, con el cual se determinó la corriente y potencial de corrosión.' );
			
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);

			$text = array(); 
			$text[] = array( 'text' => 'Para la determinación de los potenciales de corrosión, fueron trazadas las curvas de polarización (curvas anódicas y catódicas), y obtención de pendientes de tafel.' );
			
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
$text[] = array( 'text' => 'Esquema utilizado en la conexión de la celda.' ); 

$docx->addText($text, $paragraphFiguras);
$docx->addText($textSpace, $espacioOpcion);
			
?>