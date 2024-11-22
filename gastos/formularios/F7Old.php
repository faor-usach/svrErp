<?php
include_once('../conexion.php');
require('../../fpdf/fpdf.php');
$nInf 		= $_GET['nInforme'];
$nInforme 	= $_GET['nInforme'];
if(isset($_GET['Concepto'])){
	$Concepto = $_GET['Concepto'];
}
if(isset($_GET['Formulario'])){ 
	if($_GET['Formulario']=="F3B(Itau)"){ 
		$Formulario = "F3B1";
	}
	if($_GET['Formulario']=="F3B(AAA)"){ 
		$Formulario = "F3B2";
	}
	if($_GET['Formulario']=="F7"){ 
		$Formulario = "F7";
	}
}
$link=Conectarse();
$bdDep=mysql_query("SELECT * FROM Departamentos");
if ($rowDep=mysql_fetch_array($bdDep)){
	$NomDirector = $rowDep[NomDirector];
	$Cargo		 = $rowDep[Cargo];
}
mysql_close($link);

if($Formulario == "F3B1" || $Formulario == "F3B2"){
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('../logos/sdt.png',10,10,33,25);
	$pdf->Image('../logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInforme,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO '.substr($Formulario,1,2),1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'SOLICITUD DE REEMBOLSO',1,0,'L');
	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	
	$fd 	= explode('-', $_GET['Fecha']);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
	$pdf->Cell(110,5,$fd[0].'/'.$fd[1].'/'.$fd[2],0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SEÑOR '.strtoupper($NomDirector).' ('.$Cargo.')',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$link=Conectarse();
	$bdPr=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$_GET['IdProyecto']."'");
	if($row=mysql_fetch_array($bdPr)){
		$pdf->Cell(110,10,$row['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$_GET['IdProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'SE SOLICITA REEMBOLSO A NOMBRE DE:',0,0);
		//$pdf->Cell(2,5,':',0,0);

		// F3B(Itau) - IGT-1118 - Sin Iva -  Itau    Ok
		// F3B(Itau) - IGT-1118 - Con Iva -
		// F3B(Itau) - IGT-19   - Sin Iva -  Itau    Ok
		// F3B(Itau) - IGT-19   - Con Iva -
		if($Formulario=="F3B1"){
			$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
			$JefeProyecto = $row['JefeProyecto'];
		}

		// F3B(AAA) - IGT-1118 - Sin Iva - Edwards     	Ok
		// F3B(AAA) - IGT-1118 - Con Iva -
		// F3B(AAA) - IGT-19   - Sin Iva - 				Ok
		// F3B(AAA) - IGT-19   - Con Iva -
		if($Formulario=="F3B2"){
			if($_GET['IdProyecto']=="IGT-1118"){
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente2'].", Banco ".$row['Banco2'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}else{
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}
		}
		$pdf->Ln(12);
		$pdf->Cell(70,10,'RUT:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Rut_JefeProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$Concepto,1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CORREO ELECTRÓNICO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Email'],1,0);

	}

	mysql_close($link);

	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,5,'La relación de gastos es la siguiente::',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	if($_GET['Impuesto']=="sIva"){
		$pdf->Cell(55,17,'Proveedor',1,0,'C');
		$pdf->Cell(18,17,'N° Factura',1,0,'C');
		$pdf->Cell(17,17,'Fecha',1,0,'C');
		$pdf->Cell(70,17,'Bien o Servicio Adquirido',1,0,'C');
		$pdf->Cell(20,17,'Monto',1,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(55,18,'',0,0,'C');
		$pdf->Cell(18,18,'o Boleta',0,0,'C');
		$pdf->Cell(17,18,'Factura o',0,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(55,20,'',0,0,'C');
		$pdf->Cell(18,20,'',0,0,'C');
		$pdf->Cell(17,20,'o Boleta',0,0,'C');
	}
	if($_GET['Impuesto']=="cIva"){
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
	}
	if($Formulario=="F3B1"){
		if($_GET['Impuesto']=="sIva"){
			//$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 3 && Iva = 0 && Neto = 0 && Estado = 'I'"; 
			$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso = 1 && Iva = 0 && Neto = 0 && Estado = 'I'"; 
		}
		if($_GET['Impuesto']=="cIva"){
			//$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 3 && Iva > 0 && Neto > 0 && Estado = 'I'"; 
			$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso = 1 && Iva > 0 && Neto > 0 && Estado = 'I'"; 
		}
	}
	if($Formulario=="F3B2"){
		if($_GET['Impuesto']=="sIva"){
			$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso = 4 && Iva = 0 && Neto = 0 && Estado = 'I'"; 
		}
		if($_GET['Impuesto']=="cIva"){
			$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso = 4 && Iva > 0 && Neto > 0 && Estado = 'I'"; 
		}
	}
	$pdf->SetFont('Arial','',6);

	$tBrupo = 0;
	$pdf->Ln(13);
	$nLn = 161;
	$link=Conectarse();
	$bdGto=mysql_query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	//$bdGto=mysql_query("SELECT * FROM MovGastos  Order By FechaGasto Desc");
	if ($row=mysql_fetch_array($bdGto)){
		do{
			// Inicio Linea de Detalle
			if($_GET['Impuesto']=="sIva"){
				$pdf->Cell(55,5,$row['Proveedor'],1,0);
				$pdf->Cell(18,5,$row['nDoc'],1,0,'R');
				$pdf->Cell(17,5,$row['FechaGasto'],1,0,'C');
				
				$Txt = $row['Bien_Servicio'];
			   	$newtext = wordwrap($Txt, 64, "<br />\n");
				
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(70,5,$row['Bien_Servicio'],1,0);
				$pdf->SetFont('Arial','',6);
				//$pdf->Cell(70,5,substr($newtext,69),1,0);
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}else{
				$pdf->SetXY(10,$nLn);
				$pdf->MultiCell(50,10,$row['Proveedor'],1,'J');
				$pdf->SetXY(60,$nLn);
				$pdf->MultiCell(16,10,$row['nDoc'],1,'R');
				$pdf->SetXY(76,$nLn);
				$pdf->MultiCell(17,10,$row['FechaGasto'],1,'C');
				$pdf->SetXY(93,$nLn);
				if(strlen($row['Bien_Servicio'])>65){
					$pdf->MultiCell(60, 5,$row['Bien_Servicio'],1,'J');
										 //0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789
				}else{
					$pdf->MultiCell(60,10,$row['Bien_Servicio'],1,'J');
				}
				$pdf->SetXY(153,$nLn);
				$pdf->MultiCell(15,10,number_format($row['Neto'], 0, ',', '.'),1,'R');
				$pdf->SetXY(168,$nLn);
				$pdf->MultiCell(15,10,number_format($row['Iva'], 0, ',', '.'),1,'R');
				$pdf->SetXY(183,$nLn);
				$pdf->MultiCell(15,10,number_format($row['Bruto'], 0, ',', '.'),1,'R');
				$tNeto 	+= $row['Neto'];
				$tIva 	+= $row['Iva'];
				$tBruto += $row['Bruto'];
				$nLn +=10;
				if($nLn>261){
					$pdf->AddPage();
					$nLn = 13;
				}
			}
		}while ($row=mysql_fetch_array($bdGto));
	}
	

	// Linea Total
	if($_GET['Impuesto']=="sIva"){
		$pdf->Cell(55,5,'',0,0,'C');
		$pdf->Cell(18,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(70,5,'TOTAL',0,0,'R');
		$pdf->Cell(20,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}else{
		$pdf->Cell(50,5,'',0,0,'C');
		$pdf->Cell(16,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(60,5,'TOTAL',0,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tNeto, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tIva, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}

	$ln = $pdf->GetY();
	$ln += 1;
	$pdf->SetXY(10,$ln);
	
	//$pdf->SetXY(10,250);
	$Nota = "Nota: Especifique claramente el motivo que generó los gastos detallados, evitando la devolución de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");

	$ln = $pdf->GetY();
	$ln += 6;
	$pdf->SetXY(10,$ln);

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);

	$ln += 1;
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->Cell(130,5,strtoupper($NomDirector),0,0,"C");
	
	$ln += 2;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F3B-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');
}


if($Formulario == "F7"){
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('../logos/sdt.png',10,10,33,25);
	$pdf->Image('../logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInforme,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO F7',1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'SOLICITUD DE PAGO DE FACTURAS',1,0,'L');

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$fd 	= explode('-', $_GET['Fecha']);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
	$pdf->Cell(110,5,$fd[0].'/'.$fd[1].'/'.$fd[2],0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SEÑOR '.strtoupper($NomDirector).' ('.$Cargo.')',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$link=Conectarse();
	$bdPr=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$_GET['IdProyecto']."'");
	if($rowPr=mysql_fetch_array($bdPr)){
		$JefeProyecto = $rowPr['JefeProyecto'];
		$pdf->Ln(5);
		$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$rowPr['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$_GET['IdProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$Concepto,1,0);

	}
	mysql_close($link);


	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(180,5,'DETALLE DE FACTURAS',0,0,"C");

	$pdf->SetFont('Arial','B',6);
	$pdf->Ln(5);
	if($_GET['Impuesto']=="sIva"){
		$pdf->Cell(55,17,'PROVEEDOR',1,0,'C');
		$pdf->Cell(45,17,'CORREO ELECTRÓNICO',1,0,'C');
		$pdf->Cell(20,17,'BANCO',1,0,'C');
		$pdf->Cell(20,17,'CTA. CTE.',1,0,'C');
		$pdf->Cell(20,17,'RUT',1,0,'C');
		$pdf->Cell(20,17,'VALOR TOTAL',1,0,'C');
	}
	if($_GET['Impuesto']=="cIva"){
		$pdf->Cell(45,17,'PROVEEDOR',1,0,'C');
		$pdf->Cell(42,17,'CORREO ELECTRÓNICO',1,0,'C');
		$pdf->Cell(17,17,'BANCO',1,0,'C');
		$pdf->Cell(16,17,'CTA. CTE.',1,0,'C');
		$pdf->Cell(15,17,'RUT',1,0,'C');
		$pdf->Cell(15,17,'NETO',1,0,'C');
		$pdf->Cell(15,17,'IVA',1,0,'C');
		$pdf->Cell(15,17,'BRUTO',1,0,'C');
	}

	if($_GET['Impuesto']=="sIva"){
		$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 5 && Iva = 0 && Neto = 0 && Estado = 'I'"; 
	}
	if($_GET['Impuesto']=="cIva"){
		$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 5 && Iva > 0 && Neto > 0 && Estado = 'I'"; 
	}

	$pdf->SetFont('Arial','',5);
	$tBrupo = 0;
	$pdf->Ln(12);
	$link=Conectarse();
	$bdGto=mysql_query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($row=mysql_fetch_array($bdGto)){
		do{
			// Inicio Linea de Detalle
			if($_GET['Impuesto']=="sIva"){
				$pdf->Cell(55,5,$row['Proveedor'],1,0);
				$bdProv=mysql_query("SELECT * FROM Proveedores Where Proveedor = '".$row['Proveedor']."'");
				if ($rowProv=mysql_fetch_array($bdProv)){
					$pdf->Cell(45,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(20,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}else{
				$pdf->Cell(45,5,$row['Proveedor'],1,0);
				$bdProv=mysql_query("SELECT * FROM Proveedores Where Proveedor = '".$row['Proveedor']."'");
				//$bdProv=mysql_query("SELECT * FROM Proveedores");
				if ($rowProv=mysql_fetch_array($bdProv)){
					$pdf->Cell(42,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(17,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(16,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(15,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(15,5,number_format($row['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($row['Iva'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tNeto 	+= $row['Neto'];
				$tIva 	+= $row['Iva'];
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}
			//$nLn = $nLn + 1;
			// Termino Linea de Detalle
		}while ($row=mysql_fetch_array($bdGto));
	}


	$pdf->SetFont('Arial','',6);
	// Linea Total
	if($_GET['Impuesto']=="sIva"){
		$pdf->Cell(55,5,'',0,0,'C');
		$pdf->Cell(45,5,'',0,0,'C');
		$pdf->Cell(20,5,'',0,0,'C');
		$pdf->Cell(20,5,'',0,0,'C');
		$pdf->Cell(20,5,'TOTAL',0,0,'R');
		$pdf->Cell(20,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}else{
		$pdf->Cell(45,5,'',0,0,'C');
		$pdf->Cell(42,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(16,5,'',0,0,'C');
		$pdf->Cell(15,5,'TOTAL',0,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tNeto, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tIva, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}

	$pdf->SetXY(10,240);
	$Nota = "Nota: Especifique claramente el motivo que generó los gastos detallados, evitando la devolución de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 258, 90, 258);
	$pdf->SetXY(20,259);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->SetXY(20,263);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 258, 190, 258);
	$pdf->SetXY(120,259);
	$pdf->Cell(70,5,strtoupper($NomDirector),0,0,"C");
	$pdf->SetXY(120,263);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

	//$pdf->Output('F7-00001.pdf','I');
	$NombreFormulario = "F7-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');
}


?>
