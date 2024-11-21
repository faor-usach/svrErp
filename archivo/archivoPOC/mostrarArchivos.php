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
			<a href="../../plataformaErp.php" title="Menú Principal">
				<img src="../../gastos/imagenes/Menu.png"></a>
			<br>
			Principal
		</div>
		<div id="ImagenBarraLeft">
			<a href="../archivos.php" title="POCs">
				<img src="../../imagenes/settings_128.png"></a>
			<br>
			POCs
		</div>
		<div id="ImagenBarraLeft">
			<a href="agregaDoc.php?accion=Abrir&nDocGes=<?php echo $nDocGes; ?>&tpDoc=IOC&IOC=" title="Subir IOC">
				<img src="../../imagenes/newPdf.png"></a>
			<br>
			+IOC
		</div>
		<div id="ImagenBarraLeft">
			<a href="agregaDoc.php?accion=Agrega&nDocGes=<?php echo $nDocGes; ?>&tpDoc=Formulario&Formulario=0" title="Subir Formulario">
				<img src="../../imagenes/docx.png"></a>
			<br>
			+Form
		</div>
	</div>
	<div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="10%" rowspan="2" align="center"><strong>Form <br>IOC<br>Reg.</strong></td>
				<td  width="20%" rowspan="2" align="center"><strong>Documento			</strong></td>
				<td  width="05%" rowspan="2" align="center"><strong>Versión				</strong></td>
				<td  width="05%" rowspan="2" align="center"><strong>Revisión			</strong></td>
				<td  width="12%" rowspan="2" align="center"><strong>Fecha<br>Aprobación	</strong></td>
				<td  width="10%" rowspan="2" align="center"><strong>Pdf					</strong></td>
				<td  width="10%" rowspan="2" align="center"><strong>Word				</strong></td>
				<td  width="10%" rowspan="2" align="center"><strong>Excel				</strong></td>
				<td  width="13%" colspan="2" rowspan="2" align="center"><strong>Acciones</strong></td>
				<td width="5%" align="center">Registros</td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
				<?php
				$link=Conectarse();

				$filSQL = "Where 1";
				
				$bdDoc=$link->query("SELECT * FROM documentacionIOC where nDocGes = $nDocGes"); 
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					do{
						$tr = "barraBlanca";
						$tr = 'barraAmarilla';
						if($rowDoc['pdf']){
							$tr = 'barraAmarilla';
							if($rowDoc['word']){
								$tr = 'barraAzul';
							}
						}?>
						<tr id="<?php echo $tr; ?>">
							<td width="10%">
								<?php echo 'IOC-'.$rowDoc['IOC']; ?>
							</td>
							<td width="20%">
								<?php echo $rowDoc['Documento']; ?>
							</td>
							<td width="05%">
								<?php echo $rowDoc['Version']; ?>
							</td>
							<td width="05%">
								<?php echo $rowDoc['Revision']; ?>
							</td>
							<td width="12%" align="center">
								<?php 
									$fd = explode('-',$rowDoc['fechaAprobacion']);
									echo $fd[1].'/'.$fd[0]; 
								?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['pdf']){?>
									<a href="<?php echo '../'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['pdf']; ?>" target="_blank" title="Ver PDF"> 
										<img src="../../imagenes/informeUP.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir PDF"> 
										<img src="../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['word']){?>
									<a href="<?php echo '../'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['word']; ?>" target="_blank" title="Ver PDF"> 
										<img src="../../imagenes/word.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir WORD"> 
										<img src="../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['excel']){?>
									<a href="<?php echo '../'.$rowDoc['Referencia'].'/IOC/'.$rowDoc['excel']; ?>" target="_blank" title="Ver EXCEL"> 
										<img src="../../imagenes/excel_icon.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir EXCEL"> 
										<img src="../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="6%"><a href="agregaDoc.php?accion=Actualiza&nDocGes=<?php echo $rowDoc['nDocGes']; 	?>&IOC=<?php echo $rowDoc['IOC']; 	?>&tpDoc=IOC"><img src="../../gastos/imagenes/corel_draw_128.png"   		width="32" height="32" title="Editar Documento">	</a></td>
							<td width="6%"><a href="agregaDoc.php?accion=Borrar&nDocGes=<?php echo $rowDoc['nDocGes']; 		?>&IOC=<?php echo $rowDoc['IOC']; 	?>&tpDoc=IOC"><img src="../../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar Documento">	</a></td>
							<td width="5%"><a href="registros/?accion=Mostrar&nDocGes=<?php echo $rowDoc['nDocGes']; 		?>&IOC=<?php echo $rowDoc['IOC']; 	?>&tpDoc=IOC"><img src="../../imagenes/open_48.png" 				width="32" height="32" title="Registros">			</a></td>
						</tr>
						<?php
					}while ($rowDoc=mysqli_fetch_array($bdDoc));
				}
				$link->close();
				?>
				
				<?php
				$link=Conectarse();

				$filSQL = "Where 1";
				
				$bdDoc=$link->query("SELECT * FROM docformpoc where nDocGes = $nDocGes"); 
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					do{
						$tr = "barraBlanca";
						if($rowDoc['pdf']){
							$tr = 'barraAmarilla';
							if($rowDoc['word']){
								$tr = 'barraVerde';
							}
							if($rowDoc['excel']){
								$tr = 'barraVerde';
							}
						}?>
						<tr id="<?php echo $tr; ?>">
							<td width="10%">
								<?php echo 'Reg-'.$rowDoc['Formulario']; ?>
							</td>
							<td width="20%">
								<?php echo $rowDoc['Documento']; ?>
							</td>
							<td width="05%">
								<?php echo $rowDoc['Version']; ?>
							</td>
							<td width="05%">
								<?php echo $rowDoc['Revision']; ?>
							</td>
							<td width="12%" align="center">
								<?php 
									$fd = explode('-',$rowDoc['fechaAprobacion']);
									echo $fd[1].'/'.$fd[0]; 
								?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['pdf']){?>
									<a href="<?php echo '../'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['pdf']; ?>" target="_blank" title="Ver PDF"> 
										<img src="../../imagenes/informeUP.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir PDF"> 
										<img src="../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['word']){?>
									<a href="<?php echo '../'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['word']; ?>" target="_blank" title="Ver PDF"> 
										<img src="../../imagenes/word.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir WORD"> 
										<img src="../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['excel']){?>
									<a href="<?php echo '../'.$rowDoc['Referencia'].'/Formularios/'.$rowDoc['excel']; ?>" target="_blank" title="Ver EXCEL"> 
										<img src="../../imagenes/excel_icon.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir EXCEL"> 
										<img src="../../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="6%"><a href="agregaDoc.php?accion=Actualiza&nDocGes=<?php echo $rowDoc['nDocGes']; 	?>&Formulario=<?php echo $rowDoc['Formulario']; 	?>&tpDoc=Formulario"><img src="../../gastos/imagenes/corel_draw_128.png"   		width="32" height="32" title="Editar Documento">	</a></td>
							<td width="6%"><a href="agregaDoc.php?accion=Borrar&nDocGes=<?php echo $rowDoc['nDocGes']; 		?>&Formulario=<?php echo $rowDoc['Formulario']; 	?>&tpDoc=Formulario"><img src="../../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar Documento">	</a></td>
							<td width="5%"><a href="registros/?accion=Mostrar&nDocGes=<?php echo $rowDoc['nDocGes']; 		?>&Formulario=<?php echo $rowDoc['Formulario']; 	?>&tpDoc=Registros"><img src="../../imagenes/open_48.png" 				width="32" height="32" title="Registros">			</a></td>
						</tr>
						<?php
					}while ($rowDoc=mysqli_fetch_array($bdDoc));
				}
				$link->close();
				?>

				
		</table>
</div>
		