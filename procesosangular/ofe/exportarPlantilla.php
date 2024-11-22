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

include_once("../../conexionli.php");
require_once '../../phpdocx/classes/CreateDocx.php';

$version='Old';
$CAM = $_GET['CAM'];
$version = $_GET['version']; 

$link=Conectarse();
$bdCAM=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."'");
if($rowCAM=mysqli_fetch_array($bdCAM)){
	$fechaHoy 		= date('Y-m-d');
	$fd = explode('-',$fechaHoy);
	$fechaEmision	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	//$TipoMuestra 	= $rowInf['tipoMuestra'];
	//$nMuestras		= $rowInf['nMuestras'];

	$NetoUF			= $rowCAM['NetoUF'];
	$Validez		= $rowCAM['Validez'];
	$dHabiles		= $rowCAM['dHabiles'];
	//if($rowInf['fechaInforme']){
	//	$fd = explode('-',$rowInf['fechaInforme']);
	//}
	$fechaInforme 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	
	$Rev 			= 00;
	
	$bdCli = $link->query("SELECT * FROM Clientes Where RutCli = '".$rowCAM['RutCli']."'");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$Cliente 	= $rowCli['Cliente'];
		$Direccion 	= $rowCli['Direccion'];
		$RutCli		= $rowCli['RutCli'];
	}	
	$bdtpInf = $link->query("SELECT * FROM amtpensayo Where tpEnsayo = '".$rowCAM['tpEnsayo']."'");
	if($rsInf=mysqli_fetch_array($bdtpInf)){
		$tpInforme 	= $rsInf['Ensayo'];
	}	

	$bdCon = $link->query("SELECT * FROM contactoscli Where RutCli = '".$rowCAM['RutCli']."' and nContacto = '".$rowCAM['nContacto']."'");
	if($rowCon=mysqli_fetch_array($bdCon)){
		$Contacto 	= $rowCon['Contacto'];
		$Email 		= $rowCon['Email'];
	}	

	$bdPro = $link->query("SELECT * FROM propuestaeconomica Where OFE = '".$rowCAM['CAM']."'");
	if($rowPro=mysqli_fetch_array($bdPro)){
		$tituloOferta 		= $rowPro['tituloOferta'];
		//$firmaUsr = $rowPro['usrElaborado'];
		$bdUsr = $link->query("SELECT * FROM usuarios Where usr = '".$rowPro['usrElaborado']."'");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			$Elaborado	= $rowUsr['usuario'];
			$cargoUsr	= $rowUsr['cargoUsr'];
			$firmaUsr	= $rowUsr['firmaUsr'];
		}	
		$Revisado = '';
		$bdUsr = $link->query("SELECT * FROM usuarios Where usr = '".$rowPro['usrAprobado']."'");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			$Revisado	= $rowUsr['usuario'];
		}	
		$fechaElaboracion	= $rowPro['fechaElaboracion'];
		$fd = explode('-',$fechaElaboracion);
		$fechaElaboracion	= $fd[2].'-'.$fd[1].'-'.$fd[0];
		$fechaAprobacion	= $rowPro['fechaAprobacion'];
		$fd = explode('-',$fechaAprobacion);
		$fechaAprobacion	= $fd[2].'-'.$fd[1].'-'.$fd[0];
		$objetivoGral		= $rowPro['objetivoGeneral'];
	}	

}
$link->close();

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter');
$version = 'New';
if($version=='Old'){
	$docx = new CreateDocxFromTemplate('plantillaOFECAM.docx');
}
if($version=='New'){
	$docx = new CreateDocxFromTemplate('OfertaEconomica.docx');
}

$options = array(
				'target' 		=> 'header',
				'firstMatch' 	=> false,
				);
$docx->replaceVariableByText(array(
									'CODOFE' 		=> 'OFE-'.$CAM,
									'TPINFORME' 	=> strtoupper($tpInforme),
									'CLIENTE' 		=> $Cliente,
									'FECHAINF' 		=> $fechaInforme,
									'REV' 			=> $Rev,
									), $options);

$imgFirma = '../../ft/'.$firmaUsr;							

$image = new WordFragment($docx, 'document');
//$image->addImage(array('src' => $imgFirma , 'scaling' => 100, 'float' => 'right', 'textWrap' => 1));

$docx->replaceVariableByWordFragment(array('Firma' => $image), array('type' => 'block'));

$docx->replaceVariableByText(array(
									'Clientes' 			=> $Cliente,
									'Direccion' 		=> $Direccion,
									'RutCli' 			=> $RutCli,
									'Email' 			=> $Email,
									'OfertaEconomica' 	=> $tituloOferta,
									'Atencion' 			=> $Contacto,
									'Ofe' 				=> $CAM,
									'Elaborado'			=> $Elaborado,
									'Cargo'				=> $cargoUsr,
									'NetoUF'			=> $NetoUF,
									'Validez'			=> $Validez,
									'dHabiles'			=> $dHabiles,
									'Revisado'			=> $Revisado,
									'fechaElaboracion'	=> $fechaElaboracion,
									'fechaEmision'		=> $fechaEmision,
									'fechaAprobacion'	=> $fechaAprobacion,
									'ObjetivoGeneral'	=> $objetivoGral,
								)
							);


$multiline = '';
/*
$i = 0;
$link=Conectarse();
$bdObj=$link->query("SELECT * FROM objetivospropuestas where OFE = '".$CAM."' Order By nObjetivo");
while($rowObj=mysqli_fetch_array($bdObj)){
		$i++;
		if($i == 1){
			$letra = 'a';
			$multiline = $letra.') '.$rowObj['Objetivos'].'\n';
		}else{
			$letra++;
			$multiline .= $letra.') '.$rowObj['Objetivos'].'\n';
		}
}
$link->close();
*/
$options = array('parseLineBreaks' =>true);
$docx->replaceVariableByText(array(
									'ObjetivoEspecifico'=> $multiline,
								), $options
							);
					
							
$vocales = array('á', 'é', 'í', 'ó','ú','ñ','Ñ');
$vAcute  = array('&aacute;', '&eacute;', '&iacute;', '&oacute;','&uacute;','&ntilde;','&Ntilde;');

/* */
$nEnsayo 	= 0;					
$letra 		= 'a';
$txtObj		= '';
$Objetivos 	= '';

$link=Conectarse();
// Revisar Tidy

$bdObj=$link->query("SELECT * FROM objetivospropuestas where OFE = '".$CAM."' Order By nObjetivo");
while($rowObj=mysqli_fetch_array($bdObj)){
		$Objetivos = str_replace($vocales, $vAcute, $rowObj['Objetivos']);
		$txtObj .= '<div style="margin-left: 40px; text-align: justify; font-family: arial; font-size: 10;">'.$letra.') '.$Objetivos.'</div>';
}
$link->close();
/*
Este no funciona
$docx->replaceVariableByHTML('ObjetivoEspecifico', 'block', $txtObj, array('parseDivsAsPs' => true));
*/
/* */




$multi = '';
$nEnsayo = 0;
$letra = 'a';
$link=Conectarse();
$bdEns=$link->query("SELECT * FROM ensayosofe Where OFE = '".$CAM."' Order By nDescEnsayo"); 
while($rowEns=mysqli_fetch_array($bdEns)){
		$nEnsayo++;
		$SQL = "SELECT * FROM ofensayos Where nDescEnsayo = '".$rowEns['nDescEnsayo']."'";
		//$multi = $SQL;
		$bdIe=$link->query($SQL);
		if($rowIe=mysqli_fetch_array($bdIe)){
			if($nEnsayo == 1){
				$multi  = '2.3.'.$nEnsayo.'.- '.$rowIe['nomEnsayo'].': ';
				$multi  .= $rowIe['Descripcion'].'\n';
			}else{
				$multi .= '2.3.'.$nEnsayo.'.- '.$rowIe['nomEnsayo'].': ';
				$multi .= $rowIe['Descripcion'].'\n';
			}
		}
}
$link->close();
$options = array('parseLineBreaks' =>true);
$docx->replaceVariableByText(array(
									'tabla'=> $multi,
								), $options
							);


/*							
$nEnsayo = 0;					
$link=Conectarse();
$bdEns=$link->query("SELECT * FROM ensayosofe Where OFE = '".$CAM."' Order By nDescEnsayo");
while($rowEns=mysqli_fetch_array($bdEns)){
		$nEnsayo++;
		$bdIe=$link->query("SELECT * FROM ofensayos Where nDescEnsayo = '".$rowEns['nDescEnsayo']."'");
		if($rowIe=mysqli_fetch_array($bdIe)){
			if($nEnsayo == 1){
				$Descripcion = str_replace($vocales, $vAcute, $rowIe['Descripcion']);
				$nomEnsayo 	 = str_replace($vocales, $vAcute, $rowIe['nomEnsayo']);
				$tt  = '<div style="margin-left: 46px; font-family: arial; font-size: 10; float:left; line-height: 1.5;">'.'<b>2.3.'.$nEnsayo.'.- '.$nomEnsayo.': </b></div>';
				$tt .= '<div style="margin-left: 86px; text-align: justify; font-family: arial; font-size: 10; line-height: 1.5;">'.$Descripcion.'</div>';
			}else{
				$Descripcion = str_replace($vocales, $vAcute, $rowIe['Descripcion']);
				$nomEnsayo 	 = str_replace($vocales, $vAcute, $rowIe['nomEnsayo']);
				$tt .= '<span>&nbsp;</span>';
				$tt .= '<div style="margin-left: 46px; font-family: arial; font-size: 10; float:left; line-height: 1.5;">'.'<b>2.3.'.$nEnsayo.'.- '.$nomEnsayo.': </b></div>';
				$tt .= '<div style="margin-left: 86px; text-align: justify; font-family: arial; font-size: 10; line-height: 1.5;">'.$Descripcion.'</div>';
				// Texto con sangria -> $tt .= '<div style="margin-left: 86px; text-indent: 60px; text-align: justify; font-family: arial; font-size: 10;">'.$Descripcion.'</div>';
				
			}
		}
}
$link->close();
*/

//$docx->replaceVariableByHTML('tabla', 'inline', $tt, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
//$docx->replaceVariableByHTML('tabla', 'block',$tt, array('parseDivsAsPs' => true));
							
$infOfe = "Ofe-".$CAM;
$docx->createDocxAndDownload($infOfe);
?>