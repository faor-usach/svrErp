<?php
include('../conexion.php');
require('../../fpdf/fpdf.php');

/* Variables Gets recividas */
$Proyecto	= $_GET['Proyecto'];
$Periodo	= $_GET['Periodo'];

/* Variables */
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

/*
		if($rowH['Estado']!="P"){
			$actSQL="UPDATE Honorarios SET ";
			$actSQL.="FechaPago		='".date('Y-m-d')."',";
			$actSQL.="Estado		='P'";
			$actSQL.="WHERE Run		='".$Run."' && nBoleta = '".$nBoleta."'";
			$bdH=mysql_query($actSQL);
		}
*/

	$link=Conectarse();
	$bdDep=mysql_query("SELECT * FROM Departamentos");
	if ($rowDep=mysql_fetch_array($bdDep)){
		$NomDirector = $rowDep['NomDirector'];
	}
	$bd=mysql_query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
	if ($row=mysql_fetch_array($bd)){
		$NomProyecto 	= $row['Proyecto'];
		$JefeProyecto 	= $row['JefeProyecto'];
	}
	mysql_close($link);

	$pdf=new FPDF('L','mm','Letter');
	$pdf->AddPage();
	$pdf->Image('../../gastos/logos/sdt.png',10,10,33,25);
	$pdf->Image('../../gastos/logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOL�GICO',0,2,'C');
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO 1C',1,0,'C');
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	$pdf->Cell(130,10,'NOMINA DE PRESTADORES DEL PROYECTO',1,0,'L');

	$pdf->Ln(15);
	$pdf->Cell(70,5,'NOMBRE DEL PROYECTO :',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,$NomProyecto,0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'C�DIGO DEL PROYECTO :',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,$Proyecto,0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DURACI�N (meses) :',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'INDEFINIDO',0,0);

	$pdf->SetFont('Arial','B',6);
	$pdf->Ln(10);
	
	$pdf->Cell(50,20,'',1,0,'C');
	$pdf->Cell(14,20,'',1,0,'C');
	$pdf->Cell(13,20,'',1,0,'C');
	$pdf->Cell(14,20,'',1,0,'C');
	$pdf->Cell(25,20,'',1,0,'C');
	$pdf->Cell(18,20,'',1,0,'C');
	$pdf->Cell(35,20,'',1,0,'C');
	$pdf->Cell(70,20,'',1,0,'C');
	$pdf->Cell(14,20,'',1,0,'C');
	$pdf->Cell(8,20,'',1,0,'C');
	$pdf->Ln(1);
	$pdf->Cell(50,5,'Nombre del Profesinal',0,0,'C');
	$pdf->Cell(14,5,'Rut',0,0,'C');
	$pdf->Cell(13,5,'Contrato de',0,0,'C');
	$pdf->Cell(14,5,'Contrato a',0,0,'C');
	$pdf->Cell(25,5,'Periodo de',0,0,'C');
	$pdf->Cell(18,5,'Lugar de',0,0,'C');
	$pdf->Cell(35,5,'Funci�n o',0,0,'C');
	$pdf->Cell(70,5,'Descripci�n de Tarea Principal',0,0,'C');
	$pdf->Cell(14,5,'Monto a',0,0,'C');
	$pdf->Cell(8,5,'N� de',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'(Apellidos - Nombres)',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'Planta',0,0,'C');
	$pdf->Cell(14,5,'Contrata',0,0,'C');
	$pdf->Cell(25,5,'Contrato',0,0,'C');
	$pdf->Cell(18,5,'Desempe�o',0,0,'C');
	$pdf->Cell(35,5,'Cargo',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'Cancelar',0,0,'C');
	$pdf->Cell(8,5,'Pagos',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'USACH',0,0,'C');
	$pdf->Cell(14,5,'USACH',0,0,'C');
	$pdf->Cell(25,5,'Honorarios',0,0,'C');
	$pdf->Cell(18,5,'(Oficina Usach -',0,0,'C');
	$pdf->Cell(35,5,'',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'Mensual',0,0,'C');
	$pdf->Cell(8,5,'',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'(si o no)',0,0,'C');
	$pdf->Cell(14,5,'(Indicar hasta',0,0,'C');
	$pdf->Cell(25,5,'(Desde - Hasta)',0,0,'C');
	$pdf->Cell(18,5,'En Terreno)',0,0,'C');
	$pdf->Cell(35,5,'',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(8,5,'',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(13,5,'',0,0,'C');
	$pdf->Cell(14,5,'que fecha)',0,0,'C');
	$pdf->Cell(25,5,'',0,0,'C');
	$pdf->Cell(18,5,'',0,0,'C');
	$pdf->Cell(35,5,'',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(8,5,'',0,0,'C');

	$pdf->Ln(2);

	$sTotal = 0;
	$link=Conectarse();
	$bdH=mysql_query("SELECT * FROM Honorarios WHERE IdProyecto = '".$Proyecto."' && PeriodoPago = '".$Periodo."' && Estado != 'P' Order By Run");
	if ($rowH=mysql_fetch_array($bdH)){
	DO{
		$Run	 		= $rowH['Run'];
		$nBoleta 		= $rowH['nBoleta'];
		$Descripcion 	= $rowH['Descripcion'];
		$PerIniServ 	= $rowH['PerIniServ'];
		$PerTerServ 	= $rowH['PerTerServ'];
		$LugarTrabajo 	= $rowH['LugarTrabajo'];
		$FuncionCargo 	= $rowH['FuncionCargo'];
		$Descripcion 	= $rowH['Descripcion'];
		$Total 			= $rowH['Total'];
		$sTotal			+= $Total;

		$bdP=mysql_query("SELECT * FROM PersonalHonorarios WHERE Run = '".$Run."'");
		if ($rowP=mysql_fetch_array($bdP)){
			$Nombre 		= $rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'];
			$Run 			= $rowP['Run'];
			$ServicioIntExt	= $rowP['ServicioIntExt'];
			$Banco 			= $rowP['Banco'];
			$nCuenta 		= $rowP['nCuenta'];
			$TipoContrato	= $rowP['TipoContrato'];
			$ServicioIntExt	= $rowP['ServicioIntExt'];
			if(substr($Run,8,1)=="-"){
				$RunF 	= number_format(substr($Run,0,8), 0, ',', '.');
				$Dv		= substr($Run,8,2);
			}else{
				$RunF 	= number_format(substr($Run,0,7), 0, ',', '.');
				$Dv		= substr($Run,7,2);
			}
		}

		$pdf->SetFont('Arial','',6);
		$pdf->Ln(5);
		$pdf->Cell(50,5,$Nombre,1,0);
		$pdf->Cell(14,5,$RunF.$Dv,1,0,'R');
		if($TipoContrato=="P"){
			$pdf->Cell(13,5,'Si',1,0,'C');
		}else{
			$pdf->Cell(13,5,'No',1,0,'C');
		}

		// �Contrato a Contrata, hasta que fecha?
		if($TipoContrato=="P"){
			$pdf->Cell(14,5,'No',1,0,'C');
		}else{
			if($TipoContrato=="C"){ // Indicar la Fecha
				$pdf->Cell(14,5,'No',1,0,'C');
			}else{
				$pdf->Cell(14,5,'No',1,0,'C');
			}
		}
		$fd 	= explode('-', $PerIniServ);
		$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
		$ft 	= explode('-', $PerTerServ);
		$FechaT	= "{$ft[2]}-{$ft[1]}-{$ft[0]}";
		$pdf->Cell(25,5,$fd[2].' al '.$ft[2].' de '.$Mes[intval($ft[1])],1,0);
		$pdf->Cell(18,5,$LugarTrabajo,1,0);
		$pdf->Cell(35,5,$FuncionCargo,1,0);
		$pdf->Cell(70,5,$Descripcion,1,0);
		$pdf->Cell(14,5,number_format($Total, 0, ',', '.'),1,0,'R');
		$pdf->Cell(8,5,'1',1,0,'R');
		
	}WHILE ($rowH=mysql_fetch_array($bdH));
	}
	mysql_close($link);

	$pdf->SetFont('Arial','B',10);
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 180, 90, 180);
	$pdf->SetXY(20,183);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->SetXY(20,188);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 180, 190, 180);
	$pdf->SetXY(120,183);
	$pdf->Cell(70,5,$NomDirector,0,0,"C");
	$pdf->SetXY(120,188);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

/* Imprime Contrato */
	$NombreFormulario = "Prestadores.pdf";
	//$pdf->Output($NombreFormulario,'I'); //Para Imprimir Pantalla
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output($NombreFormulario,'F');

?>
