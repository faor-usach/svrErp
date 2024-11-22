<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");
	$IdProyecto = $_GET[IdProyecto];
	$Formulario	= $_POST[Formulario];

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width=" 5%"><strong>N°				</strong></td>';
				echo '			<td  width=" 8%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="15%"><strong>Proveedor		</strong></td>';
				echo '			<td  width="10%"><strong>Tip.Doc.		</strong></td>';
				echo '			<td  width=" 7%"><strong>N° Doc.		</strong></td>';
				echo '			<td  width="15%"><strong>Bien o Servicio</strong></td>';
				echo '			<td  width=" 5%"><strong>Neto			</strong></td>';
				echo '			<td  width=" 5%"><strong>IVA			</strong></td>';
				echo '			<td  width=" 5%"><strong>Bruto			</strong></td>';
				echo '			<td  width="10%"><strong>Item			</strong></td>';
				echo '			<td  width="10%"><strong>Proyecto		</strong></td>';
				echo '		</tr>';
				echo '	</table>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				

							$filtroSql = "Where Estado != 'I'";

							if($Formulario=="F3B1"){
								$filtroSql .= " && IdRecurso <= 3";
							}
							
							$link=Conectarse();
							
							$bdGto=mysql_query("SELECT * FROM MovGastos $filtroSql");
							if ($row=mysql_fetch_array($bdGto)){
								do{
									$n++;
									$tNeto	+= $row['Neto'];
									$tIva	+= $row['Iva'];
									$tBruto	+= $row['Bruto'];
									echo '<tr>';
									echo '			<td width=" 5%">'.$n.' - '.$Formulario.'</td>';
									$fd 	= explode('-', $row['FechaGasto']);
									$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
									echo '			<td width=" 8%">'.$Fecha.'		</td>';
									echo '			<td width="15%">'.$row['Proveedor'].'		</td>';
									echo '			<td width="10%">';
									if($row['TpDoc']=="B"){
										echo 'Boleta';
									}else{
										echo 'Factura';
									}
									echo '			</td>';
									echo '			<td width=" 7%">'.$row['nDoc'].'			</td>';
									echo '			<td width="15%">'.$row['Bien_Servicio'].'	</td>';
									echo '			<td width=" 5%">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
									echo '			<td width=" 5%">'.number_format($row['Iva']	 , 0, ',', '.').'				</td>';
									echo '			<td width=" 5%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
									$link=Conectarse();
									$bdIt = mysql_query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
									if ($rowIt=mysql_fetch_array($bdIt)){
										$Items = $rowIt['Items'];
									}
									echo '			<td width="10%">'.$Items.'			</td>';
									echo '			<td width="10%">'.$row['IdProyecto'].'			</td>';
									echo '		</tr>';
								}while ($row=mysql_fetch_array($bdGto));
							}
							
							mysql_close($link);
							
				echo '	</table>';

?>