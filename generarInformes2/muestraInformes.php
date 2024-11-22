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
	$MesFiltro 	= $Mes[intval($fd[1])];
	$RAM		= 0;
	
	if(isset($_GET['CodInforme']))  { $CodInforme	= $_GET['CodInforme']; }
	if(isset($_GET['RAM']))  		{ $RAM  	 	= $_GET['RAM']; 		}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>Informes			</strong></td>';
				echo '			<td  width="15%">							<strong>Tipo Ensayo			</strong></td>';
				echo '			<td  width="15%">							<strong>Tipo Muestra		</strong></td>';
				echo '			<td  width="10%">							<strong>Cantidad<br>Muestras</strong></td>';
				echo '			<td  width="30%">							<strong>Reesponsables		</strong></td>';
				echo '			<td  width="20%" align="center" colspan="3"><strong>Acciones			</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				$bdHon=$link->query("SELECT * FROM amInformes Where Estado = 'P' and CodInforme Like '%".$CodInforme."%' Order By CodInforme");
				if($row=mysqli_fetch_array($bdHon)){
					do{
						$tr = "bVerde";
						if($row['tpEnsayo']==0){
							$tr = "bAmarilla";
						}
						echo '	<tr id="'.$tr.'">';
						echo '		<td width="10%" style="font-size:16px;">';
										echo $row['CodInforme'];
						echo '		</td>';
						echo '		<td width="15%">';
										if($row['tpEnsayo']){
											$bdEns=$link->query("SELECT * FROM amTpEnsayo Where tpEnsayo = '".$row['tpEnsayo']."'");
											if($rowEns=mysqli_fetch_array($bdEns)){
												echo $rowEns['Ensayo'];
											}
										}else{
											echo 'NO ESPECIFICADO';
										}
						echo '		</td>';
						echo '		<td width="15%">';
										if($row['tipoMuestra']){
											echo $row['tipoMuestra'];
										}else{
											echo 'NO ESPECIFICADA';
										}
						echo '		</td>';
						echo '		<td width="10%">';
										echo $row['nMuestras'];
						echo '		</td>';
						echo '		<td width="30%">';
										$cRes = 0;
										$iRes = 0;
										$bdUsr=$link->query("SELECT * FROM Usuarios Where usr = '".$row['ingResponsable']."'");
										if($rowUsr=mysqli_fetch_array($bdUsr)){
											$iRes = $rowUsr['titPie'].' '.$rowUsr['usuario'];
										}
										$bdUsr=$link->query("SELECT * FROM Usuarios Where usr = '".$row['cooResponsable']."'");
										if($rowUsr=mysqli_fetch_array($bdUsr)){
											$cRes = $rowUsr['titPie'].' '.$rowUsr['usuario'];
										}
										echo $iRes.'/';
										echo $cRes;
						echo ' 		</td>';
						echo '		<td width="6%">';
										//echo '<a href="plataformaGenInf.php?accion=BajarWord&CodInforme='.$row[CodInforme].'"	><img src="../imagenes/word.gif" width="50" height="50" title="BAJAR INFORMES">	</a>';
						echo '		<td>';
						echo '		<td width="6%">';
										if($row['nMuestras']){
											$bdOT=$link->query("SELECT * FROM OTAMs Where CodInforme = '".$row['CodInforme']."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												echo '<a href="edicionInformes.php?accion=Editar&CodInforme='.$row['CodInforme'].'&RAM='.$RAM.'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/actividades.png" 	width="50" title="Editar Informe"		>	</a>';
											}
										}else{
											echo '<a href="nominaInformes.php?accion=Titular&CodInforme='.$row['CodInforme'].'&RAM='.$RAM.'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/actividades.png" 	width="50" title="Generar Informes AM"	>	</a>';
										}
						echo '		</td>';
						echo '		<td width="6%"><a href="plataformaGenInf.php?accion=Eliminar&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/inspektion.png"   	width="50" title="Eliminar Informe AM"			>	</a></td>';
						echo '		<td width="8%"><a href="asociaMuestras.php?accion=Asociar&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'"		><img src="../imagenes/extra_column.png"   	width="50" title="Asociar Muestras al Informe"	>	</a></td>';
						echo '	</tr>';
					}while ($row=mysqli_fetch_array($bdHon));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
		</div>
		