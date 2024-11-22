<?php
$Formulario = $_POST[Formulario];
$Iva 		= $_POST[Iva];
$IdProyecto = $_POST[IdProyecto];

require_once('../fpdf/fpdf.php');

include_once("../../conexionli.php");

$link=Conectarse();

/*
$bdnInf=$link->query("SELECT * FROM tablaRegForm");
if ($rownInf=mysqli_fetch_array($bdnInf)){
	$nInf = $rownInf['nInforme'] + 1;
	$actSQL="UPDATE tablaRegForm SET ";
	$actSQL.="nInforme	='".$nInf."'";
	$bdnInf=$link->query($actSQL);
}
*/
$bdDep=$link->query("SELECT * FROM Departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep[NomDirector];
}
$link->close();

if($Formulario == "F3B(Itau)" || $Formulario == "F3B(AAA)"){

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('logos/sdt.png',10,10,33,25);
	$pdf->Image('logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInforme,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO '.substr($Formulario,1,2),1,0,'C');
	$pdf->Cell(130,10,'SOLICITUD DE REEMBOLSO',1,0,'L');
	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SEÑOR '.strtoupper($rowDep['NomDirector']).' ('.$rowDep['Cargo'].')',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$IdProyecto."'");
	if($row=mysqli_fetch_array($bdPr)){
		$pdf->Cell(110,10,$row['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$IdProyecto,1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'SE SOLICITA REEMBOLSO A NOMBRE DE:',0,0);
		if($Formulario=="F3B(Itau)"){
			$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
			$JefeProyecto = $row['JefeProyecto'];
		}

		if($Formulario=="F3B(AAA)"){
			if($IdProyecto=="IGT-1118"){
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente2'].", Banco ".$row['Banco2'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}else{
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N° ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}
		}
		$pdf->Ln(12);
		$pdf->Cell(70,10,'RUT:',0,0);
		$pdf->Cell(110,10,$row['Rut_JefeProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		$pdf->Cell(110,10,$Concepto,1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CORREO ELECTRÓNICO:',0,0);
		$pdf->Cell(110,10,$row['Email'],1,0);

	}

	$link->close();

	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,5,'La relación de gastos es la siguiente::',0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	if($Iva=="sIva"){
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
	if($Iva=="cIva"){
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
	if($Formulario=="F3B(Itau)"){
		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && IdRecurso <= 3 && Iva = 0 && Neto = 0 && Estado != 'I'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && IdRecurso <= 3 && Iva > 0 && Neto > 0 && Estado != 'I'"; 
		}
	}
	if($Formulario=="F3B(AAA)"){
		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && IdRecurso = 4 && Iva = 0 && Neto = 0 && Estado != 'I'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && IdRecurso = 4 && Iva > 0 && Neto > 0 && Estado != 'I'"; 
		}
	}
	$pdf->SetFont('Arial','',6);

	$tBrupo = 0;
	$pdf->Ln(13);
	$link=Conectarse();
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($row=mysqli_fetch_array($bdGto)){
		do{
			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->Cell(55,5,$row['Proveedor'],1,0);
				$pdf->Cell(18,5,$row['nDoc'],1,0,'R');
				$fd 	= explode('-', $row['FechaGasto']);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$pdf->Cell(17,5,$Fecha,1,0,'C');
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(70,5,$row['Bien_Servicio'],1,0);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}else{
				$pdf->Cell(50,5,$row['Proveedor'],1,0);
				$pdf->Cell(16,5,$row['nDoc'],1,0,'R');
				$fd 	= explode('-', $row['FechaGasto']);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$pdf->Cell(17,5,$Fecha,1,0,'C');
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(60,5,$row['Bien_Servicio'],1,0);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(15,5,number_format($row['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($row['Iva'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tNeto 	+= $row['Neto'];
				$tIva 	+= $row['Iva'];
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}
			
			// Termino Linea de Detalle
		}while ($row=mysqli_fetch_array($bdGto));
	}
	
	$FechaInforme = date('Y-m-d');

/*
	$actSQL="UPDATE MovGastos SET ";
	$actSQL.="Estado	    ='I',";
	$actSQL.="Modulo	    ='G',";
	$actSQL.="FechaInforme  ='".$FechaInforme."',";
	$actSQL.="nInforme  	='".$nInf."'";
	$actSQL.=$filtroSQL;
	$bdGto=$link->query($actSQL);
*/
	$f = "F3B";
	$f = $Formulario;
/*
	$link->query("insert into Formularios (	nInforme,
											Formulario,
											Impuesto,
											Modulo,
											Fecha,
											Concepto,
											IdProyecto,
											Neto,
											Iva,
											Bruto) 
							values 		 (	'$nInf',
											'$f',
											'$Iva',
											'G',
											'$FechaInforme',
											'$Concepto',
											'$IdProyecto',
											'$tNeto',
											'$tIva',
											'$tBruto')");

*/
	$link->close();

	// Linea Total
	if($Iva=="sIva"){
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
	$pdf->Cell(70,5,strtoupper($rowDep['NomDirector']),0,0,"C");
	$pdf->SetXY(120,263);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F3B-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');
}


if($Formulario == "F7"){
	$pdf=new FPDF('P','mm','A4');
	if($Iva=="sIva"){
		$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && IdRecurso = 5 && Iva = 0 && Neto = 0 && Estado != 'I'"; 
	}
	if($Iva=="cIva"){
		$filtroSQL = "Where IdProyecto ='".$IdProyecto."' && IdRecurso = 5 && Iva > 0 && Neto > 0 && Estado != 'I'"; 
	}

	$link=Conectarse();
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($rowGto=mysqli_fetch_array($bdGto)){
		DO{
			$tNeto 	= 0;
			$tIva 	= 0;
			$tBruto = 0;
			
			$pdf->AddPage();
			$pdf->Image('logos/sdt.png',10,10,33,25);
			$pdf->Image('logos/logousach.png',170,10,18,25);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(40);
			$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
			$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOLÓGICO',0,2,'C');
			$pdf->Ln(10);
			$pdf->Cell(370,5,$nInforme,0,0,'C');
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(50,10,'FORMULARIO F7',1,0,'C');
			$pdf->Cell(130,10,'SOLICITUD DE PAGO DE FACTURAS',1,0,'L');

			$pdf->Ln(13);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(70,5,'FECHA:',0,0);
			//$pdf->Cell(2,5,':',0,0);
			$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

			$pdf->Ln(5);
			$pdf->Cell(70,5,'DE:',0,0);
			//$pdf->Cell(2,5,':',0,0);
			$pdf->Cell(110,5,strtoupper($rowDep['NomDirector']).' ('.$rowDep['Cargo'].')',0,0);
	
			$pdf->Ln(5);
			$pdf->Cell(70,5,'A:',0,0);
			//$pdf->Cell(2,5,':',0,0);
			$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

			$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$IdProyecto."'");
			if($rowPr=mysqli_fetch_array($bdPr)){
				$JefeProyecto = $rowPr['JefeProyecto'];
				$pdf->Ln(5);
				$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				$pdf->Cell(110,10,$rowPr['Proyecto'],1,0);
				$pdf->Ln(12);
				$pdf->Cell(70,10,'CÓDIGO DEL PROYECTO:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				$pdf->Cell(110,10,$IdProyecto,1,0);

				$pdf->Ln(12);
				$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				//$pdf->Cell(110,10,$Concepto,1,0);
				$pdf->Cell(110,10,$rowGto['Bien_Servicio'],1,0);
			}
			$pdf->SetFont('Arial','',7);
		
			$pdf->Ln(10);
			$pdf->Cell(180,5,'DETALLE DE FACTURAS',0,0,"C");
	
			$pdf->SetFont('Arial','B',6);
			$pdf->Ln(5);
			if($Iva=="sIva"){
				$pdf->Cell(55,17,'PROVEEDOR',1,0,'C');
				$pdf->Cell(45,17,'CORREO ELECTRÓNICO',1,0,'C');
				$pdf->Cell(20,17,'BANCO',1,0,'C');
				$pdf->Cell(20,17,'CTA. CTE.',1,0,'C');
				$pdf->Cell(20,17,'RUT',1,0,'C');
				$pdf->Cell(20,17,'VALOR TOTAL',1,0,'C');
			}
			if($Iva=="cIva"){
				$pdf->Cell(45,17,'PROVEEDOR',1,0,'C');
				$pdf->Cell(42,17,'CORREO ELECTRÓNICO',1,0,'C');
				$pdf->Cell(17,17,'BANCO',1,0,'C');
				$pdf->Cell(16,17,'CTA. CTE.',1,0,'C');
				$pdf->Cell(15,17,'RUT',1,0,'C');
				$pdf->Cell(15,17,'NETO',1,0,'C');
				$pdf->Cell(15,17,'IVA',1,0,'C');
				$pdf->Cell(15,17,'BRUTO',1,0,'C');
			}

			$pdf->SetFont('Arial','',6);
			$tBrupo = 0;
			$pdf->Ln(12);

			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->Cell(55,5,$rowGto['Proveedor'],1,0).'- Sin Iva '.$Iva;
				$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
				if ($rowProv=mysqli_fetch_array($bdProv)){
					$pdf->Cell(45,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(20,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$pdf->Ln(5);
			}else{
				$pdf->Cell(45,5,$rowGto['Proveedor'],1,0).'- Con Iva '.$Iva;
				$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
				if ($rowProv=mysqli_fetch_array($bdProv)){
					$pdf->Cell(42,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(17,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(16,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(15,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(15,5,number_format($rowGto['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($rowGto['Iva'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($rowGto['Bruto'], 0, ',', '.'),1,0,'R');
				$tNeto 	+= $rowGto['Neto'];
				$tIva 	+= $rowGto['Iva'];
				$tBruto += $rowGto['Bruto'];
				$pdf->Ln(5);
			}
			//$nLn = $nLn + 1;
			// Termino Linea de Detalle

			// Linea Total
			if($Iva=="sIva"){
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
			$pdf->Cell(70,5,strtoupper($rowDep['NomDirector']),0,0,"C");
			$pdf->SetXY(120,263);
			$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

		}while ($rowGto=mysqli_fetch_array($bdGto));
	}
	$link->close();

	$link=Conectarse();
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($rowGto=mysqli_fetch_array($bdGto)){
		do{

			$FechaInforme    = date('Y-m-d');
			$tNeto	= $rowGto['Neto'];
			$tIva	= $rowGto['Iva'];
			$tBruto	= $rowGto['Bruto'];
			
			$filtroSQLm = $filtroSQL." && nDoc = '".$rowGto['nDoc']."'"; 
/*

			$actSQL="UPDATE MovGastos SET ";
			$actSQL.="Estado	    ='I',";
			$actSQL.="FechaInforme  ='".$FechaInforme."',";
			$actSQL.="nInforme  	='".$nInf."'";
			$actSQL.=$filtroSQLm;
			$bdGto=$link->query($actSQL);

			$f = "F7";
			$Concepto = $rowGto['Bien_Servicio'];
			$link->query("insert into Formularios (	nInforme,
													Modulo,
													Formulario,
													Impuesto,
													Fecha,
													nDocumentos,
													Concepto,
													IdProyecto,
													Neto,
													Iva,
													Bruto) 
									values 		 (	'$nInf',
													'G',
													'$f',
													'$Iva',
													'$FechaInforme',
													'1',
													'$Concepto',
													'$IdProyecto',
													'$tNeto',
													'$tIva',
													'$tBruto')");
*/
			$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
		}WHILE ($rowGto=mysqli_fetch_array($bdGto));
	}
	$link->close();





	//$pdf->Output('F7-00001.pdf','I');
	$NombreFormulario = "F7.pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');
}

?>
<script>
		document.form.Formulario.value 	= '';
		document.form.Iva.value 		= '';
		document.form.IdProyecto.value 	= '';
</script>