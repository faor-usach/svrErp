<?php
//****************************************************************************
//Tabla Tracción 
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
						
				
	if($Ref == 'CR'){
		$col_2_1 = array(	'value' 			=> $rowOtam['Otam'], // Dato
							'backgroundColor' 	=> 'ffffff',
							'bold'				=> true,
							'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
							'borderLeft'		=> 'double',
							'cellMargin'		=> 100,
						);
		$col_2_2 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
						);
		$col_2_3 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'borderRight'		=> 'double',
						);
	}else{
		$col_2_1 = array(	'value' 			=> $rowOtam['Otam'], // Dato
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
						);
		$col_2_3 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
							'borderRight'		=> 'double',
						);
	}


//set teh global table properties
$options = array(	'columnWidths' 		=> array(2835,2834,2834), 
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
					'width'				=> 100,
					'cellMargin'		=> 100,
				);
$col1_2 = array( 	'value' 			=> 'Carga Máxima (Kgf)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_3 = array( 	'value' 			=> 'Carga por distancia lineal (Khf/cm)(*)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
if($Ref == 'CR'){
	$col_R_1 = array(	'value' 			=> 'Referencia', // Dato
						'bold'				=> true,
						'borderTop'			=> 'double',
						'borderLeft'		=> 'double',
						'borderBottom'		=> 'double',
						'cellMargin'		=> 100,
					);
	$col_R_2 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_3 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
						'borderRight'		=> 'double',
					);
}				
if($Ref == 'SR'){
	$valuesTr = array(	array($col1_1, $col1_2, $col1_3),
						array($col_2_1, $col_2_2, $col_2_3),
	);
}else{
	$valuesTr = array(	array($col1_1, $col1_2, $col1_3),
						array($col_2_1, $col_2_2, $col_2_3),
						array($col_R_1, $col_R_2, $col_R_3),
	);
}
				
$docx->addTable($valuesTr, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>