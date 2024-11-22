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
						
/* Data de Charpy */

$col_2_1 = array(	'value' 			=> $rowOtam['Otam'], // Dato
					//'backgroundColor' 	=> 'ffffff',
					'bold'				=> true,
					'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
				);

$mediaIndenta 	= 0;
$nIndenta		= 0;		
$bdReg=$link->query("SELECT * FROM regDoblado Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."' Order By nIndenta");
while($rowReg=mysqli_fetch_array($bdReg)){
		$mediaImpactos += $rowReg['vIndenta'];
		$nIndenta++;
		if($rowReg['nIndenta'] == 1){
			$col_2_2 = array( 	'value' 			=> number_format($rowReg['vIndenta'], 2, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nIndenta'] == 2){
			$col_2_3 = array( 	'value' 			=> number_format($rowReg['vIndenta'], 2, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nIndenta'] == 3){
			$col_2_4 = array( 	'value' 			=> number_format($rowReg['vIndenta'], 2, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nIndenta'] == 4){
			$col_2_5 = array( 	'value' 			=> number_format($rowReg['vIndenta'], 2, ',', '.'),  
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
		if($rowReg['nIndenta'] == 5){
			$col_2_6 = array( 	'value' 			=> number_format($rowReg['vIndenta'], 2, ',', '.'), 
								'backgroundColor' 	=> 'ffffff',
								'cellMargin'		=> 100,
								'borderBottom'		=> 'double',
							);
		}
}
$mediaIndenta = $mediaImpactos / $nIndenta;
if($nIndenta == 3){
	$col_2_5 = array( 	'value' 			=> number_format($mediaIndenta, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}
if($nIndenta == 4){
	$col_2_6 = array( 	'value' 			=> number_format($mediaIndenta, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}
if($nIndenta == 5){
	$col_2_7 = array( 	'value' 			=> number_format($mediaIndenta, 1, ',', '.'), 
						'backgroundColor' 	=> 'ffffff',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}


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
					//'rowspan'			=> 2,
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'width'				=> 1300,
				);
$col1_2 = array( 	'value' 			=> 'Dureza ', //.$rowTabEns['Tem'],
					'colspan'			=> $nIndenta+1,
					'backgroundColor' 	=> 'eeeeee',
					'borderRight'		=> 'double',
					'borderTop'			=> 'double',
				);

$tipoEnsayo = '';
$bdTp=$link->query("SELECT * FROM amTpsMuestras Where tpMuestra = '".$rowTabEns['tpMuestra']."' and idEnsayo = '".$rowEns['idEnsayo']."'");
if($rowTp=mysqli_fetch_array($bdTp)){
	$tipoEnsayo = $rowTp['tipoEnsayo'];
}
$col0_2 = array(	'value' 			=> $tipoEnsayo, // Poner campo
					'colspan'			=> $rowOtam['Ind']+1,
					'bold'				=> true,
					'vAlign' 			=> 'center',
					'borderLeft'		=> 'double',
					//'borderRight'		=> 'double',
					'backgroundColor' 	=> 'eeeeee',
				);
$col0_3 = array(	'value' 			=> 'Promedio', // Poner campo
					'bold'				=> true,
					'vAlign' 			=> 'center',
					'borderRight'		=> 'double',
					'backgroundColor' 	=> 'eeeeee',
				);
				
if($nIndenta == 3){
	$col2_5 = array( 	'value' 			=> 'Promedio',
						'bold'				=> true,
						'backgroundColor' 	=> 'eeeeee',
						'borderRight'		=> 'double',
					);
}
if($nIndenta == 4){
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
if($nIndenta == 5){
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
						'colspan'			=> $nIndenta+1,
						'borderLeft'		=> 'double',
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
						'vAlign' 			=> 'center',
						'cellMargin'		=> 100,
					);
	$col_R_7 = array(	'value' 			=> '0',
						'borderRight'		=> 'double',
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
						'vAlign' 			=> 'center',
					);
}


if($nIndenta == 3){
	if($Ref == 'SR'){
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2, $col0_3),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5),
		);
	}else{
		$valuesCh = array(	array($col1_1, $col1_2),
							array($col0_2, $col0_3),
							array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5),
							array($col_R_1, $col_R_7),
		);
	}
}
if($nIndenta == 4){
	if($Ref == 'SR'){
		$valuesCh = array(	array($col1_1, $col1_2),
					array($col0_2, $col0_3),
					array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6),
		);
	}else{
		$valuesCh = array(	array($col1_1, $col1_2),
					array($col0_2, $col0_3),
					array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6),
							array($col_R_1, $col_R_7),
		);
	}
}
if($nIndenta == 5){
	if($Ref == 'SR'){
		$valuesCh = array(	array($col1_1, $col1_2),
					array($col0_2, $col0_3),
					array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7),
		);
	}else{
		$valuesCh = array(	array($col1_1, $col1_2),
					array($col0_2, $col0_3),
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