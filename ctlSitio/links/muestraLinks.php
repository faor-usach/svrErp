		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" align="center">
			<tr>
				<td  width="05%"><strong>N° 			</strong></td>
				<td  width="20%"><strong>Servicio		</strong></td>
				<td  width="60%"><strong>Links 			</strong></td>
				<td  width="15%"><strong>Opciones		</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$linkSitio=ConectarseSitio();
				$bdSe=mysql_query("SELECT * FROM servicios Order By nServicio");
				if($rowSe=mysql_fetch_array($bdSe)){
					do{
						$tr = 'barraAmarilla';
						 ?>
						<tr id="<?php echo $tr; ?>" style="font-size:18px;">
							<td width="05%"><?php echo $rowSe['nServicio']; ?>	</td>
							<td width="20%"><?php echo $rowSe['nomServicio'];?>	</td>
							<td width="60%">
								<?php echo substr($rowSe['txtServicio'],0,200);?>
							</td>
							<td width="15%">
								<a href="index.php?nServicio=<?php echo $rowSe['nServicio']; ?>&accion=Actualizar">
									<img src="/imagenes/seguimiento.png" width="40" title="Edición">
								</a>
								<a href="index.php?nServicio=<?php echo $rowSe['nServicio']; ?>&accion=Eliminar">
									<img src="/imagenes/inspektion.png" width="40" title="Edición">
								</a>
							</td>
						</tr>
						<?php
					}while ($rowSe=mysql_fetch_array($bdSe));
				}
				mysql_close($linkSitio);
			?>
		</table>
