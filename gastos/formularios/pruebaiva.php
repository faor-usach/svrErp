<?php
require('../../fpdf/fpdf.php');

$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40);
$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,10,'FORMULARIO 3B',1,0,'C');
$pdf->Cell(130,10,'SOLICITUD DE REEMBOLSO',1,0,'L');
$pdf->Ln(13);
$pdf->SetFont('Arial','',7);

$pdf->Cell(70,5,'FECHA:',0,0);
//$pdf->Cell(2,5,':',0,0);
$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

$pdf->Ln(5);
$pdf->Cell(70,5,'DE:',0,0);
//$pdf->Cell(2,5,':',0,0);
$pdf->Cell(110,5,'SEÑOR CRISTIAN VARGAS RIQUELME (Jefe Centro de Costo)',0,0);

$pdf->Ln(5);
$pdf->Cell(70,5,'A:',0,0);
//$pdf->Cell(2,5,':',0,0);
$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

$pdf->Ln(5);
$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
//$pdf->Cell(2,5,':',0,0);

$pdf->SetFont('Arial','',7);

$pdf->Ln(10);
$pdf->Cell(70,5,'La relación de gastos es la siguiente::',0,0);
//$pdf->Cell(2,5,':',0,0);

$pdf->SetFont('Arial','B',8);
$pdf->Ln(5);
$pdf->Cell(50,17,'Proveedor',1,0,'C');
$pdf->Cell(16,17,'N° Factura',1,0,'C');
$pdf->Cell(17,17,'Fecha',1,0,'C');
$pdf->Cell(60,17,'Bien o Servicio Adquirido',1,0,'C');
$pdf->Cell(15,17,'Neto',1,0,'C');
$pdf->Cell(15,17,'IVA',1,0,'C');
$pdf->Cell(15,17,'Bruto',1,0,'C');
$pdf->Ln(2);
$pdf->Cell(50,18,'',0,0,'C');
$pdf->Cell(16,18,'o Boleta',0,0,'C');
$pdf->Cell(17,18,'Factura o',0,0,'C');
$pdf->Ln(2);
$pdf->Cell(50,20,'',0,0,'C');
$pdf->Cell(16,20,'',0,0,'C');
$pdf->Cell(17,20,'o Boleta',0,0,'C');

// Inicio Linea de Detalle
$pdf->Ln(13);
$pdf->Cell(50,5,'Petrobras',1,0);
$pdf->Cell(16,5,'100',1,0,'R');
$pdf->Cell(17,5,'11/06/2013',1,0,'C');
$pdf->Cell(60,5,'Bencina',1,0);
$pdf->Cell(15,5,'1.300.000',1,0,'R');
$pdf->Cell(15,5,'1.300.000',1,0,'R');
$pdf->Cell(15,5,'1.300.000',1,0,'R');

$pdf->Ln(5);
$pdf->Cell(50,5,'Enrique Paolo Sepulveda Herrera',1,0);
$pdf->Cell(16,5,'100',1,0,'R');
$pdf->Cell(17,5,'11/06/2013',1,0,'C');
$pdf->Cell(60,5,'Grata rueda, grata copa',1,0);
$pdf->Cell(15,5,'300.000',1,0,'R');
$pdf->Cell(15,5,'300.000',1,0,'R');
$pdf->Cell(15,5,'300.000',1,0,'R');

// Termino Linea de Detalle

// Linea Total
$pdf->Ln(5);
$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(16,5,'',0,0,'C');
$pdf->Cell(17,5,'',0,0,'C');
$pdf->Cell(60,5,'TOTAL',0,0,'R');
$pdf->Cell(15,5,'1.300.000',1,0,'R');
$pdf->Cell(15,5,'1.300.000',1,0,'R');
$pdf->Cell(15,5,'1.300.000',1,0,'R');

// Line(Col, FilaDesde, ColHasta, FilaHasta) 
$pdf->Line(20, 258, 90, 258);
$pdf->SetXY(20,259);
//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
$pdf->Cell(70,5,"Alfredo Artigas",0,0,"C");

$pdf->Line(120, 258, 190, 258);
$pdf->SetXY(120,259);
$pdf->Cell(70,5,"Alfredo Artigas",0,0,"C");


//$pdf->Output('F3B-00001','D'); //Para Descarga
$pdf->Output('F3B-00001','I');
?> 