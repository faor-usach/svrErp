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
require_once '../phpdocx/classes/CreateDocx.php';
include("../conexionli.php");


$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter');

// list items
$itemList = array();
$html = '<ul style="font-family: arial; font-size: 10.5px; text-align: justify;">';
$link=Conectarse();
$bdNot=$link->query("SELECT * FROM amNotas Order By nNota Asc");
while($rowNot=mysqli_fetch_array($bdNot)){
    $paragraphOptions = array(
        'font' 		=> 'Arial',
        'fontSize'	=> 10,
        'textAlign'	=> 'left',
        'tab'	=> 5,
        'textAlign'	=> 'both'
    );

    $text = array(); 
    $text[] = array( 'text' => '* '.$rowNot['Nota'], 'bold' => true ); 
    $docx->addText($text, $paragraphOptions);

}
$link->close();




$informe = 'Informe';
$docx->createDocxAndDownload($informe);

?>