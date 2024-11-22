	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
	include_once("../conexionli.php"); 
	$CodInforme = $_GET['CodInforme'];
?>
<style>
#cajaExterna {
	border: 0px solid #aaa;
	border-radius: 5px 5px 5px 5px;
	box-shadow: 0 0 5px #aaa;
	-moz-border-radius: 0px 0px 0px 5px;
	-moz-box-shadow: 0 0 5px #aaa; 
	-webkit-border-radius: 0px 0px 0px 5px; 
	-webkit-box-shadow: 0 0 5px #aaa;
	margin:0 0 0 10px;
	padding-bottom:10px;
}
#cajaExterna div.tInf {
	background-color:#FF9900;
	height:30;
	font-size:30px;
	width:80%;
	border-style:dotted;
	border:1px solid #999;
	margin:5px 0px 0px 5px;
	float:left;
	text-align:center;
}
#cajaExterna div.cInf {
	background-color:#FFFFFF;
	height:30;
	font-size:30px;
	width:80%;
	border-style:dotted;
	border:1px solid #999;
	margin:0px 0px 0px 5px;
	float:left;
	text-align:center;
}
#cajaExterna td.titAsociacion {
	background-color:#0099CC;
	color:#FFFFFF;
	text-align:center;
	font-size:24px;
}
#cajaExterna td.tMuestras {
	background-color:#CCCCCC;
	color:#FFFFFF;
	text-align:center;
	font-size:24px;
	border-top:1px solid #000;
	border-bottom:1px solid #000;
}

#cMuestras {
	width:99%;
	background-color:#fff;
	margin:0px 1px 0px 5px;
	padding:0px;
	border-radius: 0px 0px 0px 0px;
	box-shadow: 0 0 1px #aaa;
}
#cMuestras td {
	font-size:36px;
	color:#000000;
	border:1px solid #ccc;
}
#cMuestras td:hover {
	background-color:#F4FFFF;
	box-shadow: 0 0 5px #aaa;
	-moz-box-shadow: 0 0 5px #aaa; 
	-webkit-box-shadow: 0 0 5px #aaa;
	opacity:0.9;
}
#cMuestras td.infSel {
	background-color:#00CC33;
	border-bottom:1px solid #000;
	font-size:36px;
	color:#000000;
}
#cMuestras td.infSel:hover {
	background-color:#00CC33;
	box-shadow: 0 0 5px #aaa;
	-moz-box-shadow: 0 0 5px #aaa; 
	-webkit-box-shadow: 0 0 5px #aaa;
	opacity:0.5;
}
#cMuestras td.infSelOtro {
	background-color:#006699;
	border-bottom:1px solid #000;
	font-size:18px;
	color:#FFFFFF;
}
#cMuestras td a {
	text-decoration:none;
}
</style>

<table width="98%" cellpadding="0" cellspacing="0" id="cajaExterna">
	<tr>
		<td colspan="3" class="titAsociacion">Asociaci&oacute;n de Muestras</td>
  	</tr>
	<tr>
		<td width="40%" valign="top">
			<div class="tInf">Informe</div>
			<div class="cInf"><?php echo $CodInforme; ?></div>
		</td>
	    <td width="30%" valign="top">
			<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
				<tr>
					<td align="center"><strong>Muestras<br>
					  Asociados
					</strong></td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" id="cMuestras">
				<?php
				$fi = explode('-',$CodInforme);
				$link=Conectarse();
				$bdMu=$link->query("SELECT * FROM amMuestras Where idItem Like '%".$fi['1']."%' Order By idItem");
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{?>
						<tr>
							<?php 
								if($rowMu['CodInforme']){
									if($rowMu['CodInforme'] == $CodInforme){
										?>
										<td height="40" align="center" class="infSel" valign="top">
											<a href="asociaMuestras.php?accion=Quitar&CodInforme=<?php echo $CodInforme; ?>&idItem=<?php echo $rowMu['idItem']; ?>"><?php echo $rowMu['idItem']; ?></a>
										</td>
										<?php
									}else{
										?>
										<td height="40" align="center" class="infSelOtro" valign="top">
											<?php echo $rowMu['idItem'].'<br>'.$rowMu['CodInforme']; ?>
										</td>
										<?php
									}
								}else{ ?>
									<td height="40" align="center" valign="top">
										<a href="asociaMuestras.php?accion=Guardar&CodInforme=<?php echo $CodInforme; ?>&idItem=<?php echo $rowMu['idItem']; ?>"><?php echo $rowMu['idItem']; ?></a>
									</td>
									<?php 
								} 
								?>
						</tr>
						<?php
					}while ($rowMu=mysqli_fetch_array($bdMu));
					}
				$link->close();
				?>
			</table>
		</td>
	    <td width="30%" valign="top">
			<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
				<tr>
					<td  width="10%" align="center"><strong>Ensayos<br>
					    Asociadas</strong></td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" id="cMuestras">
				<?php
				$fi = explode('-',$CodInforme);
				$link=Conectarse();
				$bdMu=$link->query("SELECT * FROM OTAMs Where idItem Like '%".$fi['1']."%' Order By Otam");
				if($rowMu=mysqli_fetch_array($bdMu)){
					do{?>
						<tr>
							<?php 
								if($rowMu['CodInforme']){
									if($rowMu['CodInforme'] == $CodInforme){
										?>
										<td height="40" align="center" class="infSel" valign="top">
											<a href="asociaMuestras.php?accion=QuitarEnsayo&CodInforme=<?php echo $CodInforme; ?>&idItem=<?php echo $rowMu['idItem']; ?>&Otam=<?php echo $rowMu['Otam']; ?>"><?php echo $rowMu['Otam']; ?></a>
										</td>
										<?php
									}else{
										?>
										<td height="40" align="center" class="infSelOtro" valign="top">
											<?php echo $rowMu['Otam'].'<br>'.$rowMu['CodInforme']; ?>
										</td>
										<?php
									}
								}else{ ?>
									<td height="40" align="center" valign="top">
										<a href="asociaMuestras.php?accion=AsignarEnsayo&CodInforme=<?php echo $CodInforme; ?>&idItem=<?php echo $rowMu['idItem']; ?>&Otam=<?php echo $rowMu['Otam']; ?>"><?php echo $rowMu['Otam']; ?></a>
									</td>
									<?php 
								} 
							?>
						</tr>
						<?php
					}while ($rowMu=mysqli_fetch_array($bdMu));
				}
				$link->close();
				?>
			</table>
		</td>
	</tr>
	
</table>