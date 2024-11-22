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
						
//$SQLtr = "SELECT * FROM regTraccion Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."'";	
$SQLtr = "SELECT * FROM regTraccion Where idItem = '".$rowOtam['Otam']."'";	
$text = $rowOtam['idEnsayo'].' '.$rowOtam['tpMuestra'].' '.$rowOtam['Otam'];

//$docx->addText($SQLtr);
$bdReg=$link->query($SQLtr);
if($rowReg=mysqli_fetch_array($bdReg)){
	$Espesor = $rowReg['Espesor'];

	if($Ref == 'CR'){
		$text = [];
		$text[] = array( 'text' => $rowReg['idItem'], 'bold' => true, 'fontSize'		=> 8 ); 

		$col_2_1 = array(	'value' 			=> $text, // Dato
							'bold'				=> true,
							'backgroundColor' 	=> 'ffffff',
							'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
							'borderLeft'		=> 'double',
							'cellMargin'		=> 100,
						);
		$col_2_2 = array( 	'value' 			=>  number_format(($rowReg['aIni']), 2, ',', '.'), 
							'backgroundColor' 	=> 'ffffff',
						);
		$col_2_3 = array( 	'value' 			=> $rowReg['cFlu'],
							'backgroundColor' 	=> 'ffffff',
						);
		$col_2_4 = array( 	'value' 			=> number_format(intval($rowReg['cMax']), 0, ',', '.'), 
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['tFlu']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_5 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(($rowReg['tMax']), 3, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_6 = array( 	'value' 			=> $text,
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['aSob']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_7 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderRight'		=> 'double',
						);
	}else{
		$text = [];
		$text[] = array( 'text' => $rowReg['idItem'], 'bold' => true, 'fontSize'		=> 8 ); 

		$col_2_1 = array(	'value' 			=> $text, // Dato
							'bold'				=> true,
							'backgroundColor' 	=> 'ffffff',
							'borderLeft'		=> 'double',
							'vAlign' 			=> 'center',
							'borderBottom'		=> 'double',
							'cellMargin'		=> 100,
						);
		$col_2_2 = array( 	'value' 			=>  number_format(($rowReg['aIni']), 2, ',', '.'),
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$col_2_3 = array( 	'value' 			=> $rowReg['cFlu'],
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$col_2_4 = array( 	'value' 			=> number_format(intval($rowReg['cMax']), 0, ',', '.'), 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['tFlu']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_5 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		$text[] = array( 'text' => number_format(($rowReg['tMax']), 3, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_6 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['aSob']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_7 = array( 	'value' 			=> $text, 
							'borderRight'		=> 'double',
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
	}
}


//set teh global table properties
$options = array(	'columnWidths' 		=> array(1219,1214,1214,1214,1214,1214,1214), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					'backgroundColor' 	=> 'ffffff',
					'tableAlign' 		=> 'center',
					//'float' 			=> array('align' 	=> 'center'	),
					'tableAlign' 		=> 'center',
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
$text = [];
$text[] = array( 'text' => 'Área Inicial (mm', 'fontSize'		=> 8 ); 
$text[] = array( 'text' => '2', 'superscript' => true, 'fontSize'		=> 8 ); 
$text[] = array( 'text' => ')', 'fontSize'		=> 8 ); 
		
$col1_2 = array( 	'value' 			=> $text, 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_3 = array( 	'value' 			=> 'Carga de Fluencia 0,2% Def.(Kgf)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_4 = array( 	'value' 			=> 'Carga Máxima (Kgf)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_5 = array( 	'value' 			=> 'Tensión de Fluencia 0,2% Def.(MPa)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_6 = array( 	'value' 			=> 'Tensión Máxima (MPa)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_7 = array( 	'value' 			=> 'Alarg. Sobre 50 mm (%)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
if($Ref == 'CR'){
	$text = [];
	$text[] = array( 'text' => 'Referencia', 'bold' => true, 'fontSize'		=> 8 ); 

	$col_R_1 = array(	'colspan' 			=> 4,
						'value' 			=> $text, // Dato
						'bold'				=> true,
						'borderTop'			=> 'double',
						'backgroundColor' 	=> 'ffffff',
						'borderLeft'		=> 'double',
						'borderBottom'		=> 'double',
						'cellMargin'		=> 100,
					);
	/*
	$col_R_2 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_3 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_4 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	*/
	$text = [];
	$text[] = array( 'text' => '0', 'bold' => true, 'fontSize'		=> 8 ); 

	$col_R_5 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_6 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_7 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}				
if($Ref == 'SR'){
	$valuesTr = array(	array($col1_1, $col1_2, $col1_3, $col1_4, $col1_5, $col1_6, $col1_7),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7),
	);
}else{
	$valuesTr = array(	array($col1_1, $col1_2, $col1_3, $col1_4, $col1_5, $col1_6, $col1_7),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7),
						array($col_R_1, $col_R_2, $col_R_3, $col_R_4, $col_R_5, $col_R_6, $col_R_7),
	);
}
				
$docx->addTable($valuesTr, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>