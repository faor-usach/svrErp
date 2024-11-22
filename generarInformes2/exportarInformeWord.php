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

include_once("../conexionli.php");
require_once '../phpdocx/classes/CreateDocx.inc';

if(isset($_GET['CodInforme'])){ $CodInforme = $_GET['CodInforme']; };

$imgMuestra = '';
$link=Conectarse();
$bdInf=$link->query("SELECT * FROM amInformes Where CodInforme = '".$CodInforme."'");
if($rowInf=mysqli_fetch_array($bdInf)){
	$ingResponsable		= $rowInf['ingResponsable'];
	$cooResponsable		= $rowInf['cooResponsable'];
	$CodigoVerificacion = $rowInf['CodigoVerificacion'];
	$imgQR 				= $rowInf['imgQR'];
	$imgMuestra			= $rowInf['imgMuestra'];

	$fechaRecepcion	= $rowInf['fechaRecepcion'];
	$fd = explode('-',$fechaRecepcion);
	$fechaRecepcion	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	$fechaHoy 		= date('Y-m-d');
	$fd = explode('-',$fechaHoy);
	$fechaEmision	= $fd[2].'-'.$fd[1].'-'.$fd[0];

	$TipoMuestra 	= $rowInf['tipoMuestra'];
	$nMuestras		= $rowInf['nMuestras'];

	$bdTe=$link->query("SELECT * FROM tipoensayo Where tpEnsayo = '".$rowInf['tpEnsayo']."'");
	if($rowTe=mysqli_fetch_array($bdTe)){
		$TipoEnsayo = $rowTe['nomTipoEnsayo'];
	}

	$fd = explode('-',$rowInf['fechaInforme']);
	$fechaInforme 	= $fd[2].' de '.$Mes[intval($fd[1])].' de '.$fd[0];
	$Rev 			= 00;
	
	$fdRAM = explode('-', $CodInforme);
	$RAM = $fdRAM[1];
	$nContacto = 0;
	$bdCAM = $link->query("SELECT * FROM cotizaciones Where RAM = '".$RAM."'");
	if($rowCAM=mysqli_fetch_array($bdCAM)){
		$nContacto = $rowCAM['nContacto'];
	}
	
	$bdCli = $link->query("SELECT * FROM Clientes Where RutCli = '".$rowInf['RutCli']."'");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$Cliente 	= $rowCli['Cliente'];
		$CLIENTE 	= $rowCli['Cliente'];
		$Direccion 	= $rowCli['Direccion'];
		$RutCli		= $rowCli['RutCli'];
	}	

	$bdCon = $link->query("SELECT * FROM contactoscli Where RutCli = '".$rowInf['RutCli']."' and nContacto = '".$nContacto."'");
	if($rowCon=mysqli_fetch_array($bdCon)){
		$Contacto 	= $rowCon['Contacto'];
		$Email 		= $rowCon['Email'];
	}	

}
$link->close();

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter');
$docx = new CreateDocxFromTemplate('plantillaINFORMES.docx');
$Rev = 0;
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
									'TipoMuestra'		=> $TipoMuestra,
									'Cantidad'			=> $nMuestras,
									'TipoEnsayo'		=> $TipoEnsayo,
									'Rec'				=> $fechaRecepcion,
									'Contacto'			=> $Contacto,
									'Emi'				=> $fechaEmision,
								)
							);

$data = array(); 
$link=Conectarse();
$bdMue=$link->query("SELECT * FROM amMuestras Where CodInforme = '".$CodInforme."' Order By idItem");
if($rowMue=mysqli_fetch_array($bdMue)){
	do{
		$idMuestra = 'Se ha recibido una muestra, identificada por el cliente como: "'.$rowMue['idMuestra'].'".';
		$data[] = array( 	'ITEM' 		=> $rowMue['idItem'],
							'REFERENCE' => $idMuestra,
						);
	}while($rowMue=mysqli_fetch_array($bdMue));
}
$link->close();

$docx->replaceTableVariable($data);
$img = 'imgMuestras/muestraImg.jpg';

if($imgMuestra){
	$img = 'imgMuestras/'.$CodInforme.'/'.$imgMuestra;
}

$options = array(
					'src' 			=> $img,
					'imageAlign' 	=> 'center',
					'scaling' 		=> 100,
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

$espacioOpcion = array(
						'font' 				=> 'Arial',
						'fontSize'			=> 10,
						'lineSpacing'		=> 360,
						);
$textSpace = '';
$docx->addText($textSpace, $espacioOpcion);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'Figura A.1 ', 'bold' => true ); 
$text[] = array( 'text' => 'Imagen de las muestras recibidas.' ); 

$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'center'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$letraItem = 'A';
$idEnsayo = '';
$link=Conectarse();
$bdEns=$link->query("SELECT * FROM amEnsayos Where Status = 'on' Order By nEns");
if($rowEns=mysqli_fetch_array($bdEns)){
	do{
		$idItem = '';
		$n 		= 0;
		$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."'");
		if($rowTabEns=mysqli_fetch_array($bdTabEns)){
			$letraItem++;
			$tEnsayo = 'Ensayos ';
			if($rowOtam['idEnsayo'] == 'Qu'){
				$tEnsayo = 'Análisis ';
			}
			$text = array(); 
			$text[] = array( 'text' => $letraItem.'.- Resultado de '.$tEnsayo.$rowEns['Ensayo'], 'bold' => true ); 
			$paragraphOptions = array(
										'font' 		=> 'Arial',
										'fontSize'	=> 10,
										'textAlign'	=> 'left',
										'underline'	=> 'single'
									);
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);

			$n++;
			$text = array(); 
			$text[] = array( 'text' => 'En la tabla '.$letraItem.' '.$n.' se muestran los valores resultantes del análisis químico, obtenido mediante espectrometría de emisión óptica.' ); 
			$paragraphOptions = array(
										'font' 		=> 'Arial',
										'fontSize'	=> 10,
										'textAlign'	=> 'left'
									);
			$docx->addText($text, $paragraphOptions);
			$docx->addText($textSpace, $espacioOpcion);
			$espacioOpcionTablas = array(
											'font' 				=> 'Arial',
											'fontSize'			=> 10,
											//'lineSpacing'		=> 100,
											);
			$text = array(); 
			$text[] = array( 'text' => 'Tabla '.$letraItem.' '.$n, 'bold' => true ); 
			$text[] = array( 'text' => ' Resultados de '.$tEnsayo.$rowEns['Ensayo'] ); 
			$paragraphOptions = array(
										'font' 		=> 'Arial',
										'fontSize'	=> 9,
										'textAlign'	=> 'left'
									);
			$docx->addText($text, $paragraphOptions);
			//$docx->addBreak(array('type' => 'line'));							
			
			//$docx->addText($textSpace, $espacioOpcion);
			//$docx->addText($textSpace, $espacioOpcionTablas);
		}
/*		
		$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."' Order By idItem");
		if($rowTabEns=mysqli_fetch_array($bdTabEns)){
			do{
*/				
				//$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."' and idItem = '".$rowTabEns['idItem']."' Order By Otam";
				$SQL = "SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."' Order By Otam";
				$bdOtam=$link->query($SQL);
				//$bdOtam=$link->query("SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowEns['idEnsayo']."' Order By Otam");
				if($rowOtam=mysqli_fetch_array($bdOtam)){
					do{
						if($rowOtam['idEnsayo'] == 'Qu' and $rowOtam['tpMuestra'] == 'Ac'){
							require('expQuimicosAc.php');
						}
/*						
						if($rowOtam['idEnsayo'] == 'Qu' and $rowOtam['tpMuestra'] == 'Co'){
							//include('expQuimicosCo.php');
						}
						if($rowOtam['idEnsayo'] == 'Qu' and $rowOtam['tpMuestra'] == 'Al'){
							//include('expQuimicosAl.php');
						}
						if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Re'){
							include('expTraccionRe.php');
						}
*/						
						if($rowOtam['idEnsayo'] == 'Tr' and $rowOtam['tpMuestra'] == 'Pl'){
							include('expTraccionPl.php');
						}
					}while($rowOtam=mysqli_fetch_array($bdOtam));
				}
/*				
			}while($rowTabEns=mysqli_fetch_array($bdTabEns));
		}
*/		
	}while($rowEns=mysqli_fetch_array($bdEns));
}
$link->close();

$docx->addText($textSpace, $espacioOpcion);
$letraItem++;
$text = array(); 
$text[] = array( 'text' => $letraItem.'.- Observaciones:', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'underline'	=> 'single'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'No presenta.' ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'tab'		=> true
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$letraItem++;
$text = array(); 
$text[] = array( 'text' => $letraItem.'.- Comentarios:', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'underline'	=> 'single'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'No presenta.' ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'tab'		=> true
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);

$text = array(); 
$text[] = array( 'text' => 'NOTAS:', 'bold' => true ); 
$paragraphOptions = array(
							'font' 		=> 'Arial',
							'fontSize'	=> 10,
							'textAlign'	=> 'left',
							'underline'	=> 'single'
						);
$docx->addText($text, $paragraphOptions);
$docx->addText($textSpace, $espacioOpcion);
		
$latinListOptions = array();
$latinListOptions[0]['type'] 		= 'bullet';
$latinListOptions[0]['font'] 		= 'Font family: Arial';
$latinListOptions[0]['fontSize'] 	= 8;

// create the list style with name: latin
$docx->createListStyle('latin', $latinListOptions);

// list items
$itemList = array();
$link=Conectarse();
$bdNot=$link->query("SELECT * FROM amNotas Order By nNota Asc");
if($rowNot=mysqli_fetch_array($bdNot)){
	do{
		if($rowNot['idEnsayo']){
			$bdTabEns=$link->query("SELECT * FROM amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowNot['idEnsayo']."'");
			if($rowTabEns=mysqli_fetch_array($bdTabEns)){
				$itemList[] = $rowNot['Nota']; 
				if($rowNot['idEnsayo'] == 'Me'){
					$itemList[]	= $rowNot['Nota'];
				}
			}
		}else{
			$itemList[] = $rowNot['Nota']; 
		}
	}while($rowNot=mysqli_fetch_array($bdNot));
}
$link->close();

$options = array(
					'font' => 'Arial',
					'fontSize' => 8,
				);
$docx->addList($itemList, 1, $options);
$docx->addText($textSpace, $espacioOpcion);

//include('pieInforme.php');

$informe = $CodInforme;
$docx->createDocxAndDownload($informe);
?>