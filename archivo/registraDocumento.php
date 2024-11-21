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

	$dBuscado 	= '';
	$sinAcceso 	= '';

	$nDocGes			= '';
	$Referencia 		= '';
	$Documento 			= '';
	$Version			= '';
	$Revision 			= '';
	$Acreditacion		= '';
	$pdf				= '';
	$word				= '';
	$newPdf				= '';
	$newWord			= '';
	$fechaAprobacion 	= date('Y-m-d');
	$sinAcceso 			= '';

	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	if(isset($_POST['nDocGes'])) 	{ $nDocGes   = $_POST['nDocGes']; 	}

	if(isset($_POST['confirmarBorrar'])){ 
		$link=Conectarse();
		$BorrarDir = 'SI';
		
		$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$_POST['nDocGes']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){

			$bdFor=$link->query("SELECT * FROM docFormPOC WHERE nDocGes = '".$_POST['nDocGes']."'");
			if($rowFor=mysqli_fetch_array($bdFor)){
				do{
					$BorrarDir = 'NO';
				}while ($rowFor=mysqli_fetch_array($bdFor));
/*				
				rmdir($rowDoc['Referencia'].'/Formularios/');
				rmdir('y:AAA/Documentos/'.$rowDoc['Referencia'].'/Formularios/');
				$bdProv=$link->query("DELETE FROM docFormPOC WHERE nDocGes = '".$_POST['nDocGes']."'");
				if($rowDoc['pdf']){
					unlink($rowDoc['Referencia'].'/'.$rowDoc['pdf']);
					unlink('y:AAA/Documentos/'.$rowDoc['Referencia'].'/'.$rowDoc['pdf']);
				}
				if($rowDoc['word']){
					unlink($rowDoc['Referencia'].'/'.$rowDoc['word']);
					unlink('y:AAA/Documentos/'.$rowDoc['Referencia'].'/'.$rowDoc['word']);
				}
				rmdir($rowDoc['Referencia']);
				rmdir('y:AAA/Documentos/'.$rowDoc['Referencia']);
				$bdProv=$link->query("DELETE FROM Documentacion WHERE nDocGes = '".$_POST['nDocGes']."'");
*/				
			}

			/* IOC Borrar */
			$bdFor=$link->query("SELECT * FROM documentacionIOC WHERE nDocGes = '".$_POST['nDocGes']."'");
			if($rowFor=mysqli_fetch_array($bdFor)){
				do{
/*					
					if($rowFor['pdf']){
						unlink($rowFor['Referencia'].'/IOC/'.$rowFor['pdf']);
						unlink('y:/AAA/Documentos/'.$rowFor['Referencia'].'/IOC/'.$rowFor['pdf']);
					}
					if($rowDoc['word']){
						unlink($rowFor['Referencia'].'/IOC/'.$rowFor['word']);
						unlink('y:/AAA/Documentos/'.$rowFor['Referencia'].'/IOC/'.$rowFor['word']);
					}
*/					
					$BorrarDir = 'NO';
				}while ($rowFor=mysqli_fetch_array($bdFor));
/*				
				rmdir($rowDoc['Referencia'].'/IOC/');
				rmdir('y:AAA/Documentos/'.$rowDoc['Referencia'].'/IOC/');
				$bdProv=$link->query("DELETE FROM documentacionIOC WHERE nDocGes = '".$_POST['nDocGes']."'");
				if($rowDoc['pdf']){
					unlink($rowDoc['Referencia'].'/'.$rowDoc['pdf']);
					unlink('y:AAA/Documentos/'.$rowDoc['Referencia'].'/'.$rowDoc['pdf']);
				}
				if($rowDoc['word']){
					unlink($rowDoc['Referencia'].'/'.$rowDoc['word']);
					unlink('y:AAA/Documentos/'.$rowDoc['Referencia'].'/'.$rowDoc['word']);
				}
*/
			}
			if($BorrarDir == 'SI'){
				if($rowDoc['pdf']){
					unlink($rowDoc['Referencia'].'/'.$rowDoc['pdf']);
					unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/'.$rowDoc['pdf']);
				}
				if($rowDoc['word']){
					unlink($rowDoc['Referencia'].'/'.$rowDoc['word']);
					unlink('y:/AAA/Documentos/'.$rowDoc['Referencia'].'/'.$rowDoc['word']);
				}
				rmdir($rowDoc['Referencia']);
				rmdir('y:AAA/Documentos/'.$rowDoc['Referencia']);
				$bdProv=$link->query("DELETE FROM Documentacion WHERE nDocGes = '".$_POST['nDocGes']."'");
			}
			
		}
		$link->close();
		$linkVolver = "Location: archivos.php";
		header($linkVolver);
	}

	if(isset($_POST['confirmarGuardar'])){ 

		$rBD 				= true;
		$nDocGes 			= $_POST['nDocGes'];
		$Referencia 		= $_POST['Referencia'];
		$Documento 			= $_POST['Documento'];
		$Version 			= $_POST['Version'];
		//$Revision 			= $_POST['Revision'];
		if(isset($_POST['Acreditacion'])) { $Acreditacion		= $_POST['Acreditacion']; }
		$fechaAprobacion	= $_POST['fechaAprobacion'];
		if(isset($_POST['sinAcceso'])) 	{ $sinAcceso    = $_POST['sinAcceso']; 	}

		/* Documento PDF */
		$nombre_Pdf 	= $_FILES['PDF']['name'];
		$tipo_Pdf 		= $_FILES['PDF']['type'];
		$tamano_Pdf 	= $_FILES['PDF']['size'];
		$desde_Pdf		= $_FILES['PDF']['tmp_name'];

		$directorioPOC=$Referencia;
		if(!file_exists($directorioPOC)){
			mkdir($directorioPOC,0777);
			mkdir('y:AAA/Documentos/'.$directorioPOC,0777);
		}

		$directorioPdf="docPdf";
		if(!file_exists($directorioPdf)){
			mkdir($directorioPdf,0777);
			mkdir('y:AAA/Documentos/'.$directorioPdf,0777);
		}

		if($tipo_Pdf == "application/pdf") {
    		//if(move_uploaded_file($desde_Pdf, $directorioPdf."/".$nombre_Pdf)){
			$newPdf = $Referencia.'-'.$Version.'.pdf';
    		if(move_uploaded_file($desde_Pdf, $directorioPOC."/".$newPdf)){ 
				$txtPDF = 'Documento $newPdf Subido...';
				copy($directorioPOC."/".$newPdf, 'y:AAA/Documentos/'.$directorioPOC."/".$newPdf);
			}
		}

		/* Documento PDF */
		$nombre_Word	= $_FILES['WORD']['name'];
		$tipo_Word 		= $_FILES['WORD']['type'];
		$tamano_Word 	= $_FILES['WORD']['size'];
		$desde_Word		= $_FILES['WORD']['tmp_name'];

		$directorioDoc="docDoc";
		if(!file_exists($directorioDoc)){
			mkdir($directorioDoc,0777);
			mkdir('a:AAA/Documentos/'.$directorioDoc,0777);
		}

		if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_Word == "application/msword") {
			if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				$newWord = $Referencia.'-'.$Version.'.docx';
			}
			if($tipo_Word == "application/msword") {
				$newWord = $Referencia.'-'.$Version.'.doc';
			}
    		if(move_uploaded_file($desde_Word, $directorioPOC."/".$newWord)){ 
				$txtDoc = 'Documento $newWord Subido...';
				copy($directorioPOC."/".$newWord, 'y:AAA/Documentos/'.$directorioPOC."/".$newWord);
			}
		}
		
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM Documentacion WHERE Referencia = '".$_POST['Referencia']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			if($newPdf == ''){
				$newPdf = $rowDoc['pdf'];
			}
			if($newWord == ''){
				$newWord = $rowDoc['word'];
			}
			
			//$pdf 	= $rowDoc['pdf'];
			//$word 	= $rowDoc['word'];
/*			
			if($Revision != $rowDoc['Revision']){
				if($rowDoc['pdf']){
					unlink('docPdf/'.$rowDoc['pdf']);
					$pdf	= '';
					$word	= '';
				}
			}
*/
			
			$actSQL="UPDATE Documentacion SET ";
			$actSQL.="Documento			='".$Documento.			"',";
			$actSQL.="Version			='".$Version.			"',";
			//$actSQL.="Revision			='".$Revision.			"',";
			$actSQL.="Acreditacion		='".$Acreditacion.		"',";
			$actSQL.="fechaAprobacion	='".$fechaAprobacion.	"',";
			$actSQL.="pdf				='".$newPdf.			"',";
			$actSQL.="word				='".$newWord.			"',";
			$actSQL.="sinAcceso			='".$sinAcceso.			"'";
			$actSQL.="WHERE nDocGes 	= '".$_POST['nDocGes'].	"'";
			$bdDoc=$link->query($actSQL);
		}else{
			$bdDoc=$link->query("SELECT * FROM Documentacion Order By nDocGes Desc");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				$nDocGes = $rowDoc['nDocGes'] + 1;
			}
			$link->query("insert into Documentacion	(	nDocGes,
														Referencia,
														Documento,
														Version,
														Acreditacion,
														fechaAprobacion,
														sinAcceso,
														pdf,
														word
													)	 
										  values 	(	'$nDocGes',
										  				'$Referencia',
														'$Documento',
														'$Version',
														'$Acreditacion',
														'$fechaAprobacion',
														'$sinAcceso',
														'$newPdf',
														'$newWord'
										  			)");
			
		}
		$link->close();
		//header("Location: archivos.php");
	}
	
	if(isset($_GET['nDocGes'])) 	{ $nDocGes    = $_GET['nDocGes']; 	}
	if(isset($_GET['accion'])) 		{ $accion    = $_GET['accion']; 	}
	if($nDocGes){
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$nDocGes."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$Referencia 		= $rowDoc['Referencia'];
			$Documento 			= $rowDoc['Documento'];
			$Version 			= $rowDoc['Version'];
			//$Revision 			= $rowDoc['Revision'];
			$Acreditacion		= $rowDoc['Acreditacion'];
			$fechaAprobacion 	= $rowDoc['fechaAprobacion'];
			$sinAcceso 			= $rowDoc['sinAcceso'];
			$pdf 				= $rowDoc['pdf'];
			$word 				= $rowDoc['word'];
		}
		$link->close();
	}
?>
<form name="form" action="agregaDoc.php" method="post" enctype="multipart/form-data">
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="archivos.php" title="Archivos">
				<img src="../imagenes/open_48.png"></a>
			<br>
			Docs
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
					<span style="padding-left:15px;">Formulario de Registro de Documentos</span>
				</td>
			</tr>
			<tr>
			  <td style="border-right:1px solid #ccc;">N&deg; Documento</td>
			  <td style="font-size:16px;">
				<input name="nDocGes" type="hidden" value="<?php echo $nDocGes; ?>">
			  	<?php echo $nDocGes; ?>
			  </td>
		  </tr>
			<tr>
				<td width="15%" style="border-right:1px solid #ccc;">Referencia</td>
			  	<td width="85%"><input name="Referencia" type="text" size="30" maxlength="30" value="<?php echo $Referencia; ?>" autofocus></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Documento</td>
			  	<td><input name="Documento" type="text" size="100" maxlength="100" value="<?php echo $Documento; ?>" ></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Versión</td>
			  	<td><input name="Version" type="text" size="10" maxlength="10" value="<?php echo $Version; ?>" required /></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Alcance Acreditación</td>
			  	<td>
					<?php if($Acreditacion == 'on'){?>
							<input name="Acreditacion" type="checkbox" checked>
					<?php }else{ ?>
							<input name="Acreditacion" type="checkbox">
					<?php } ?>
				</td>
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
			  	<td><input name="fechaAprobacion" type="date" value="<?php echo $fechaAprobacion; ?>"></td>
		  	</tr>
			
			
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="14%" height="42">PDF</td>
						  <td width="52%">
								<input type="hidden" name="MAX_FILE_SIZE" value="104857600"> 
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
											<button name="confirmarGuardar" style="float:right;" title="Guardar">
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
								<input type="hidden" name="MAX_FILE_SIZE" value="104857600">
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
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;" title)="Guardar">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
</form>