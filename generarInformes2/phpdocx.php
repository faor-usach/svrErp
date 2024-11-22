<?php
require_once '../phpdocx/classes/CreateDocx.php';

$docx = new CreateDocx();
$docx->addText('Hello world!');
$docx->createDocx('hello_world'); 




$valuesTable = array(
    array(
        11,12,13,14
    ),
    array(
        21,22,23,24
    ),
    array(
        31,32,33,34
    ),
);
$paramsTable = array(
    'border' => 'single',
    'tableAlign' => 'center',
    'borderWidth' => 10,
    'borderColor' => 'B70000',
    'textProperties' => array('bold' => true, 'font' => 'Algerian', 'fontSize' => 18),
    'tableLayout' => 'autofit', // this is the default value
    'tableWidth' => array('type' =>'pct', 'value' => 50),
);
$docx->addTable($valuesTable, $paramsTable);




$informe = 'informe';
$docx->createDocxAndDownload($informe);

?>