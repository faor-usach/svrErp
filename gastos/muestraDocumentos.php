<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");

	if(isset($_GET['Formulario'])) 	{ $Formulario 	= $_GET['Formulario']; 	}
	if(isset($_GET['Iva'])) 		{ $Iva 			= $_GET['Iva'];			}
	if(isset($_GET['IdProyecto'])) 	{ $IdProyecto 	= $_GET['IdProyecto'];	}

	?>
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
		<tr>
			<td  width=" 5%"><strong>N°				</strong></td>
			<td  width=" 8%"><strong>Fecha 			</strong></td>
			<td  width="15%"><strong>Proveedor		</strong></td>
			<td  width="10%"><strong>Tip.Doc.		</strong></td>
			<td  width=" 7%"><strong>N° Doc.		</strong></td>
			<td  width="15%"><strong>Bien o Servicio</strong></td>
			<td  width=" 5%"><strong>Neto			</strong></td>
			<td  width=" 5%"><strong>IVA			</strong></td>
			<td  width=" 5%"><strong>Bruto			</strong></td>
			<td  width="10%"><strong>Item			</strong></td>
			<td  width="10%"><strong>Proyecto		</strong></td>
		</tr>
	</table>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
		$n = 0;
		if($Formulario){
			$ff = explode('(',$Formulario);
			$Recurso = substr($ff[1],0,strlen($ff[1])-1);
			
			$IdRecurso = 0;
			$link=Conectarse();
			$bdRec=$link->query("SELECT * FROM recursos Where Formulario = '".$ff[0]."' and Recurso = '".$Recurso."'");
			if($rowRec=mysqli_fetch_array($bdRec)){
				$IdRecurso = $rowRec['IdRecurso'];
			}
			$link->close();
		}
				
		$filtroSQL = "Where Estado != 'I' ";
		if($Formulario){
					$filtroSQL .= " and IdRecurso = '".$IdRecurso."'";
		}
		if($IdProyecto != ''){
			if($IdProyecto != 'Seleccione Proyecto'){
				$filtroSQL .= " && IdProyecto = '".$IdProyecto."'";
			}
		}
		if($Iva != ''){
			if($Iva != 'Seleccione Doc. cIva/sIva'){
				if($Iva=="cIva"){
					$filtroSQL .= " && Iva > 0 && Neto > 0";
				}else{
					//$filtroSQL .= " && Iva = 0 && Neto = 0";
					$filtroSQL .= " && Iva = 0";
				}
			}
		}
		
		$tNeto 	= 0;
		$tIva	= 0;
		$tBruto	= 0;
				
		$link=Conectarse();
		$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto");
		if($row=mysqli_fetch_array($bdGto)){
			do{
				$n++;
				$tNeto	+= $row['Neto'];
				$tIva	+= $row['Iva'];
				$tBruto	+= $row['Bruto'];
				
				$tFormulario = '';
				$bdRec=$link->query("SELECT * FROM recursos Where IdRecurso = '".$row['IdRecurso']."'");
				if($rowRec=mysqli_fetch_array($bdRec)){
					$tFormulario = $rowRec['Formulario'].'('.$rowRec['Recurso'].')';
				}

				echo '<tr id="barraVerde">';
				echo '			<td width=" 5%">'.$n.'.'.$tFormulario.'			</td>';
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
				$bdIt = $link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
				if ($rowIt=mysqli_fetch_array($bdIt)){
					$Items = $rowIt['Items'];
				}
				echo '			<td width="10%">'.$Items.'			</td>';
				echo '			<td width="10%">'.$row['IdProyecto'].'			</td>';
				echo '		</tr>';
			}while ($row=mysqli_fetch_array($bdGto));
		}
		$filtroSQL = "Where Estado != 'P' and IdRecurso = 5 and nInforme = 0 and TpCosto != 'M'";
		if($IdProyecto != ''){
				$filtroSQL .= " and IdProyecto = '".$IdProyecto."'";
		}
		if($Iva != ''){
			if($Iva=="cIva"){
				$filtroSQL .= " and Iva > 0 and Neto > 0";
			}else{
				$filtroSQL .= " and Iva = 0";
			}
		}
		
		$bdGto=$link->query("SELECT * FROM Facturas ".$filtroSQL." Order By FechaFactura");
		while($row=mysqli_fetch_array($bdGto)){
				$n++;
				$tNeto	+= $row['Neto'];
				$tIva	+= $row['Iva'];
				$tBruto	+= $row['Bruto'];
				
				$tFormulario = '';
				$bdRec=$link->query("SELECT * FROM recursos Where IdRecurso = '".$row['IdRecurso']."'");
				if($rowRec=mysqli_fetch_array($bdRec)){
					$tFormulario = $rowRec['Formulario'];
				}

				echo '<tr id="barraVerde">';
				echo '			<td width=" 5%">'.$n.'.'.$tFormulario.'			</td>';
									$fd 	= explode('-', $row['FechaFactura']);
									$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				echo '			<td width=" 8%">'.$Fecha.'		</td>';
				echo '			<td width="15%">';
				$bdPr=$link->query("SELECT * FROM Proveedores Where RutProv = '".$row['RutProv']."'");
				if($rowPr=mysqli_fetch_array($bdPr)){
					echo $rowPr['Proveedor'];
				}
				echo '			</td>';
				echo '			<td width="10%">';
				echo 				'Factura Sueldo';
				echo '			</td>';
				echo '			<td width=" 7%">'.$row['nFactura'].'			</td>';
				echo '			<td width="15%">'.$row['Descripcion'].'	</td>';
				echo '			<td width=" 5%">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
				echo '			<td width=" 5%">'.number_format($row['Iva']	 , 0, ',', '.').'				</td>';
				echo '			<td width=" 5%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
				$link=Conectarse();
				$bdIt = $link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
				if ($rowIt=mysqli_fetch_array($bdIt)){
					$Items = $rowIt['Items'];
				}
				echo '			<td width="10%">Sueldos			</td>';
				echo '			<td width="10%">';
				echo 				$row['IdProyecto'];
				echo 				"<a href='formularios/F7exento.php?Proceso=2&RutProv=".$row['RutProv']."&nFactura=".$row['nFactura']."&Periodo=".$row['PeriodoPago']."'><img src='imagenes/printer_128_hot.png' width='32' height='32' title='Imprimir'></a>";
				echo '			</td>';
				echo '		</tr>';
		}



		$link->close();?>
	</table>
