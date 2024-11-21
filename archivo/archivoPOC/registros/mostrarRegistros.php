<?php
	
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
	$filtroSQL 	= '';
	
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	
?>

	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="../../../plataformaErp.php" title="Menú Principal">
				<img src="../../../gastos/imagenes/Menu.png"></a>
			<br>
			Principal
		</div>
		<div id="ImagenBarraLeft">
			<a href="../../archivos.php" title="POCs">
				<img src="../../../imagenes/settings_128.png"></a>
			<br>
			POCs
		</div>
		<div id="ImagenBarraLeft">
			<a href="../index.php?accion=Abrir&nDocGes=<?php echo $nDocGes; ?>" title="Formularios - IOCs">
				<img src="../../../imagenes/docx.png"></a>
			<br>
			Form
		</div>
		<div id="ImagenBarraLeft">
			<a href="agregaDoc.php?accion=Abrir&nDocGes=<?php echo $nDocGes; ?>&tpDoc=Registros&Formulario=<?php echo $Formulario; ?>&IOC=<?php echo $IOC; ?>&Registro=0" title="Subir Registro">
				<img src="../../../imagenes/crear_certificado.png"></a>
			<br>
			+REG
		</div>
	</div>
	<div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="10%" align="center"><strong>Form<br>IOC			</strong></td>
				<td  width="20%" align="center"><strong>Documento			</strong></td>
				<td  width="10%" align="center"><strong>Fecha<br>Registro	</strong></td>
				<td  width="10%" align="center"><strong>Pdf					</strong></td>
				<td  width="10%" align="center"><strong>Word				</strong></td>
				<td  width="10%" align="center"><strong>Excel				</strong></td>
				<td  width="10%" align="center"><strong>Imagen				</strong></td>
				<td  width="20%" rowspan="2" align="center"><strong>Accion				</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$link=Conectarse();
				if($IOC > 0) { $Formulario = $IOC; }
				$bdDoc=$link->query("SELECT * FROM docRegPOC where nDocGes = $nDocGes and Formulario = $Formulario Order By fechaRegistro"); 
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					do{
						$tr = "barraBlanca";
						if($rowDoc['pdf'] or $rowDoc['word'] or $rowDoc['excel'] or $rowDoc['imagen']){
							$tr = 'barraVerde';
						}?>
						<tr id="<?php echo $tr; ?>">
							<td width="10%">
								<?php echo $rowDoc['Referencia']; ?>
							</td>
							<td width="20%">
								<?php echo $rowDoc['Documento']; ?>
							</td>
							<td width="10%">
								<?php echo $rowDoc['fechaRegistro']; ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['pdf']){?>
									<a href="<?php echo '../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['pdf']; ?>" target="_blank" title="Ver PDF"> 
										<img src="../../../imagenes/informeUP.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir PDF"> 
										<img src="../../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%">
								<?php if($rowDoc['word']){?>
									<a href="<?php echo '../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['word']; ?>" target="_blank" title="Ver Word"> 
										<img src="../../../imagenes/informeUP.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir Word"> 
										<img src="../../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['excel']){?>
									<a href="<?php echo '../../'.$rowDoc['Referencia'].'/Registros/'.$rowDoc['excel']; ?>" target="_blank" title="Ver Registro Excel"> 
										<img src="../../../imagenes/excel_icon.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir Word"> 
										<img src="../../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%">
								<?php echo $rowDoc['imagen']; ?>
							</td>
							<td width="10%" align="center">
								<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>&Formulario=<?php echo $rowDoc['Formulario']; ?>&fechaRegistro=<?php echo $rowDoc['fechaRegistro']; ?>" title="Actualizar"> 
									<img src="../../../imagenes/corel_draw_128.png" width="30">
								</a>
							</td>
							<td width="10%" align="center">
								<a href="agregaDoc.php?accion=Borrar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>&Formulario=<?php echo $rowDoc['Formulario']; ?>&fechaRegistro=<?php echo $rowDoc['fechaRegistro']; ?>" title="Eliminar"> 
									<img src="../../../imagenes/inspektion.png" width="30">
								</a>
							</td>
						</tr>
						<?php
					}while ($rowDoc=mysqli_fetch_array($bdDoc));
				}
				$link->close();
				?>
				
		</table>
</div>
		