<?php
	header ('Content-type: text/html; charset=utf-8'); 
	require_once('../../fpdf/fpdf.php');
    include_once("../../conexionli.php");

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('../../imagenes/logonewsimet.jpg',10,02,50);
    //$this->Image('../../imagenes/cintaceleste.png',0,47,220,250);
    $this->SetFont('Arial','',15);
    $this->Ln(10);
}

// Pie de página
function Footer()
{
	$this->SetTextColor(200, 200, 200);
    $this->SetFont('Arial','',12);
    //$this->Image('../../gastos/logos/logousach.png',195,250,15,23);

    $this->SetXY(112, -27);
    $this->Cell(0,4,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,0);
    $this->SetFont('Arial','',10);
    $this->SetXY(130, -23);
    $this->Cell(0,4, utf8_decode('Departamento de Ingeniería Metalúrgia'),0,0);
    $this->SetXY(108, -19);
    $this->Cell(0,4,utf8_decode('Laboratorio de Ensayos e Investigación de Materiales'),0,0);
    $this->SetXY(108, -14);
    $this->Cell(0,4,utf8_decode('Av. Ecuador 3769, Estación Central - Santiago - Chile'),0,0);
    $this->SetXY(10, -10);
    $this->Cell(0,4,utf8_decode('Reg. 0201 V.05'),0,0);
    $this->SetXY(95, -10);
    $this->Cell(0,4,utf8_decode('Fono:(+569)23234780, Email: simet@usach.cl / www.simet.cl'),0,0);

}
}





$NombreFormulario = "CAM.pdf";
//$pdf->Output($NombreFormulario,'D'); //Para Descarga
//$pdf->Output($NombreFormulario,'I'); //Muestra en el Navegador
$pdf->Output($NombreFormulario,'F'); //Guarda en un Fichero
$pdf->Output($NombreFormulario,'D'); //Para Descarga
//copy($NombreFormulario, 'Y://AAA/Archivador-2020/CAMs/'.$NombreFormulario);
//unlink($NombreFormulario);
//$pdf->Output();
?>
