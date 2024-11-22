<?php
//****************************************************************************
//Tabla Químicos Acero
//****************************************************************************
header('Content-Type: text/html; charset=utf-8');
include_once("../conexionli.php");
require_once '../phpdocx/classes/CreateDocx.inc';
$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter');
$docx = new CreateDocxFromTemplate('plantillaINFORMES.docx');

			$espacioOpcionTablas = array(
											'font' 				=> 'Arial',
											'fontSize'			=> 10,
											//'lineSpacing'		=> 100,
											);
			$textSpace = '';

$CodInforme = 'AM-10104-0101';
$link=Conectarse();
$bdEns=$link->query("SELECT * FROM amEnsayos Where Status = 'on' Order By nEns");
if($rowEns=mysqli_fetch_array($bdEns)){
	do{
		$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."' Order By Otam";
		$bdOtam=$link->query($SQL);
		if($rowOtam=mysqli_fetch_array($bdOtam)){
			do{
				$trProperties = array();
				$trProperties[0] = array(	'minHeight' 	=> 100, 
											'tableHeader' 	=> false,
											'font' 			=> 'Arial',
											'fontSize' 		=> 9,
											//'border'		=> 'double',
										);
				$trProperties[0] = array(	'minHeight' 	=> 100, 
											'width'			=> 50000,
										);
										
				$col_1_1 = array( 	'value' 			=> 'ID ITEM', 
									'backgroundColor' 	=> 'eeeeee',
									'borderTop'			=> 'double',
									'borderLeft'		=> 'double',
									'cellMargin'		=> 100,
								);
				$col_1_2 = array( 	'value' 			=> '%C', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_3 = array( 	'value' 			=> '%Si', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_4 = array( 	'value' 			=> '%Mn', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_5 = array( 	'value' 			=> '%P', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_6 = array( 	'value' 			=> '%S', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_7 = array( 	'value' 			=> '%Cr', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_8 = array( 	'value' 			=> '%Ni', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_9 = array( 	'value' 			=> '%Mo', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_10 = array( 	'value' 			=> '%Ai', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRightColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
								);
				$col_1_11 = array( 	'value' 			=> '%Cu', 
									'backgroundColor' 	=> 'eeeeee',
									'borderLeftColor'	=> 'eeeeee',
									'borderTop'			=> 'double',
									'borderRight'		=> 'double',
								);
								
								
				$col_3_2 = array( 	'value' 			=> '%Co', 
									'backgroundColor' 	=> 'eeeeee',
									'cellMargin'		=> 100,
								);
				$col_3_3 = array( 	'value' 			=> '%Ti', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_4 = array( 	'value' 			=> '%Nb', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_5 = array( 	'value' 			=> '%V', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_6 = array( 	'value' 			=> '%W', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_7 = array( 	'value' 			=> '%Sn', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_8 = array( 	'value' 			=> '%B', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_9 = array( 	'value' 			=> '-', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_10 = array( 	'value' 			=> '-', 
									'backgroundColor' 	=> 'eeeeee',
								);
				$col_3_11 = array( 	'value' 			=> '%Fe', 
									'backgroundColor' 	=> 'eeeeee',
									'borderRight'		=> 'double',
								);

				$col_2_1 = array(	'rowspan' 			=> 3, 
									'value' 			=> $rowOtam['Otam'], // Dato
									'bold'				=> true,
									'borderLeft'		=> 'double',
									'vAlign' 			=> 'center',
									'borderBottom'		=> 'double',
								);

				$options = array(	//'columnWidths' 		=> array(950,720,720,720,720,720,720,720,720,720,720), 
									'borderWidth' 		=> 0, 
									'float' 			=> array('align' 	=> 'center'	),
									'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
									'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
								);
								
				$values = array(	array($col_1_1, $col_1_2, $col_1_3, $col_1_4, $col_1_5, $col_1_6, $col_1_7, $col_1_8, $col_1_9, $col_1_10, $col_1_11),
									array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7, $col_2_8, $col_2_9, $col_2_10, $col_2_11),
									array($col_3_2, $col_3_3, $col_3_4, $col_3_5, $col_3_6, $col_3_7, $col_3_8, $col_3_9, $col_3_10, $col_3_11),
									array($col_4_2, $col_4_3, $col_4_4, $col_4_5, $col_4_6, $col_4_7, $col_4_8, $col_4_9, $col_4_10, $col_4_11),
								);
				
				$docx->addTable($values, $options, $trProperties);
				//$docx->addTable($values, $options);
				$docx->addText($textSpace, $espacioOpcionTablas);
			}while($rowOtam=mysqli_fetch_array($bdOtam));
		}
	}while($rowEns=mysqli_fetch_array($bdEns));
}
$link->close();

$html = '<h1 style="color: #b70000">An embedHTML() example</h1>';
$html .= '<p>We draw a table with border and rawspans and colspans:</p>';
$html .= '<table border="1" style="border-collapse: collapse">
<tbody>
<tr>
<td style="background-color: yellow">1_1</td>
<td rowspan="3" colspan="2">1_2</td>
</tr>
<tr>
<td>Some random text.</td>
</tr>
<tr>
<td>
<ul>
<li>One</li>
<li>Two <b>and a half</b></li>
</ul>
</td>
</tr>
<tr>
<td>3_2</td>
<td>3_3</td>
<td>3_3</td>
</tr>
</tbody>
</table>';

$docx->embedHTML($html);

$informe = $CodInforme;
$docx->createDocxAndDownload($informe);

//****************************************************************************
//Tabla Químicos Acero FIN TABLA
//****************************************************************************
?>