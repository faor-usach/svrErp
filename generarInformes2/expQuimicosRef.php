<?php
//****************************************************************************
//Tabla Químicos Acero
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
						

$col_1_1 = array( 	'value' 			=> 'Referencia', 
					'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderLeft'		=> 'double',
					'cellMargin'		=> 100,
				);
$col_1_2 = array( 	'value' 			=> '%Zn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_3 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_4 = array( 	'value' 			=> '%Sn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_5 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_6 = array( 	'value' 			=> '%Mn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_7 = array( 	'value' 			=> '%Fe', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_8 = array( 	'value' 			=> '%Ni(**)', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_9 = array( 	'value' 			=> '%Si', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_10 = array( 	'value' 			=> '%Al', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_11 = array( 	'value' 			=> '%Cu()***', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
						
$col_4_1 = array( 	'value' 			=> '', 
					'borderLeft'		=> 'double',
					'cellMargin'		=> 100,
					'borderBottom'		=> 'double',
				);
$col_4_2 = array( 	'value' 			=> '', 
					'cellMargin'		=> 100,
					'borderBottom'		=> 'double',
				);
$col_4_3 = array( 	'value' 			=> '', 
					'borderBottom'		=> 'double',
				);
$col_4_4 = array( 	'value' 			=> '', 
					'borderBottom'		=> 'double',
				);
$col_4_5 = array( 	'value' 			=> '', 
					'borderBottom'		=> 'double',
				);
$col_4_6 = array( 	'value' 			=> '', 
					'borderBottom'		=> 'double',
				);
$col_4_7 = array( 	'value' 			=> '', 
					'borderBottom'		=> 'double',
				);
$col_4_8 = array( 	'value' 			=> '', 
					'borderBottom'		=> 'double',
				);
$col_4_9 = array( 	'value' 			=> '-', 
					'borderBottom'		=> 'double',
				);
$col_4_10 = array( 	'value' 			=> '-', 
					'borderBottom'		=> 'double',
				);
$col_4_11 = array( 	'value' 			=> '', 
					'borderRight'		=> 'double',
					'borderBottom'		=> 'double',
				);


//set teh global table properties
$options = array(	//'columnWidths' 		=> array(950,720,720,720,720,720,720,720,720,720,720), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					//'float' 			=> array('align' 	=> 'center'	),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
				
$values = array(	array($col_1_1, $col_1_2, $col_1_3, $col_1_4, $col_1_5, $col_1_6, $col_1_7, $col_1_8, $col_1_9, $col_1_10, $col_1_11),
					array($col_4_1, $col_4_2, $col_4_3, $col_4_4, $col_4_5, $col_4_6, $col_4_7, $col_4_8, $col_4_9, $col_4_10, $col_4_11),
				);
				
$docx->addTable($values, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Químicos Acero FIN TABLA
//****************************************************************************
?>