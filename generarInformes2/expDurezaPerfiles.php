<?php
//****************************************************************************
//Tabla Tracción 
//****************************************************************************

$trProperties = array();
$trProperties[0] = array(	'minHeight' 	=> 500, 
							'tableHeader' 	=> false,
							'font' 			=> 'Arial',
							'fontSize' 		=> 9,
						);

//set teh global table properties
$options = array(	'border'			=> 'none',
					'tableAlign' 		=> 'center',
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
				

$col1_1 = array(	'value' 			=> 'Distancia desde superficie (mm)',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'width'				=> 1000,
					'cellMargin'		=> 100
				);
$col1_2 = array( 	'value' 			=> 'Dureza (HRC)'.$rowOtam['Otam'], 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
					'width'				=> 100
				);
/*
$valuesTr = array(	array($col1_1,      $col1_2),
                    array($col_2_1,     $col_2_2),
					array($col_ult_1,   $col_ult_2)
	                );
*/
$valuesDu = array();

array_push($valuesDu, array($col1_1, $col1_2));	
$i = 0;
//$SQLdu = "SELECT * FROM regdoblado Where CodInforme = '".$rowOtam['CodInforme']."' and idItem = '".$rowOtam['Otam']."' Order By nIndenta";
$SQLdu = "SELECT * FROM regdoblado Where  idItem = '".$rowOtam['Otam']."' Order By nIndenta";
$bddu=$link->query($SQLdu);
while($rd=mysqli_fetch_array($bddu)){
    $i++;
    if($i < $rowOtam['Ind']){
        $col_2_1 = array(	'value' 			=> number_format($rd['Distancia'], 1, ',', ' '), // Dato
                            'backgroundColor' 	=> 'ffffff',
                            'bold'				=> true,
                            'borderLeft'		=> 'double',
                            'vAlign' 			=> 'center',
                            'cellMargin'		=> 100,
                        );
        $col_2_2 = array( 	'value' 			=> number_format($rd['Dureza'], 1, ',', ' '), 
                            'backgroundColor' 	=> 'ffffff',
                            'borderRight'		=> 'double',
                            );
        array_push($valuesDu, array($col_2_1, $col_2_2));
    }else{
        $col_ult_1 = array(	'value' 			=> number_format($rd['Distancia'], 1, ',', ' '), // Dato
                            'backgroundColor' 	=> 'ffffff',
                            'bold'				=> true,
                            'borderLeft'		=> 'double',
                            'cellMargin'		=> 100,
                            'borderBottom'		=> 'double',
                        );
        $col_ult_2 = array( 'value' 			=> number_format($rd['Dureza'], 1, ',', ' '), 
                            'backgroundColor' 	=> 'ffffff',
                            'borderBottom'		=> 'double',
                            'borderRight'		=> 'double',
                        );
        array_push($valuesDu, array($col_ult_1, $col_ult_2));				
    }
			
}
$docx->addTable($valuesDu, $options, $trProperties);
$docx->addText($textSpace, $espacioOpcion);

/*
$espacioOpcion = array(
						'font' 				=> 'Arial',
						'fontSize'			=> 10,
						'lineSpacing'		=> 360,
						);

$textSpace = '';
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Figura '.$letraItem.'.1 ', 'bold' => true ); 
$text[] = array( 'text' => 'Gráfico de durezas v/s distancia.' ); 

$docx->addText($text, $paragraphFiguras);
$docx->addText($textSpace, $espacioOpcion);
*/

//****************************************************************************
//Tabla dureza perfil FIN TABLA
//****************************************************************************
?>