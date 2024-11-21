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
	$newPdf				= '';
	$newWord			= '';
	$fechaAprobacion 	= date('Y-m-d');
	$sinAcceso 			= '';
	$tpDoc				= '';
	$Formulario			= 0;
	$IOC				= 0;
	$accion 			= '';

	if(isset($_GET['accion'])) 		{ $accion  		= $_GET['accion']; 		}
	if(isset($_GET['nDocGes'])) 	{ $nDocGes  	= $_GET['nDocGes']; 	}
	if(isset($_GET['tpDoc'])) 		{ $tpDoc  		= $_GET['tpDoc']; 		}
	if(isset($_GET['Formulario']))	{ $Formulario 	= $_GET['Formulario']; 	}
	if(isset($_GET['IOC']))			{ $IOC 			= $_GET['IOC']; 		}

	if(isset($_POST['dBuscado'])) 	{ $dBuscado  	= $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    	= $_POST['nOrden']; 	}
	if(isset($_POST['nDocGes'])) 	{ $nDocGes   	= $_POST['nDocGes']; 	}
	if(isset($_POST['tpDoc'])) 		{ $tpDoc   		= $_POST['tpDoc']; 		}
	if(isset($_POST['Formulario']))	{ $Formulario 	= $_POST['Formulario']; }
	if(isset($_POST['IOC']))		{ $IOC 			= $_POST['IOC']; 		}
	
	if(isset($_POST['confirmarBorrar'])){ 
		$link=Conectarse();
		if($tpDoc == 'Formulario'){
			$bdDoc=$link->query("SELECT * FROM docFormPOC WHERE nDocGes = '".$_POST['nDocGes']."' and Formulario = '".$_POST['Formulario']."'");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				if($rowDoc['pdf']){
					unlink('../'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['pdf']);
					unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['pdf']);
				}
				if($rowDoc['word']){
					unlink('../'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['word']);
					unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['word']);
				}
				rmdir('../'.$rowDoc['Referencia'].'/Formularios');
				rmdir('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/Formularios');
				$bdProv=$link->query("DELETE FROM docFormPOC WHERE nDocGes = '".$_POST['nDocGes']."' and Formulario = '".$Formulario."'");
			}
		}

		if($tpDoc == 'IOC'){
			$bdDoc=$link->query("SELECT * FROM documentacionIOC WHERE nDocGes = '".$_POST['nDocGes']."' and IOC = '".$_POST['IOC']."'");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				if($rowDoc['pdf']){
					unlink('../'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['pdf']);
					unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['pdf']);
				}
				if($rowDoc['word']){
					unlink('../'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['word']);
					unlink('y:/AAA/Documnentos/'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['word']);
				}
				rmdir('../'.$rowDoc['Referencia'].'/IOC');
				rmdir('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/IOC');
				$bdProv=$link->query("DELETE FROM documentacionIOC 	WHERE nDocGes = '".$_POST['nDocGes']."' and IOC = '".$IOC."'");
			}
		}
		
		$link->close();
		$linkVolver = "Location: index.php?accion=Abrir&nDocGes=$nDocGes";
		header($linkVolver);
	}

	if(isset($_POST['confirmarGuardar'])){ 

		$rBD 				= true;
		$nDocGes 			= $_POST['nDocGes'];
		$Referencia 		= $_POST['Referencia'];
		$Documento 			= $_POST['Documento'];
		$Version 			= $_POST['Version'];
		$Revision 			= $_POST['Revision'];
		$fechaAprobacion	= $_POST['fechaAprobacion'];
		if(isset($_POST['sinAcceso'])) 	{ $sinAcceso    = $_POST['sinAcceso']; 	}

		/* Documento PDF */
		$nombre_Pdf 	= $_FILES['PDF']['name'];
		$tipo_Pdf 		= $_FILES['PDF']['type'];
		$tamano_Pdf 	= $_FILES['PDF']['size'];
		$desde_Pdf		= $_FILES['PDF']['tmp_name'];

		if($tpDoc == 'Formulario') { 
			$directorioPOC='../'.$Referencia.'/'.'Formularios';
			$directorioPOCRes='y:/AAA/Documentos/'.$Referencia.'/'.'Formularios';
		}
		if($tpDoc == 'IOC') { 
			$directorioPOC='../'.$Referencia.'/'.'IOC';
			$directorioPOCRes='y:/AAA/Documentos/'.$Referencia.'/'.'IOC';
		}
		if(!file_exists($directorioPOC)){
			mkdir($directorioPOC,0755);
		}
		if(!file_exists($directorioPOCRes)){
			mkdir($directorioPOCRes,0755);
		}

		$tpReg = 'Reg';
		echo $tipo_Pdf;
		//if($tipo_Pdf == "application/pdf") {
		if($nombre_Pdf) {
			if($tpDoc == 'IOC') { $tpReg = 'IOC'; }
			if($tpDoc == 'Formulario') { 
				$newPdf = $tpReg.'-'.$Referencia.'-'.$Formulario.'-'.$Version.'.pdf';
			}
			if($tpDoc == 'IOC') { 
				$newPdf = $tpReg.'-'.$Referencia.'-'.$IOC.'-'.$Version.'.pdf';
			}
    		if(move_uploaded_file($desde_Pdf, $directorioPOC."/".$newPdf)){ 
				$txtPDF = 'Documento $newPdf Subido...';
				copy($directorioPOC."/".$newPdf, $directorioPOCRes."/".$newPdf);
			}
		}

		/* Documento PDF */
		$nombre_Word	= $_FILES['WORD']['name'];
		$tipo_Word 		= $_FILES['WORD']['type'];
		$tamano_Word 	= $_FILES['WORD']['size'];
		$desde_Word		= $_FILES['WORD']['tmp_name'];

		if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_Word == "application/msword") {
			if($tpDoc == 'IOC') { $tpReg = 'IOC'; }
			if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				if($tpDoc == 'IOC') { 
					$newWord = $tpReg.'-'.$Referencia.'-'.$IOC.'-'.$Version.'.docx';
				}
				if($tpDoc == 'Formulario') { 
					$newWord = $tpReg.'-'.$Referencia.'-'.$Formulario.'-'.$Version.'.docx';
				}
			}
			if($tipo_Word == "application/msword") {
				if($tpDoc == 'Formulario') { 
					$newWord = $tpReg.'-'.$Referencia.'-'.$Formulario.'-'.$Version.'.doc';
				}
				if($tpDoc == 'IOC') { 
					$newWord = $tpReg.'-'.$Referencia.'-'.$IOC.'-'.$Version.'.doc';
				}
			}
    		if(move_uploaded_file($desde_Word, $directorioPOC."/".$newWord)){ 
				$txtDoc = 'Documento $newWord Subido...';
				copy($directorioPOC."/".$newWord, $directorioPOCRes."/".$newWord);
			}
		}
		if($tpDoc == 'Formulario'){
			$link=Conectarse();
			$bdDoc=$link->query("SELECT * FROM docFormPOC WHERE nDocGes = '".$_POST['nDocGes']."' and Formulario = '".$_POST['Formulario']."'");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				if($newPdf == ''){
					$newPdf = $rowDoc['pdf'];
				}
				if($newWord == ''){
					$newWord = $rowDoc['word'];
				}
				
				$actSQL="UPDATE docFormPOC SET ";
				$actSQL.="Documento			='".$Documento.			"',";
				$actSQL.="Version			='".$Version.			"',";
				$actSQL.="Revision			='".$Revision.			"',";
				$actSQL.="fechaAprobacion	='".$fechaAprobacion.	"',";
				$actSQL.="pdf				='".$newPdf.			"',";
				$actSQL.="word				='".$newWord.			"',";
				$actSQL.="sinAcceso			='".$sinAcceso.			"'";
				$actSQL.="WHERE nDocGes 	= '".$_POST['nDocGes'].	"' and Formulario = '".$_POST['Formulario']."'";
				$bdDoc=$link->query($actSQL);
			}else{
				$link->query("insert into docFormPOC	(	nDocGes,
															Referencia,
															Formulario,
															Documento,
															Version,
															Revision,
															fechaAprobacion,
															sinAcceso,
															pdf,
															word
														)	 
											  values 	(	'$nDocGes',
															'$Referencia',
															'$Formulario',
															'$Documento',
															'$Version',
															'$Revision',
															'$fechaAprobacion',
															'$sinAcceso',
															'$newPdf',
															'$newWord'
														)");
			}
			$link->close();
		}
		if($tpDoc == 'IOC'){
			$link=Conectarse();
			$SQLioc = "SELECT * FROM documentacionIOC WHERE nDocGes = '".$_POST['nDocGes']."' and IOC = '".$_POST['IOC']."'";
			$bdDoc=$link->query($SQLioc);
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				if($newPdf == ''){
					$newPdf = $rowDoc['pdf'];
				}
				if($newWord == ''){
					$newWord = $rowDoc['word'];
				}
				
				$actSQL="UPDATE documentacionIOC SET ";
				$actSQL.="Documento			='".$Documento.			"',";
				$actSQL.="Version			='".$Version.			"',";
				$actSQL.="Revision			='".$Revision.			"',";
				$actSQL.="fechaAprobacion	='".$fechaAprobacion.	"',";
				$actSQL.="pdf				='".$newPdf.			"',";
				$actSQL.="word				='".$newWord.			"',";
				$actSQL.="sinAcceso			='".$sinAcceso.			"'";
				$actSQL.="WHERE nDocGes 	= '".$_POST['nDocGes'].	"' and IOC = '".$_POST['IOC']."'";
				$bdDoc=$link->query($actSQL);
			}else{
				$link->query("insert into documentacionioc(	nDocGes				,
															Referencia			,
															IOC					,
															Documento			,
															Version				,
															Revision			,
															fechaAprobacion		,
															sinAcceso			,
															pdf					,
															word
														)	 
											  values 	(	'$nDocGes'			,
															'$Referencia'		,
															'$IOC'				,
															'$Documento'		,
															'$Version'			,
															'$Revision'			,
															'$fechaAprobacion'	,
															'$sinAcceso'		,
															'$newPdf'			,
															'$newWord'
														)");

			}
			$link->close();
		}

		$rBD = true;
		//$linkVolver = "Location: index.php?accion=Abrir&nDocGes=$nDocGes";
		//header($linkVolver);
		//header("Location: archivos.php");
	}
	
	$Version 	= '';
	$Referencia	= '';
	$link=Conectarse();
	$SQL = "SELECT * FROM Documentacion WHERE nDocGes = '".$nDocGes."'";
	$bdDoc=$link->query($SQL);
	if($rowDoc=mysqli_fetch_array($bdDoc)){
		$Referencia = $rowDoc['Referencia'];
	}
	$Documento = '';	
	if($tpDoc == 'Formulario'){
		$SQL = "SELECT * FROM docFormPOC WHERE nDocGes = '".$nDocGes."' and Formulario = '".$Formulario."'";
	}
	if($tpDoc == 'IOC'){
		$SQL = "SELECT * FROM documentacionIOC WHERE nDocGes = '".$nDocGes."' and IOC = '".$IOC."'";
	}
	$bdDoc=$link->query($SQL);
	if($rowDoc=mysqli_fetch_array($bdDoc)){
		$Documento 			= $rowDoc['Documento'];
		$Version 			= $rowDoc['Version'];
		$Revision 			= $rowDoc['Revision'];
		$fechaAprobacion 	= $rowDoc['fechaAprobacion'];
		$sinAcceso 			= $rowDoc['sinAcceso'];
		$pdf 				= $rowDoc['pdf'];
		$word 				= $rowDoc['word'];
	}else{
		if($tpDoc == 'Formulario'){
			$SQL = "SELECT * FROM docFormPOC WHERE nDocGes = '".$nDocGes."' Order By Formulario Desc";
		}
		if($tpDoc == 'IOC'){
			$SQL = "SELECT * FROM documentacionIOC WHERE nDocGes = '".$nDocGes."' Order By IOC Desc";
		}
		//echo $SQL;
		$bdDoc=$link->query($SQL);
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			//$Formulario			= $rowDoc['Formulario']+1;
		}else{
			$fdRe = explode('-',$Referencia);
			if(intval($Referencia) > 0){
				$Formulario			= $fdRe[1].'01';
			}else{
				$Formulario			= '01'.'01';
			}
		}
	}
	$link->close();
?>
<form name="form" action="agregaDoc.php" method="post" enctype="multipart/form-data">
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="../archivos.php" title="POCs">
				<img src="../../imagenes/settings_128.png"></a>
			<br>
			POCs
		</div>
		<div id="ImagenBarraLeft">
			<a href="../archivoPOC/index.php?accion=Abrir&nDocGes=<?php echo $nDocGes; ?>" title="Volver">
				<img src="../../imagenes/volver.png"></a>
			<br>
			<?php echo $Referencia; ?>
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
			  <td style="border-right:1px solid #ccc;">N&deg; Documento</td>
			  <td style="font-size:16px;">
				<input name="nDocGes" 		type="hidden" value="<?php echo $nDocGes; ?>">
				<input name="Referencia" 	type="hidden" value="<?php echo $Referencia; ?>">			
				<input name="Formulario" 	type="hidden" value="<?php echo $Formulario; ?>">			
				<input name="IOC" 			type="hidden" value="<?php echo $IOC; ?>">			
				<input name="tpDoc" 		type="hidden" value="<?php echo $tpDoc; ?>">			
			  	<?php echo $nDocGes; ?>
			  </td>
			</tr>
			<tr>
				<?php
					if($tpDoc == 'Formulario'){?>
						<td width="15%" style="border-right:1px solid #ccc;">REG</td>
						<td width="85%"><input name="Formulario" type="text" size="30" maxlength="30" value="<?php echo $Formulario; ?>" autofocus required></td>
						<?php
					}
					if($tpDoc == 'IOC'){?>
						<td width="15%" style="border-right:1px solid #ccc;">IOC</td>
						<td width="85%"><input name="IOC" type="text" size="30" maxlength="30" value="<?php echo $IOC; ?>" autofocus required></td>
						<?php
					}
				?>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Documento</td>
			  	<td><input name="Documento" type="text" size="100" maxlength="100" value="<?php echo $Documento; ?>" required></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Versión</td>
			  	<td><input name="Version" type="text" size="10" maxlength="10" value="<?php echo $Version; ?>" required></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Revisión</td>
			  	<td><input name="Revision" type="text" size="2" maxlength="2" value="<?php echo $Revision; ?>" required></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Sin Acceso</td>
			  	<td>
					<?php if($sinAcceso == 'on'){?>
							<input name="sinAcceso" type="checkbox" checked>
					<?php }else{ ?>
							<input name="sinAcceso" type="checkbox">
					<?php } ?>
				</td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Fecha Aprobación</td>
			  	<td><input name="fechaAprobacion" type="date" value="<?php echo $fechaAprobacion; ?>" required></td>
		  	</tr>
			
			
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
										$dPdf = 'docPdf/'.$pdf;
										?>
										<a href="<?php echo $Referencia.'/'.$pdf; ?>" target="_blank"><img src="../imagenes/informes.png" width="30"></a>
										<?php
										echo $pdf;
									}
								?>
						  </td>
						  <td width="34%" rowspan="2" valign="top">
								<?php
									if($accion == 'Subir'){?>
										<div id="botonImagen">
											<button name="confirmarGuardar" style="float:right;">
												<img src="../imagenes/upload2.png" width="55" height="55">
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
					</table>
				</td>
			</tr>
			
			
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<?php
						if($accion == 'Guardar' or $accion == 'Agrega' or $accion == 'Actualizar' or $accion == 'Actualiza' or $accion == 'Abrir'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
</form>