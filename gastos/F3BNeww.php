<?php
require_once('../fpdf/fpdf.php');
$link=Conectarse();

$tBruto	= 0;
$tNeto 	= 0;
$tIva	= 0;

$JefeProyecto = '';

$bdnInf=$link->query("SELECT * FROM Formularios Order By nInforme Desc");
if ($rownInf=mysqli_fetch_array($bdnInf)){
	$nInf = $rownInf['nInforme'] + 1;
}
$bdDep=$link->query("SELECT * FROM Departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
}
$link->close();

$ff = explode('(',$Formulario);
$Recurso = substr($ff[1],0,strlen($ff[1])-1);

$Formulario = $ff[0];
$mesPalabras = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
if($Formulario == "F3B"){

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('logos/sdt.png',10,10,33,25);
	$pdf->Image('logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(45);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOL�GICO DE LA USACH LTDA.',0,2,'C');
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInf,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO '.substr($_POST['Formulario'],1,2),1,0,'C');
	
	$fechaHoy = date('Y-m-d');
	$fd 	= explode('-', $fechaHoy);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	
	$pdf->Cell(130,10,'REEMBOLSO DE GASTOS',1,0,'L');
	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA: '.$fd[2].' de '.$mesPalabras[intval($fd[1]-1)].' de '.$fd[0],0,0);
	//$pdf->Cell(2,5,':',0,0);
	//$pdf->Cell(110,5,date('d').' de '.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(10,5,'DE',0,0);
	$pdf->Cell(10,5,':',0,0);
	$pdf->Cell(80,5,'SE�OR '.strtoupper($rowDep['NomDirector']).' (Jefe del Proyecto)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(10,5,'A',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(10,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO (SDT USACH LTDA.)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'NOMBRE DEL PROYECTO',1,0);

	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$_POST['IdProyecto']."'");
	if($row=mysqli_fetch_array($bdPr)){
		$JefeProyecto = $row['JefeProyecto'];
		$pdf->Cell(110,5,$row['Proyecto'],1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'C�DIGO DEL PROYECTO',1,0);
		$pdf->Cell(110,5,$_POST['IdProyecto'],1,0);

		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva = 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva > 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
		}
		$Rendicion = 0;
		$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
		if ($row=mysqli_fetch_array($bdGto)){
			do{
				$Rendicion += $row['Bruto'];
			}while ($row=mysqli_fetch_array($bdGto));
		}
		$pdf->Ln(5);
		$pdf->Cell(70,5,'RINDO CUENTA POR LA SUMA',1,0);
		$pdf->Cell(110,5,'$ '.number_format($Rendicion, 0, ',', '.'),1,0);
		
		$pdf->Ln(12);
		$pdf->Cell(70,5,'SE SOLICITA REEMBOLSO A NOMBRE DE ',1,0);
		
		$bdCt=$link->query("SELECT * FROM CtasCtesCargo Where aliasRecurso = '".$IdRecurso."'");
		if($rowCt=mysqli_fetch_array($bdCt)){
			$nCuenta 	= $rowCt['nCuenta'];
			$Banco 	 	= $rowCt['Banco'];
			$rutTitular	= $rowCt['rutTitular'];
		}

		$bdRee=$link->query("SELECT * FROM Proyectos Where Rut_JefeProyecto = '".$rutTitular."'");
		if($rowRee=mysqli_fetch_array($bdRee)){
			$aNombre 			= $rowRee['JefeProyecto'];
			$Rut_JefeProyecto 	= $rowRee['Rut_JefeProyecto'];
			$Email 				= $rowRee['Email'];
		}
		
		$pdf->Cell(110,5,$aNombre,1,0);
		//$pdf->Cell(110,10,$aNombre.", Cta.Cte. N� ".$nCuenta.", Banco ".$Banco,1,0);
		
		$pdf->Ln(5);
		$pdf->Cell(70,5,'RUT DEL SOLICITANTE',1,0);
		$pdf->Cell(110,5,$Rut_JefeProyecto,1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'MOTIVO',1,0);
		$pdf->Cell(110,5,$Concepto,1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'CORREO ELECTR�NICO',1,0);
		$pdf->Cell(110,5,$Email,1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'MODALIDAD DE PAGO',1,0);
		$pdf->Cell(110,5,'TRANSFERENCIA ELECTR�NICA',1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'DATOS BANCARIOS',1,0);
		$pdf->Cell(110,5,$nCuenta.' / '.$Banco,1,0);
	}

	$link->close();

	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,5,'La relaci�n de gastos es la siguiente::',0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	if($Iva=="sIva"){
		$pdf->Cell(55,17,'Proveedor',1,0,'C');
		$pdf->Cell(18,17,'N� Factura',1,0,'C');
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
		$pdf->Cell(16,17,'N� Factura',1,0,'C');
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
	if($Iva=="sIva"){
		$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva = 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
	}
	if($Iva=="cIva"){
		$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva > 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
	}

	$pdf->SetFont('Arial','',6);

	$tBrupo = 0;
	$nLn = $pdf->GetY()+13;
	$nRegistros = 0;
	$link=Conectarse();

	$tGastos = 0;
	$nPagina = 1;
	$SQL = "SELECT Count(*) as sGastos FROM MovGastos ".$filtroSQL;
	$result  = $link->query($SQL);  
	$rowGto	 = mysqli_fetch_array($result);
	$tGastos = $rowGto['sGastos'];
	
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($row=mysqli_fetch_array($bdGto)){
		do{
			$nRegistros++;
			if($nPagina > 1){
				if($nRegistros > 25){
						$pdf->addPage();
						$nLn = 13;
						$nRegistros = 1;
				}
			}
			if($nPagina == 1){
					if($nRegistros > 12){
						$nRegistros = 1;

						$ln = 245;

						$pdf->SetXY(10,$ln);

						// Line(Col, FilaDesde, ColHasta, FilaHasta) 
						$pdf->Line(20, $ln, 90, $ln);
						$pdf->Line(120, $ln, 190, $ln);

						$ln += 1;
						$pdf->SetXY(20,$ln);
						$pdf->SetXY(20,259);

						//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
						$pdf->SetXY(20,$ln);
						//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
						$pdf->Cell(70,5,utf8_decode($JefeProyecto),0,0,"C");
						$pdf->Cell(130,5,strtoupper($NomDirector),0,0,"C");
						
						$ln += 3;
						$pdf->SetXY(20,$ln);
						$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
						$pdf->Cell(130,5,"Director de Departamento",0,0,"C");

						$ln = $pdf->GetY() + 15;
						$pdf->SetXY(200,$ln);
						$pdf->Line(80, $ln, 130, $ln);
						$ln += 2;
						$pdf->SetXY(73,$ln);
						$pdf->Cell(70,5,"Firma del receptor del fondo",0,0,"C");
					
					
					

						$pdf->addPage();
						$nLn = 13;
						
						
						
					}
			}
			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->SetXY(10,$nLn);
				$pdf->Cell(55,5,utf8_decode($row['Proveedor']),1,0);
				$pdf->Cell(18,5,$row['nDoc'],1,0,'R');
				$fd 	= explode('-', $row['FechaGasto']);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$pdf->Cell(17,5,$Fecha,1,0,'C');
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(70,5,utf8_decode($row['Bien_Servicio']),1,0);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$nLn +=5;
				if($nLn>261){
					$pdf->AddPage();
					$nLn = 13;
				}
			}else{
				$pdf->SetXY(10,$nLn);
				$pdf->Cell(50,5,utf8_decode($row['Proveedor']),1,0);
				$pdf->SetXY(60,$nLn);
				$pdf->MultiCell(16,5,$row['nDoc'],1,'R');
				$fd 	= explode('-', $row['FechaGasto']);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$pdf->SetXY(76,$nLn);
				$pdf->MultiCell(17,5,$Fecha,1,'C');
				$pdf->SetFont('Arial','',5);
				$pdf->SetXY(93,$nLn);
				if(strlen($row['Bien_Servicio'])>65){
					$pdf->MultiCell(60, 5,utf8_decode($row['Bien_Servicio']),1,'J');
										 //0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789
				}else{
					$pdf->MultiCell(60,5,$row['Bien_Servicio'],1,'J');
				}
				$pdf->SetXY(153,$nLn);
				$pdf->Cell(15,5,number_format($row['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->SetXY(168,$nLn);
				$pdf->MultiCell(15,5,number_format($row['Iva'], 0, ',', '.'),1,'R');
				$pdf->SetXY(183,$nLn);
				$pdf->MultiCell(15,5,number_format($row['Bruto'], 0, ',', '.'),1,'R');
				$tNeto 	+= $row['Neto'];
				$tIva 	+= $row['Iva'];
				$tBruto += $row['Bruto'];
				$nLn +=5;
				if($nLn>261){
					$pdf->AddPage();
					$nLn = 13;
				}
			}
			
			//$nLn = $nLn + 1;
			// Termino Linea de Detalle
		}while ($row=mysqli_fetch_array($bdGto));
	}
	
	$FechaInforme = date('Y-m-d');

	$actSQL="UPDATE MovGastos SET ";
	$actSQL.="Estado	    ='I',";
	$actSQL.="Modulo	    ='G',";
	$actSQL.="FechaInforme  ='".$FechaInforme."',";
	$actSQL.="nInforme  	='".$nInf."'";
	$actSQL.=$filtroSQL;
	$bdGto=$link->query($actSQL);

	$f = "F3B";
	$IdProyecto = $_POST['IdProyecto'];
	if($_POST['Formulario'] == "F3B1"){
		$f = "F3B(Itau)";
	}
	if($_POST['Formulario'] == "F3B2"){
		$f = "F3B(AAA)";
	}

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

	$link->close();

	// Linea Total
	if($Iva=="sIva"){
		$pdf->Ln(5);
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

	$pdf->SetFont('Arial','',7);
	$nLn = $pdf->GetY() + 7;
	$txt = "Notas:";
	$pdf->SetXY(10,$nLn);
	$pdf->MultiCell(20,5,$txt,0,'L');
	$nLn +=  5;
	$txt = "-";
	$pdf->SetXY(20,$nLn);
	$pdf->MultiCell(10,5,$txt,0,'L');
	$pdf->SetXY(30,$nLn);
	$txt  = "La direcci�n comercial de SDT USACH LTDA: es Av. Libertador Bernardo O'Higgins N� 1611, sin embargo, ";
	$txt .= "para dar inicio a la tramitaci�n de este Formulario, debe ser entregado en la Unidad de Ingreso de ";
	$txt .= "Requerimientos, Av. Libertador Bernardo O'Higgins N� 2229";
	$pdf->MultiCell(170,5,$txt,0,'L');
	$nLn = $pdf->GetY() + 1;
	$txt = "-";
	$pdf->SetXY(20,$nLn);
	$pdf->MultiCell(10,5,$txt,0,'L');
	$pdf->SetXY(30,$nLn);
	$txt  = "Los reembolsos de gastos no pueden ser utilizados para la compra de materiales que ser�n utilizados en ";
	$txt .= "obras de infraestructura, ni para el pago de contratistas por la ejecuci�n y/o estudios de obras.";
	$pdf->MultiCell(170,5,$txt,0,'L');
	
	//$ln = $pdf->SetY();
	$ln = 245;

	$pdf->SetXY(10,$ln);

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);

	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);

	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,utf8_decode($JefeProyecto),0,0,"C");
	$pdf->Cell(130,5,strtoupper($NomDirector),0,0,"C");
	
	$ln += 3;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");

	$ln = $pdf->GetY() + 15;
	$pdf->SetXY(200,$ln);
	$pdf->Line(80, $ln, 130, $ln);
	$ln += 2;
	$pdf->SetXY(73,$ln);
	$pdf->Cell(70,5,"Firma del receptor del fondo",0,0,"C");


	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F3B-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');
}

if($Formulario == "F7"){
	$pdf=new FPDF('P','mm','A4');
	$nDocumentos = 0;

	$link=Conectarse();

			$tNeto 	= 0;
			$tIva 	= 0;
			$tBruto = 0;
			
			$pdf->AddPage();
			$pdf->Image('logos/sdt.png',10,10,33,25);
			$pdf->Image('logos/logousach.png',170,10,18,25);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(45);
			$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
			$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOL�GICO DE LA USACH LTDA.',0,2,'C');
			$pdf->Ln(10);
			$pdf->Cell(370,5,$nInf,0,0,'C');
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(50,10,'FORMULARIO F7',1,0,'C');
			//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
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
			$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOL�GICO (SDT USACH)',0,0);

			$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$_POST['IdProyecto']."'");
			if($rowPr=mysqli_fetch_array($bdPr)){
				$JefeProyecto = $rowPr['JefeProyecto'];
				$pdf->Ln(5);
				$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				$pdf->Cell(110,10,$rowPr['Proyecto'],1,0);
				$pdf->Ln(12);
				$pdf->Cell(70,10,'C�DIGO DEL PROYECTO:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				$pdf->Cell(110,10,$_POST['IdProyecto'],1,0);

				$pdf->Ln(12);
				$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				//$pdf->Cell(110,10,$Concepto,1,0);
				$pdf->Cell(110,10,$Concepto,1,0);
			}
			$pdf->SetFont('Arial','',7);
		
			$pdf->Ln(10);
			$pdf->Cell(180,5,'DETALLE DE FACTURAS',0,0,"C");
	
			$pdf->SetFont('Arial','B',6);
			$pdf->Ln(5);
			if($Iva=="sIva"){
				$pdf->Cell(55,17,'PROVEEDOR',1,0,'C');
				$pdf->Cell(45,17,'CORREO ELECTR�NICO',1,0,'C');
				$pdf->Cell(20,17,'BANCO',1,0,'C');
				$pdf->Cell(20,17,'CTA. CTE.',1,0,'C');
				$pdf->Cell(20,17,'RUT',1,0,'C');
				$pdf->Cell(20,17,'VALOR TOTAL',1,0,'C');
			}
			if($Iva=="cIva"){
				$pdf->Cell(45,17,'PROVEEDOR',1,0,'C');
				$pdf->Cell(42,17,'CORREO ELECTR�NICO',1,0,'C');
				$pdf->Cell(17,17,'BANCO',1,0,'C');
				$pdf->Cell(16,17,'CTA. CTE.',1,0,'C');
				$pdf->Cell(15,17,'RUT',1,0,'C');
				$pdf->Cell(15,17,'NETO',1,0,'C');
				$pdf->Cell(15,17,'IVA',1,0,'C');
				$pdf->Cell(15,17,'VALOR TOTAL',1,0,'C');
			}

			$pdf->SetFont('Arial','',6);
			$tBrupo = 0;
			$pdf->Ln(12);

	if($Iva=="sIva"){
		$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' and IdRecurso = 5 and Iva = 0 and Estado != 'I'"; 
	}
	if($Iva=="cIva"){
		$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' and IdRecurso = 5 and Iva > 0 and Estado != 'I'"; 
	}

	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($rowGto=mysqli_fetch_array($bdGto)){
		do{
			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->Cell(55,5,utf8_decode($rowGto['Proveedor']),1,0).'- Sin Iva '.$Iva;
				$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
				if ($rowProv=mysqli_fetch_array($bdProv)){
					$pdf->Cell(45,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(20,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$nDocumentos++;
				$pdf->Ln(5);
			}else{
				$pdf->Cell(45,5,utf8_decode($rowGto['Proveedor']),1,0).'- Con Iva '.$Iva;
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
				$nDocumentos++;
				$pdf->Ln(5);
			}
		}while ($rowGto=mysqli_fetch_array($bdGto));
	}
	$link->close();

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

	$nLn = $pdf->GetY() + 7;
	$txt = "Especifique claramente el motivo que gener� los gastos detallados, evitando la devoluci�n de este formulario a su Unidad de origen";
	$pdf->SetXY(10,$nLn);
	$pdf->MultiCell(180,5,$txt,0,'L');
	$nLn = $pdf->GetY() + 5;
	$txt  = "Nota: La direcci�n de SDT USACH es Av. Libertador Bernado O'Higgins N� 1611, sin embargo, para dar inicio a la tramitaci�n de este ";
	$txt .= "Formulario, lo debe entregar en la direcci�n Av. Bernardo O'Higgins N� 2229, Oficina de Ingreso de Requerimientos.";
	$pdf->SetXY(10,$nLn);
	$pdf->MultiCell(180,5,$txt,0,'L');

	$ln = 250;
		
	$pdf->SetXY(10,$ln);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);
		
	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);
		
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,utf8_decode($JefeProyecto),0,0,"C");
	$pdf->Cell(130,5,strtoupper($NomDirector),0,0,"C");
			
	$ln += 2;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");
		
	$ln += 18;
	$pdf->SetXY(10,$ln);
	$Nota = "Nota: Especifique claramente el motivo que gener� los gastos detallados, evitando la devoluci�n de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");

	//$Concepto = $concepto;
	$IdProyecto = $_POST['IdProyecto'];

	$link=Conectarse();
	$FechaInforme    = date('Y-m-d');
	$actSQL  = "UPDATE MovGastos SET ";
	$actSQL .= "Estado	    		= 'I',";
	$actSQL .= "FechaInforme  		= '".$FechaInforme.	"',";
	$actSQL .= "nInforme  			= '".$nInf.			"'";
	$actSQL .= $filtroSQL;
	$bdGto = $link->query($actSQL);

	$f = "F7";

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
									values 	 (	'$nInf',
												'G',
												'$f',
												'$Iva',
												'$FechaInforme',
												'$nDocumentos',
												'$Concepto',
												'$IdProyecto',
												'$tNeto',
												'$tIva',
												'$tBruto')");
	$link->close();

	//$pdf->Output('F7-00001.pdf','I');
	$NombreFormulario = "F7.pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');
}

?>
