<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	date_default_timezone_set("America/Santiago");
	$MsgUsr ="";	
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}

	if(isset($_GET[accion]))		{ $accion 		= $_GET[accion]; 		}
	if(isset($_GET[CodInforme]))	{ $CodInforme   = $_GET[CodInforme];	}
	if(isset($_GET[IdInforme]))		{ $IdInforme   	= $_GET[IdInforme];		}
	if(isset($_GET[RutCli]))		{ $RutCli   	= $_GET[RutCli];		}

	if(isset($_POST[accion])) 		{ $accion 		= $_POST[accion]; 		}
	if(isset($_POST[CodInforme]))	{ $CodInforme   = $_POST[CodInforme];	}
	if(isset($_POST[IdInforme]))  	{ $IdInforme   	= $_POST[IdInforme];	}
	if(isset($_POST[RutCli]))  		{ $RutCli   	= $_POST[RutCli];		}

	$CodigoVerificacion = '';
	if(isset($_POST['Generar'])) {
		$CodigoVerificacion   	= $_POST[CodigoVerificacion];		

		$i=0; 
		$password=""; 
		$pw_largo = 12; 
		$desde_ascii = 50; // "2" 
		$hasta_ascii = 122; // "z" 
		$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
		while ($i < $pw_largo) { 
			mt_srand ((double)microtime() * 1000000); 
			$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
			if (!in_array ($numero_aleat, $no_usar)) { 
				$password = $password . chr($numero_aleat); 
				$i++; 
			} 
		}
		$CodigoVerificacion = $password;
	}

	if(isset($_POST['subirGuardarInforme'])){
		$nombre_archivo = $_FILES['Informe']['name'];
		$tipo_archivo 	= $_FILES['Informe']['type'];
		$tamano_archivo = $_FILES['Informe']['size'];
		$desde 			= $_FILES['Informe']['tmp_name'];

		$directorio="../../intranet/informes";
/*
		$directorio="informes";
*/
		if(!file_exists($directorio)){
			mkdir($directorio,0755);
		}
		if ($tipo_archivo == "application/pdf" and $tamano_archivo <= 20480000) {
    		if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
   				
				$MsgUsr="El Informe ".$nombre_archivo." ha sido cargado correctamente....";
				
				$link=Conectarse();
				$bdInf=mysql_query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
				if ($rowInf=mysql_fetch_array($bdInf)){
					$actSQL="UPDATE Informes SET ";
					$actSQL.="informePDF		= '".$nombre_archivo."'";
					$actSQL.="WHERE CodInforme 	= '".$CodInforme."'";
					$bdInf=mysql_query($actSQL);
				}

				mysql_close($link);

				chmod($directorio.'/'.$nombre_archivo, 0000);

				$CodInf	 		= substr($CodInforme,0,7);
				$RAM	 		= substr($CodInforme,3,4);
				$infoNumero 	= 0;
				$infoSubidos 	= 0;

				$link=Conectarse();

				$bdInf=mysql_query("SELECT * FROM Informes Where CodInforme Like '%".$RAM."%'");
				if($rowInf=mysql_fetch_array($bdInf)){
					do{
						$infoNumero++;
						if($rowInf[informePDF]){
							$infoSubidos++;
						}
					}while ($rowInf=mysql_fetch_array($bdInf));
				}
				
				$fechaInformeUP = '0000-00-00';
				$informeUP 		= '0000-00-00';
				if($infoNumero == $infoSubidos){
					$fechaInformeUP = date('Y-m-d');
					$informeUP 		= 'on';
				}
				
				$bdCot=mysql_query("SELECT * FROM Cotizaciones WHERE RAM = '".$RAM."'");
				if ($rowCot=mysql_fetch_array($bdCot)){
					$actSQL="UPDATE Cotizaciones SET ";
					$actSQL.="fechaInformeUP	= '".$fechaInformeUP.	"',";
					$actSQL.="informeUP			= '".$informeUP.		"',";
					$actSQL.="infoNumero		= '".$infoNumero.		"',";
					$actSQL.="infoSubidos		= '".$infoSubidos.		"'";
					$actSQL.="WHERE RAM 		= '".$RAM."'";
					$bdCot=mysql_query($actSQL);
				}

				mysql_close($link);

				$MsgUsr="Informe ".$RAM.': '.$infoNumero."/".$infoSubidos;

    		}else{ 
   				$MsgUsr="Ocurrió algún error al subir el fichero ".$nombre_archivo." No pudo guardar.... ";
    		} 
		}else{
    		$MsgUsr="Se permite subir un documento PDF <br>"; 
		}

		
	}
	if(isset($_POST['guardarInforme'])){
		$fechaInforme = date('Y-m-d');
				
		$CodigoVerificacion   	= $_POST[CodigoVerificacion];		
		if($CodigoVerificacion){
		}else{
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;
		}
		
		$IdProyecto = 'IGT-1118';

		if(isset($_POST[RutCli]))		{ $RutCli 		= $_POST[RutCli]; 		}
		if(isset($_POST[fechaInforme]))	{ $fechaInforme	= $_POST[fechaInforme]; }
		if(isset($_POST[Estado]))		{ $Estado		= $_POST[Estado]; 		}
		if(isset($_POST[Detalle]))		{ $Detalle		= $_POST[Detalle]; 		}

		$fd = explode('-', $fechaInforme);

		$DiaInforme 	= $fd[2];
		$MesInforme 	= $fd[1];
		$AgnoInforme 	= $fd[0];

		$link=Conectarse();
		$bdInf=mysql_query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if($rowInf=mysql_fetch_array($bdInf)){
			$actSQL="UPDATE Informes SET ";
			$actSQL.="RutCli				='".$RutCli.			"',";
			$actSQL.="CodigoVerificacion	='".$CodigoVerificacion."',";
			$actSQL.="DiaInforme			='".$DiaInforme.		"',";
			$actSQL.="MesInforme			='".$MesInforme.		"',";
			$actSQL.="AgnoInforme			='".$AgnoInforme.		"',";
			$actSQL.="Estado				='".$Estado.			"',";
			$actSQL.="Detalle				='".$Detalle.			"'";
			$actSQL.="WHERE CodInforme		= '".$CodInforme."'";
			$bdInf=mysql_query($actSQL);
		}else{
			mysql_query("insert into Informes(	CodInforme,
												RutCli,
												CodigoVerificacion,
												DiaInforme,
												MesInforme,
												AgnoInforme,
												IdProyecto,
												Estado,
												Detalle
											) 
								values 		(	'$CodInforme',
												'$RutCli',
												'$CodigoVerificacion',
												'$DiaInforme',
												'$MesInforme',
												'$AgnoInforme',
												'$IdProyecto',
												'$Estado',
												'$Detalle'
			)",$link);
		}
		mysql_close($link);
	}

	if(isset($_POST['borrarInforme'])){
		$link=Conectarse();
		$bdInf=mysql_query("DELETE FROM Informes WHERE CodInforme = '".$CodInforme."'");
		mysql_close($link);
		header("Location: plataformaInformes.php");
	}

	$fechaInforme = date('Y-m-d');
	if($CodInforme){
		$link=Conectarse();
		$bdInf=mysql_query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if ($rowInf=mysql_fetch_array($bdInf)){
			$RutCli 			= $rowInf[RutCli];
			$informePDF 		= $rowInf[informePDF];
			$DiaInforme			= $rowInf[DiaInforme];
			$MesInforme			= $rowInf[MesInforme];
			$AgnoInforme		= $rowInf[AgnoInforme];
			$Estado  			= $rowInf[Estado];
			$Detalle  			= $rowInf[Detalle];
			$CodigoVerificacion = $rowInf[CodigoVerificacion];
			
			if($MesInforme<10) { $MesInforme = '0'.$MesInforme; }
			if($DiaInforme<10) { $DiaInforme = '0'.$DiaInforme; }
			
			$fechaInforme	= $AgnoInforme.'-'.$MesInforme.'-'.$DiaInforme;
		}
		mysql_close($link);
	}	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Módulo Informes</title>

<link href="styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="javascript" src="validaciones.js"></script> 
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="mInforme.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Informes <!-- <img src="imagenes/room_32.png" width="28" height="28"> -->
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaInformes.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
			</div>
			<!-- Fin Caja Cuerpo -->
			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td height="40"><span style="padding:5px;">Ficha Informe AM</span>
							<div style="margin:5px; float:right; ">
								<?php if($accion == 'Agregar' or $accion == 'Actualizar' or $accion == 'SubirPdf'){?>
										<button name="guardarInforme">
            								<img src="../gastos/imagenes/guardar.png" width="32" height="32" title="Guardar Informe">
										</button>
								<?php }else{ ?>
										<button name="borrarInforme">
            								<img src="../gastos/imagenes/inspektion.png" width="32" height="32" title="Eliminar Informe">';
										</button>
								<?php } ?>
							</div>
						</td>
					</tr>
				</table>
				<div id="RegistroFactura">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
						  <td colspan="2" align="right"class="tituloficha" >Mensaje</td>
						  <td colspan="4"><?php echo $MsgUsr; ?></td>
					  </tr>
						<tr>
							<td colspan="2" align="right"class="tituloficha" >Cód. Informe</td>
						  	<td width="84%" colspan="4">
								<input name="CodInforme" type="text" size="20" maxlength="20" value="<?php echo $CodInforme; ?>" autofocus />
								<input name="accion"  	type="hidden" value="<?php echo $accion; ?>">
								<button name="consultaInforme">
                                	<img src="../gastos/imagenes/buscar.png" width="32" height="32">
								</button>
							</td>
						</tr>
						<?php if($CodInforme){?>
							<tr>
							  <td colspan="2">C&oacute;digo de Verificaci&oacute;n: </td>
							  <td colspan="4">
								<input name="CodigoVerificacion" type="text" id="CodigoVerificacion" size="20" maxlength="20"  value="<? echo $CodigoVerificacion; ?>">
								<?php if($CodigoVerificacion){
									echo $CodigoVerificacion;
								}else{ ?>
									<input name="Generar" type="submit" id="Generar" value="Generar C&oacute;digo">
								<?php } ?>
							</td>
							</tr>
	
							<?php if($CodigoVerificacion) {?>
							<tr>
							  <td colspan="2">C&oacute;digo QR: </td>
							  <td colspan="4">
								<?php
									if(isset($CodInforme)) {
										if(isset($CodigoVerificacion)) {
											$dirinfo  = "http://www.simet.cl/mostrarPdf.php";
											$dirinfo .= '?CodInforme='.$CodInforme.'&amp;CodigoVerificacion='.$CodigoVerificacion;
											//$dirinfo="http://www.simet.cl/verpdf.php?CodInforme=".$CodInforme."&CodigoVerificacion=".$CodigoVerificacion;
											//$dirinfo="http://www.simet.cl/muestrapdf.php?S13jUs425nSch17769T87653812_foAa=".$CodigoVerificacion;
											echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=".$dirinfo."' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
										}else{
											echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=http://www.simet.cl' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
										}
									}else{
										echo "<iframe scrolling='no' src='../codigoqr/phpqrcode/index.php?data=http://www.simet.cl' width='100%' height='200px' frameborder='0' marginheight='0' marginwidth='0'></iframe>";
									}
								?>
							  </td>
							</tr>
							<?php } ?>
							
							<tr>
								<td colspan="2">Cliente: </td>
								<td colspan="4">
									<select name="RutCli" id="RutCli">
										<option></option>
										<?
										$link=Conectarse();
										$bdCli=mysql_query("SELECT * FROM Clientes Order By Cliente");
										if($rowCli=mysql_fetch_array($bdCli)){
											do{
												if($RutCli==$rowCli[RutCli]){
													echo "<option selected 	value='".$rowCli[RutCli]."'>".$rowCli[Cliente]."</option>";
												}else{
													echo "<option  			value='".$rowCli[RutCli]."'>".$rowCli[Cliente]."</option>";
												}
											}while ($rowCli=mysql_fetch_array($bdCli));
										}
										mysql_close($link);
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">Fecha Informe: </td>
								<td colspan="4">
									<input name="fechaInforme" 	type="date" value="<?php echo $fechaInforme; ?>">
								</td>
							</tr>
							<?php if($CodInforme){?>
								<tr>
								  <td colspan="2">Informe:</td>
								  <td colspan="4">
									<?php
										if($informePDF != ''){
											echo '<a href="mostrarPdfLocal.php?accion=Actualizar&CodInforme='.$CodInforme.'&RutCli='.$row[RutCli].'"	><img src="../imagenes/informeUP.png"  title="Informe Subido (VER INFORME)">	</a>';
										}else{
											echo '<a href="plataformaInformes.php?accion=SubirPdf&CodInforme='.$CodInforme.'"	><img src="../imagenes/upload2.png" width="70" height="70" title="SUBIR INFORME">	</a>';
										}
									?>
								  </td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="2">Estado Servicio: </td>
								<td colspan="4">
								  <select name="Estado" id="Estado">
									<option>
										<?php if($Estado){
													if ($Estado=="1") { echo "Pendiente";};
													if ($Estado=="2") { echo "Terminado";};
												}else{
													echo "";
												}
											?>
									</option>
									<option value="1">Pendiente</option>
									<option value="2">Terminado</option>
								  </select>
								</td>
							</tr>
							<tr>
								<td colspan="2">Detalle/Descripci&oacute;n: </td>
								<td colspan="4">
									<textarea name="Detalle" cols="80" rows="10"><?php echo $Detalle;?> </textarea>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>