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
						
$col_2_1 = array(	'value' 			=> '', // Dato
					'backgroundColor' 	=> 'ffffff',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
					'cellMargin'		=> 100,
				);
$col_2_2 = array( 	'value' 			=> '', 
					'backgroundColor' 	=> 'ffffff',
					'borderBottom'		=> 'double',
					'cellMargin'		=> 100,
				);
$col_2_3 = array( 	'value' 			=> '', 
					'backgroundColor' 	=> 'ffffff',
					'borderBottom'		=> 'double',
				);

$col_2_4 = array( 	'value' 			=> '', 
					'backgroundColor' 	=> 'ffffff',
					'cellMargin'		=> 100,
					'borderBottom'		=> 'double',
				);
$col_2_5 = array( 	'value' 			=> '', 
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
				

$col1_1 = array(	'value' 			=> 'Electrolito',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'cellMargin'		=> 100,
					'width'				=> 100,
				);
$col1_2 = array( 	'value' 			=> 'Muestras de acero', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'cellMargin'		=> 100,
				);
$col1_3 = array( 	'value' 			=> 'Potencial de corrosión (Ecor) mV', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'cellMargin'		=> 100,
				);
$col1_4 = array( 	'value' 			=> 'Densidad de corriente de corrosión (Lcorr) µA/cm2', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'cellMargin'		=> 100,
				);
$col1_5 = array( 	'value' 			=> 'Velocidad de corrosión (MYP)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
					'cellMargin'		=> 100,
				);
				
$valuesTr = array(	array($col1_1,  $col1_2,  $col1_3,  $col1_4,  $col1_5),
					array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5),
);
$docx->addTable($valuesTr, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>