<?php
//****************************************************************************
//Tabla Químicos Acero
//****************************************************************************

$trProperties = array();
/*
$trProperties[0] = array(	'minHeight' 	=> 100, 
							'tableHeader' 	=> false,
							'font' 			=> 'Arial',
							'fontSize' 		=> 9,
							'border'		=> 'double',
						);
*/
$trProperties[0] = array(	'minHeight' 	=> 100, 
							'width'			=> 50000,
						);
						
$col_1_1 = array( 	'value' 			=> 'ID ITEM', 
					'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderLeft'		=> 'double',
					'cellMargin'		=> 100,
				);
$col_1_2 = array( 	'value' 			=> '%Si', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_3 = array( 	'value' 			=> '%Fe', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_4 = array( 	'value' 			=> '%Cu', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_5 = array( 	'value' 			=> '%Mn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_6 = array( 	'value' 			=> '%Mg', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double', 
				);
$col_1_7 = array( 	'value' 			=> '%Cr', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_8 = array( 	'value' 			=> '%Ni', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_9 = array( 	'value' 			=> '%Zn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_10 = array( 	'value' 			=> '%Ti', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_11 = array( 	'value' 			=> '%Pb', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
				
$col_3_2 = array( 	'value' 			=> '%Sn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'cellMargin'		=> 100,
				);
$col_3_3 = array( 	'value' 			=> '%Bi', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'cellMargin'		=> 100,
				);
$col_3_4 = array( 	'value' 			=> '%Zr', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'cellMargin'		=> 100,
				);
$col_3_5 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
				);
$col_3_6 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
				);
$col_3_7 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
				);
$col_3_8 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
				);
$col_3_9 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
				);
$col_3_10 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
				);
$col_3_11 = array( 	'value' 			=> '%Al', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'cellMargin'		=> 100,
					'borderRight'		=> 'double',
				);

$col_2_1 = array(	'rowspan' 			=> 3, 
					'value' 			=> $rowOtam['Otam'], // Dato
					'backgroundColor' 	=> 'ffffff',
					'bold'				=> true,
					'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
				);
//$bdReg=$link->query("SELECT * FROM regquimico Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."'");
//$bdReg=$link->query("SELECT * FROM regquimico Where idItem = '".$rowOtam['Otam']."'");
$bdReg=$link->query("SELECT * FROM regquimico Where idItem = '".$rowOtam['Otam']."' and CodInforme = '".$CodInforme."'");

if($rowReg=mysqli_fetch_array($bdReg)){
	$col_2_2 = array( 	'value' 			=> $rowReg['cSi'], 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_3 = array( 	'value' 			=> $rowReg['cFe'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_4 = array( 	'value' 			=> $rowReg['cCu'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_5 = array( 	'value' 			=> $rowReg['cMn'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_6 = array( 	'value' 			=> $rowReg['cMg'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_7 = array( 	'value' 			=> $rowReg['cCr'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_8 = array( 	'value' 			=> $rowReg['cNi'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_9 = array( 	'value' 			=> $rowReg['cZn'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_10 = array( 	'value' 			=> $rowReg['cTi'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						//'textDirection' 	=> 'tbRl',
					);
	$col_2_11 = array( 	'value' 			=> $rowReg['cPb'], 
						'backgroundColor' 	=> 'ffffff',
						//'cellMargin'		=> 100,
						'borderRight'		=> 'double',
						//'textDirection' 	=> 'tbRl',
					);
	if($Ref == 'SR'){
		$col_4_2 = array( 	'value' 			=> $rowReg['cSn'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_3 = array( 	'value' 			=> $rowReg['cBi'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_4 = array( 	'value' 			=> $rowReg['cZr'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_5 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_6 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_7 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_8 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_9 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_10 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_4_11 = array( 	'value' 			=> $rowReg['cAl'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderRight'		=> 'double',
							'borderBottom'		=> 'double',
						);
	}else{
		$col_4_2 = array( 	'value' 			=> $rowReg['cSn'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_3 = array( 	'value' 			=> $rowReg['cBi'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_4 = array( 	'value' 			=> $rowReg['cZr'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_5 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_6 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_7 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_8 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_9 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_10 = array( 	'value' 			=> '', 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_4_11 = array( 	'value' 			=> $rowReg['cAl'], 
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderRight'		=> 'double',
						);
	}
}

if($Ref == 'CR'){
	$col_R_2 = array( 	'value' 			=> 'Referencia', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderLeft'		=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_2 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_3 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_4 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_5 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_6 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_7 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_8 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_9 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_10 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_11 = array( 	'value' 			=> '', 
						'backgroundColor' 	=> 'ffffff',
						'cellMargin'		=> 100,
						'borderRight'		=> 'double',
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
}
//set teh global table properties
$options = array(	//'columnWidths' 		=> array(10000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000), 
					'borderWidth' 		=> 1, 
					//'float' 			=> array('align' 	=> 'center'	),
					'tableAlign' 		=> 'center',
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
if($Ref == 'SR'){
	$values = array(	array($col_1_1, $col_1_2, $col_1_3, $col_1_4, $col_1_5, $col_1_6, $col_1_7, $col_1_8, $col_1_9, $col_1_10, $col_1_11),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7, $col_2_8, $col_2_9, $col_2_10, $col_2_11),
						array($col_3_2, $col_3_3, $col_3_4, $col_3_5, $col_3_6, $col_3_7, $col_3_8, $col_3_9, $col_3_10, $col_3_11),
						array($col_4_2, $col_4_3, $col_4_4, $col_4_5, $col_4_6, $col_4_7, $col_4_8, $col_4_9, $col_4_10, $col_4_11),
					);
}else{
	$values = array(	array($col_1_1, $col_1_2, $col_1_3, $col_1_4, $col_1_5, $col_1_6, $col_1_7, $col_1_8, $col_1_9, $col_1_10, $col_1_11),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7, $col_2_8, $col_2_9, $col_2_10, $col_2_11),
						array($col_3_2, $col_3_3, $col_3_4, $col_3_5, $col_3_6, $col_3_7, $col_3_8, $col_3_9, $col_3_10, $col_3_11),
						array($col_4_2, $col_4_3, $col_4_4, $col_4_5, $col_4_6, $col_4_7, $col_4_8, $col_4_9, $col_4_10, $col_4_11),
						array($col_R_1, $col_R_2, $col_R_3, $col_R_4, $col_R_5, $col_R_6, $col_R_7, $col_R_8, $col_R_9, $col_R_10, $col_R_11),
					);
	
}
				
//$docx->addTable($values, $options, $trProperties);
//$docx->addTable($values, $options);
$docx->addTable($values, $options);

//****************************************************************************
//Tabla Químicos Acero FIN TABLA
//****************************************************************************
?>