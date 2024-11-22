<?php
//****************************************************************************
//Tabla Doblado Guiado 
//****************************************************************************

$trProperties = array();
$trProperties[0] = array(	'minHeight' 	=> 500, 
							'tableHeader' 	=> false,
							'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
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
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
					'cellMargin'		=> 100,
				);

$mediaIndenta 	= 0;
$nIndenta		= 0;		
//$bdReg=$link->query("SELECT * FROM regDobladosReal Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."'");
$bdReg=$link->query("SELECT * FROM regDobladosReal Where idItem = '".$rowOtam['Otam']."'");
if($rowReg=mysqli_fetch_array($bdReg)){
	$fr = explode('-', $rowOtam['Otam']);
	$RAM = $fr[0];

	$bdcot=$link->query("SELECT * FROM cotizaciones Where RAM = '$RAM'");
	if($rscot=mysqli_fetch_array($bdcot)){
		$tpEnsayo = $rscot['tpEnsayo'];
	}

	$obsDoblado = '';
	$bd=$link->query("SELECT * FROM obsdoblado Where nObsDoblado = '".$rowReg['Observaciones']."'");
	if($rs=mysqli_fetch_array($bd)){
		$obsDoblado = $rs['obsDoblado'];
	}
	$Tipo = '';
	$Condicion = '';
	if($rowReg['Tipo'] == 'C'){ $Tipo = 'Cara'; }
	if($rowReg['Tipo'] == 'R'){ $Tipo = 'Raiz'; }
	if($rowReg['Tipo'] == 'L'){ $Tipo = 'Lado'; }
	
	if($rowReg['Condicion'] == 'Si'){ $Condicion = 'Cumple'; }
	if($rowReg['Condicion'] == 'No'){ $Condicion = 'No Cumple'; }

	if($tpEnsayo != 5){
		$col_2_2 = array( 	'value' 			=> $Tipo, 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
	}
	
	$col_2_3 = array( 	'value' 			=> $obsDoblado, 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderBottom'		=> 'double',
					);
	$col_2_4 = array( 	'value' 			=> $Condicion, 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderBottom'		=> 'double',
						'borderRight'		=> 'double',
					);
}

//set teh global table properties
$options = array(	'border'			=> 'none',
					'tableAlign' 		=> 'center',
					//'float' 			=> array('align' 	=> 'center'	),
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
					'width'				=> 1300,
				);

if($tpEnsayo != 5){
	$col1_2 = array( 	'value' 			=> 'Tipo',
						'backgroundColor' 	=> 'eeeeee',
						'borderTop'			=> 'double',
					);
}

$col1_3 = array( 	'value' 			=> 'Observaciones',
					'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_4 = array( 	'value' 			=> 'Condición',
					'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);

if($tpEnsayo == 5){
	$valuesDo = array(	array($col1_1, $col1_3, $col1_4),
						array($col_2_1, $col_2_3, $col_2_4),
	);
}else{
	$valuesDo = array(	array($col1_1, $col1_2, $col1_3, $col1_4),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4),
	);
}
$docx->addTable($valuesDo, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>