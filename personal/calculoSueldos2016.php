			<div id="linea"></div>
			<div id="Cuerpo">
				<?php //include_once('menulateral.php'); ?>
				<div id="CajaCpo">
					<div id="CuerpoTitulo">
						<img src="../gastos/imagenes/purchase_128.png" width="28" height="28" align="middle">
						<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
							<?php echo 'Calculo de Sueldos '.'<span id="BoxPeriodo">'.$pPago.'</span>'; ?>
						</strong>
						<?php include_once('barramenu.php'); ?>
					</div>
					<div id="BarraOpciones">
						<div id="ImagenBarraLeft">
							<a href="../plataformaErp.php" title="Menú Principal">
								<img src="../gastos/imagenes/Menu.png"><br>
							</a>
							Principal
						</div>
						<div id="ImagenBarraLeft">
							<a href="personal.php" title="Personal">
								<img src="../gastos/imagenes/subst_student.png" width="48"><br>
							</a>
							Personal
						</div>
						<div id="ImagenBarraLeft" title="Prestadores">
							<a href="phonorarios.php" title="Prestadores">
								<img src="../gastos/imagenes/send_48.png"><br>
							</a>
							Prestadores
						</div>
						<div id="ImagenBarraLeft" title="Proveedores">
							<a href="proveedores.php" title="Proveedores">
								<img src="../gastos/imagenes/contactus_128.png"><br>
							</a>
							Proveedores
						</div>
						<div id="ImagenBarraLeft" title="Cálculo de Sueldos">
							<a href="CalculoSueldos.php" title="Cálculo de Sueldos">
								<img src="../gastos/imagenes/purchase_128.png"><br>
							</a>
							Sueldos
						</div>
						<div id="ImagenBarraLeft" title="Cálculo de Honorarios">
							<a href="CalculoHonorarios.php" title="Servicios de Honorarios">
								<img src="../gastos/imagenes/blank_128.png"><br>
							</a>
							Honorarios
						</div>
						<div id="ImagenBarraLeft" title="Pago Factura Proveedores">
							<a href="CalculoFacturas.php" title="Pago con Factura">
								<img src="../gastos/imagenes/crear_certificado.png"><br>
							</a>
							Facturas
						</div>
						<div id="ImagenBarraLeft" title="Informes Emitidos">
							<a href="ipdf.php" title="Informes Emitidos">
								<img src="../gastos/imagenes/pdf.png"><br>
							</a>
							Emitidos
						</div>
						<div id="ImagenBarraLeft" title="Calcular Sueldo">
							<?php
							echo '<a href="cSueldo.php?Proceso=1&Periodo='.$PeriodoPago.'" title="Calculo de Sueldo Funcionario">';
							echo '	<img src="../gastos/imagenes/export_32.png"><br>';
							echo '</a>'
							?>
							+Sueldo
						</div>
					</div>
					
					<div id="BarraFiltro">
						<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">

							<!-- Fitra por Proyecto -->
							<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
								<?php 

									$link=Conectarse();
									$bdPr=$link->query("SELECT * FROM Proyectos");
									if ($row=mysqli_fetch_array($bdPr)){
										$Proyecto = $row['Proyecto'];
										echo "	<option value='CalculoSueldos.php?Proyecto=".$row['IdProyecto']."&MesSueldo=".$MesSueldo."'>".$row['IdProyecto']."</option>";
									}
									$link->close();
								?>
							</select>

							<!-- Fitra por Fecha -->
								<select name='MesSueldo' id='MesSueldo' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
									<?php
										for($i=1; $i <=12 ; $i++){
											if($Mes[$i]==$Mm){
												echo '<option selected value="CalculoSueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
											}else{
												if($i > strval($fd[1])){
													//echo '<option style="opacity:.5; color:#ccc;" disabled value="CalculoSueldos.php?Mm='.$Mes[$i].'&Agno='.$Agno.'">'.$Mes[$i].'</option>';
													echo '<option   value="CalculoSueldos.php?Mm='.$Mes[$i].'&Agno='.$Agno.'">'.$Mes[$i].'</option>';
												}else{
													echo '<option value="CalculoSueldos.php?Mm='.$Mes[$i].'&Agno='.$Agno.'">'.$Mes[$i].'</option>';
												}
											}
										}
									?>
								</select>
								<select name='Agno' id='Agno' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
									<?php
									for($i=2014; $i<=$fd[0]; $i++){
										if($i==$Agno){
											echo '<option selected	value="CalculoSueldos.php?Mm='.$Mm.'&Agno='.$i.'" >'.$i.'</option>';
										}else{								
											echo '<option 			value="CalculoSueldos.php?Mm='.$Mm.'&Agno='.$i.'" >'.$i.'</option>';
										}
									}			 
									?>
								</select>
							<!-- Fin Filtro -->
					</div>

					<?php
						echo '<div >';
						echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
						echo '		<tr>';
						echo '			<td  width="05%" align="center"><strong>N°	 			</strong></td>';
						echo '			<td  width="10%" align="center"><strong>RUT				</strong></td>';
						echo '			<td  width="25%" align="center"><strong>Nombres			</strong></td>';
						echo '			<td  width="10%" align="center"><strong>Fecha Pago		</strong></td>';
						echo '			<td  width="10%" align="center"><strong>Liquido			</strong></td>';
						echo '			<td  width="10%" align="center"><strong>H.Extras		</strong></td>';
						echo '			<td  width="10%" align="center"><strong>Previsión		</strong></td>';
						echo '			<td  width="10%" align="center"><strong>Bruto			</strong></td>';
						echo '			<td colspan="2"  width="10%" align="center"><strong>Mes.'.$PeriodoPago.'</strong></td>';
						echo '		</tr>';
						echo '	</table>';
						echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
						$n 		= 0;
						$tSb 	= 0;
						$tEx 	= 0;
						$tPr 	= 0;
						$tLi 	= 0;
						$link=Conectarse();
						$bdProv=$link->query("SELECT * FROM Personal Where TipoContrato = 'P' or TipoContrato = 'C' Order By Estado, Paterno Limit $inicio, $nRegistros");
						if ($row=mysqli_fetch_array($bdProv)){
							DO{
								$bdSue=$link->query("SELECT * FROM Sueldos Where Run = '".$row['Run']."' && PeriodoPago = '".$PeriodoPago."'");
								if ($rowSue=mysqli_fetch_array($bdSue)){
									$n++;
									echo '<tr>';
									echo '	<td width="05%">'.$n.'</td>';
									echo '	<td width="10%">';
									echo 		$row['Run'];
									echo '	</td>';
									echo '	<td width="25%">';
									echo 		$row['Paterno'].' '.$row['Materno'].' '.$row['Nombres'];
									echo '	</td>';
									echo '	<td width="10%">';
												$fd = explode('-', $rowSue['FechaPago']);
												if($fd[1]>0){
													echo $fd[2].'-'.$fd[1].'-'.$fd[0];
													echo '<img src="../gastos/imagenes/Confirmation_32.png" width="20" height="20">';
												}else{
													echo '&nbsp;';
												}
									echo '	</td>';
									echo '	<td width="10%" align="right">'.number_format($rowSue['SueldoBase'], 0, ',', '.').'</td>';
									echo '	<td width="10%" align="right">'.number_format($rowSue['nHorasExtras'], 0, ',', '.').'		</td>';
									echo '	<td width="10%" align="right">'.number_format($rowSue['Prevision'], 0, ',', '.').'		</td>';
									echo '	<td width="10%" align="right">'.number_format($rowSue['Liquido'], 0, ',', '.').'			</td>';
									echo '	<td width="5%"><a href="cSueldo.php?Proceso=2&Run='.$row['Run'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/corel_draw_128.png"   width="22" height="22" title="Editar y Confirmar Pago"></a></td>';
									echo '	<td width="5%"><a href="cSueldo.php?Proceso=3&Run='.$row['Run'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/delete_32.png" 		 width="22" height="22" title="Eliminar"	></a></td>';
									$tSb += $rowSue['SueldoBase'];
									$tEx += $rowSue['nHorasExtras'];
									$tPr += $rowSue['Prevision'];
									$tLi += $rowSue['Liquido'];
								}
								echo '		</tr>';
							}WHILE ($row=mysqli_fetch_array($bdProv));
						}
						$link->close();
						echo '	</table>';
						if($tSb){
						echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
						echo '		<tr>';
						echo '			<td width="50%" align="right">Total Mes '.$pPago.'</td>';
						echo '			<td width="10%" align="right">'.number_format($tSb , 0, ',', '.').'			</td>';
						echo '			<td width="10%" align="right">'.number_format($tEx  , 0, ',', '.').'			</td>';
						echo '			<td width="10%" align="right">'.number_format($tPr  , 0, ',', '.').'			</td>';
						echo '			<td width="10%" align="right">'.number_format($tLi, 0, ',', '.').'			</td>';
						echo '			<td width="05%">&nbsp;</td>';
						echo '			<td width="05%">&nbsp;</td>';
						echo '		</tr>';
						echo '	</table>';
						}				
						echo '</div>';
					?>
				</div>
			</div>
			<div style="clear:both; "></div>
			<br>
