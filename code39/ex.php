<?php
require('code39.php');

$pdf=new PDF_Code39();
$pdf->AddPage();
//$pdf->Code39(80,40,'780070008401',1,10);
$pdf->Code39(80,40,'78007000-T01',1,10);
$pdf->Output();
?>
