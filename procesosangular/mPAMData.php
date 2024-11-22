				<?php
				$filtro = '';
				if($usrFiltro){
					$filtro = " and usrResponzable Like '%".$usrFiltro."%'";
				}
				if($filtroCli){
					$filtro = " and RutCli Like '%".$filtroCli."%'";
				}
				$tRAMsUF = 0;
				$tRAMsPe = 0;
				?>
				<table id="example" class="display" style="width:100%">
					<thead>
						<tr>
							<th align="center" height="40" >&nbsp;	</th>
							<th>PAM 		 						</th>
							<th>Inicio		 						</th>
							<th>Término		 						</th>
							<th>Clientes	 						</th>
							<th>Observaciones						</th>
							<th>Imprimir<br>RAM 					</th>
							<th align="center">	Seg.				</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$link=Conectarse();
						$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' ".$filtro." Order By RAM Desc, RAM Asc";
						$bdEnc=$link->query($sql);
						while($row=mysqli_fetch_array($bdEnc)){?>
							<tr>
								<td></td>
								<td><?php echo $row['RAM']; ?></td>
								<td><?php echo $row['usrResponzable']; ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php
						}
						$link->close();
						?>
					</tbody>
				</table>
