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
						
				
//$bdReg=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."'");
$bdReg=$link->query("SELECT * FROM regCharpy Where  idItem = '".$rowOtam['Otam']."'");
if($rowReg=mysqli_fetch_array($bdReg)){

	$col_2_1 = array(	'value' 			=> $rowOtam['Otam'], // Dato
						'bold'				=> true,
						'borderLeft'		=> 'double',
						'vAlign' 			=> 'center',
						'borderBottom'		=> 'double',
					);
	$col_2_2 = array( 	'value' 			=> $rowReg['vImpacto'], 
						'cellMargin'		=> 100,
						'borderBottom'		=> 'double',
					);
	$col_2_3 = array( 	'value' 			=> $rowReg['vImpacto'], 
						'borderBottom'		=> 'double',
					);
	$col_2_4 = array( 	'value' 			=> $rowReg['vImpacto'], 
						'borderBottom'		=> 'double',
					);
	$col_2_5 = array( 	'value' 			=> $rowReg['vImpacto'], 
						'borderBottom'		=> 'double',
					);
}


//set teh global table properties
$options = array(	'columnWidths' 		=> array(1703,1700,1700,1700,1700), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					//'float' 			=> array('align' 	=> 'center'	),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
				

$col1_1 = array(	'value' 			=> 'ID ITEM',
					'colspan'			=> 3,
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'width'				=> 100,
				);
$col1_2 = array( 	'value' 			=> 'Energía de impacto a T° Normal',
					'rowspan'			=> 4,
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);

$col2_2 = array(	'value' 			=> 'Muestra N° 1',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'width'				=> 100,
				);
$col2_3 = array( 	'value' 			=> 'Muestra N° 2',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col2_4 = array( 	'value' 			=> 'Muestra N° 3',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col2_5 = array( 	'value' 			=> 'Promedio',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
				
				
				
$valuesCh = array(	array($col1_1, $col1_2),
 					array($col_2_2, $col_2_3, $col_2_4, $col_2_5),
);
				
$docx->addTable($valuesCh, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>