<?php
header('Content-Type: text/html; charset=utf-8');

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
$tEnsayo 	= $_GET['Ensayo'];

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

	$fd = explode('-',$rowInf['fechaInforme']);
	$fechaInforme 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	$Rev 			= 00;
	
	$bdTe = mysql_query("SELECT * FROM amTpEnsayo Where tpEnsayo = '".$rowInf['tpEnsayo']."'");
	if($rowTe=mysql_fetch_array($bdTe)){
		//$Ensayo = $rowTe['Ensayo'];
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
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter');
$docx = new CreateDocxFromTemplate('plantillaEyP.docx');

$options = array(
				'target' 		=> 'header',
				'firstMatch' 	=> false,
				);
$docx->replaceVariableByText(array(
									'CODINFORME' 	=> $CodInforme,
									'CLIENTE' 		=> utf8_encode($Cliente),
									'FECHAINF' 		=> $fechaInforme,
									'REV' 			=> $Rev,
									), $options);

$docx->replaceVariableByText(array(
									'Clientes' 		=> utf8_encode($Cliente),
									'Direccion' 	=> $Direccion,
									'TipoMuestra' 	=> $TipoMuestra,
									'Cantidad' 		=> $nMuestras,
									'TipoEnsayo' 	=> $tEnsayo,
									'Solicitante' 	=> $Contacto,
									'Rec' 			=> $fechaRecepcion,
									'Emi' 			=> $fechaEmision,
									));


$docx->createDocxAndDownload($CodInforme);
?>
