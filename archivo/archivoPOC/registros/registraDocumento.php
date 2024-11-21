<?php
	$accion = 'Guardar';
	$rBD 	= false;
	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

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
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));

	$dBuscado 			= '';
	$sinAcceso 			= '';

	$nDocGes			= '';
	$Referencia 		= '';
	$Documento 			= '';
	$Version			= '';
	$Revision 			= '';
	$pdf				= '';
	$word				= '';
	$excel				= '';
	$imagen				= '';
	$newPdf				= '';
	$newWord			= '';
	$newExcel			= '';
	$newImagen			= '';
	$fechaRegistro 		= date('Y-m-d');
	$sinAcceso 			= '';
	$tpDoc				= '';
	$Formulario			= 0;
	$IOC				= 0;
	$accion 			= '';

	if(isset($_GET['accion'])) 			{ $accion  			= $_GET['accion']; 			}
	if(isset($_GET['nDocGes'])) 		{ $nDocGes  		= $_GET['nDocGes']; 		}
	if(isset($_GET['Formulario']))		{ $Formulario 		= $_GET['Formulario']; 		}
	if(isset($_GET['IOC']))				{ $IOC 				= $_GET['IOC']; 			}
	if(isset($_GET['Referencia']))		{ $Referencia 		= $_GET['Referencia']; 		}
	if(isset($_GET['fechaRegistro']))	{ $fechaRegistro 	= $_GET['fechaRegistro']; 	}
	if(isset($_GET['tpDoc'])) 			{ $tpDoc  			= $_GET['tpDoc']; 			}
	if(isset($_GET['IOC']))				{ $IOC 				= $_GET['IOC']; 			}

	if(isset($_POST['accion'])) 		{ $accion  			= $_POST['accion']; 		}
	if(isset($_POST['nDocGes'])) 		{ $nDocGes   		= $_POST['nDocGes']; 		}
	if(isset($_POST['Formulario']))		{ $Formulario 		= $_POST['Formulario']; 	}
	if(isset($_POST['IOC']))			{ $IOC 				= $_POST['IOC']; 			}
	if(isset($_POST['Referencia']))		{ $Referencia 		= $_POST['Referencia']; 	}
	if(isset($_POST['fechaRegistro']))	{ $fechaRegistro 	= $_POST['fechaRegistro']; 	}
	if(isset($_POST['tpDoc'])) 			{ $toDoc   			= $_POST['tpDoc']; 			}
	if(isset($_POST['IOC']))			{ $IOC 				= $_POST['IOC']; 			}
	
	if(isset($_POST['nSerie']))			{ $nSerie			= $_POST['nSerie']; 		}
	if(isset($_POST['fechaTentativa']))	{ $fechaTentativa	= $_POST['fechaTentativa']; }
	if(isset($_POST['fechaAccion']))	{ $fechaAccion		= $_POST['fechaAccion']; 	}
	if(isset($_POST['AccionEquipo']))	{ $AccionEquipo		= $_POST['AccionEquipo']; 	}
	if(isset($_POST['usrResponsable']))	{ $usrResponsable	= $_POST['usrResponsable']; }

	if(isset($_POST['confirmarBorrar'])){
		$ReferenciaBorrar = '';
		$link=Conectarse();
		$SQLreg = "SELECT * FROM docRegPOC WHERE nDocGes = $nDocGes and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'";
		$bdDoc=$link->query($SQLreg);
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$ReferenciaBorrar = $rowDoc['Referencia'];
			if($rowDoc['pdf']){
				unlink('../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['pdf']);
				//unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Resgistros/'.$rowDoc['pdf']);
			}
			if($rowDoc['word']){
				unlink('../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['word']);
				//unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['word']);
			}
			if($rowDoc['excel']){
				unlink('../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['excel']);
				//unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['excel']);
			}
			if($rowDoc['imagen']){
				unlink('../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['imagen']);
				//unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['imagen']);
			}
			$bdProv=$link->query("DELETE FROM docRegPOC	WHERE nDocGes = $nDocGes and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'");
		}
		$link->close();

		$link=Conectarse();
		$BorrarCarpeta = 'SI';
		//$SQLreg = "SELECT * FROM docRegPOC WHERE nDocGes = $nDocGes and Referencia = $Formulario";
		$SQLreg = "SELECT * FROM docRegPOC WHERE nDocGes = $nDocGes";
		$bdDoc=$link->query($SQLreg);
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			do{
				echo 'Borrar Carpeta... '.$BorrarCarpeta;
				if($rowDoc['pdf']){
					$BorrarCarpeta = 'NO';
				}
				if($rowDoc['word']){
					$BorrarCarpeta = 'NO';
				}
				if($rowDoc['excel']){
					$BorrarCarpeta = 'NO';
				}
				if($rowDoc['imagen']){
					$BorrarCarpeta = 'NO';
				}
			}while ($rowDoc=mysqli_fetch_array($bdDoc));
		}
		if($BorrarCarpeta == 'SI'){
			rmdir('../../'.$ReferenciaBorrar.'/Registros');
		}
		$link->close();
		header("Location: ../../archivoPOC/Registros/index.php?accion=Mostrar&nDocGes=$nDocGes&Formulario=$Formulario");
	}
	if(isset($_POST['confirmarGuardar'])){ 

		$rBD 				= true;
		$nDocGes 			= $_POST['nDocGes'];
		$Referencia 		= $_POST['Referencia'];
		$Documento 			= $_POST['Documento'];
		$fechaRegistro		= $_POST['fechaRegistro'];

		/* Documento PDF */
		$nombre_Pdf 	= $_FILES['PDF']['name'];
		$tipo_Pdf 		= $_FILES['PDF']['type'];
		$tamano_Pdf 	= $_FILES['PDF']['size'];
		$desde_Pdf		= $_FILES['PDF']['tmp_name'];

		$directorioPOC='../../'.$Referencia.'/'.'Registros';
		if(!file_exists($directorioPOC)){
			mkdir($directorioPOC,0755);
		}

		if($tipo_Pdf == "application/pdf") {
			if($Formulario > 0){
				$newPdf = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.pdf';
			}
			if($IOC > 0){
				$newPdf = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.pdf';
			}
    		if(move_uploaded_file($desde_Pdf, $directorioPOC."/".$newPdf)){ 
				$txtPDF = 'Documento $newPdf Subido...';
			}
		}

		/* Documento PDF */
		$nombre_Word	= $_FILES['WORD']['name'];
		$tipo_Word 		= $_FILES['WORD']['type'];
		$tamano_Word 	= $_FILES['WORD']['size'];
		$desde_Word		= $_FILES['WORD']['tmp_name'];

		if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_Word == "application/msword") {
			if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				if($Formulario > 0){
					$newWord = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.docx';
				}
				if($IOC > 0){
					$newWord = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.docx';
				}
			}
			if($tipo_Word == "application/msword") {
				if($Formulario > 0){
					$newWord = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.doc';
				}
				if($IOC > 0){
					$newWord = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.doc';
				}
			}
    		if(move_uploaded_file($desde_Word, $directorioPOC."/".$newWord)){ 
				$txtDoc = 'Documento $newWord Subido...';
			}
		}
		
		/* Documento PDF */
		$nombre_Excel	= $_FILES['EXCEL']['name'];
		$tipo_Excel 	= $_FILES['EXCEL']['type'];
		$tamano_Excel 	= $_FILES['EXCEL']['size'];
		$desde_Excel	= $_FILES['EXCEL']['tmp_name'];
		
		if($tipo_Excel == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" or $tipo_Excel == "application/vnd.ms-excel") {
			if($tipo_Excel == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
				if($Formulario > 0){
					$newExcel = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.xlsx';
				}
				if($IOC > 0){
					$newExcel = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.xlsx';
				}
			}
			if($tipo_Excel == "application/vnd.ms-excel") {
				if($Formulario > 0){
					$newExcel = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.xls';
				}
				if($IOC > 0){
					$newExcel = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.xls';
				}
			}
    		if(move_uploaded_file($desde_Excel, $directorioPOC."/".$newExcel)){ 
				$txtDoc = 'Documento $newWord Subido...';
			}
		}
		/* Documento PDF */
		$nombre_Imagen	= $_FILES['IMAGEN']['name'];
		$tipo_Imagen 	= $_FILES['IMAGEN']['type'];
		$tamano_Imagen 	= $_FILES['IMAGEN']['size'];
		$desde_Imagen	= $_FILES['IMAGEN']['tmp_name'];

		if($tipo_Imagen == "image/png" or $tipo_Imagen == "image/jpeg") {
			if($tipo_Imagen == "image/png") {
				if($Formulario > 0){
					$newImagen = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.png';
				}
				if($IOC > 0){
					$newImagen = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.png';
				}
			}
			if($tipo_Imagen == "image/jpeg") {
				if($Formulario > 0){
					$newImagen = 'Reg-'.$Formulario.'-'.$fechaRegistro.'.jpg';
				}
				if($IOC > 0){
					$newImagen = 'RegIOC-'.$IOC.'-'.$fechaRegistro.'.jpg';
				}
			}
    		if(move_uploaded_file($desde_Imagen, $directorioPOC."/".$newImagen)){ 
				$txtDoc = 'Documento $newImagen Subido...';
			}
		}
		$link=Conectarse();
		if($IOC > 0){
			$Formulario = $IOC;
		}
		$SQLreg = "SELECT * FROM docRegPOC WHERE nDocGes = $nDocGes and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'";
		$bdDoc=$link->query($SQLreg);
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			if($newPdf == ''){
				$newPdf = $rowDoc['pdf'];
			}
			if($newWord == ''){
				$newWord = $rowDoc['word'];
			}
			if($newExcel == ''){
				$newExcel = $rowDoc['excel'];
			}
			if($newImagen == ''){
				$newImagen = $rowDoc['imagen'];
			}
			
			$actSQL="UPDATE docRegPOC SET ";
			$actSQL.="Documento			='".$Documento.			"',";
			$actSQL.="pdf				='".$newPdf.			"',";
			$actSQL.="word				='".$newWord.			"',";
			$actSQL.="excel				='".$newExcel.			"',";
			$actSQL.="imagen			='".$newImagen.			"',";
			$actSQL.="sinAcceso			='".$sinAcceso.			"'";
			$actSQL.="WHERE nDocGes 	= '".$_POST['nDocGes'].	"' and Formulario = '".$_POST['Formulario']."' and fechaRegistro = '".$_POST['fechaRegistro']."'";
			$bdDoc=$link->query($actSQL);
		}else{
			$link->query("insert into docRegPOC		(	nDocGes,
														Referencia,
														Formulario,
														fechaRegistro,
														Documento,
														sinAcceso,
														pdf,
														word,
														excel,
														imagen
													)	 
										  values 	(	'$nDocGes',
										  				'$Referencia',
										  				'$Formulario',
														'$fechaRegistro',
														'$Documento',
														'$sinAcceso',
														'$newPdf',
														'$newWord',
														'$newExcel',
														'$newImagen'
										  			)");
			
		}
		if($nSerie){
			if(!$fechaTentativa) 	{	$fechaTentativa = $fechaRegistro;	}
			if(!$fechaAccion) 		{	$fechaAccion 	= $fechaRegistro;	}
			$SQLeq = "SELECT * FROM EquiposHistorial WHERE nSerie = '$nSerie' and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'";
			$bdEq=$link->query($SQLeq);
			if($rowEq=mysqli_fetch_array($bdEq)){
				echo 'Aguarda Datos en el Equipo';
				$actSQL="UPDATE EquiposHistorial SET ";
				$actSQL.="Accion			='".$AccionEquipo.		"',";
				$actSQL.="fechaTentativa	='".$fechaTentativa.	"',";
				$actSQL.="fechaAccion		='".$fechaAccion.		"',";
				$actSQL.="usrResponsable	='".$usrResponsable.	"',";
				$actSQL.="pdf				='".$newPdf.			"'";
				$actSQL.="WHERE nSerie = '$nSerie' and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'";
				$bdDoc=$link->query($actSQL);
			}else{
				echo 'Crea Registro en Historial de Equipo';
				$link->query("insert into EquiposHistorial(	nSerie,
															Formulario,
															fechaRegistro,
															fechaTentativa,
															Accion,
															fechaAccion,
															usrResponsable,
															pdf
														)	 
											  values 	(	'$nSerie',
															'$Formulario',
															'$fechaRegistro',
															'$fechaTentativa',
															'$AccionEquipo',
															'$fechaAccion',
															'$usrResponsable',
															'$newPdf'
														)");
			}
		}

		$link->close();

		$rBD = true;
		//header("Location: ../index.php?accion=Abrir&nDocGes=$nDocGes");
	}
	
	$Version 	= '';
	$Referencia	= '';
	$link=Conectarse();
	$SQL = "SELECT * FROM Documentacion WHERE nDocGes = $nDocGes";
	$bdDoc=$link->query($SQL);
	if($rowDoc=mysqli_fetch_array($bdDoc)){
		$Referencia = $rowDoc['Referencia'];
	}
	if($Formulario > 0){
		$SQL = "SELECT * FROM docFormPOC WHERE nDocGes = $nDocGes and Formulario = $Formulario";
	}
	if($IOC > 0){
		$SQL = "SELECT * FROM documentacionIOC WHERE nDocGes = $nDocGes and IOC = $IOC";
	}
	$bdDoc=$link->query($SQL);
	if($rowDoc=mysqli_fetch_array($bdDoc)){
		$Documento = 'Registro '.$rowDoc['Documento'];
	}
		
	if($fechaRegistro){
		if($Formulario > 0){
			$SQL = "SELECT * FROM docRegPOC WHERE nDocGes = $nDocGes and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'";
		}
		if($IOC > 0){
			$SQL = "SELECT * FROM docRegPOC WHERE nDocGes = $nDocGes and Formulario = $IOC and fechaRegistro = '".$fechaRegistro."'";
		}
		$bdDoc=$link->query($SQL);
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$Documento 			= $rowDoc['Documento'];
			$Version 			= $rowDoc['Version'];
			$Revision 			= $rowDoc['Revision'];
			$fechaRegistro 		= $rowDoc['fechaRegistro'];
			$sinAcceso 			= $rowDoc['sinAcceso'];
			$pdf 				= $rowDoc['pdf'];
			$word 				= $rowDoc['word'];
			$excel 				= $rowDoc['excel'];
			$imagen				= $rowDoc['imagen'];
		}
	}
	$link->close();
?>
<form name="form" action="agregaDoc.php" method="post" enctype="multipart/form-data">
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="../../archivos.php" title="POCs">
				<img src="../../../imagenes/settings_128.png"></a>
			<br>
			POCs
		</div>
		<div id="ImagenBarraLeft">
			<a href="../../archivoPOC/Registros/index.php?accion=Mostrar&nDocGes=<?php echo $nDocGes; ?>&Formulario=<?php echo $Formulario; ?>" title="Volver">
				<img src="../../../imagenes/volver.png"></a>
			<br>
			<?php echo 'Regs.'.$Formulario; ?>
		</div>
	</div>
		<?php
			if($rBD == true){
				?>
					<div class="exito mensajes2">Se ha guardado exitosamente el Registro...</div>
				<?php
			}
		?>
		<table width="95%" border="0" cellspacing="0" cellpadding="0" id="tablaDatosAjax" style="margin-top:15px; " align="center">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="padding-left:15px;">
						<?php
							if($Version > 0){
								echo 'Actualizar '.$tpDoc;
							}else{
								echo 'Agregar '.$tpDoc;
							}
						?>
					</span>
				</td>
			</tr>
			<tr>
			  <td style="border-right:1px solid #ccc;">POC</td>
			  <td style="font-size:16px;">
				<input name="accion" 		type="hidden" value="<?php echo $accion; ?>">
				<input name="nDocGes" 		type="hidden" value="<?php echo $nDocGes; ?>">
				<input name="Referencia" 	type="hidden" value="<?php echo $Referencia; ?>">			
				<input name="Formulario" 	type="hidden" value="<?php echo $Formulario; ?>">			
				<input name="IOC" 			type="hidden" value="<?php echo $IOC; ?>">			
			  	<?php echo $Referencia; ?>
			  </td>
			</tr>
			<tr>
				<td width="15%" style="border-right:1px solid #ccc;">Formulario</td>
			  	<td width="85%">
					<?php 
						if($Formulario > 0){
							echo $Formulario;
						}
						if($IOC > 0){
							echo $IOC;
						}
					?>
				</td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Documento</td>
			  	<td><input name="Documento" type="text" size="100" maxlength="100" value="<?php echo $Documento; ?>" required></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Fecha Registro</td>
			  	<td><input name="fechaRegistro" type="date" value="<?php echo $fechaRegistro; ?>" required></td>
		  	</tr>
			
			<!-- Asocia Registro a un Equipo -->
			<tr>
				<td style="border-top:1px solid #000; background-color: lightblue; border-bottom:1px solid #000;" colspan=2>Equipo Asociado al Registro</td>
			</tr>
			<tr>
				<td>Equipo</td>
				<td>
					<?php
						$link=Conectarse();
						$nSerie = '';
						$fechaTentativa = "0000-00-00";
						$fechaAccion	= "0000-00-00";
						//$SQLeq = "SELECT * FROM EquiposHistorial WHERE nSerie = '$nSerie' and Formulario = $Formulario and fechaRegistro = '".$fechaRegistro."'";
						$SQLeq = "SELECT * FROM EquiposHistorial WHERE pdf = '$pdf'";
						$bdEq=$link->query($SQLeq);
						if($rowEq=mysqli_fetch_array($bdEq)){
							$nSerie 		= $rowEq['nSerie'];
							$AccionEquipo	= $rowEq['Accion'];
							$fechaTentativa	= $rowEq['fechaTentativa'];
							$fechaAccion	= $rowEq['fechaAccion'];
							$usrResponsable	= $rowEq['usrResponsable'];
						}
					?>
					<select name="nSerie" id="nSerie">
						<option></option>
						<?php
							$SQL = "SELECT * FROM Equipos";
							$bdEq=$link->query($SQL);
							if($rowEq=mysqli_fetch_array($bdEq)){
								do{
									if($nSerie == $rowEq['nSerie']){?>
										<option value="<?php echo $rowEq['nSerie'];?>" selected><?php echo $rowEq['nomEquipo'];?></option>
										<?php
									}else{
										?>
										<option value="<?php echo $rowEq['nSerie'];?>"><?php echo $rowEq['nomEquipo'];?></option>
									<?php
									}		
								}while ($rowEq=mysqli_fetch_array($bdEq));
							}
							$link->close();
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Acción</td>
				<td>
					<select name="AccionEquipo" id="AccionEquipo">
						<option></option>
						<?php
							if(!$AccionEquipo){?>
								<option value="Man">Mantención</option>
								<option value="Cal">Calibración</option>
								<option value="Ver">Verificación</option>
							<?php
							}else{
								if($AccionEquipo == "Man"){?>
									<option value="Man" selected>Mantención</option>
									<option value="Cal">Calibración</option>
									<option value="Ver">Verificación</option>
								<?php
								}
								if($AccionEquipo == "Cal"){?>
									<option value="Man">Mantención</option>
									<option value="Cal"selected>Calibración</option>
									<option value="Ver">Verificación</option>
								<?php
								}
								if($AccionEquipo == "Ver"){?>
									<option value="Man">Mantención</option>
									<option value="Cal">Calibración</option>
									<option value="Ver"selected>Verificación</option>
								<?php
								}
							}
							?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Fecha Tentativa</td>
				<td>
					<input name="fechaTentativa" id="fechaTentativa" type="date" value="<?php echo $fechaTentativa; ?>">
				</td>
			</tr>
			<tr>
				<td>Fecha Acción</td>
				<td>
					<input name="fechaAccion" id="fechaAccion" type="date" value="<?php echo $fechaAccion; ?>">
				</td>
			</tr>
			<tr>
				<td>Responsable</td>
				<td>
					<select name="usrResponsable" id="usrResponsable">
						<option></option>
						<?php
							$link=Conectarse();
							$SQL = "SELECT * FROM Usuarios Where firmaUsr != ''";
							$bdUs=$link->query($SQL);
							if($rowUs=mysqli_fetch_array($bdUs)){
								do{
									if($usrResponsable == $rowUs['usr']){?>
										<option value="<?php echo $rowUs['usr']; ?>" selected><?php echo $rowUs['usr']; ?></option>
										<?php
									}else{?>
										<option value="<?php echo $rowUs['usr']; ?>"><?php echo $rowUs['usr']; ?></option>
									<?php
									}
								}while ($rowUs=mysqli_fetch_array($bdUs));
							}
							$link->close();
						?>
					</select>
				</td>
			</tr>
			<!-- Asocia Registro a un Equipo -->
			
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="14%" height="42">PDF</td>
						  <td width="52%">
								<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
								<input name="PDF" type="file" id="PDF">
								<?php 
									if($pdf){
										$dPdf = '../../'.$Referencia.'/Registros/'.$pdf;
										?>
										<a href="<?php echo $dPdf; ?>" target="_blank"><img src="../../../imagenes/informes.png" width="30"></a>
										<?php
									}
								?>
						  </td>
						  <td width="34%" rowspan="2" valign="top">
								<?php
									if($accion == 'Subir'){?>
										<div id="botonImagen">
											<button name="confirmarGuardar" style="float:right;">
												<img src="../../../../imagenes/upload2.png" width="55" height="55">
											</button>
										</div>
										<?php
									}
								?>
						  </td>
						</tr>
						<tr>
							<td>Word</td>
							<td>
								<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
								<input name="WORD" type="file" id="WORD">
								<?php 
									if($word){
										$dDoc = 'docDoc/'.$word;
										?>
										<a href="<?php echo $Referencia.'/'.$word; ?>" target="_blank"><img src="../imagenes/word.png" width="30"></a>
										<?php
										echo $word;
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Excel</td>
							<td>
								<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
								<input name="EXCEL" type="file" id="EXCEL">
								<?php 
									if($excel){
										$dDoc = 'docDoc/'.$word;
										?>
										<a href="<?php echo $Referencia.'/'.$word; ?>" target="_blank"><img src="../imagenes/word.png" width="30"></a>
										<?php
										echo $word;
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Imagen</td>
							<td>
								<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
								<input name="IMAGEN" type="file" id="IMAGEN">
								<?php 
									if($imagen){
										$dDoc = 'docDoc/'.$word;
										?>
										<a href="<?php echo $Referencia.'/'.$word; ?>" target="_blank"><img src="../imagenes/word.png" width="30"></a>
										<?php
										echo $word;
									}
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<?php
						if($accion == 'Guardar' or $accion == 'Agrega' or $accion == 'Actualiza' or $accion == 'Actualizar' or $accion == 'Abrir'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../../../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../../../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
</form>