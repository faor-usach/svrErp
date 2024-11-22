<?php
    //require('../../fpdf/fpdf.php');
    require_once("../../fpdf182/fpdf.php");

    require_once("../../fpdi/src/autoload.php");
    use \setasign\Fpdi\Fpdi;

	include_once("../../conexionli.php");

	$nSolicitud = $_GET['nSolicitud'];
	$IdProyecto = '';
	$Departamento = '';
	$Fono = '';
	$Correo = '';

	$Mes = array(
					'Enero',  
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				);

	$link=Conectarse();
	$bdSol=$link->query("SELECT * FROM solfactura WHERE nSolicitud = '$nSolicitud'");
	if($rowSol=mysqli_fetch_array($bdSol)){


		$IdProyecto = $rowSol['IdProyecto'];
		$pdf=new Fpdi('P','mm','A4');
		$pdf->AddPage();
		

		//$pdf->Image('../../gastos/logos/logousach.png',170,10,15,23);
		//$pdf->Image('../../gastos/logos/logousach.png',170,10,15,23);
		$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40);

		//$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
		//$pdf->Cell(100,1,utf8_decode('SOCIEDAD DE DESARROLLO TECNOLÓGICO DE LA USACH LTDA.'),0,2,'C');

		$pdf->SetFont('Arial','',6);
		$pdf->Cell(140,5,'',0,0);
		$pdf->Cell(5,5,$nSolicitud,0,0);


		$pdf->Ln(20);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(234, 80, 55);
		//$pdf->SetDrawColor(234, 80, 55);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetXY(10,37);
		$pdf->Cell(100,5,'FORMULARIO DE SOLICITUD DE FACTURA',1,0,'C', true);
		//$pdf->SetDrawColor(0, 0, 0);
		$pdf->SetTextColor(0, 0, 0);


		//$pdf->SetFillColor(0,0,0);
		//$pdf->Cell(60,5,,1,0,'L');
		
		$pdf->SetFont('Arial','',7);
		$pdf->SetXY(120,37);
		$pdf->Cell(40,5,'(Uso Interno SDT)',1,0,'L');
		$pdf->Cell(35,5,'',1,0,'L');
		$pdf->SetXY(120,42);
		$pdf->Cell(40,5,utf8_decode('Nº Fact:'),1,0,'L');
		$pdf->Cell(35,5,'',1,0,'L');
		
		/*
		$pdf->SetXY(10,44);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(70,5,'FECHA:',0,0);
		$fd 	= explode('-', $rowSol['fechaSolicitud']);
		$pdf->Cell(110,5,$fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0],0,0);
		

		$bdDep=$link->query("SELECT * FROM Departamentos");
		if($rowDep=mysqli_fetch_array($bdDep)){
			$NomDirector 	= utf8_decode(($rowDep['NomDirector']));
			$EmailDepto 	= utf8_decode($rowDep['EmailDepto']);
			$pdf->SetXY(10,49);
			$pdf->Cell(70,5,'DE:',0,0);
			$pdf->Cell(110,5,utf8_decode(strtoupper($rowDep['NomDirector'])).' ('.utf8_decode($rowDep['Cargo']).')',0,0);
		}		

		$pdf->SetXY(10,54);
		$pdf->Cell(70,5,'A:',0,0);
		$pdf->Cell(110,5,utf8_decode('DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLÓGICO  (SDT)'),0,0);
		*/
		
		$pdf->SetXY(10,59);
		$pdf->Cell(70,5,utf8_decode('Solicto a Ud. emisión de factura de venta para:'),0,0);

		$pdf->SetXY(10,64);
		$pdf->Cell(70,5,'NOMBRE DEL PROYECTO:',0,0);
		
		$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$rowSol['IdProyecto']."'");
		if($rowPr=mysqli_fetch_array($bdPr)){
			$JefeProyecto = $rowPr['JefeProyecto'];
			$firmaJefe = $rowPr['firmaJefe'];
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(50,6,$rowPr['Proyecto'],1,0,'C');

			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(130,64);
			$pdf->Cell(35,6,utf8_decode('CÓDIGO DEL PROYECTO'),0,0);
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(160,64);
			$pdf->Cell(35,6,strtoupper($rowSol['IdProyecto']),1,0,'C');
		}
		
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(10,69);
		$pdf->Cell(35,10,'DATOS DE LA EMPRESA CLIENTE:',0,0);

		$pdf->SetFont('Arial','',7);

		$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowSol['RutCli']."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$pdf->SetXY(10,76);
			$pdf->Cell(70,5,utf8_decode('RAZÓN SOCIAL:'),0,0);
			$pdf->Cell(115,5,strtoupper(utf8_decode($rowCli['Cliente'])),1,0);

			$pdf->SetXY(10,83);
			$pdf->Cell(70,5,'GIRO:',0,0);
			$pdf->Cell(115,5,utf8_decode($rowCli['Giro']),1,0);

			$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowSol['RutCli']."' and Contacto Like '%".$rowSol['Contacto']."%'");
			if($rowCon=mysqli_fetch_array($bdCon)){
				$Contacto 		= $rowCon['Contacto'];
				$Departamento 	= $rowCon['Depto'];
				$Correo 		= $rowCon['Email'];
				$Fono 			= $rowCli['Telefono'];
			}

				$pdf->SetXY(10,90);
				$pdf->Cell(70,5,utf8_decode('ATENCIÓN:'),0,0);
				$pdf->Cell(115,5,utf8_decode($rowSol['Atencion']),1,0);

			
			$pdf->SetXY(10,97);
			$pdf->Cell(70,5,'DEPARTAMENTO:',0,0);
			$pdf->Cell(115,5,strtoupper(utf8_decode($Departamento)),1,0);

			$pdf->SetXY(10,104);
			$pdf->Cell(70,5,'RUT:',0,0);
			$pdf->Cell(115,5,strtoupper($rowCli['RutCli']),1,0);

			$pdf->SetXY(10,111);
			$pdf->Cell(70,5,utf8_decode('DIRECCIÓN / COMUNA:'),0,0);
			$pdf->Cell(115,5,strtoupper($rowCli['Direccion']),1,0);

			$pdf->SetXY(10,118);
			$pdf->Cell(70,5,'FONO:',0,0);
			if($Fono){
				$pdf->Cell(50,5,$Fono,1,0);
			}else{
				$pdf->Cell(50,5,$rowCli['Telefono'],1,0);
			}

			$fdCorreos = explode(',', $rowSol['correosFactura']);
			$nFilas = count($fdCorreos) * 5;
			$pdf->SetXY(10,125);
			$pdf->Cell(70,5,utf8_decode('CORREO ELECTRÓNICO:'),0,0);
			//$pdf->SetTextColor(0,0,0);
			$pdf->Cell(50,$nFilas,'',1,0, 'C');

			$pdf->SetXY(140,125);
			$pdf->Cell(20,6,'VENCIMIENTO',0,0);
			$pdf->SetXY(160,125);
			$valVencimiento = $rowSol['vencimientoSolicitud'].utf8_decode(' Días');
			if($rowSol['vencimientoSolicitud'] == 0){
				$valVencimiento = 'Contado';
			}
			$pdf->SetFillColor(249, 231, 159);
			$pdf->Cell(35,6,$valVencimiento,1,0, 'C', true);

			$pdf->SetXY(10,128);
			$pdf->SetFont('Arial','',5);
			$pdf->Cell(70,5,utf8_decode('(A ESTA DIRECCIÓN SERÁ EMITIDA LA FACTURA UNA VEZ'). $nFilas,0,0);
			$pdf->SetXY(10,130);
			$pdf->Cell(70,5,'EMITIDA)',0,0);
			
			$fdCorreos = explode(',', $rowSol['correosFactura']);
			$ln = 120;
			for($i=0; $i < count($fdCorreos); $i++){
				$ln += 5;
				$pdf->SetFont('Arial','',7);
				$pdf->SetXY(10,$ln);
				$pdf->Cell(70,4,'',0,0);
				$pdf->Cell(50,4,$fdCorreos[$i],0,0);
			}
		}		
		$ln += 7;
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(10,$ln);
		$pdf->Cell(20,5,'CANTIDAD',1,0,'C');
		$pdf->Cell(125,5,utf8_decode('ESPECIFICACIÓN'),1,0,'C');
		$pdf->Cell(20,5,'Valor Unitario',1,0,'C');
		$pdf->Cell(20,5,'VALOR TOTAL',1,0,'C');
		
		$pdf->SetFont('Arial','',6);
		//$ln = $ln + 5;
		$bdDet=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' Order By nItems");
		if($rowDet=mysqli_fetch_array($bdDet)){
			do{
				$ln += 5;
				$co = 5;
				$pdf->SetXY(10,$ln);
				$pdf->MultiCell(20,$co,$rowDet['Cantidad'],1,'C');
				
				$pdf->SetXY(30,$ln);
				$pdf->Cell(125,$co,strtoupper($rowDet['Especificacion']),1,0,'L');

				$pdf->SetFont('Arial','',6);
				$pdf->SetXY(155,$ln);
				if($rowSol['tipoValor']=='D'){
					if(($rowDet['valorUnitarioUS'] - intval($rowDet['valorUnitarioUS']))>0){
						$pdf->MultiCell(20,$co,'US$ '.number_format($rowDet['valorUnitarioUS'], 2, ',', '.'),1,'R');
					}else{
						$pdf->MultiCell(20,$co,'US$ '.number_format($rowDet['valorUnitarioUS'], 0, ',', '.'),1,'R');
					}
				}

				if($rowSol['tipoValor']=='U'){
					if(($rowDet['valorUnitarioUF'] - intval($rowDet['valorUnitarioUF']))>0){
						$pdf->MultiCell(20,$co,number_format($rowDet['valorUnitarioUF'], 2, ',', '.').' UF',1,'R');
					}else{
						$pdf->MultiCell(20,$co,number_format($rowDet['valorUnitarioUF'], 0, ',', '.').' UF',1,'R');
					}
				}
				if($rowSol['tipoValor']=='P'){
					$pdf->MultiCell(20,$co,'$ '.number_format($rowDet['valorUnitario'], 0, ',', '.'),1,'R');
				}

				$pdf->SetXY(175,$ln);
				if($rowSol['tipoValor']=='D'){
					if(($rowDet['valorTotalUS'] - intval($rowDet['valorTotalUS']))>0){
						$pdf->MultiCell(20,$co,'US$ '.number_format($rowDet['valorTotalUS'], 2, ',', '.'),1,'R');
					}else{
						$pdf->MultiCell(20,$co,'US$ '.number_format($rowDet['valorTotalUS'], 0, ',', '.'),1,'R');
					}
				}
				if($rowSol['tipoValor']=='U'){
					if(($rowDet['valorTotalUF'] - intval($rowDet['valorTotalUF']))>0){
						$pdf->MultiCell(20,$co,number_format($rowDet['valorTotalUF'], 2, ',', '.').' UF',1,'R');
					}else{
						$pdf->MultiCell(20,$co,number_format($rowDet['valorTotalUF'], 0, ',', '.').' UF',1,'R');
					}
				}
				if($rowSol['tipoValor']=='P'){
					$pdf->MultiCell(20,$co,'$ '.number_format($rowDet['valorTotal'], 0, ',', '.'),1,'R');
				}

			}while ($rowDet=mysqli_fetch_array($bdDet));
		}
		$infoAM  = "";
		$infoCAM = "";
		$sw		 = "No";
		if($rowSol['informesAM']){
			$fdInf = explode('-', $rowSol['informesAM']);
			$i = 0;
			$dAM = '';
			foreach($fdInf as $valor){
				if($i == 0){
					$dAM = $valor;
				}else{
					$dAM .= ' - '.$valor;
				}
				$i++;
			}
			$infoAM = 'INFORME(s) AM: '.strtoupper($dAM);
			$sw		= "Si";
		}
		if($rowSol['cotizacionesCAM']){
			$fdCAM = explode('-', $rowSol['cotizacionesCAM']);
			$i = 0;
			$dCAM = '';
			foreach($fdCAM as $valor){
				if($i == 0){
					$dCAM = $valor;
				}else{
					$dCAM .= ' - '.$valor;
				}
				$i++;
			}
			//$infoCAM = 'COTIZACION(ES) CAM: '.strtoupper($rowSol['cotizacionesCAM']);
			$infoCAM = 'COTIZACION(ES) CAM: '.strtoupper($dCAM);
			$sw		= "Si";
		}
		if(strlen($infoAM)>0 && strlen($infoCAM)>0 ){
			$ln +=5;

			$pdf->SetXY(30,$ln);
			$pdf->SetXY(155,$ln);
			$pdf->MultiCell(20,5,'MONTO NETO',1,'C');

			$pdf->SetXY(175,$ln);
			if($rowSol['tipoValor']=='D'){
				if(($rowSol['NetoUS'] - intval($rowSol['NetoUS']))>0){
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['NetoUS'], 2, ',', '.'),1,'R');
				}else{
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['NetoUS'], 0, ',', '.'),1,'R');
				}
			}
			if($rowSol['tipoValor']=='U'){
				if(($rowSol['netoUF'] - intval($rowSol['netoUF']))>0){
					$pdf->MultiCell(20,5,number_format($rowSol['netoUF'], 2, ',', '.').' UF',1,'R');
				}else{
					$pdf->MultiCell(20,5,number_format($rowSol['netoUF'], 0, ',', '.').' UF',1,'R');
				}
			}
			if($rowSol['tipoValor']=='P'){
				$pdf->MultiCell(20,5,'$ '.number_format($rowSol['Neto'], 0, ',', '.'),1,'R');
			}

			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(85,15,'',1,'L');
			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(85,3,$infoAM,0,'L');
			$ln +=6;
			$pdf->SetXY(30,$ln);
			$pdf->MultiCell(85,3,$infoCAM,0,'L');

		}else{
			if(strlen($infoAM)>0){
				$ln +=5;
				$pdf->SetXY(30,$ln);
				$pdf->MultiCell(85,5,'',1,'L');
				$pdf->SetXY(30,$ln);
				$pdf->MultiCell(85,5,$infoAM,0,'L');
			}
			if(strlen($infoCAM)>0){
				$ln +=5;
				$pdf->SetXY(30,$ln);
				$pdf->MultiCell(85,5,'',1,'L');
				$pdf->SetXY(30,$ln);
				$pdf->MultiCell(85,5,$infoCAM,0,'L');
			}
			if(strlen($infoAM)>0 || strlen($infoCAM)>0 ){
				$pdf->SetXY(155,$ln);
				$pdf->MultiCell(20,5,'MONTO NETO',1,'C');
	
				$pdf->SetXY(175,$ln);
				if($rowSol['tipoValor']=='D'){
					if(($rowSol['NetoUS'] - intval($rowSol['NetoUS']))>0){
						$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['NetoUS'], 2, ',', '.'),1,'R');
					}else{
						$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['NetoUS'], 0, ',', '.'),1,'R');
					}
				}
				if($rowSol['tipoValor']=='U'){
					if(($rowSol['netoUF'] - intval($rowSol['netoUF']))>0){
						$pdf->MultiCell(20,5,number_format($rowSol['netoUF'], 2, ',', '.').' UF',1,'R');
					}else{
						$pdf->MultiCell(20,5,number_format($rowSol['netoUF'], 0, ',', '.').' UF',1,'R');
					}
				}
				if($rowSol['tipoValor']=='P'){
					$pdf->MultiCell(20,5,'$ '.number_format($rowSol['Neto'], 0, ',', '.'),1,'R');
				}
			}
		}
		if($sw=='No'){
			$ln +=4;
			$pdf->SetXY(155,$ln);
			$pdf->MultiCell(20,5,'MONTO NETO',1,'C');

			$pdf->SetXY(175,$ln);
			if($rowSol['tipoValor']=='D'){
				if(($rowSol['NetoUS'] - intval($rowSol['NetoUS']))>0){
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['NetoUS'], 2, ',', '.'),1,'R');
				}else{
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['NetoUS'], 0, ',', '.'),1,'R');
				}
			}
			if($rowSol['tipoValor']=='U'){
				if(($rowSol['netoUF'] - intval($rowSol['netoUF']))>0){
					$pdf->MultiCell(20,5,number_format($rowSol['netoUF'], 2, ',', '.').' UF',1,'R');
				}else{
					$pdf->MultiCell(20,5,number_format($rowSol['netoUF'], 0, ',', '.').' UF',1,'R');
				}
			}
			if($rowSol['tipoValor']=='P'){
				$pdf->MultiCell(20,5,'$ '.number_format($rowSol['Neto'], 0, ',', '.'),1,'R');
			}

			$ln +=5;
			$pdf->SetXY(155,$ln);
			$pdf->MultiCell(20,5,'19% IVA',1,'C');
	
			$pdf->SetXY(175,$ln);
			if($rowSol['tipoValor']=='D'){
				if(($rowSol['IvaUS'] - intval($rowSol['IvaUS']))>0){
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['IvaUS'], 2, ',', '.'),1,'R');
				}else{
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['IvaUS'], 0, ',', '.'),1,'R');
				}
			}
			if($rowSol['tipoValor']=='U'){
				if(($rowSol['ivaUF'] - intval($rowSol['ivaUF']))>0){
					$pdf->MultiCell(20,5,number_format($rowSol['ivaUF'], 2, ',', '.').' UF',1,'R');
				}else{
					$pdf->MultiCell(20,5,number_format($rowSol['ivaUF'], 0, ',', '.').' UF',1,'R');
				}
			}
			if($rowSol['tipoValor']=='P'){
				$pdf->MultiCell(20,5,'$ '.number_format($rowSol['Iva'], 0, ',', '.'),1,'R');
			}
		}else{
			$ln +=4;
			if(strlen($infoAM)>0 && strlen($infoCAM)>0 ){
				$ln -=5;
			}
			$pdf->SetXY(155,$ln);
			$pdf->MultiCell(20,5,'19% IVA',1,'C');
	
			$pdf->SetXY(175,$ln);
			if($rowSol['tipoValor']=='D'){
				if(($rowSol['IvaUS'] - intval($rowSol['IvaUS']))>0){
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['IvaUS'], 2, ',', '.'),1,'R');
					//$pdf->MultiCell(40,5,number_format($rowSol['IvaUF'], 0, ',', '.').' UF',1,'R');
				}else{
					$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['IvaUS'], 0, ',', '.'),1,'R');
				}
			}
			if($rowSol['tipoValor']=='U'){
				if(($rowSol['ivaUF'] - intval($rowSol['ivaUF']))>0){
					$pdf->MultiCell(20,5,number_format($rowSol['ivaUF'], 2, ',', '.').' UF',1,'R');
					//$pdf->MultiCell(40,5,number_format($rowSol['ivaUF'], 0, ',', '.').' UF',1,'R');
				}else{
					$pdf->MultiCell(20,5,number_format($rowSol['ivaUF'], 0, ',', '.').' UF',1,'R');
				}
			}
			if($rowSol['tipoValor']=='P'){
				$pdf->MultiCell(20,5,'$ '.number_format($rowSol['Iva'], 0, ',', '.'),1,'R');
			}
		}
		$ln +=5;
		$pdf->SetXY(155,$ln);
		$pdf->MultiCell(20,5,'TOTAL',1,'C');
	
		$pdf->SetXY(175,$ln);
		if($rowSol['tipoValor']=='D'){
			if(($rowSol['BrutoUS'] - intval($rowSol['BrutoUS']))>0){
				$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['BrutoUS'], 2, ',', '.'),1,'R');
			}else{
				$pdf->MultiCell(20,5,'US$ '.number_format($rowSol['BrutoUS'], 0, ',', '.'),1,'R');
			}
		}
		if($rowSol['tipoValor']=='U'){
			if(($rowSol['brutoUF'] - intval($rowSol['brutoUF']))>0){
				$pdf->MultiCell(20,5,number_format($rowSol['brutoUF'], 2, ',', '.').' UF',1,'R');
				//$pdf->MultiCell(40,5,number_format($rowSol['brutoUF'], 0, ',', '.').' UF',1,'R');
			}else{
				$pdf->MultiCell(20,5,number_format($rowSol['brutoUF'], 0, ',', '.').' UF',1,'R');
			}
		}
		if($rowSol['tipoValor']=='P'){
			$pdf->MultiCell(20,5,'$ '.number_format($rowSol['Bruto'], 0, ',', '.'),1,'R');
		}

		$ln +=5;
		$pdf->SetFont('Arial','',5);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(400,3,utf8_decode('TODA LA FACTURACIÓN ELECTRÓNICA DE SDT SERÁ ENVIADA MEDIANTE E-MAIL A LA DIRECCIÓN'),0,'L');

		$ln +=4;
		$pdf->SetFont('Arial','',5);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(400,3,'INDICADA EN EL PRESENTE FORMULARIO',0,'L');

		$ln +=5;
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(40,5,'ENVIAR FACTURA A:',0,'L');

		$ln +=5;
		$pdf->SetFont('Arial','',7);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(30,5,'USACH',0,'L');
		$pdf->SetXY(30,$ln);
		$pdf->MultiCell(40,5,'(Departamento o persona)',1,'C');
		$pdf->SetXY(70,$ln);
		$pdf->MultiCell(40,5,'EMPRESA (solo marcar x si corresponde)',0,'C');
		$pdf->SetXY(110,$ln);
		if($rowSol['enviarFactura']==2){
			$pdf->MultiCell(10,5,'X',1,'C');
		}else{
			$pdf->MultiCell(10,5,'X',1,'C');
		}
		$pdf->SetXY(120,$ln);
		$pdf->MultiCell(40,5,'OTRO (Especificar)',0,'C');

		$pdf->SetXY(155,$ln);
		$pdf->MultiCell(40,5,'Mail',1,'C');
	
		$ln +=7;
		$pdf->SetXY(10,$ln);
		$pdf->SetFillColor(249, 231, 159);
		$pdf->MultiCell(30,5,$rowSol['nOrden'],1,'C', true);
		$pdf->SetXY(40,$ln);
		$pdf->MultiCell(30,5,utf8_decode('Nº de Orden de Compra'),0,'C');

		$ln +=7;
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(30,5,'Observaciones',0,'L');

		$ln +=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(10,$ln);
		$pdf->SetFillColor(249, 231, 159);
		$pdf->MultiCell(185,5,strip_tags(strtoupper( utf8_decode($rowSol['Observa']))),1,'L', true);

		$txt  = "Nota: La dirección de SDT USACH es Av. Libertador Bernado O'Higgins Nº 1611, sin embargo, para dar inicio a la tramitación de este ";
		$txt .= "Formulario, lo debe entregar en la dirección Av. Bernardo O'Higgins Nº 2229, Oficina de Ingreso de Requerimientos.";
		$ln = $pdf->GetY() + 5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(10,$ln);
		$pdf->MultiCell(185,5,utf8_decode($txt),0,'L');
		
	}

		$bdProv=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
		if ($row=mysqli_fetch_array($bdProv)){
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="Estado			='I'";
			$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
			$bdProv=$link->query($actSQL);
	}
	
	$link->close();

	if($firmaJefe){
		$pdf->Image('../../ft/'.$firmaJefe,40,230,40,40);
		if($IdProyecto == 'IGT-19'){
			$pdf->SetXY(70,260);
			$pdf->Cell(5,5,'p.p.',0,0,"C");
		}
		
	}
	
	$pdf->Image('../../ft/timbreSolicitudes.png',80,230,40,40);

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, 265, 90, 265);
	$pdf->SetXY(20,266);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,utf8_decode($JefeProyecto),0,0,"C");
	$pdf->SetXY(20,268);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");

	$pdf->Line(120, 265, 190, 265);
	$pdf->SetXY(120,266);
	$pdf->Cell(70,5,($NomDirector),0,0,"C");
	$pdf->SetXY(120,268);
	$pdf->Cell(70,5,"Director de Departamento",0,0,"C");

	$agnoActual = date('Y'); 

	$CAM = 0;
	$link=Conectarse();
	$bd=$link->query("SELECT * FROM cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
	if($rs=mysqli_fetch_array($bd)){
		$CAM = $rs['CAM'];
	}

	$directorioSOL = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/SOL-'.$nSolicitud;
    if(!file_exists($directorioSOL)){
		mkdir($directorioSOL);
    }

	$directorioDocOC = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$CAM.'.pdf';;
    if(file_exists($directorioDocOC)){
		$doc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$CAM.'.pdf';;
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

	$directorioDocOC = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/HES-'.$CAM.'.pdf';;
    if(file_exists($directorioDocOC)){
		$doc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/HES-'.$CAM.'.pdf';;
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

	$directorioDocOC = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/ANE-'.$CAM.'.pdf';;
    if(file_exists($directorioDocOC)){
		$doc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/ANE-'.$CAM.'.pdf';;
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




	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "SOL-".$nSolicitud.".pdf";
	//$pdf->Output($NombreFormulario,'D'); //Para Descarga

	$vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/SOL-'.$nSolicitud;
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
	$pdf->Output($NombreFormulario,'F'); //Guarda en un Fichero
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	copy($NombreFormulario, $vDir.'/'.$NombreFormulario);
	unlink($NombreFormulario);


	//$pdf->Output('F3B-00001.pdf','F');

?>
