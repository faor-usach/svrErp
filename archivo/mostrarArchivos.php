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
			<a href="../plataformaErp.php" title="Menú Principal">
				<img src="../gastos/imagenes/Menu.png"></a>
			<br>
			Principal
		</div>
		<div id="ImagenBarraLeft">
			<a href="agregaDoc.php" title="Agregar Documento">
				<img src="../imagenes/agragarEquipo.png"></a>
			<br>
			+Doc
		</div>
	</div>
	<div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="05%" height="40" rowspan="2" align="center"><strong>N°			</strong></td>
				<td  width="10%" rowspan="2" align="center"><strong>Referencia				</strong></td>
				<td  width="15%" rowspan="2" align="center"><strong>Documento				</strong></td>
				<td  width="05%" rowspan="2" align="center"><strong>Versión					</strong></td>
				<td  width="05%" rowspan="2" align="center"><strong>Revisión				</strong></td>
				<td  width="05%" rowspan="2" align="center"><strong>Alcance					</strong></td>
				<td  width="12%" rowspan="2" align="center"><strong>Fecha<br>Aprobación		</strong></td>
				<td  width="10%" colspan="2" align="center"><strong>Accesos					</strong></td>
				<td  width="10%" rowspan="2" align="center"><strong>Pdf						</strong></td>
				<td  width="10%" rowspan="2" align="center"><strong>Word					</strong></td>
				<td  width="13%" colspan="2" rowspan="2" align="center"><strong>Acciones	</strong></td>
			</tr>
			<tr>
			  <td width="5%" align="center">Res</td>
		      <td width="5%" align="center">Usr</td>
		  </tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$link=Conectarse();

				$filSQL = "Where 1";
				
				$bdDoc=$link->query("SELECT * FROM Documentacion $filtroSQL Order By nDocGes"); // N� de Documento de Gesti�n
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					do{
						$tr = "barraBlanca";
						if($rowDoc['pdf']){
							$tr = 'barraAmarilla';
							if($rowDoc['word']){
								$tr = 'barraVerde';
							}
						}?>
						<tr id="<?php echo $tr; ?>">
							<td width="05%" style="font-size:16px;">
								<?php echo $rowDoc['nDocGes']; ?>
							</td>
							<td width="10%">
								<?php echo $rowDoc['Referencia']; ?>
							</td>
							<td width="15%">
								<?php echo $rowDoc['Documento']; ?>
							</td>
							<td width="05%">
								<?php echo $rowDoc['Version']; ?>
							</td>
							<td width="05%">
								<?php echo $rowDoc['Revision']; ?>
							</td>
							<td width="05%">
								<?php 
									if($rowDoc['Acreditacion'] == 'on'){?>
										<img src="../imagenes/printing.png" width="30" title="Alcande Acreditación">
									<?php
									}
								?>
							</td>
							<td width="12%" align="center">
								<?php 
									$fd = explode('-',$rowDoc['fechaAprobacion']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 
								?>
							</td>
							<td width="5%" align="center">
								<?php if($rowDoc['sinAcceso'] == 'on'){?>
										<img src="../imagenes/about_us_close_128.png" width="30" title="Acceso Restringido">
								<?php } ?>
							</td>
							<td width="5%" align="center">
								<?php if($rowDoc['sinAcceso'] != 'on'){
										$result  = $link->query("SELECT Count(*) as nAcc FROM accesoDoc Where nDocGes = '".$rowDoc['nDocGes']."'");  
										$rowAcc	 = mysqli_fetch_array($result);
										?>
										<a href="accesosDocumentos.php?accion=Accesos&nDocGes=<?php echo $rowDoc['nDocGes']; ?>"> 
											<?php if($rowAcc['nAcc'] > 0){?>
												<img src="../imagenes/about_us_ok_128.png" width="30" title="<?php echo $rowAcc['nAcc']; ?> Usuarios Asignados">
											<?php }else{ ?>
												<img src="../imagenes/bola_amarilla.png" title="Asignar Usuarios">
											<?php } ?>
										</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['pdf']){?>
									<!-- <a href="subirDoc.php?accion=Subir&nDocGes=<?php echo $rowDoc['nDocGes']; ?>"" title="Subir PDF">  -->
									<a href="<?php echo $rowDoc['Referencia'].'/'.$rowDoc['pdf']; ?>" target="_blank" title="Ver PDF"> 
										<img src="../imagenes/informeUP.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="archivoPOC/index.php?accion=Abrir&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir PDF"> 
										<img src="../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="10%" align="center">
								<?php if($rowDoc['word']){?>
									<a href="<?php echo $rowDoc['Referencia'].'/'.$rowDoc['word']; ?>" target="_blank" title="Ver WORD"> 
										<img src="../imagenes/word.png" width="30">
									</a>
								<?php }else{ ?>
									<a href="archivoPOC/index.php?accion=Abrir&nDocGes=<?php echo $rowDoc['nDocGes']; ?>" title="Subir WORD"> 
										<img src="../imagenes/upload-40.png" width="30">
									</a>
								<?php } ?>
							</td>
							<td width="6%"><a href="agregaDoc.php?accion=Actualizar&nDocGes=<?php echo $rowDoc['nDocGes']; 	?>"><img src="../gastos/imagenes/corel_draw_128.png"   		width="32" height="32" title="Editar Documento">	</a></td>
							<td width="6%">
								<?php
									$iconoBorrar = 'SI';
									$bdFor=$link->query("SELECT * FROM docFormPOC WHERE nDocGes = '".$rowDoc['nDocGes']."'");
									if($rowFor=mysqli_fetch_array($bdFor)){
										$iconoBorrar = 'NO';
									}
									$bdFor=$link->query("SELECT * FROM documentacionIOC WHERE nDocGes = '".$rowDoc['nDocGes']."'");
									if($rowFor=mysqli_fetch_array($bdFor)){
										$iconoBorrar = 'NO';
									}
									if($iconoBorrar == 'SI'){
										?>
											<a href="agregaDoc.php?accion=Borrar&nDocGes=<?php echo $rowDoc['nDocGes']; 		?>"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar Documento">	</a>
										<?php
									}
								?>
							</td>
							<td width="6%">
								<a href="archivoPOC/index.php?accion=Abrir&nDocGes=<?php echo $rowDoc['nDocGes']; ?>"><img src="../imagenes/open_48.png" 					width="32" height="32" title="Abrir Carpeta POC">	</a>
							</td>
						</tr>
						<?php
					}while ($rowDoc=mysqli_fetch_array($bdDoc));
				}
				$link->close();
				?>
	  </table>
</div>
		