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
						
/* Data de Charpy */

$col_2_1 = array(	'value' 			=> $rowOtam['Otam'], // Dato
					'backgroundColor' 	=> 'ffffff',
					'bold'				=> true,
					'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
				);

$mediaImpactos 	= 0;
$nImpactos		= 0;	


	
$bdReg=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."' Order By nImpacto");
while($rowReg=mysqli_fetch_array($bdReg)){
		
		$mediaImpactos += $rowReg['vImpacto'];
		$nImpactos++;
		if($rowReg['nImpacto'] == 1){
			$col_2_2 = array( 	'value' 			=> number_format($rowReg['vImpacto'], 1, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nImpacto'] == 2){
			$col_2_3 = array( 	'value' 			=> number_format($rowReg['vImpacto'], 1, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nImpacto'] == 3){
			$col_2_4 = array( 	'value' 			=> number_format($rowReg['vImpacto'], 1, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nImpacto'] == 4){
			$col_2_5 = array( 	'value' 			=> number_format($rowReg['vImpacto'], 1, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nImpacto'] == 5){
			$col_2_6 = array( 	'value' 			=> number_format($rowReg['vImpacto'], 1, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
}
$mediaImpactos = $mediaImpactos / $nImpactos;
if($nImpactos == 2){
	$arrayCol = array(2128, 2125,2125,2125);
	$col_2_4 = array( 	'value' 			=> number_format($mediaImpactos, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}

if($nImpactos == 3){
	$arrayCol = array(1703, 1700,1700,1700,1700);
	$col_2_5 = array( 	'value' 			=> number_format($mediaImpactos, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}
if($nImpactos == 4){
	$arrayCol = array(1418, 1417,1417,1417,1417,1417);
	$col_2_6 = array( 	'value' 			=> number_format($mediaImpactos, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}
if($nImpactos == 5){
	$arrayCol = array(1219, 1214,1214,1214,1214,1214,1214);
	$col_2_7 = array( 	'value' 			=> number_format($mediaImpactos, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderBottom'		=> 'double',
						'borderRight'		=> 'double',
					);
}


//set teh global table properties
$options = array(	'columnWidths' 		=> $arrayCol, 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					'tableAlign' 		=> 'center',
					//'float' 			=> array('align' 	=> 'center'	),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
				

$col1_1 = array(	'value' 			=> 'ID ITEM ',
					'rowspan'			=> 3,
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'width'				=> 300,
				);
$col1_2 = array( 	'value' 			=> 'Energía de impacto a '.$rowOtam['Tem'].'°C'],
					'colspan'			=> $nImpactos+1,
					'backgroundColor' 	=> 'eeeeee',
					'borderRight'		=> 'double',
					'borderTop'			=> 'double',
				);

$col0_2 = array(	'value' 			=> '(Joule)',
					'colspan'			=> $nImpactos+1,
					'bold'				=> true,
					'vAlign' 			=> 'center',
					'borderRight'		=> 'double',
					'backgroundColor' 	=> 'eeeeee',
				);
$col2_2 = array(	'value' 			=> 'Muestra N° 1',
						'bold'				=> true,
						'vAlign' 			=> 'center',
						'backgroundColor' 	=> 'eeeeee',
					);
$col2_3 = array( 	'value' 			=> 'Muestra N° 2',
					'bold'				=> true,
					'backgroundColor' 	=> 'eeeeee',
				);
$col2_4 = array( 	'value' 			=> 'Muestra N° 3',
					'bold'				=> true,
					'backgroundColor' 	=> 'eeeeee',
				);
if($nImpactos == 3){
	$col2_5 = array( 	'value' 			=> 'Promedio',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
						'borderRight'		=> 'double',
					);
}
if($nImpactos == 4){
	$col2_5 = array( 	'value' 			=> 'Muestra N° 4',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
					);
	$col2_6 = array( 	'value' 			=> 'Promedio',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
						'borderRight'		=> 'double',
					);
}
if($nImpactos == 5){
	$col2_5 = array( 	'value' 			=> 'Muestra N° 4',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
					);
	$col2_6 = array( 	'value' 			=> 'Muestra N° 5',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
					);
	$col2_7 = array( 	'value' 			=> 'Promedio',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
						'borderRight'		=> 'double',
					);
}

if($Ref == 'CR'){
	$col_R_1 = array(	'value' 			=> 'Referencia según especificación del cliente',
						'colspan'			=> $nImpactos+1,
						'borderLeft'		=> 'double',
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
						'vAlign' 			=> 'center',
						'cellMargin'		=> 100,
					);
	$col_R_7 = array(	'value' 			=> '0.00',
						'borderRight'		=> 'double',
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
						'vAlign' 			=> 'center',
					);
}

if($nImpactos == 3){
	if($Ref == 'SR'){
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2),
							array($col2_2, $col2_3, $col2_4, $col2_5),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5),
		);
	}else{
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2),
							array($col2_2, $col2_3, $col2_4, $col2_5),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5),
							array($col_R_1, $col_R_7),
		);
	}
}
if($nImpactos == 4){
	if($Ref == 'SR'){
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2),
							array($col2_2, $col2_3, $col2_4, $col2_5, $col2_6),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6),
		);
	}else{
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2),
							array($col2_2, $col2_3, $col2_4, $col2_5, $col2_6),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6),
							array($col_R_1, $col_R_7),
		);
	}
}
if($nImpactos == 5){
	if($Ref == 'SR'){
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2),
							array($col2_2, $col2_3, $col2_4, $col2_5, $col2_6, $col2_7),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7),
		);
	}else{
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2),
							array($col2_2, $col2_3, $col2_4, $col2_5, $col2_6, $col2_7),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7),
							array($col_R_1, $col_R_7),
		);
	}
}

$docx->addTable($valuesCh, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>