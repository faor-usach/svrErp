<?php
header('Content-Type: text/html; charset=iso-8859-1');

$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
			);

include_once("conexion.php");
require_once '../phpdocx/classes/CreateDocx.inc';

$CodInforme = $_GET['CodInforme'];
$tEns 		= $_GET['tEnsayo'];
$vDir 		= $_GET['Direccion'];

$link=Conectarse();
$bdInf=mysql_query("SELECT * FROM amInformes Where CodInforme = '".$CodInforme."'");
if($rowInf=mysql_fetch_array($bdInf)){
	$fechaRecepcion	= $rowInf['fechaRecepcion'];
	$fd = explode('-',$fechaRecepcion);
	$fechaRecepcion	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	$fechaHoy 		= date('Y-m-d');
	$fd = explode('-',$fechaHoy);
	$fechaEmision	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	$TipoMuestra 	= $rowInf['tipoMuestra'];
	$nMuestras		= $rowInf['nMuestras'];

	$fd = explode('-',$fechaHoy);
	$fechaInforme 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	$Rev 			= 0;
	
	$bdTe = mysql_query("SELECT * FROM amTpEnsayo Where tpEnsayo = '".$rowInf['tpEnsayo']."'");
	if($rowTe=mysql_fetch_array($bdTe)){
		$Ensayo = $rowTe['Ensayo'];
	}
		
	$bdCli = mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowInf['RutCli']."'");
	if($rowCli=mysql_fetch_array($bdCli)){
		$Cliente 	= $rowCli['Cliente'];
		$Direccion 	= $rowCli['Direccion'];
	}	

	$bdCon = mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowInf['RutCli']."' and nContacto = '".$rowInf['nContacto']."'");
	if($rowCon=mysql_fetch_array($bdCli)){
		$Contacto 	= $rowCon['Contacto'];
	}	
}
//mysql_close($link);

$docx = new CreateDocx();
 
//set the default language to Spanish using standard ISO codes
$docx->setLanguage('es-ES');
//add a couple of paragraphs, one in spanish and the other in English
//$docx->addText("Este texto está en español y no debería estar marcado si se utiliza el corrector ortográfico.");
//whenever you start editing the file the following text will be underline by the spell checker.
//$docx->addText('Now in english.');

$Dire = mb_convert_encoding($Direccion,"UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
$vDir = iconv("UTF-8", "ISO-8859-1", $Direccion);

$docx->modifyPageLayout('letter');
$docx = new CreateDocxFromTemplate('plantilla.docx');

$options = array(
				'target' 		=> 'header',
				'firstMatch' 	=> false,
				);
$docx->replaceVariableByText(array(
									'CODINFORME' 	=> $CodInforme,
									'CLIENTE' 		=> $Cliente,
									'FECHAINF' 		=> $fechaInforme,
									'REV' 			=> $Rev,
									), $options);

$docx->replaceVariableByText(array(
									'Clientes' 		=> $Cliente,
									'Direccion' 	=> $vDir,
									'TipoMuestra' 	=> $TipoMuestra,
									'Cantidad' 		=> $nMuestras,
									'TipoEnsayo' 	=> $tEns,
									'Solicitante' 	=> $Contacto,
									'Rec' 			=> $fechaRecepcion,
									'Emi' 			=> $fechaEmision,
									));


$paragraphOptions = array(
							'rtl' 	=> true,
							'font' 	=> 'Arial'
						);

$text = 'Dirección';
//$docx->addText($Direccion);

$tit = 'INFORME DE RESULTADOS';
$colImg = array( 	'rowspan' 			=> 3,
					'value' 			=> 'Simet',
					'borderColor' 		=> 'cccccc',
					'border' 			=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colTit = array( 	'rowspan' 			=> 1,
					'value' 			=> $Cliente,
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderBottom' 		=> 'none',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colAM = array( 	'rowspan' 			=> 1,
					'value' 			=> 'AM-1000',
					'borderColor' 		=> 'cccccc',
					'border' 			=> 'none',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colEmp = array( 	'rowspan' 			=> 1,
					'value' 			=> 'CESMEC',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'none',
					'borderBottom' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colFec = array( 	'rowspan' 			=> 1,
					'value' 			=> 'Fecha:',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colRev = array( 	'rowspan' 			=> 1,
					'value' 			=> 'Revision: 00',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colPag = array( 	'rowspan' 			=> 1,
					'value' 			=> 'Pagina: 1 de 1',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
				
//set teh global table properties
$options = array(	'columnWidths' 		=> array(2000, 3500, 3200),
				);

$values = array( 	array($colImg, $colTit, $colFec),
					array($colAM,  $colRev),
					array($colEmp, $colPag),
				);

				
$docx->addTable($values, $options);

$html='<p>'.$Direccion.'</p>';
 
$docx->embedHTML($html);

$docx->createDocxAndDownload($CodInforme);
?>
