<?php
//****************************************************************************
//Tabla Dureza 
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
						

$col1_1 = array(	'value' 			=> 'TITULO', // Dato
					'bold'				=> true,
					'vAlign' 			=> 'center',
					'borderLeft'		=> 'threeDEngrave',
					'borderRight'		=> 'threeDEngrave',
					'borderTop'			=> 'threeDEngrave',
					'borderBottom'		=> 'threeDEngrave',
				);

$col1_2 = array( 	'value' 			=> $Titulo, 
					'cellMargin'		=> 100,
					'borderLeft'		=> 'threeDEngrave',
					'borderRight'		=> 'threeDEngrave',
					'borderTop'			=> 'threeDEngrave',
					'borderBottom'		=> 'threeDEngrave',
				);
				
$col2_1 = array(	'value' 			=> 'AUTORES', // Dato
					'bold'				=> true,
					'borderLeft'		=> 'threeDEngrave',
					'borderRight'		=> 'threeDEngrave',
					'borderTop'			=> 'threeDEngrave',
					'borderBottom'		=> 'threeDEngrave',
				);

$col2_2 = array( 	'value' 			=> $Titulo, 
					'cellMargin'		=> 100,
					'borderLeft'		=> 'threeDEngrave',
					'borderRight'		=> 'threeDEngrave',
					'borderTop'			=> 'threeDEngrave',
					'borderBottom'		=> 'threeDEngrave',
				);

$col3_1 = array(	'value' 			=> 'Palabras Claves', // Dato
					'bold'				=> true,
					'borderLeft'		=> 'threeDEngrave',
					'borderRight'		=> 'threeDEngrave',
					'borderTop'			=> 'threeDEngrave',
					'borderBottom'		=> 'threeDEngrave',
				);

$col3_2 = array( 	'value' 			=> $palsClaves, 
					'cellMargin'		=> 100,
					'borderLeft'		=> 'threeDEngrave',
					'borderRight'		=> 'threeDEngrave',
					'borderTop'			=> 'threeDEngrave',
					'borderBottom'		=> 'threeDEngrave',
				);
				

//set teh global table properties
$options = array(	//'columnWidths' 		=> array(950,720,720,720,720,720,720,720,720,720,720), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					//'float' 			=> array('align' 	=> 'center'	),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 10),
				);
				


$values = array(	array($col1_1, $col1_2),
					array($col2_1, $col2_2),
					array($col3_1, $col3_2),
);

$docx->addTable($values, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>