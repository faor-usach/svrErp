				<p class="blanco" >&nbsp;</p>
				<?php
				$letraItem++;
				echo '<p class="blancoSubTitulos">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de Ensayos de Doblado Guiado:</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<p class="inter15">
					En la tabla <?php echo $letraItem.'.'.$i; ?> se muestran los resultados obtenidos del 
					ensayo y sus observaciones.
				</p>

				<p class="blanco" >&nbsp;</p>

				<?php
				$cRef 	= 'No';
				$i	  	= 0;
				$nro 	= 0;
				$tpMuestraCtrl = '';
				$tpMuestraAnt = '';
				$tabla	= 'Cerrada';
				
				echo '<span style="font-size:0.9em;"><b>Tabla '.$letraItem.'.'.$i.'</b> Resultados de ensayo de doblado. </span>';
				?>
				<table cellpadding="0" cellspacing="0" class="ftoTablaResultado" align="center">
					<tr bgcolor="#E6E6E6" align="center">
						<td align="center" class="tResQ1">ID<br>ITEM</td>
						<td align="center">
							Tipo
						</td>
						<td align="center">
							Observaciones
						</td>
						<td align="center">
							Condici&oacute;n
						</td>
					</tr>
					<?php
					$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$CodInforme."' and idEnsayo = 'Do' Order By Otam");
					if($rowOT=mysqli_fetch_array($bdOT)){
						do{
							datosDoblado($CodInforme, $rowOT['Otam'], $rowOT['tpMuestra']);
						}while($rowOT=mysqli_fetch_array($bdOT));
					}
					?>
				</table>
				<p class="blanco" >&nbsp;</p>
