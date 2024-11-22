<?php
include_once('../../conexionli.php');
require('../../fpdf/fpdf.php');
$tBruto = 0;
$tNeto 	= 0;
$tIva 	= 0;
$JefeProyecto = '';

if(isset($_GET['nInforme'])) { $nInf 		= $_GET['nInforme']; 	}
if(isset($_GET['nInforme'])) { $nInforme 	= $_GET['nInforme'];	}

if(isset($_GET['Concepto'])){
	$Concepto = $_GET['Concepto'];
}

if(isset($_GET['Formulario'])){ 
	$Formulario = $_GET['Formulario'];
}
$link=Conectarse();
$bdDep=$link->query("SELECT * FROM Departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
	$Cargo		 = $rowDep['Cargo'];
}
$link->close();
		
$ff = explode('(',$Formulario);
$Recurso = substr($ff[1],0,strlen($ff[1])-1);

$Formulario = $ff[0];
$mesPalabras = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
if($Formulario == "F3B"){
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('../logos/sdt.png',10,10,33,25);
	$pdf->Image('../logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(45);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,utf8_decode('SOCIEDAD DE DESARROLLO TECNOLÓGICO DE LA USACH LTDA.'),0,2,'C');
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInforme,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO '.substr($Formulario,1,2),1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'REEMBOLSO DE GASTOS',1,0,'L');

	$fd 	= explode('-', $_GET['Fecha']);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA: '.$fd[0].' de '.$mesPalabras[intval($fd[1]-1)].' de '.$fd[2],0,0);

	$pdf->Ln(5);
	$pdf->Cell(10,5,'DE',0,0);
	$pdf->Cell(10,5,':',0,0);
	$pdf->Cell(80,5,utf8_decode('SEÑOR '.strtoupper($NomDirector).' (Jefe del Proyecto)'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(10,5,'A',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(10,5,':',0,0);
	$pdf->Cell(110,5,utf8_decode('DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLÓGICO (SDT USACH LTDA.)'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'NOMBRE DEL PROYECTO',1,0);

	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$_GET['IdProyecto']."'");
	if($row=mysqli_fetch_array($bdPr)){
		$JefeProyecto = $row['JefeProyecto'];
		$firmaJefe = $row['firmaJefe'];
		$pdf->Cell(110,5,$row['Proyecto'],1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,utf8_decode('CÓDIGO DEL PROYECTO'),1,0);
		$pdf->Cell(110,5,$_GET['IdProyecto'],1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'RINDO CUENTA POR LA SUMA',1,0);
		$bdFor=$link->query("SELECT * FROM Formularios Where nInforme = '".$_GET['nInforme']."'");
		if ($rowFor=mysqli_fetch_array($bdFor)){
			$pdf->Cell(110,5,'$ '.number_format($rowFor['Bruto'], 0, ',', '.'),1,0);
		}
		$pdf->Ln(10);
		$pdf->Cell(70,5,'SE SOLICITA REEMBOLSO A NOMBRE DE:',1,0);
		$IdRecurso = '';
		$bdG=$link->query("SELECT * FROM MovGastos Where nInforme = '".$nInforme."'");
		if($rowG=mysqli_fetch_array($bdG)){
			$IdRecurso = $rowG['IdRecurso'];
		}
		$bdCt=$link->query("SELECT * FROM CtasCtesCargo Where aliasRecurso = '".$IdRecurso."'");
		if($rowCt=mysqli_fetch_array($bdCt)){
			$nCuenta 	= $rowCt['nCuenta'];
			$Banco 	 	= $rowCt['Banco'];
			$rutTitular	= $rowCt['rutTitular'];
		}
		$bdRee=$link->query("SELECT * FROM Proyectos Where Rut_JefeProyecto = '".$rutTitular."'");
		if($rowRee=mysqli_fetch_array($bdRee)){
			$aNombre = $rowRee['JefeProyecto'];
		}
		$pdf->Cell(110,5,utf8_decode($aNombre),1,0);
		//$pdf->Cell(110,5,$aNombre.", Cta.Cte. N� ".$nCuenta.", Banco ".$Banco,1,0);

		$pdf->Ln(5);
		$pdf->Cell(70,5,'RUT DEL SOLICITANTE',1,0);
		$pdf->Cell(110,5,$row['Rut_JefeProyecto'],1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'MOTIVO',1,0);
		$pdf->Cell(110,5,utf8_decode($Concepto),1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,utf8_decode('CORREO ELECTRÓNICO'),1,0);
		$pdf->Cell(110,5,$row['Email'],1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'MODALIDAD DE PAGO',1,0);
		$pdf->Cell(110,5,utf8_decode('TRANSFERENCIA ELECTRÓNICA'),1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'DATOS BANCARIOS',1,0);
		$pdf->Cell(110,5,$nCuenta.' / '.$Banco,1,0);
/*
		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,utf8_decode($Concepto),1,0);
*/
	}

	$link->close();

	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,5,utf8_decode('La relación de gastos es la siguiente:'),0,0);
	//$pdf->Cell(2,5,':',0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	if($_GET['Impuesto']=="sIva"){
		$pdf->Cell(55,17,'Proveedor',1,0,'C');
		$pdf->Cell(18,17,utf8_decode('Nº Factura'),1,0,'C');
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
		$pdf->Cell(16,17,utf8_decode('Nº Factura'),1,0,'C');
		$pdf->Cell(17,17,'Fecha',1,0,'C');
		$pdf->Cell(90,17,'Bien o Servicio Adquirido',1,0,'C');
		$pdf->Cell(15,17,'MONTO',1,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(50,18,'',0,0,'C');
		$pdf->Cell(16,18,'o Boleta',0,0,'C');
		$pdf->Cell(17,18,'Factura o',0,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(17,20,'o Boleta',0,0,'C');
	}

	$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' and  Estado = 'I'"; 
	
	$pdf->SetFont('Arial','',6);

	$tBrupo = 0;
	//$pdf->Ln(13);
	//$nLn = 161;
	$nLn = $pdf->GetY()+13;
	$nRegistros = 0;
	$link=Conectarse();
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	//$bdGto=$link->query("SELECT * FROM MovGastos  Order By FechaGasto Desc");
	if ($row=mysqli_fetch_array($bdGto)){
		do{
			$nRegistros++;
			if($nRegistros == 19){
				$pdf->addPage(); 
				$nLn = 13;
			}
			// Inicio Linea de Detalle
			if($_GET['Impuesto']=="sIva"){
				$pdf->SetXY(10,$nLn);
				$pdf->Cell(55,5,utf8_decode($row['Proveedor']),1,0);
				$pdf->Cell(18,5,$row['nDoc'],1,0,'R');
				$pdf->Cell(17,5,$row['FechaGasto'],1,0,'C');
				
				$Txt = utf8_decode($row['Bien_Servicio']);
			   	$newtext = wordwrap($Txt, 64, "<br />\n");
				
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(70,5,$row['Bien_Servicio'],1,0);
				$pdf->SetFont('Arial','',6);
				//$pdf->Cell(70,5,substr($newtext,69),1,0);
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$nLn +=5;
				if($nLn>261){
					$pdf->AddPage();
					$nLn = 13;
				}
			}else{
				$pdf->SetFont('Arial','',5);
				$pdf->SetXY(10,$nLn);
				$pdf->MultiCell(50,5,utf8_decode($row['Proveedor']),1,'J');
				$pdf->SetXY(60,$nLn);
				$pdf->MultiCell(16,5,$row['nDoc'],1,'R');
				$pdf->SetXY(76,$nLn);
				$pdf->MultiCell(17,5,$row['FechaGasto'],1,'C');
				$pdf->SetXY(93,$nLn);
				if(strlen($row['Bien_Servicio'])>85){
					$pdf->MultiCell(90, 5,$row['Bien_Servicio'],1,'J');
										 //0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789
				}else{
					$pdf->MultiCell(90,5,utf8_decode($row['Bien_Servicio']),1,'J');
				}
				$pdf->SetXY(153,$nLn);
				$pdf->SetXY(168,$nLn);
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
		}while ($row=mysqli_fetch_array($bdGto));
	}
	
	//$pdf->Ln(5);

	// Linea Total
	if($_GET['Impuesto']=="sIva"){
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
		$pdf->Cell(90,5,'TOTAL',0,0,'R');
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
	$txt  = "La dirección comercial de SDT USACH LTDA: es Av. Libertador Bernardo O'Higgins Nº 1611, sin embargo, ";
	$txt .= "para dar inicio a la tramitación de este Formulario, debe ser entregado en la Unidad de Ingreso de ";
	$txt .= "Requerimientos, Av. Libertador Bernardo O'Higgins Nº 2229";
	$pdf->MultiCell(170,5,utf8_decode($txt),0,'L');
	$nLn = $pdf->GetY() + 1;
	$txt = "-";
	$pdf->SetXY(20,$nLn);
	$pdf->MultiCell(10,5,$txt,0,'L');
	$pdf->SetXY(30,$nLn);
	$txt  = "Los reembolsos de gastos no pueden ser utilizados para la compra de materiales que serán utilizados en ";
	$txt .= "obras de infraestructura, ni para el pago de contratistas por la ejecución y/o estudios de obras.";
	$pdf->MultiCell(170,5,utf8_decode($txt),0,'L');

	$pdf->SetFont('Arial','B',7);
	$ln = 245;
	$pdf->SetXY(10,$ln);
	
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);

	$ln += 1;
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,40,210,40,40);
	}

	$pdf->Image('../../ft/timbreSolicitudes.png',80,210,40,40);

	$pdf->Cell(70,6,utf8_decode($JefeProyecto),0,0,"C");
	$pdf->Cell(130,5,strtoupper(utf8_decode($NomDirector)),0,0,"C");
	
	$ln += 3;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,6,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,85,230,40,40);
	}
	$ln = $pdf->GetY() + 15;
	$pdf->SetXY(200,$ln);
	$pdf->Line(80, $ln, 130, $ln);
	$ln += 2;
	$pdf->SetXY(73,$ln);
	$pdf->Cell(70,5,"Firma del receptor del fondo",0,0,"C");

/*
	$ln += 5;
	$pdf->SetXY(10,$ln);
	$Nota = "Nota: Especifique claramente el motivo que gener� los gastos detallados, evitando la devoluci�n de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");
*/
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
	$pdf->Cell(45);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,utf8_decode('SOCIEDAD DE DESARROLLO TECNOLÓGICO DE LA USACH LTDA.'),0,2,'C');
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
	$pdf->Cell(110,5,utf8_decode('SEÑOR ').strtoupper(utf8_decode($NomDirector)).' ('.$Cargo.')',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,utf8_decode('DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNÓLOGICO  (SDT USACH)'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(110,5,utf8_decode('Solicito a Ud. La cancelación de las facturas que se detallan, con cargo a:'),0,0);
	
	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$_GET['IdProyecto']."'");
	if($rowPr=mysqli_fetch_array($bdPr)){
		$JefeProyecto = $rowPr['JefeProyecto'];
		$firmaJefe = $rowPr['firmaJefe'];

		$pdf->Ln(5);
		$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$rowPr['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,utf8_decode('CÓDIGO DEL PROYECTO:'),0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$_GET['IdProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,utf8_decode($Concepto),1,0);

		$pdf->Ln(12);
		$pdf->MultiCell(180,5,utf8_decode('En la siguiente tabla Ud. podrá evaluar al proveedor del producto o servicio adquirido, con una puntuación que abarca desde un mínimo de 1, que representa la peor calificación, a un máximo de 5, para la mejor calificación. Esta evaluación debe ser aplicada al costo del producto o servicio, su calidad y los Servicios de Pre y Post Venta entregados por el proveedor:'), 0, "J");

		$pdf->Ln(5);
		$pdf->Cell(70,10,'',0,0);
		$pdf->MultiCell(110,5,utf8_decode('Calificación de Proveedores de 1 a 5'), 1, "C");

		$pdf->Cell(70,10,'',0,0);
		$pdf->Cell(27,5,'COSTO', 1, 0, "C");
		$pdf->Cell(27,5,'CALIDAD', 1, 0, "C");
		$pdf->Cell(27,5,'PREVENTA', 1, 0, "C");
		$pdf->Cell(29,5,'POSTVENTA', 1, 0, "C");

		if($_GET['Impuesto']=="sIva"){
			$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 5 && Iva = 0 && Estado = 'I'"; 
		}
		if($_GET['Impuesto']=="cIva"){
			$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 5 && Iva > 0 && Neto > 0 && Estado = 'I'"; 
		}
		

		$bdFac=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
		if($rowFac=mysqli_fetch_array($bdFac)){
			$pdf->Ln(5);
			$pdf->Cell(70,10,'',0,0);
			$pdf->Cell(27,5,$rowFac['CalCosto'], 1, 0, "C");
			$pdf->Cell(27,5,$rowFac['CalCalidad'], 1, 0, "C");
			$pdf->Cell(27,5,$rowFac['CalPreVenta'], 1, 0, "C");
			$pdf->Cell(29,5,$rowFac['CalPostVenta'], 1, 0, "C");
		}
	}
	$link->close();


	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(180,5,'DETALLE DE FACTURAS',0,0,"C");

	$pdf->SetFont('Arial','B',6);
	$pdf->Ln(5);
	if($_GET['Impuesto']=="sIva"){
		$pdf->Cell(55,17,'PROVEEDOR',1,0,'C');
		$pdf->Cell(45,17,utf8_decode('CORREO ELECTRÓNICO'),1,0,'C');
		$pdf->Cell(20,17,'BANCO',1,0,'C');
		$pdf->Cell(20,17,'CTA. CTE.',1,0,'C');
		$pdf->Cell(20,17,'RUT',1,0,'C');
		$pdf->Cell(20,17,'VALOR TOTAL',1,0,'C');
	}
	if($_GET['Impuesto']=="cIva"){
		$pdf->Cell(45,17,'PROVEEDOR',1,0,'C');
		$pdf->Cell(42,17,utf8_decode('CORREO ELECTRÓNICO'),1,0,'C');
		$pdf->Cell(17,17,'BANCO',1,0,'C');
		$pdf->Cell(16,17,'CTA. CTE.',1,0,'C');
		$pdf->Cell(15,17,'RUT',1,0,'C');
		$pdf->Cell(15,17,'NETO',1,0,'C');
		$pdf->Cell(15,17,'IVA',1,0,'C');
		$pdf->Cell(15,17,'VALOR TOTAL',1,0,'C');
	}

	if($_GET['Impuesto']=="sIva"){
		$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 5 && Iva = 0 && Estado = 'I'"; 
	}
	if($_GET['Impuesto']=="cIva"){
		$filtroSQL = "Where nInforme = '".$_GET['nInforme']."' && IdProyecto ='".$_GET['IdProyecto']."' && IdRecurso <= 5 && Iva > 0 && Neto > 0 && Estado = 'I'"; 
	}

	$pdf->SetFont('Arial','',5);
	$tBrupo = 0;
	$pdf->Ln(12);
	$link=Conectarse();
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($row=mysqli_fetch_array($bdGto)){
		do{
			// Inicio Linea de Detalle
			if($_GET['Impuesto']=="sIva"){
				$pdf->Cell(55,5,utf8_decode($row['Proveedor']),1,0);
				$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor Like '%".$row['Proveedor']."%'");
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
				$SQLPR = "SELECT * FROM Proveedores Where Proveedor Like '%".$row['Proveedor']."%'";
				$pdf->Cell(45,5,utf8_decode($row['Proveedor']),1,0);
				$bdProv=$link->query($SQLPR);
				//$bdProv=$link->query("SELECT * FROM Proveedores");
				if ($rowProv=mysqli_fetch_array($bdProv)){
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
		}while ($row=mysqli_fetch_array($bdGto));
	}

	$bdFor=$link->query("SELECT * FROM Formularios Where nInforme = '".$nInforme."'");
	if ($rowFor=mysqli_fetch_array($bdFor)){
		$tNeto = $rowFor['Neto'];
		$tIva  = $rowFor['Iva'];
		$tBruto = $rowFor['Bruto'];
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

	$nLn = $pdf->GetY() + 7;
	$txt = "Especifique claramente el motivo que generá los gastos detallados, evitando la devolución de este formulario a su Unidad de origen";
	$pdf->SetXY(10,$nLn);
	$pdf->MultiCell(180,5,utf8_decode($txt),0,'L');
	$nLn = $pdf->GetY() + 5;
	$txt  = "Nota: La dirección de SDT USACH es Av. Libertador Bernado O'Higgins Nº 1611, sin embargo, para dar inicio a la tramitación de este ";
	$txt .= "Formulario, lo debe entregar en la dirección Fanor Velasco Nº 85 oficina 803, Oficina de Ingreso de Requerimientos.";
	$pdf->SetXY(10,$nLn);
	$pdf->MultiCell(180,5,utf8_decode($txt),0,'L');

	$ln = 250;

	$pdf->SetXY(10,$ln);

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);

	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,240);
	$pdf->Cell(20,5,'P.P.',0,0,"C");


	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);

	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	
	$firmaJefe = 'aaa.png';

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,40,215,40,40);
	}

	$pdf->Image('../../ft/timbreSolicitudes.png',80,215,40,40);

	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,utf8_decode($JefeProyecto),0,0,"C");
	$pdf->Cell(130,5,strtoupper(utf8_decode($NomDirector)),0,0,"C");
	
	$ln += 2;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");
/*
	$ln += 18;
	$pdf->SetXY(10,$ln);
	$Nota = "Nota: Especifique claramente el motivo que gener� los gastos detallados, evitando la devoluci�n de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");
*/
	//$pdf->Output('F7-00001.pdf','I');
	$NombreFormulario = "F7-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');
}


?>
