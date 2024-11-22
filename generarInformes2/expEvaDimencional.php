<?php
//****************************************************************************
//Tabla Metalografia 
//****************************************************************************

$link=Conectarse();
$SQL = "SELECT * FROM regTraccion Where idItem = '$OtamTr'";	
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
}

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
$fi = explode('-',$CodInforme);
$Di = $fi[1].'-'.substr($fi[2],0,2).'-Di01';
$col_2_1 = array(	'value' 			=> $Di, // Dato
					'backgroundColor' 	=> 'ffffff',
					'rowspan' 			=> 2,
					'bold'				=> true,
					'borderTop'		    => 'double',
					'borderLeft'		=> 'double',
					'vAlign' 			=> 'center',
					'borderBottom'		=> 'double',
				);
$col_2_2 = array( 	'value' 			=> $rs['Espesor'], 
					'backgroundColor' 	=> 'ffffff',
					'cellMargin'		=> 100,
                    'borderTop'		    => 'double',
                    'borderLeft'		=> 'double',
                    'borderRight'		=> 'double',
                    'borderBottom'		=> 'double',

				);
$col_2_3 = array( 	'value' 			=> '1 Grueso', 
					'backgroundColor' 	=> 'ffffff',
					'borderRight'		=> 'double',
				);

$col_3_2 = array( 	'value' 			=> 'D (Óxidos globulares)', 
					'backgroundColor' 	=> 'ffffff',
					'cellMargin'		=> 100,
					'borderBottom'		=> 'double',
					'borderRight'		=> 'double',
				);
$col_3_3 = array( 	'value' 			=> '2 Grueso', 
					'backgroundColor' 	=> 'ffffff',
					'borderRight'		=> 'double',
					'borderBottom'		=> 'double',
				);


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
				

$col1_1 = array(	'rowspan' 			=> 2,
                    'value' 			=> 'ID ITEM',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
                    'borderRight'		=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
					'width'				=> 100,
				);
$col1_2 = array( 	'value' 			=> 'Dimensiones (mm)', 
                    'bold'				=> true,
                    'backgroundColor' 	=> 'eeeeee',
					'borderTop'			=> 'double',
                    'borderRight'		=> 'double',
					'cellMargin'		=> 100,
				);
$col2_1 = array( 	
                    'value' 			=> 'Espesor', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					// 'borderTop'			=> 'single',
					'borderRight'		=> 'double',
					'cellMargin'		=> 100,
				);
$col2_2 = array( 	'value' 			=> 'Espesor', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'single',
					'borderRight'		=> 'double',
					'cellMargin'		=> 100,
				);
				
$valuesTr = array(	array($col1_1, $col1_2),
                    array($col2_2),
					array($col_2_1, $col_2_2),
);
$docx->addTable($valuesTr, $options, $trProperties);

$link->close();

			
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>