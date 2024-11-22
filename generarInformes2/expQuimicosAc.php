<?php
//****************************************************************************
//Tabla Químicos Acero
//****************************************************************************








$col_1_1 = array( 	'value' 			=> 'ID ITEM', 
					'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderLeft'		=> 'double',
					'cellMargin'		=> 100,
				);
$col_1_2 = array( 	'value' 			=> '%C', 
					'bold'				=> true,
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_3 = array( 	'value' 			=> '%Si', 
					'bold'				=> true,
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_4 = array( 	'value' 			=> '%Mn', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_5 = array( 	'value' 			=> '%P', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_6 = array( 	'value' 			=> '%S', 
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
$col_1_9 = array( 	'value' 			=> '%Mo', 
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
$col_1_11 = array( 	'value' 			=> '%Cu', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
				
$col_3_2 = array( 	'value' 			=> '%Co', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
					'cellMargin'		=> 100,
				);
$col_3_3 = array( 	'value' 			=> '%Ti', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
				);
$col_3_4 = array( 	'value' 			=> '%Nb', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
				);
$col_3_5 = array( 	'value' 			=> '%V', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
				);
$col_3_6 = array( 	'value' 			=> '%B', 
					'backgroundColor' 	=> 'eeeeee',
					'bold'				=> true,
				);


$CE = '';
$bdReg=$link->query("SELECT * FROM regquimico Where idItem = '".$rowOtam['Otam']."' and CodInforme = '".$CodInforme."'");
if($rowReg=mysqli_fetch_array($bdReg)){

	$vCarbono = '';

	$cC = $rowReg['cC'];
	if(substr($rowReg['cC'],0,1) == '<'){
		$cC = substr($rowReg['cC'],1);
	}
	$cC = floatval(str_replace(',','.',$cC));

	$cMn = $rowReg['cMn'];
	if(substr($rowReg['cMn'],0,1) == '<'){
		$cMn = substr($rowReg['cMn'],1);
	}
	$cMn = floatval(str_replace(',','.',$cMn));

	$cCr = $rowReg['cCr'];
	if(substr($rowReg['cCr'],0,1) == '<'){
		$cCr = substr($rowReg['cCr'],1);
	}
	$cCr = floatval(str_replace(',','.',$cCr));

	$cMo = $rowReg['cMo'];
	if(substr($rowReg['cMo'],0,1) == '<'){
		$cMo = substr($rowReg['cMo'],1);
	}
	$cMo = floatval(str_replace(',','.',$cMo));

	$cV = $rowReg['cV'];
	if(substr($rowReg['cV'],0,1) == '<'){
		$cV = substr($rowReg['cV'],1);
	}
	$cV = floatval(str_replace(',','.',$cV));

	$cV = $rowReg['cV'];
	if(substr($rowReg['cV'],0,1) == '<'){
		$cV = substr($rowReg['cV'],1);
	}
	$cV = floatval(str_replace(',','.',$cV));

	$cNi = $rowReg['cNi'];
	if(substr($rowReg['cNi'],0,1) == '<'){
		$cNi = substr($rowReg['cNi'],1);
	}
	$cNi = floatval(str_replace(',','.',$cNi));

	$cCu = $rowReg['cCu'];
	if(substr($rowReg['cCu'],0,1) == '<'){
		$cCu = substr($rowReg['cCu'],1);
	}
	$cCu = floatval(str_replace(',','.',$cCu));



	$vCarbono = $cC + ($cMn/6) + (($cCr + $cMo + $cV) / 5) + (($cNi + $cCu) / 15);
	$vCarbono = number_format($vCarbono, 2, '.', ',');






}


$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'W'");
$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
if($rowQu['imprimible'] == 'on') { 
	$col_3_7 = array( 	'value' 			=> '-', 
						'backgroundColor' 	=> 'eeeeee',
					);
}else{
	if($rowReg['cW']){
		$col_3_7 = array( 	'value' 			=> '-', 
							'backgroundColor' 	=> 'eeeeee',
						);
	}else{
		$col_3_7 = array( 	'value' 			=> '-', 
							'backgroundColor' 	=> 'eeeeee',
						);
	}
}
$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn'");
$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
if($rowQu['imprimible'] == 'on') { 
	$col_3_8 = array( 	'value' 			=> '%Sn', 
						'backgroundColor' 	=> 'eeeeee',
					);
}else{
	if($rowReg['cSn']){
		$col_3_8 = array( 	'value' 			=> '%Sn', 
							'backgroundColor' 	=> 'eeeeee',
						);
	}else{
		$col_3_8 = array( 	'value' 			=> '-', 
							'backgroundColor' 	=> 'eeeeee',
						);
	}
}
$col_3_9 = array( 	'value' 			=> '-', 
					'backgroundColor' 	=> 'eeeeee',
				);
if($rowInf['tpEnsayo'] == 5){
	$col_3_10 = array( 	'value' 			=> '%CE', 
						'backgroundColor' 	=> 'eeeeee',
					);
}else{
	$col_3_10 = array( 	'value' 			=> '-', 
						'backgroundColor' 	=> 'eeeeee',
					);
}
$col_3_11 = array( 	'value' 			=> '%Fe', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRight'		=> 'double',
				);

$col_2_1 = array(	'rowspan' 			=> 3, 
					'textProperties'	=> array('bold' => true),
					'value' 			=> $rowOtam['Otam'], // Dato
					'backgroundColor' 	=> 'ffffff',
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
				);
		$bdReg=$link->query("SELECT * FROM regquimico Where idItem = '".$rowOtam['Otam']."' and CodInforme = '".$CodInforme."'");
		if($rowReg=mysqli_fetch_array($bdReg)){
			$colorRojo = 'ffffff';
			if($rowReg['Precaucion'] == 'on'){
				$colorRojo = 'FC4720';
			}
			$col_2_2 = array( 	'value' 			=> $rowReg['cC'],
								'backgroundColor' 	=> $colorRojo,
								'border'			=> 'none',
								'cellMargin'		=> 100,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_3 = array( 	'value' 			=> $rowReg['cSi'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_4 = array( 	'value' 			=> $rowReg['cMn'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_5 = array( 	'value' 			=> $rowReg['cP'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_6 = array( 	'value' 			=> $rowReg['cS'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_7 = array( 	'value' 			=> $rowReg['cCr'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_8 = array( 	'value' 			=> $rowReg['cNi'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_9 = array( 	'value' 			=> $rowReg['cMo'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_10 = array( 	'value' 			=> $rowReg['cAl'], 
								'backgroundColor' 	=> $colorRojo,
								//'textDirection' 	=> 'tbRl',
							);
			$col_2_11 = array( 	'value' 			=> $rowReg['cCu'], 
								'backgroundColor' 	=> $colorRojo,
								'borderRight'		=> 'double',
								//'textDirection' 	=> 'tbRl',
							);

			if($Ref == 'SR'){
				$col_4_2 = array( 	'value' 			=> $rowReg['cCo'], 
									'backgroundColor' 	=> $colorRojo,
									'cellMargin'		=> 100,
									'borderBottom'		=> 'double',
								);
				$col_4_3 = array( 	'value' 			=> $rowReg['cTi'], 
									'backgroundColor' 	=> $colorRojo,
									'borderBottom'		=> 'double',
								);
				$col_4_4 = array( 	'value' 			=> $rowReg['cNb'], 
									'backgroundColor' 	=> $colorRojo,
									'borderBottom'		=> 'double',
								);
				$col_4_5 = array( 	'value' 			=> $rowReg['cV'], 
									'backgroundColor' 	=> $colorRojo,
									'borderBottom'		=> 'double',
								);
				$col_4_6 = array( 	'value' 			=> $rowReg['cB'], 
									'backgroundColor' 	=> $colorRojo,
									'borderBottom'		=> 'double',
								);
				$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'W'");
				$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
				if($rowQu['imprimible'] == 'on') { 
					$col_4_7 = array( 	'value' 			=> '-', 
										'backgroundColor' 	=> $colorRojo,
										'borderBottom'		=> 'double',
									);
				}else{
					if($rowReg['cW']) { 
						$col_4_7 = array( 	'value' 			=> '-', 
											'backgroundColor' 	=> $colorRojo,
											'borderBottom'		=> 'double',
										);
					}else{
						$col_4_7 = array( 	'value' 			=> '-', 
											'backgroundColor' 	=> $colorRojo,
											'borderBottom'		=> 'double',
										);
					}
				}
				$bdQu=$link->query("SELECT * FROM tabparensayos Where idEnsayo = 'Qu' and tpMuestra = 'Ac' and Simbolo = 'Sn'");
				$rowQu = $bdQu->fetch_array(MYSQLI_ASSOC);
				if($rowQu['imprimible'] == 'on') { 
					$col_4_8 = array( 	'value' 			=> $rowReg['cSn'], 
										'backgroundColor' 	=> $colorRojo,
										'borderBottom'		=> 'double',
									);
				}else{
					if($rowReg['cSn']) { 
						$col_4_8 = array( 	'value' 			=> $rowReg['cSn'], 
											'backgroundColor' 	=> $colorRojo,
											'borderBottom'		=> 'double',
										);
					}else{
						$col_4_8 = array( 	'value' 			=> '-', 
											'backgroundColor' 	=> $colorRojo,
											'borderBottom'		=> 'double',
										);
					}
				}
				$col_4_9 = array( 	'value' 			=> '-', 
									'backgroundColor' 	=> $colorRojo,
									'borderBottom'		=> 'double',
								);
				if($rowInf['tpEnsayo'] == 5){
					$col_4_10 = array( 	'value' 			=> $vCarbono, // vCarbono
										'backgroundColor' 	=> $colorRojo,
										'borderBottom'		=> 'double',
									);
				}else{
					$col_4_10 = array( 	'value' 			=> '-', 
										'backgroundColor' 	=> $colorRojo,
										'borderBottom'		=> 'double',
									);
				}
				$col_4_11 = array( 	'value' 			=> 'Resto', //$rowReg['cFe'], 
									'backgroundColor' 	=> $colorRojo,
									'borderRight'		=> 'double',
									'borderBottom'		=> 'double',
								);
			}else{
				$col_4_2 = array( 	'value' 			=> $rowReg['cCo'], 
									'backgroundColor' 	=> $colorRojo,
									'cellMargin'		=> 100,
								);
				$col_4_3 = array( 	'value' 			=> $rowReg['cTi'], 
									'backgroundColor' 	=> $colorRojo,
								);
				$col_4_4 = array( 	'value' 			=> $rowReg['cNb'], 
									'backgroundColor' 	=> $colorRojo,
								);
				$col_4_5 = array( 	'value' 			=> $rowReg['cV'], 
									'backgroundColor' 	=> $colorRojo,
								);
				$col_4_6 = array( 	'value' 			=> $rowReg['cW'], 
									'backgroundColor' 	=> $colorRojo,
								);
				$col_4_7 = array( 	'value' 			=> $rowReg['cSn'], 
									'backgroundColor' 	=> $colorRojo,
								);
				$col_4_8 = array( 	'value' 			=> $rowReg['cB'], 
									'backgroundColor' 	=> $colorRojo,
								);
				$col_4_9 = array( 	'value' 			=> '-', 
									'backgroundColor' 	=> $colorRojo,
								);
				if($rowInf['tpEnsayo'] == 5){
					$col_4_10 = array( 	'value' 			=> $vCarbono, // vCarbono
										'backgroundColor' 	=> $colorRojo,
										'borderBottom'		=> 'double',
									);
				}else{
					$col_4_10 = array( 	'value' 			=> '-', 
										'backgroundColor' 	=> $colorRojo,
										'borderBottom'		=> 'double',
									);
				}
				$col_4_11 = array( 	'value' 			=> 'Resto', //$rowReg['cFe'], 
					'backgroundColor' 	=> $colorRojo,
					'borderRight'		=> 'double',
				);
				
			}
		}

		if($Ref == 'CR'){
			$col_R_1 = array( 	'value' 			=> 'Referencia', 
								'cellMargin'		=> 100,
								'borderLeft'		=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_2 = array( 	'value' 			=> '', 
								'cellMargin'		=> 100,
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
			$col_R_5 = array( 	'value' 			=> '', 
								'borderTop'			=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_6 = array( 	'value' 			=> '', 
								'borderTop'			=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_7 = array( 	'value' 			=> '', 
								'borderTop'			=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_8 = array( 	'value' 			=> '', 
								'borderTop'			=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_9 = array( 	'value' 			=> '-', 
								'borderTop'			=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_10 = array( 	'value' 			=> '-', 
								'borderTop'			=> 'double',
								'borderBottom'		=> 'double',
							);
			$col_R_11 = array( 	'value' 			=> '', 
								'borderTop'			=> 'double',
								'borderRight'		=> 'double',
								'borderBottom'		=> 'double',
							);
		}

//set teh global table properties
$options = array(	'columnWidths' 		=> array(2000,720,720,720,720,720,720,720,720,720,720), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					//'float' 			=> array('align' 	=> 'center'	),
					'tableAlign' 		=> 'center',
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
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
$trProperties = array();
$trProperties[0] = array(	'minHeight' 	=> 500, 
							'tableHeader' 	=> false,
							'font' 			=> 'Arial',
							'fontSize' 		=> 9,
							//'border'		=> 'double',
						);
$trProperties[1] = array(	'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8), 
						);
//$docx->addTable($values, $options, $trProperties);
$docx->addTable($values, $options);

//$docx->addTable($values, $options);

//****************************************************************************
//Tabla Químicos Acero FIN TABLA
//****************************************************************************
?>