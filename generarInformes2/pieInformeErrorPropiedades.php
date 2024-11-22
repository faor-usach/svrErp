<?php
//****************************************************************************
//Tabla Pie Informe
//****************************************************************************
$link=Conectarse();
$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = '".$ingResponsable."'");
if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
	$fusr 		= $rowUsuarios['firmaUsr'];
	$ingResp 	= $rowUsuarios['usuario'];
	$carResp 	= $rowUsuarios['cargoUsr'];
}
$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = '".$cooResponsable."'");
if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
	$fusc 		= $rowUsuarios['firmaUsr'];
	$ingCoo 	= $rowUsuarios['usuario'];
	$carCoo 	= $rowUsuarios['cargoUsr'];
}
$bdUsuarios=$link->query("SELECT * FROM Usuarios Where usr = 'Alfredo.Artigas'");
if($rowUsuarios=mysqli_fetch_array($bdUsuarios)){
	$fjefe 		= $rowUsuarios['firmaUsr'];
	$idjefe 	= $rowUsuarios['usuario'];
	$carjefe 	= $rowUsuarios['cargoUsr'];
}
$link->close();
/*
$img = '../ft/timSim.png';
$options = array(
					'src' 			=> $img,
					'imageAlign' 	=> 'center',
					'scaling' 		=> 100,
					'spacingTop' 	=> 0,
					'spacingBottom' => 0,
					'spacingLeft' 	=> 0,
					'spacingRight'	=> 0,
					'textWrap' 		=> 0,
					//'float' => right,
					'height'		=> 185.19685,
					'width'			=> 185.19685,

					//'borderStyle' => 'lgDash',
					//'borderWidth' => 6,
					//'borderColor' => 'FF0000',
				);
$docx->addImage($options);



$timbre = new WordFragment($docx);
$options = array(
    'src' 		=> '../ft/timSim.png',
	'height'	=> 100,
	'width'		=> 100,
);
$docx->addImage($options);
*/


$firma1 = new WordFragment($docx);
$options = array(
	'src' => '../ft/'.$fusr,
	'height'	=> 100,
	'width'		=> 140,
);
$firma1->addImage($options);

$firma2 = new WordFragment($docx);
$options = array(
	'src' => '../ft/'.$fusc,
	'height'	=> 100,
	'width'		=> 140,
	'imageAlign' 	=> 'center',
);
$firma2->addImage($options);

$image = new WordFragment($docx);
$options = array(
    'src' => '../ft/timSim.png',
	'height'	=> 135,
	'width'		=> 135,
	'imageAlign' 	=> 'center',
);
$image->addImage($options);


$col_1_1 = array( 	'value' 			=> $firma1, 
					'textAlign'			=> 'center',
					'tableAlign' 		=> 'center',
				);
$col_1_2 = array( 	'rowspan' 			=> 5,
					'value' 			=> $image, 
					'textAlign'			=> 'center',
				);
$col_1_3 = array( 	'value' 			=> $firma2, 
					'textAlign'			=> 'center',
					'tableAlign' 		=> 'center',
				);

$col_2_1 = array(	 
					'value' 			=> '____________________', // Dato
					'bold'				=> true,
				);
				
$col_2_3 = array( 	'value' 			=> '____________________',
					'bold'				=> true,
					'textAlign'			=> 'center',
				);
				
$col_3_1 = array( 	'value' 			=> $ingResp, 
					'textAlign'			=> 'center',
					'fontSize' 			=> 7,
					'bold'				=> true,
				);
				
$col_3_3 = array( 	'value' 			=> $ingCoo, 
					'bold'				=> true,
					'fontSize' 			=> 7,
					'textAlign'			=> 'center',
				);
$col_4_1 = array( 	'value' 			=> $carResp, 
				'bold'				=> true,
				'fontSize' 			=> 7,
				'textAlign'			=> 'center',
			);
			
$col_4_3 = array( 	'value' 			=> $carCoo, 
				'bold'				=> true,
				'fontSize' 			=> 7,
				'textAlign'			=> 'center',
			);

$col_5_1 = array( 	'value' 			=> 'Laboratorio SIMET-USACH', 
				'bold'				=> true,
				'fontSize' 			=> 7,
				'textAlign'			=> 'center',
			);
			
$col_5_3 = array( 	'value' 			=> 'Laboratorio SIMET-USACH',  
				'bold'				=> true,
				'fontSize' 			=> 7,
				'textAlign'			=> 'center',
			);
$options = array(	//'columnWidths' 		=> array(10000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000), 
				'borderWidth' 		=> 1, 
				//'float' 			=> array('align' 	=> 'center'	),
				'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
				//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 10000),
				'imageAlign' 	=> 'center',
				'tableAlign' 		=> 'center',
				'textAlign'			=> 'center',
				'textProperties' 	=> array('bold' 	=> true, 'font' => 'Arial', 'fontSize' => 7, 'textAlign' => 'center'),
);

$trProperties = array();
$trProperties[0] = array(	'minHeight' 	=> 100, 
							'width'			=> 50000,
						);
			
$values = array(	array($col_1_1, $col_1_2, $col_1_3),
				array($col_2_1, $col_2_3),
				array($col_3_1, $col_3_3),
				array($col_4_1, $col_4_3),
				array($col_5_1, $col_5_3),
			);
			
$docx->addTable($values, $options, $trProperties);
$docx->addText($textSpace, $espacioOpcion);


$firmaJefe = '../ft/'.$fjefe;
$options = array(
					'src' 			=> $firmaJefe,
					'imageAlign' 	=> 'center',
					'height'	=> 100,
					'width'		=> 140,
									//'height'		=> 132.4,
					//'width'			=> 132.4,
					'spacingTop' 	=> 0,
					'spacingBottom' => 0,
					'spacingLeft' 	=> 0,
					'spacingRight'	=> 0,
					'textWrap' 		=> 0,
					//'borderStyle' => 'lgDash',
					//'borderWidth' => 6,
					//'borderColor' => 'FF0000',
				);
$docx->addImage($options);

$text = array(); 
$text[] = array( 'text' => '___________________________' ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 7,
							'textAlign'	=> 'center',
						);
$docx->addText($text, $paragraphOptions);

$text = array(); 
$text[] = array( 'text' => $idjefe ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'bold'		=> true,
							'fontSize'	=> 7,
							'textAlign'	=> 'center',
						);
$docx->addText($text, $paragraphOptions);

$text = array(); 
$text[] = array( 'text' => $carjefe ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'bold'		=> true,
							'fontSize'	=> 7,
							'textAlign'	=> 'center',
						);
$docx->addText($text, $paragraphOptions);

$text = array(); 
$text[] = array( 'text' => 'Laboratorio SIMET-USACH', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 7,
							'textAlign'	=> 'center',
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Es de responsabilidad del receptor verificar la veracidad de este informe y que corresponda a la última revisión, mediante el código QR o en nuestra página Web.', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 7,
							'textAlign'	=> 'both',
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$link = new WordFragment($docx);
$text = array(); 
$linkOptions = array(	'url'=> 'http://simet.cl/verificacioninforme.php',
						'color' => 'B70000',
						'font'	=> 'Arial',
						'fontSize'	=> 7,
						'underline' => 'none'
					);
$link->addLink('http://simet.cl/verificacioninforme.php', array('url'=> 'http://simet.cl/verificacioninforme.php'), $linkOptions);

$text = array();
$text[] = array('text' => 'Verificación de este documento en ', 'bold' => true);
$text[] = $link;
$text[] = array('text' => ', ingresando el número de informe y el código verificador.', 'bold' => true);
//$text[] = array( 'text' => 'Verificación de este documento en http://simet.cl/verificacioninforme.php, ingresando el número de informe y el código verificador.', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 7,
							'textAlign'	=> 'both',
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Código de Verificación: '.$CodigoVerificacion, 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 7,
							'textAlign'	=> 'left',
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

//$imgQR = '';


if($imgQR){
	$imgQR = '../codigoqr/phpqrcode/temp/'.$imgQR;
	if(file_exists($imgQR)){
		$options = array(
							'src' 			=> $imgQR,
							'imageAlign' 	=> 'right',
							'height'		=> 132.4,
							'width'			=> 132.4,
							'spacingTop' 	=> 0,
							'spacingBottom' => 0,
							'spacingLeft' 	=> 0,
							'spacingRight'	=> 0,
							'textWrap' 		=> 0,
							//'borderStyle' => 'lgDash',
							//'borderWidth' => 6,
							//'borderColor' => 'FF0000',
						);
		$docx->addImage($options);
	}
}





//****************************************************************************
//Tabla PIE INFORME
//****************************************************************************
?>