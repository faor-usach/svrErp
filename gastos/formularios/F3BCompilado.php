<?php
// require_once('../../fpdf/fpdf.php');
require_once("../../fpdf182/fpdf.php");

require_once("../../fpdi/src/autoload.php"); 
use \setasign\Fpdi\Fpdi;

include_once("../../conexionli.php");

/* Declaracion de Variables */ 

$Formulario = '';
$Iva        = '';
$IdProyecto = '';
$Concepto   = '';

$tBruto	= 0;
$tNeto 	= 0;
$tIva	= 0;
$excento= 0;

$IdRecurso = 0;

$JefeProyecto = '';
$firmaJefe = '';

if(isset($_GET['Formulario']))  { $Formulario   = $_GET['Formulario'];  }
if(isset($_GET['Iva']))         { $Iva          = $_GET['Iva'];         }
if(isset($_GET['IdProyecto']))  { $IdProyecto   = $_GET['IdProyecto'];  }
if(isset($_GET['Concepto']))    { $Concepto     = $_GET['Concepto'];    }

$link=Conectarse();
$ff = explode('(',$Formulario);
$Recurso = substr($ff[1],0,strlen($ff[1])-1);

$link=Conectarse();

$bd=$link->query("SELECT * FROM recursos Where Recurso = '$Recurso'");
if($rs=mysqli_fetch_array($bd)){
    $IdRecurso = $rs['IdRecurso'];
}

$bdsuper=$link->query("SELECT * FROM supervisor");
if($rssuper=mysqli_fetch_array($bdsuper)){
    $rutSuper 		= $rssuper['rutSuper'];
    $nombreSuper 	= $rssuper['nombreSuper'];
    $cargoSuper 	= $rssuper['cargoSuper'];
    $firmaSuper 	= $rssuper['firmaSuper'];
}


$filtroSQL = 'Where Estado != "I" ';
if($Formulario){
    $filtroSQL .= " and IdRecurso = '".$IdRecurso."'";
}
if($IdProyecto != ''){
    $filtroSQL .= " and IdProyecto = '".$IdProyecto."'";
}
if($Iva != ''){
    if($Iva=="cIva"){ 
        $filtroSQL .= " and Iva > 0 and Neto > 0";
    }else{
        //$filtroSQL .= " and Iva = 0 and Neto = 0";
        $filtroSQL .= " and Iva = 0";
    }
}


$bdnInf=$link->query("SELECT * FROM Formularios Order By nInforme Desc");
if ($rownInf=mysqli_fetch_array($bdnInf)){
	$nInf = $rownInf['nInforme'] + 1;
}
$bdDep=$link->query("SELECT * FROM Departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep['NomDirector'];
}
$bdSuper=$link->query("SELECT * FROM supervisor");
if ($rsSuper=mysqli_fetch_array($bdSuper)){
	$rutSuper 		= $rsSuper['rutSuper'];
	$nombreSuper 	= $rsSuper['nombreSuper'];
	$cargoSuper 	= $rsSuper['cargoSuper'];
	$firmaSuper 	= $rsSuper['firmaSuper'];
}
$link->close();

$Formulario = $ff[0];


$mesPalabras = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
if($Formulario == "F3B"){

	$pdf=new Fpdi('P','mm','Legal'); 

    
	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInf,0,0,'C');
	$pdf->Ln(10);


	$pdf->SetFillColor(234, 80, 55);
	// $pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(180,10,'FORMULARIO REEMBOLSO DE GASTOS ',1,0,'C', true);
	$pdf->SetTextColor(0, 0, 0);
	// $pdf->SetDrawColor(0, 0, 0);
	
	$pdf->Ln(13);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(70,5, utf8_decode('FECHA DE EMISIÓN DEL FORMULARIO:'),0,0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$fechaHoy = date('Y-m-d');
	$fd 	= explode('-', $fechaHoy);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";

	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(110,5,utf8_decode('COMPLETE LOS SIGUIENTES CAMPOS:'),0,0);
	$pdf->SetFont('Arial','',7);

	$pdf->Ln(7);
	$pdf->Cell(70,5,'NOMBRE DEL PROYECTO',1,0);

	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$_GET['IdProyecto']."'");
	if($row=mysqli_fetch_array($bdPr)){
		$JefeProyecto 		= $row['JefeProyecto'];
		$firmaJefe 			= $row['firmaJefe'];
		$Rut_JefeProyecto 	= $row['Rut_JefeProyecto'];
		$aNombre 			= $row['JefeProyecto'];
		$Email 				= $row['Email'];

		$pdf->Cell(110,5,$row['Proyecto'],1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,utf8_decode('CÓDIGO DEL PROYECTO'),1,0);
		$pdf->Cell(110,5,$_GET['IdProyecto'],1,0);

		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' && Iva = 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' && Iva > 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
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
			$aNombreSolicitante		= $rowRee['JefeProyecto'];
			$EmailSolicitante		= $rowRee['Email'];
			$firmaSolicitante		= $rowRee['firmaJefe'];

			// $Rut_JefeProyecto 	= $rowRee['Rut_JefeProyecto'];
			// $Email 				= $rowRee['Email'];
			// $firmaJefe 			= $rowRee['firmaJefe'];
		}else{
			$aNombreSolicitante		= $rowCt['nombreTitular'];

			$usrFirma		= substr($ff[1],0,3);

			$bdusr=$link->query("SELECT * FROM usuarios Where usr = '$usrFirma'");
			if($rsUsr=mysqli_fetch_array($bdusr)){
				$EmailSolicitante		= $rsUsr['email'];
				$firmaSolicitante		= $rsUsr['firmaUsr'];
			}
		}
		
		$pdf->Cell(110,5,utf8_decode($aNombreSolicitante),1,0);
		//$pdf->Cell(110,10,$aNombre.", Cta.Cte. N� ".$nCuenta.", Banco ".$Banco,1,0);
		
		$pdf->Ln(5);
		$pdf->Cell(70,5,'RUT DEL SOLICITANTE',1,0);
		// $pdf->Cell(110,5,$Rut_JefeProyecto,1,0);
		$pdf->Cell(110,5,$rutTitular,1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'MOTIVO',1,0);
		$pdf->Cell(110,5,utf8_decode($Concepto),1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,utf8_decode('CORREO ELECTRÓNICO'),1,0);
		$pdf->Cell(110,5,$EmailSolicitante,1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'MODALIDAD DE PAGO',1,0);
		$pdf->Cell(110,5,utf8_decode('TRANSFERENCIA ELECTRÓNICA'),1,0);
		$pdf->Ln(5);
		$pdf->Cell(70,5,'DATOS BANCARIOS',1,0);
		$pdf->Cell(110,5,$nCuenta.' / '.utf8_decode($Banco),1,0);
	}

	$link->close();

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(10);
	$pdf->Cell(70,5,utf8_decode('La relación de gastos es la siguiente:'),0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	$pdf->SetTextColor(255, 255, 255);
	if($Iva=="sIva"){
		$ln = $pdf->GetY();
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(55,10,'PROVEEDOR', 1, "C", true);
		$pdf->SetXY(65,$ln);
		$pdf->MultiCell(20,5,utf8_decode('Nº FACTURA O BOLETA'), 1, "C", true);
		$pdf->SetXY(85,$ln);
		$pdf->MultiCell(25,5,'FECHA FACTURA O BOLETA', 1, "C", true);
		$pdf->SetXY(110,$ln);
		$pdf->MultiCell(50,10,'BIEN O SERVICIO ADQUIRIDO', 1, "C", true);
		$pdf->SetXY(160,$ln);
		$pdf->MultiCell(30,10,'MONTO', 1, "C", true);
	}
	$pdf->SetTextColor(0,0,0);
	if($Iva=="cIva"){
		$ln = $pdf->GetY();
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(55,10,'PROVEEDOR', 1, "C", true);
		$pdf->SetXY(65,$ln);
		$pdf->MultiCell(20,5,utf8_decode('Nº FACTURA O BOLETA'), 1, "C", true);
		$pdf->SetXY(85,$ln);
		$pdf->MultiCell(25,5,'FECHA FACTURA O BOLETA', 1, "C", true);
		$pdf->SetXY(110,$ln);
		$pdf->MultiCell(50,10,'BIEN O SERVICIO ADQUIRIDO', 1, "C", true);
		$pdf->SetXY(160,$ln);
		$pdf->MultiCell(30,10,'MONTO', 1, "C", true);
	}
	if($Iva=="sIva"){
		$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' && Iva = 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
	}
	if($Iva=="cIva"){
		$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' && Iva > 0 && Estado != 'I' and IdRecurso = '".$IdRecurso."'"; 
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

	$nLn = $pdf->GetY() - 5;
	$nLn += 5;
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	while($row=mysqli_fetch_array($bdGto)){
		$nRegistros++;
		/*
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
						$pdf->Cell(130,5,strtoupper(utf8_decode($NomDirector)),0,0,"C");
						
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
		*/
		// Inicio Linea de Detalle
		$pdf->SetXY(10,$nLn);
		$pdf->Cell(55,5,utf8_decode($row['Proveedor']),1,0);
		$pdf->Cell(20,5,$row['nDoc'],1,0,'R');
		$fd 	= explode('-', $row['FechaGasto']);
		$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
		$pdf->Cell(25,5,$Fecha,1,0,'C');
		$pdf->SetFont('Arial','',5);
		$pdf->Cell(50,5,utf8_decode($row['Bien_Servicio']),1,0);
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(30,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
		$tBruto += $row['Bruto'];
		/*		
		$nLn +=5;
		if($nLn>261){
			$pdf->AddPage();
			$nLn = 13;
		}
		*/
		$nLn += 5;
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

	$IdProyecto = $_GET['IdProyecto'];
	if($_GET['Formulario'] == "F3B1"){
		$f = "F3B(Itau)";
	}
	if($_GET['Formulario'] == "F3B2"){
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
	$pdf->Ln(5);
	$pdf->Cell(55,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(25,5,'',0,0,'C');
	$pdf->Cell(50,5,'TOTAL',0,0,'R');
	$pdf->Cell(30,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');

	$pdf->SetFont('Arial','',7);
	$nLn = $pdf->GetY() + 7;
	$txt = "Nota:";
	$pdf->SetXY(10,$nLn);
	$pdf->MultiCell(20,5,$txt,0,'L');

	$nLn +=  5;	
	$pdf->SetXY(10,$nLn);
	$txt  = "Los reembolsos de gastos no pueden ser utilizados para la compra de materiales que serán utilizados en obras de infraestructura, ni para el pago de contratistas por la ejecución y/o estudio de obras.";
	$pdf->MultiCell(180,5,utf8_decode($txt),0,'L');
	
	// Firmas
	$pdf->SetFont('Arial','B',7);
	$ln = 285;
		
	$pdf->SetXY(10,$ln);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 70, $ln);
	$pdf->Line(140, $ln, 190, $ln);
		
	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);
		
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(50,5,utf8_decode($JefeProyecto),0,0,"C");
	if($Rut_JefeProyecto == $rutTitular){
		if($IdProyecto == 'IGT-1118'){
			$pdf->Image('../../ft/'.$firmaSuper,150,$ln-35,35,35);
			$pdf->Cell(185,5,strtoupper(utf8_decode($nombreSuper)),0,0,"C");
		}else{
			$firmaJefeB = 'aaa.png';
			//$pdf->Image('../../ft/TimbreDirector.png',140,$ln-20,20,20);
			// $pdf->Image('../../ft/'.$firmaJefe,40,$ln-40,40,40);
			$pdf->Image('../../ft/'.$firmaSuper,150,$ln-35,35,35);
			$pdf->Cell(185,5,strtoupper(utf8_decode($nombreSuper)),0,0,"C");
		}
	}else{
		//$pdf->Image('../../ft/TimbreDirector.png',140,$ln-20,20,20);
		$pdf->Image('../../ft/'.$firmaJefe,30,$ln-35,35,35);
		$pdf->Image('../../ft/'.$firmaSuper,150,$ln-35,35,35);
		$pdf->Cell(185,5,strtoupper(utf8_decode($nombreSuper)),0,0,"C");
	}

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,30,$ln-35,35,35);
	}
	// $pdf->Image('../../ft/'.$firmaJefe,130,$ln-40,40,40);

	if($IdProyecto == 'IGT-1118'){
		$pdf->Image('../../ft/timbreSolicitudes.png',80,$ln-38,35,35);
	}

	
	$ln += 3;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(50,5,"Jefe de Proyecto",0,0,"C");
	if($Rut_JefeProyecto == $rutTitular){
		if($IdProyecto == 'IGT-1118'){
			$pdf->Cell(185,5,utf8_decode($cargoSuper),0,0,"C");
		}else{
			//$pdf->Cell(130,5,utf8_decode('Director de Depatamento o Jefe de Centro Costo'),0,0,"C");
			$pdf->Cell(185,5,utf8_decode($cargoSuper),0,0,"C");
		}
	}else{
		//$pdf->Cell(130,5,utf8_decode('Director de Depatamento o Jefe de Centro Costo'),0,0,"C");
		$pdf->Cell(185,5,utf8_decode($cargoSuper),0,0,"C");
	}
	$pdf->SetFont('Arial','',7);

	// Fin Firmas

	$ln += 5;
	$pdf->SetFont('Arial','B',7);
	$pdf->SetXY(10,$ln);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(70, $ln, 140, $ln);
	$pdf->Image('../../ft/'.$firmaSolicitante,80,$ln-30,40,40);
	$pdf->Cell(190,5,strtoupper(utf8_decode($aNombreSolicitante)),0,0,"C");
	$ln += 3;
	$pdf->SetXY(10,$ln);
	$pdf->Cell(190,5,utf8_decode('Receptor de Reembolso'),0,0,"C");

	$ln += 3;
	$pdf->SetXY(20,$ln);
	$pdf->SetFont('Arial','',7);


	// Pie
	$fila = 310;
	$pdf->SetXY(10,$fila);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->MultiCell(185,25,'',1,'L', true);

	$fila += 2;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5,"Alameda Libertador",0,0,"L");

	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Trece Oriente Nº2211"),0,0,"L");

	$fila += 5;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Bernardo O'higgins 1611"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Piso 1, Iquique"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Santiago"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+57 22 488 84(85)"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("+562 2718 1400"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+569 4409 2070"),0,0,"L");

	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Line(160, 312, 160, 333);

	// FIN PRIMERA HOJA F3B

	// SEGUNDA HOHA F3B

	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInf,0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFillColor(234, 80, 55);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(180,10, utf8_decode('RECOMENDACIONES'),1,0,'C', true);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetDrawColor(0, 0, 0);


	// CUERPO SEGUNDA HOJA
	$nLn = $pdf->GetY() + 14;
	$pdf->SetFont('Arial','',10);

	$pdf->SetXY(10,$nLn);

	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '1.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = "Los gastos a reembolsar deben estar relacionados con la naturaleza del proyecto por el cual se está gestionando la entrega del fondo.";
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '2.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = "Los gastos a reembolsar deben ser respaldados mediante documentos tributarios (boletas y/o facturas). Esta recomendación incluye gastos en pasajes aéreos.";
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '3.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'Para dar cumplimiento a lo establecido en el Artículo Nº31 de la Ley de la Renta, SDT USACH LTDA. no podrá aceptar respaldos de gastos que contengan documentos nominados como “Vales Por”.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '4.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'Aquellos gastos a reembolsar, que por su naturaleza no puedan ser respaldados con documentos tributarios, deben presentar un comprobante que sea emitido por la persona jurídica o natural que entregó el producto o servicio adquirido. SDT USACH LTDA. se reserva el derecho de comprobar la autenticidad de los documentos enviados.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '5.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'No se aceptarán solicitudes de reembolsos que incorporen boletas de prestación de servicios profesionales (honorarios). Una Boleta de Honorarios debe ser cancelada a través del Procedimiento de Pago de Honorarios, para lo cual debe completar el Formulario de Solicitud de Pago de Honorarios, adjuntar la Boleta y el Informe de Actividades respectivo.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '6.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'Los documentos tributarios, ya sea Boletas Electrónicas y/o Facturas, deben ser emitidas a nombre de SDT USACH LTDA.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '7.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'Las compras vía tarjeta de crédito, podrán ser incorporadas en una solicitud de reembolso, siempre y cuando sean pactadas en una sola cuota.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '8.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'Si el gasto corresponde a un Activo Fijo, podrá ser incorporado en una solicitud de reembolso, siempre y cuando su respaldo corresponda a una factura.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '9.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'Los reembolsos de gastos no pueden ser utilizados para la compra de materiales que serán utilizados en obras de infraestructura, ni para el pago de contratistas por la ejecución y/o estudio de obras.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	$nLn = $pdf->GetY() + 2;
	$pdf->SetTextColor(234, 80, 55);
	$pdf->Cell(3,5, '10.',0,0,'L');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(17,$nLn);
	$evaluacion = 'La aceptación de las Solicitudes de Reembolsos que no cumplan las condiciones descritas, deberán ser solicitadas formalmente a la Dirección Ejecutiva de SDT USACH LTDA. para su evaluación.';
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");


	// CUERPO SEGUNDA HOJA
	


	// Pie
	$fila = 310;
	$pdf->SetXY(10,$fila);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->MultiCell(185,25,'',1,'L', true);

	$fila += 2;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5,"Alameda Libertador",0,0,"L");

	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Trece Oriente Nº2211"),0,0,"L");

	$fila += 5;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Bernardo O'higgins 1611"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Piso 1, Iquique"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Santiago"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+57 22 488 84(85)"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("+562 2718 1400"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+569 4409 2070"),0,0,"L");

	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Line(160, 312, 160, 333);



	// SEGUNDA HOHA F3B
	
    $agnoActual = date('Y'); 
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/tmp/';;
	
    if(file_exists($vDir)){
        //$doc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos/tmp/REM-'.$nInf.'.pdf';
        $doc = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/tmp/REM-'.$nInf.'.pdf';
        if(file_exists($doc)){
			$pageCount = $pdf->setSourceFile($doc);
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
				$templateId = $pdf->importPage($pageNo);
				$size = $pdf->getTemplateSize($templateId);
				$pdf->AddPage();
				$pdf->useTemplate($templateId, ['adjustPageSize' => true]);
			}
        }
    }
	
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/';;

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F3B-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'F');
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
    copy($NombreFormulario, $vDir.'/'.$NombreFormulario);
    copy($vDir.$NombreFormulario, '../tmp/'.$NombreFormulario);
	unlink($NombreFormulario);

}

if($Formulario == "F7"){
    $pdf=new Fpdi('P','mm','Legal'); 

	$nDocumentos = 0;

	$link=Conectarse();

	$tNeto 	= 0;
	$tIva 	= 0;
	$tBruto = 0;
	
	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInf,0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFillColor(234, 80, 55);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(180,10,'FORMULARIO DE SOLICITUD DE PAGO DE FACTURAS',1,0,'C', true);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetDrawColor(0, 0, 0);

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5, utf8_decode('FECHA DE EMISIÓN DEL FORMULARIO:'),0,0);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(110,5,utf8_decode('COMPLETE LOS SIGUIENTES CAMPOS:'),0,0);
	$pdf->SetFont('Arial','',7);
	
	$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$_GET['IdProyecto']."'");
	if($rowPr=mysqli_fetch_array($bdPr)){
		$JefeProyecto 	= $rowPr['JefeProyecto'];
		$firmaJefe 		= $rowPr['firmaJefe'];

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
		//$pdf->Cell(110,10,$Concepto,1,0);
		$pdf->Cell(110,10,$Concepto,1,0);
		//$pdf->MultiCell(180,5,utf8_decode($Concepto), 0, "J");


	}

	$pdf->Ln(10);		
	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	$pdf->SetTextColor(255, 255, 255);
	if($Iva=="sIva"){
			$pdf->Cell(65,5,'PROVEEDOR',1,0,'C', true);
			$pdf->Cell(35,5,utf8_decode('Nº DE FACTURA'),1,0,'C', true);
			$pdf->Cell(35,5,'RUT',1,0,'C', true);
			$pdf->Cell(45,5,'VALOR TOTAL',1,0,'C', true);
			//          180
	}
	if($Iva=="cIva"){
			$pdf->Cell(65,5,'PROVEEDOR',1,0,'C', true);
			$pdf->Cell(35,5,utf8_decode('Nº DE FACTURA'),1,0,'C', true);
			$pdf->Cell(35,5,'RUT',1,0,'C', true);
			$pdf->Cell(45,5,'VALOR TOTAL',1,0,'C', true);
	}
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','',7);

	$tBrupo = 0;
	$pdf->Ln(5);
	
	if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' and IdRecurso = 5 and Iva = 0 and Estado != 'I'"; 
	}
	if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' and IdRecurso = 5 and Iva > 0 and Estado != 'I'"; 
	}
	
	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($rowGto=mysqli_fetch_array($bdGto)){
				// Inicio Linea de Detalle
				if($Iva=="sIva"){
					$pdf->Cell(65,5,utf8_decode($rowGto['Proveedor']),1,0).'- Sin Iva '.$Iva;
					$pdf->Cell(35,5,$rowGto['nDoc'],1,0,'C');
					$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
					if ($rowProv=mysqli_fetch_array($bdProv)){
						$pdf->Cell(35,5,$rowProv['RutProv'],1,0,'C');
					}
					$pdf->Cell(45,5,number_format($rowGto['Bruto'], 0, ',', '.'),1,0,'R');
					$tBruto += $rowGto['Bruto'];
					$nDocumentos++;
					$pdf->Ln(5);
				}else{
					$pdf->Cell(65,5,utf8_decode($rowGto['Proveedor']),1,0).'- Con Iva '.$Iva;
					$pdf->Cell(35,5,$rowGto['nDoc'],1,0,'C');
					$bdProv=$link->query("SELECT * FROM Proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
					if ($rowProv=mysqli_fetch_array($bdProv)){
						$pdf->Cell(35,5,$rowProv['RutProv'],1,0,'C');
					}
					//$pdf->Cell(15,5,number_format($rowGto['Neto'], 0, ',', '.'),1,0,'R');
					//$pdf->Cell(15,5,number_format($rowGto['Iva'], 0, ',', '.'),1,0,'R');
					$pdf->Cell(45,5,number_format($rowGto['Bruto'], 0, ',', '.'),1,0,'R');
					$tNeto 	+= $rowGto['Neto'];
					$tIva 	+= $rowGto['Iva'];
					$tBruto += $rowGto['Bruto'];
					$nDocumentos++;
					$pdf->Ln(5);
				}
	}
	if($Iva=="sIva"){
			$pdf->Cell(65,5,'',0,0,'C');
			$pdf->Cell(35,5,'',0,0,'C');
			$pdf->Cell(35,5,'TOTAL',0,0,'R');
			$pdf->Cell(45,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}else{
			$pdf->Cell(65,5,'',0,0,'C');
			$pdf->Cell(35,5,'',0,0,'C');
			$pdf->Cell(35,5,'TOTAL',0,0,'R');
			//$pdf->Cell(15,5,"$ ".number_format($tNeto, 0, ',', '.'),1,0,'R');
			//$pdf->Cell(15,5,"$ ".number_format($tIva, 0, ',', '.'),1,0,'R');
			$pdf->Cell(45,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}
	$pdf->Ln(10);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(180,5,'DATOS BANCARIOS DEL PROVEEDOR PROVEEDOR',1,0,'C', true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln(5);
	$pdf->Cell(70,5, utf8_decode('NÚMERO DE CUENTA'),1,0);
	$pdf->Cell(110,5,$rowProv['NumCta'],1,0);
	$pdf->Ln(5);
	$pdf->Cell(70,5,utf8_decode('ENTIDAD BANCARIA'),1,0);
	$pdf->Cell(110,5,$rowProv['Banco'],1,0);
	$pdf->Ln(5);
	$pdf->Cell(70,5, utf8_decode('CORREO ELECTRÓNICO'),1,0);
	$pdf->Cell(110,5,$rowProv['Email'],1,0);

	$pdf->Ln(12);
	$pdf->MultiCell(180,5,utf8_decode('Se Solicita Completar la Recepción Conforme del Producto y/o Servicio adquirido y la Evaluación de Proveedor presentes en la siguiente página.'), 0, "J");
	
		
	// Firmas
	$pdf->SetFont('Arial','B',7);
	$ln = 285;
		
	$pdf->SetXY(10,$ln);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);
		
	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);
		
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,utf8_decode($JefeProyecto),0,0,"C");
	$pdf->Cell(130,5,utf8_decode($nombreSuper),0,0,"C");

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,40,$ln-40,40,40);
	}
	$firmaDirector = 'aaa.png';
	$pdf->Image('../../ft/'.$firmaSuper,130,$ln-40,40,40);

	$pdf->Image('../../ft/timbreSolicitudes.png',80,$ln-40,40,40);
	//$pdf->Image('../../ft/TimbreDirector.png',120,$ln-20,20,20);

	$ln += 3;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,utf8_decode($cargoSuper),0,0,"C");
	$pdf->SetFont('Arial','',7);

	// Fin Firmas

	// Pie
	$fila = 310;
	$pdf->SetXY(10,$fila);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->MultiCell(185,25,'',1,'L', true);

	$fila += 2;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5,"Alameda Libertador",0,0,"L");

	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Trece Oriente Nº2211"),0,0,"L");

	$fila += 5;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Bernardo O'higgins 1611"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Piso 1, Iquique"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Santiago"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+57 22 488 84(85)"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("+562 2718 1400"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+569 4409 2070"),0,0,"L");

	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Line(160, 312, 160, 333);

// SEGUNDA HOJA F7

	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInf,0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFillColor(234, 80, 55);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(180,10, utf8_decode('RECEPCIÓN CONFORME DEL PRODUCTO Y/O SERVICIO ADQUIRIDO Y EVALUACIÓN DEL PROVEEDOR'),1,0,'C', true);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetDrawColor(0, 0, 0);

	$nLn = $pdf->GetY() + 15;
	$pdf->SetXY(10,$nLn);
	$pdf->SetFont('Arial','B',10);
	$Nota = "RECEPCIÓN CONFORME DEL PRODUCTO Y/O SERVICIO ADQUIRIDO";
	$pdf->Cell(180,5,utf8_decode($Nota),0,0,"L");

	$pdf->SetFont('Arial','',10);
	$nLn += 7;
	$pdf->SetXY(10,$nLn);
	$recepcionConforme = "Yo ";
	$recepcionConforme .= utf8_decode($JefeProyecto);
	$recepcionConforme .= " recibí conforme el producto y/o servicio adquirido, de nombre: ";
	$recepcionConforme .= utf8_decode($rowGto['Bien_Servicio']).", de parte del proveedor ";
	$recepcionConforme .= utf8_decode($rowGto['Proveedor']);
	// $pdf->Cell(180,5,utf8_decode($recepcionConforme),0,0,"J");
	$pdf->MultiCell(180,5,utf8_decode($recepcionConforme), 0, "J");

	// +++

	$nLn += 20;
	$pdf->SetXY(10,$nLn);
	$pdf->SetFont('Arial','B',10);
	$Nota = "EVALUACIÓN DEL PROVEEDOR";
	$pdf->Cell(180,5,utf8_decode($Nota),0,0,"L");

	$pdf->SetFont('Arial','',10);
	$nLn += 7;
	$pdf->SetXY(10,$nLn);
	$evaluacion = "En la siguiente tabla Ud. podrá evaluar al proveedor del producto o servicio y/o adquirido, con una puntuación que abarca desde un mínimo de 1, que representa la peor calificación, a un máximo de 5, para la mejor calificación. Esta evaluación debe ser aplicada al costo del producto y/o servicio adquirido, su calidad y los Servicios de Pre y Post Venta entregados por el proveedor.";
	$pdf->MultiCell(180,5,utf8_decode($evaluacion), 0, "J");

	// $pdf->Ln(5);
	$nLn += 30;
	// $nLn = $pdf->GetY() + 30;
	$pdf->SetXY(35,$nLn);
	$pdf->MultiCell(110,5,utf8_decode('Calificación de Proveedores de 1 a 5'), 1, "C");

	$nLn += 5;
	$pdf->SetXY(35,$nLn);
	$pdf->Cell(27,5,'COSTO', 1, 0, "C");
	$pdf->Cell(27,5,'CALIDAD', 1, 0, "C");
	$pdf->Cell(27,5,'PREVENTA', 1, 0, "C");
	$pdf->Cell(29,5,'POSTVENTA', 1, 0, "C");

	if($Iva=="sIva"){
		$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' and IdRecurso = 5 and Iva = 0 and Estado != 'I'"; 
	}
	if($Iva=="cIva"){
		$filtroSQL = "Where IdProyecto ='".$_GET['IdProyecto']."' and IdRecurso = 5 and Iva > 0 and Estado != 'I'"; 
	}

	$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($rowGto=mysqli_fetch_array($bdGto)){
			$nLn += 5;
			$pdf->SetXY(35,$nLn);
			$pdf->Cell(27,5,$rowGto['CalCosto'], 1, 0, "C");
			$pdf->Cell(27,5,$rowGto['CalCalidad'], 1, 0, "C");
			$pdf->Cell(27,5,$rowGto['CalPreVenta'], 1, 0, "C");
			$pdf->Cell(29,5,$rowGto['CalPostVenta'], 1, 0, "C");
	}




	// Firmas
	$pdf->SetFont('Arial','B',7);
	$ln = 285;
		
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

	$pdf->Cell(130,5,utf8_decode($nombreSuper),0,0,"C");
	// $pdf->Cell(130,5,'Cristian Vargas Riquelme',0,0,"C");

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,40,$ln-40,40,40);
	}
	$firmaDirector = 'aaa.png';
	$pdf->Image('../../ft/'.$firmaSuper,130,$ln-40,40,40);

	$pdf->Image('../../ft/timbreSolicitudes.png',80,$ln-40,40,40);
	//$pdf->Image('../../ft/TimbreDirector.png',120,$ln-20,20,20);

	$ln += 3;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,utf8_decode($cargoSuper),0,0,"C");
	$pdf->SetFont('Arial','',7);

	// Fin Firmas



	// Pie
	$fila = 310;
	$pdf->SetXY(10,$fila);
	$pdf->SetDrawColor(234, 80, 55);
	$pdf->MultiCell(185,25,'',1,'L', true);

	$fila += 2;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5,"Alameda Libertador",0,0,"L");

	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Trece Oriente Nº2211"),0,0,"L");

	$fila += 5;
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Bernardo O'higgins 1611"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("Piso 1, Iquique"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("Santiago"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+57 22 488 84(85)"),0,0,"L");

	$fila += 5;
	$pdf->SetTextColor(240,240,240);
	$pdf->SetXY(120,$fila);
	$pdf->Cell(70,5, utf8_decode("+562 2718 1400"),0,0,"L");

	$pdf->SetXY(162,$fila);
	$pdf->Cell(70,5, utf8_decode("+569 4409 2070"),0,0,"L");

	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Line(160, 312, 160, 333);

	// FIN SEGUNDA HOJA





	//$Concepto = $concepto;
	$IdProyecto = $_GET['IdProyecto'];


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


	$agnoActual = date('Y'); 


	// $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos/tmp/';;
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/tmp/';;
	if(file_exists($vDir)){
		// $doc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos/tmp/REM-'.$nInf.'.pdf';
		$doc = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/tmp/REM-'.$nInf.'.pdf';
		if(file_exists($doc)){
			$pageCount = $pdf->setSourceFile($doc);
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
				$templateId = $pdf->importPage($pageNo);
				$size = $pdf->getTemplateSize($templateId);
				$pdf->AddPage();
				$pdf->useTemplate($templateId, ['adjustPageSize' => true]); 
			}
		}
	}


	// $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos/PagoFacturas/';;
	$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/';;

	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F7-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'F');
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
    copy($NombreFormulario, $vDir.'/'.$NombreFormulario);
    copy($NombreFormulario, '../tmp/'.$NombreFormulario);
	unlink($NombreFormulario);

}

?>
