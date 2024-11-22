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
				$html = '<table cellpadding="0" cellspacing="0" width=99% style="border: 1px double #000; font-family: Arial; font-size: 12px; border-collapse: collapse;">
							<tr style="background-color: #eeeeee; text-align: center; font-weight: bold; height	:15px;">
								<td>ID <br>ITEM</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
							</tr>
							<tr style="text-align: center; height: 30px;">
								<td rowspan=3 style="font-weight: bold;">'.$rowOtam['Otam'].'</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
							</tr>
							<tr style="background-color: #eeeeee; text-align: center;">
								<td colspan=1>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
								<td>%C</td>
							</tr>
							<tr>
								<td colspan=1>2000</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
								<td>20</td>
							</tr>
						</table>';

				$docx->embedHTML($html);

			}while($rowOtam=mysqli_fetch_array($bdOtam));
		}
	}while($rowEns=mysqli_fetch_array($bdEns));
}
$link->close();


$informe = $CodInforme;
$docx->createDocxAndDownload($informe);

//****************************************************************************
//Tabla Químicos Acero FIN TABLA
//****************************************************************************
?>