	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("../conexionli.php");

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

	$Proyecto 	= "IGT-1118";
	$Estado 	= "Todos";
	$Agno     	= $fd[0];
	$MesFiltro = $Mes[intval($fd[1])];
	
	if(isset($_GET['CodInforme']))  { $CodInforme= $_GET['CodInforme']; }
	if(isset($_GET['dBuscar']))  	{ $dBuscar   = $_GET['dBuscar']; 	}
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['Estado'])) 		{ $Estado 	 = $_GET['Estado']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>PAM						</strong></td>';
				echo '			<td  width="10%" align="center">			<strong>N°<br>Informe(s)		</strong></td>';
				echo '			<td  width="10%">							<strong>Ensayos					</strong></td>';
				echo '			<td  width="25%" >							<strong>Cliente					</strong></td>';
				echo '			<td  width="27%">							<strong>Descripcion				</strong></td>';
				echo '			<td  width="18%" align="center" colspan="3"><strong>Acciones				</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				$filtroSQL = "";
				if($Estado <> 'Todos'){
					if($Estado == 'Pendientes'){
						$filtroSQL = ' Estado = 1 and ';
					}
					if($Estado == 'Terminados'){
						$filtroSQL = ' Estado = 2 and ';
					}
					if($Estado == 'Sin Informe'){
						$filtroSQL = ' informePDF = "" and ';
					}
				}
				if($MesFiltro){
					$MesFiltro = intval($MesNum[ $MesFiltro ]);
				}
				if($CodInforme){
					$filtroSQL = " CodInforme Like '%".$CodInforme."%' and ";
				}
				$filtroCliente = '1';

				//$bdHon=$link->query("SELECT * FROM Cotizaciones Where (Estado = 'P' or Estado = 'T') and RAM > 0 Order By RAM");
				$bdHon=$link->query("SELECT * FROM Cotizaciones Where Estado = 'P' and RAM > 0 Order By RAM");
				if($row=mysqli_fetch_array($bdHon)){
					do{
						$tr = "bVerde";
						$nInfFalta = 0;
						//$bdInf=$link->query("SELECT * FROM Informes Where CodigoVerificacion != '' and CodInforme Like '%".$row[RAM]."%'");
						$bdInf=$link->query("SELECT * FROM Informes Where informePDF = '' and CodInforme Like '%".$row['RAM']."%'");
						if($rowInf=mysqli_fetch_array($bdInf)){
							do{
								$nInfFalta++;
							}while ($rowInf=mysqli_fetch_array($bdInf));
						}else{
								$nInfFalta++;
						}
						if($nInfFalta > 0){
							if($row['Estado']=='T'){
								$tr = 'bAmarilla';
							}
							echo '	<tr id="'.$tr.'">';
							echo '		<td width="10%" style="font-size:16px;">';
											echo $row['RAM'];
							echo '		</td>';
							echo '		<td width="10%">';
											$CodInforme = 'AM-'.$row['RAM'];
											$bdCot=$link->query("SELECT * FROM amInformes Where CodInforme Like '%".$CodInforme."%' Order By CodInforme Desc");
											if($rowCot=mysqli_fetch_array($bdCot)){
												$nIn = $rowCot['nroInformes'];
												if($rowCot['nroInformes']<10){
													$nIn = '0'.$rowCot['nroInformes'];
												}
												echo '<strong style="font-size:16px;">'.$rowCot['CodInforme'].'</strong>';
											}else{
												$CodInforme = '';
											}
	
							echo '		</td>';
							echo '		<td width="10%">';
	
							echo '		</td>';
							echo '		<td width="25%">';
											$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
											if ($rowP=mysqli_fetch_array($bdPer)){
												echo '<strong>'.$rowP['Cliente'].'</strong>';
											}
							echo '		</td>';
							echo '		<td width="27%">';
											echo $row['Descripcion'];
							echo ' 		</td>';
							echo '		<td width="6%">';
											//echo '<a href="plataformaGenInf.php?accion=BajarWord&CodInforme='.$row[CodInforme].'"	><img src="../imagenes/word.gif" width="50" height="50" title="BAJAR INFORMES">	</a>';
							echo '		<td>';
							echo '		<td width="6%">';
											if($CodInforme){
												echo '<a href="nominaInformes.php?accion=Actualizar&CodInforme='.$CodInforme.'&RAM='.$row['RAM'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/actividades.png" 	width="50" title="Generar/Editar Informes AM"	>	</a>';
											}else{
												echo '<a href="plataformaGenInf.php?accion=Actualizar&CodInforme='.$CodInforme.'&RAM='.$row['RAM'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/actividades.png" 	width="50" title="Generar/Editar Informes AM"	>	</a>';
											}
							echo '		</td>';
							echo '		<td width="6%"><a href="plataformaGenInf.php?accion=Modificar&CodInforme='.$CodInforme.'&RAM='.$row['RAM'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/inspektion.png"   	width="50" title="Eliminar Informe AM"	>	</a></td>';
							echo '	</tr>';
						}
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
		</div>
		