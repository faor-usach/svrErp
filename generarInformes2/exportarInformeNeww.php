<?
include_once("../conexionli.php");
$CodInforme	= $_GET['CodInforme'];
$accion 	= $_GET['accion'];
$nomInforme = $CodInforme.'.doc';

//Exportar datos de php a Word
header("Content-Type: application/vnd.ms-word");
header("content-disposition: attachment;filename=$nomInforme");
/*
header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
*/

$link=Conectarse();
$bdInf=$link->query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
if($rowInf=mysqli_fetch_array($bdInf)){
	$nMuestras 			= $rowInf[nMuestras];
	$tipoMuestra		= $rowInf[tipoMuestra];
	$tpEnsayo			= $rowInf[tpEnsayo];
	$fechaRecepcion 	= $rowInf[fechaRecepcion];
	$fechaInforme 		= $rowInf[fechaInforme];
	$RutCli				= $rowInf[RutCli];
	$ingResponsable		= $rowInf[ingResponsable];
	$cooResponsable		= $rowInf[cooResponsable];
	$CodigoVerificacion = $rowInf[CodigoVerificacion];
	$imgQR 				= $rowInf[imgQR];
	$imgMuestra			= $rowInf[imgMuestra];
}

$bdCli=$link->query("Select * From Clientes Where RutCli = '".$RutCli."'");
if($rowCli=mysqli_fetch_array($bdCli)){
	$Cliente 	= $rowCli[Cliente];
	$Direccion 	= $rowCli[Direccion];
}
$link->close();
?>
<HTML LANG="es">
<head>
<TITLE>::. Exportacion de Datos .::</TITLE>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<style>
body {
	font-family:Arial;
	font-size:0.85em;
	margin-right:2px;
}
.ftoTablaResultado {
	font-size:0.8em; 
	width:100%;
	border:4px double #000000;
	background-color:#CCCCCC;
}
.ftoTablaResultado td{
	height:30px;
}
.tablaId {
	width:96%;
	border:1px double #000;
	background-color:#CCCCCC;
}
.tablaId td{
	height:30px;
}
#tablaExternaNegra{
	border:4px solid #000; 
/*	background-color:#000000; */
	width:35.44em;
}
#tablaExternaNegra td{
	font-family:Arial;
	font-size:13,5px;
}
.c1{
	width		:10.5em;
	height		:0.97em;
}
.c2{
	width:1.48em;
}
.c3{
	width:13.55em;
}
.c4{
	width:14.95em;
}
.c5{
	width:1.48em;
}
.c6{
	width:5.8em;
}

.tablaInternaNegra{
	font-family:Arial;
	width:100%;
	border:1px double #000; 
	background-color:#FFFFFF;
}
</style>

</head>
<body>
	<?php $letraItem = 'A'; ?>
				<table cellpadding="0" cellspacing="0" id="tablaExternaNegra" align="center">
					<tr>
						<td class="c1"><b>Cliente</b></td>
						<td class="c2"><b>:</b></td>
					    <td colspan="4"><b><?php echo $Cliente; ?></b></td>
				    </tr>
					<tr>
						<td class="c1"><b>Direcci&oacute;n</b></td>
						<td class="c2"><b>:</b></td>
					    <td colspan="4"><?php echo $Direccion; ?></td>
				    </tr>
					<tr>
						<td class="c1"><b>Tipo de Muestra</b></td>
						<td class="c2"><b>:</b></td>
					    <td colspan="4"><?php echo $tipoMuestra; ?></td>
				    </tr>
					<tr>
						<td class="c1"><b>Cantidad</b></td>
						<td class="c2"><b>:</b></td>
					    <td colspan="4">
							<?php 
								if($nMuestras < 10){
									$nMuestras = '0'.$nMuestras;
								}
								echo $nMuestras;
							?>
						</td>
				    </tr>
					<tr>
						<td class="c1"><b>Tipo de Ensayo</b></td>
						<td class="c2"><b>:</b></td>
						<td class="c3">
							<?php
								$link=Conectarse();
								$bdTpEns=$link->query("Select * From amTpEnsayo Where tpEnsayo = '".$tpEnsayo."'");
								if($rowTpEns=mysqli_fetch_array($bdTpEns)){
									echo $rowTpEns[Ensayo];
								}
								$link->close();
							?>
						</td>
						<td class="c4"><b>Fecha de Recepci&oacute;n</b></td>
						<td class="c5"><b>:</b></td>
					    <td class="c6">
							<?php
								$fd = explode('-',$fechaRecepcion);
								echo $fd[2].'-'.$fd[1].'-'.substr($fd[0],2,2);
							?>
						</td>
					</tr>
					<tr>
						<td class="c1"><b>Solicitante</b></td>
						<td class="c2"><b>:</b></td>
						<td class="c3">
							<?php
								$Ra = explode('-',$CodInforme);
								$link=Conectarse();
								$bdCot=$link->query("SELECT * FROM Cotizaciones Where RAM = '".$Ra[1]."'");
								if($rowCot=mysqli_fetch_array($bdCot)){
									$bdCli=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCot[RutCli]."' and nContacto = '".$rowCot[nContacto]."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										echo '<strong>'.$rowCli[Contacto].'</strong>';
									}
								}
								$link->close();
							?>
						</td>
						<td class="c4"><b>Fecha de Emisi&oacute;n Informe</b></td>
						<td class="c5"><b>:</b></td>
					    <td class="c6">
							<?php
								$fd = explode('-',$fechaInforme);
								echo $fd[2].'-'.$fd[1].'-'.substr($fd[0],2,2);
							?>
						</td>
					</tr>
				</table>
	<p>
		<span style="text-decoration:underline;"><b><?php echo $letraItem; ?>.- Identificación de las Muestras:</b></span>
	</p>

			
</body>
</html>

<?php
function tablaQuimicoSR($c, $t, $m){
		$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysqli_fetch_array($bdRegQui)){
			$cC  = $rowRegQui[cC];
			$cSi = $rowRegQui[cSi];
			$cMn = $rowRegQui[cMn];
			$cP  = $rowRegQui[cP];
			$cS  = $rowRegQui[cS];
			$cCr = $rowRegQui[cCr];
			$cNi = $rowRegQui[cNi];
			$cMo = $rowRegQui[cMo];
			$cAl = $rowRegQui[cAl];
			$cCu = $rowRegQui[cCu];
			$cCo = $rowRegQui[cCo];
			$cTi = $rowRegQui[cTi];
			$cNb = $rowRegQui[cNb];
			$cV  = $rowRegQui[cV];
			$cW  = $rowRegQui[cW];
			$cSn = $rowRegQui[cSn];
			$cB  = $rowRegQui[cB];
			$cFe = $rowRegQui[cFe];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Mo</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center">&nbsp;</td>
			<td align="center"><?php echo $cC; ?></td>
			<td align="center"><?php echo $cSi; ?></td>
			<td align="center"><?php echo $cMn; ?></td>
			<td align="center"><?php echo $cP; ?></td>
			<td align="center"><?php echo $cS; ?></td>
			<td align="center"><?php echo $cCr; ?></td>
			<td align="center"><?php echo $cNi; ?></td>
			<td align="center"><?php echo $cMo; ?></td>
			<td align="center"><?php echo $cAl; ?></td>
			<td align="center"><?php echo $cCu; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF"><strong><?php echo $t; ?></strong></td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Ti</td>
			<td align="center" bgcolor="#E6E6E6">%Nb</td>
			<td align="center" bgcolor="#E6E6E6">%V</td>
			<td align="center" bgcolor="#E6E6E6">%W</td>
			<td align="center" bgcolor="#E6E6E6">%Sn</td>
			<td align="center" bgcolor="#E6E6E6">%B</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Fe</td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td><?php echo $cCo; ?></td>
			<td><?php echo $cTi; ?></td>
			<td><?php echo $cNb; ?></td>
			<td><?php echo $cV; ?></td>
			<td><?php echo $cW; ?></td>
			<td><?php echo $cSn; ?></td>
			<td><?php echo $cB; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><b>Resto</b></td>
		</tr>
	</table>
	<?php
}

function tablaQuimicoCR($t){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Mo</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF"><strong><?php echo $t; ?></strong></td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Ti</td>
			<td align="center" bgcolor="#E6E6E6">%Nb</td>
			<td align="center" bgcolor="#E6E6E6">%V</td>
			<td align="center" bgcolor="#E6E6E6">%W</td>
			<td align="center" bgcolor="#E6E6E6">%Sn</td>
			<td align="center" bgcolor="#E6E6E6">%B</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Fe</td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><b>Resto</b></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCR(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">Referencia</td>
			<td align="center" width="08%">%C</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%S</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Fe</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaQuimicoCoSR($c, $t, $m){
		$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysqli_fetch_array($bdRegQui)){
			$cC  = $rowRegQui[cC];
			$cSi = $rowRegQui[cSi];
			$cMn = $rowRegQui[cMn];
			$cP  = $rowRegQui[cP];
			$cS  = $rowRegQui[cS];
			$cCr = $rowRegQui[cCr];
			$cNi = $rowRegQui[cNi];
			$cMo = $rowRegQui[cMo];
			$cAl = $rowRegQui[cAl];
			$cCu = $rowRegQui[cCu];
			$cCo = $rowRegQui[cCo];
			$cTi = $rowRegQui[cTi];
			$cNb = $rowRegQui[cNb];
			$cV  = $rowRegQui[cV];
			$cW  = $rowRegQui[cW];
			$cPb = $rowRegQui[cPb];
			$cB  = $rowRegQui[cB];
			$cSn = $rowRegQui[cSn];
			$cZn = $rowRegQui[cZn];
			$cAs = $rowRegQui[cAs];
			$cBi = $rowRegQui[cBi];
			$cTa = $rowRegQui[cTa];
			$cCa = $rowRegQui[cCa];
			$cCe = $rowRegQui[cCe];
			$cZr = $rowRegQui[cZr];
			$cLa = $rowRegQui[cLa];
			$cSe = $rowRegQui[cSe];
			$cN  = $rowRegQui[cN];
			$cFe = $rowRegQui[cFe];
			$cMg = $rowRegQui[cMg];
			$cTe = $rowRegQui[cTe];
			$cCd = $rowRegQui[cCd];
			$cAg = $rowRegQui[cAg];
			$cAu = $rowRegQui[cAu];
			$cAi = $rowRegQui[cAi];
			$cSb = $rowRegQui[cSb];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">%Pb</td>
			<td align="center" width="08%">%Sn</td>
			<td align="center" width="08%">%P</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Mg</td>
			<td align="center" width="08%">%Cr</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td><?php echo $cZn; ?></td>
			<td><?php echo $cPb; ?></td>
			<td><?php echo $cSn; ?></td>
			<td><?php echo $cP; ?></td>
			<td><?php echo $cMn; ?></td>
			<td><?php echo $cFe; ?></td>
			<td><?php echo $cNi; ?></td>
			<td><?php echo $cSi; ?></td>
			<td><?php echo $cMg; ?></td>
			<td><?php echo $cCr; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;</strong></td>
			<td align="center" bgcolor="#E6E6E6">%Te</td>
			<td align="center" bgcolor="#E6E6E6">%As</td>
			<td align="center" bgcolor="#E6E6E6">%Sb</td>
			<td align="center" bgcolor="#E6E6E6">%Cd</td>
			<td align="center" bgcolor="#E6E6E6">%Bi</td>
			<td align="center" bgcolor="#E6E6E6">%Ag</td>
			<td align="center" bgcolor="#E6E6E6">%Co</td>
			<td align="center" bgcolor="#E6E6E6">%Ai</td>
			<td align="center" bgcolor="#E6E6E6">%S</td>
			<td align="center" bgcolor="#E6E6E6">%Zr</td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td align="center"><strong><?php echo $t; ?></td>
			<td><?php echo $cTe; ?></td>
			<td><?php echo $cAs; ?></td>
			<td><?php echo $cSb; ?></td>
			<td><?php echo $cCd; ?></td>
			<td><?php echo $cBi; ?></td>
			<td><?php echo $cAg; ?></td>
			<td><?php echo $cCo; ?></td>
			<td><?php echo $cAi; ?></td>
			<td><?php echo $cS; ?></td>
			<td><?php echo $cZr; ?></td>
		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;</td>
			<td align="center" bgcolor="#E6E6E6">%Au</td>
			<td align="center" bgcolor="#E6E6E6">%B</td>
			<td align="center" bgcolor="#E6E6E6">%Ti</td>
			<td align="center" bgcolor="#E6E6E6">%Se</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Cu</td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td><?php echo $Au; ?></td>
			<td><?php echo $cB; ?></td>
			<td><?php echo $cTi; ?></td>
			<td><?php echo $cSe; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $cCu; ?></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoCo(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">Referencia</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Sn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Ni(**)</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu()***</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaQuimicoAl($c, $t, $m){
		$bdRegQui=$link->query("SELECT * FROM regQuimico Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegQui=mysqli_fetch_array($bdRegQui)){
			$cC  = $rowRegQui[cC];
			$cSi = $rowRegQui[cSi];
			$cMn = $rowRegQui[cMn];
			$cP  = $rowRegQui[cP];
			$cS  = $rowRegQui[cS];
			$cCr = $rowRegQui[cCr];
			$cNi = $rowRegQui[cNi];
			$cMo = $rowRegQui[cMo];
			$cAl = $rowRegQui[cAl];
			$cCu = $rowRegQui[cCu];
			$cCo = $rowRegQui[cCo];
			$cTi = $rowRegQui[cTi];
			$cNb = $rowRegQui[cNb];
			$cV  = $rowRegQui[cV];
			$cW  = $rowRegQui[cW];
			$cPb = $rowRegQui[cPb];
			$cB  = $rowRegQui[cB];
			$cSn = $rowRegQui[cSn];
			$cZn = $rowRegQui[cZn];
			$cAs = $rowRegQui[cAs];
			$cBi = $rowRegQui[cBi];
			$cTa = $rowRegQui[cTa];
			$cCa = $rowRegQui[cCa];
			$cCe = $rowRegQui[cCe];
			$cZr = $rowRegQui[cZr];
			$cLa = $rowRegQui[cLa];
			$cSe = $rowRegQui[cSe];
			$cN  = $rowRegQui[cN];
			$cFe = $rowRegQui[cFe];
			$cMg = $rowRegQui[cMg];
			$cTe = $rowRegQui[cTe];
			$cCd = $rowRegQui[cCd];
			$cAg = $rowRegQui[cAg];
			$cAu = $rowRegQui[cAu];
			$cAi = $rowRegQui[cAi];
			$cSb = $rowRegQui[cSb];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Cu</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Mg</td>
			<td align="center" width="08%">%Cr</td>
			<td align="center" width="08%">%Ni</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">%Ti</td>
			<td align="center" width="08%">%Pb</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td><?php echo $cSi; ?></td>
			<td><?php echo $cFe; ?></td>
			<td><?php echo $cCu; ?></td>
			<td><?php echo $cMn; ?></td>
			<td><?php echo $cMg; ?></td>
			<td><?php echo $cCr; ?></td>
			<td><?php echo $cNi; ?></td>
			<td><?php echo $cZn; ?></td>
			<td><?php echo $cTi; ?></td>
			<td><?php echo $cPb; ?></td>
  		</tr>
		<tr style="font-weight:700;" align="center">
			<td height="28" align="center" bgcolor="#FFFFFF"><strong><?php echo $t; ?></strong></td>
			<td align="center" bgcolor="#E6E6E6">%Sn</td>
			<td align="center" bgcolor="#E6E6E6">%Bi</td>
			<td align="center" bgcolor="#E6E6E6">%Zr</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">-</td>
			<td align="center" bgcolor="#E6E6E6">%Al</td>
  		</tr>
		<tr bgcolor="#FFFFFF" align="center">
			<td>&nbsp;</td>
			<td><?php echo $cSn; ?></td>
			<td><?php echo $cBi; ?></td>
			<td><?php echo $cZr; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $cAl; ?></td>
		</tr>
	</table>
	<?php
}

function ReftablaQuimicoAl(){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">Referencia</td>
			<td align="center" width="08%">%Zn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Sn</td>
			<td align="center" width="08%">-</td>
			<td align="center" width="08%">%Mn</td>
			<td align="center" width="08%">%Fe</td>
			<td align="center" width="08%">%Ni(**)</td>
			<td align="center" width="08%">%Si</td>
			<td align="center" width="08%">%Al</td>
			<td align="center" width="08%">%Cu()***</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaTraccionRe($c, $t, $m){
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra[aIni];
			$cFlu = $rowRegTra[cFlu];
			$cMax = $rowRegTra[cMax];
			$tFlu = $rowRegTra[tFlu];
			$tMax = $rowRegTra[tMax];
			$aSob = $rowRegTra[aSob];
			$rAre = $rowRegTra[rAre];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="8%">
				Área<br>Inicial<br> (mm<sup>2</sub>)
			</td>
			<td align="center" width="8%">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center" width="8%">
				Carga<br>Máxima<br>(Kgf)
			</td>
			<td align="center" width="8%">
				Tensión de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center" width="8%">
				Tensión<br>Máxima<br>(MPa)			
			</td>
			<td align="center" width="8%">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
			<td align="center" width="8%">
				Red.<br>de Área<br> (%)
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<!-- <td><?php echo number_format($aIni, 2, '.', ','); ?></td> -->
			<td><?php echo $aIni; ?></td>
<!-- 			<td><?php echo number_format($cFlu, 0, ',', '.'); ?></td> -->
			<td><?php echo $cFlu; ?></td>
			<td><?php echo number_format($cMax, 0, ',', '.'); ?></td>
			<td><?php echo number_format($tFlu, 0, ',', '.'); ?></td>
			<!-- <td><?php echo number_format($tMax, 1, ',', '.'); ?></td> -->
			<td><?php echo $tMax; ?></td>
			<td><?php echo number_format($aSob, 0, ',', '.'); ?></td>
			<td><?php echo number_format($rAre, 0, ',', '.'); ?></td>
  		</tr>
	</table>
	<?php
}

function RefTablaTraccionRe($c, $t, $m){
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra[aIni];
			$cFlu = $rowRegTra[cFlu];
			$cMax = $rowRegTra[cMax];
			$tFlu = $rowRegTra[tFlu];
			$tMax = $rowRegTra[tMax];
			$aSob = $rowRegTra[aSob];
			$rAre = $rowRegTra[rAre];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
		  	<td width="39%" colspan="4" align="center"><strong>Referencia</strong></td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
			<td width="8%" align="center">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaTraccionPl($c, $t, $m){
		$bdRegTra=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."'");
		if($rowRegTra=mysqli_fetch_array($bdRegTra)){
			$aIni = $rowRegTra[aIni];
			$cFlu = $rowRegTra[cFlu];
			$cMax = $rowRegTra[cMax];
			$tFlu = $rowRegTra[tFlu];
			$tMax = $rowRegTra[tMax];
			$aSob = $rowRegTra[aSob];
			$rAre = $rowRegTra[rAre];
		}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<td align="center" width="15%">ID<br>ITEM</td>
			<td align="center" width="8%">
				Área<br>Inicial<br> (mm<sup>2</sub>)
			</td>
			<td align="center" width="8%">
				Carga de<br>Fluencia<br> 0,2 % Def,<br> (Kgf)
			</td>
			<td align="center" width="8%">
				Carga<br>Máxima<br>(Kgf)
			</td>
			<td align="center" width="8%">
				Tensión de<br>Fluencia<br>0,2% Def,<br> (MPa)
			</td>
			<td align="center" width="8%">
				Tensión<br>Máxima<br>(MPa)			
			</td>
			<td align="center" width="8%">
				Alarg,<br>Sobre 50<br>mm<br>(%)
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<td><?php echo $aIni; ?></td>
			<td><?php echo $cFlu; ?></td>
			<td><b><?php echo number_format($cMax, 0, ',', '.'); ?></b></td>
			<td><b><?php echo number_format($tFlu, 0, ',', '.'); ?></b></td>
			<td><b><?php echo number_format($tMax, 0, ',', '.'); ?></b></td>
			<td><b><?php echo number_format($aSob, 0, ',', '.'); ?></b></td>
		</tr>
	</table>
	<?php
}
function RefTablaTraccionPl(){
	?>
	<table cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF">
		  	<td width="39%" colspan="4" align="center"><strong>Referencia</strong></td>
			<td width="8%" align="center">0</td>
			<td width="8%" align="center">0</td>
			<td width="8%" align="center">0</td>
  		</tr>
	</table>
	<?php 
}

function tablaCharpy($c, $t, $m, $n, $tem){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" rowspan="2" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n+1; ?>" align="center">
		   		Energía de impacto a <?php echo $tem; ?><br>
				(Joule)
			</td>
  		</tr>
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
			<?php for($i=1; $i<=$n ; $i++){ ?>
				<td align="center" width="8%">
					Muestra N° <?php echo $i; ?>
				</td>
			<?php } ?>
			<td align="center" width="8%">
				Promedio
			</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<?php
				$sImpactos 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegCh=$link->query("SELECT * FROM regCharpy Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nImpacto = '".$i."'");
					if($rowRegCh=mysqli_fetch_array($bdRegCh)){
						$vImpacto = $rowRegCh[vImpacto];
					}
					$sImpactos += $vImpacto;
					$Media = $sImpactos / $n;
					echo '<td width="8%">'.number_format($vImpacto, 1, ',', '.').'</td>';
				}
			?>
			<td width="8%"><?php echo number_format($Media, 1, ',', '.'); ?></td>
		</tr>
	</table>
	<?php
}
function RefTablaCharpy($c, $t, $m, $n, $tem){
	$por = $n * 8;
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
			<td align="center" width="15%">&nbsp;</td>
		  	<td align="center" width="<?php echo $por; ?>%" colspan="<?php echo $n; ?>"><strong>Referencia según especificación del cliente</strong></td>
			<td align="center" width="8%">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

function tablaDureza($c, $t, $m, $n){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" colspan="<?php echo $n; ?>" align="center">
				Dureza <br>
				<?php 
					if( strtoupper(substr($m,2,1)) ){?>
						Rockwell <?php echo strtoupper(substr($m,2,1)); ?>
					<?php }else{ ?>
						Brinell
					<?php } ?>
			</td>
  		    <td height="41" align="center">Promedio</td>
		</tr>
		<tr bgcolor="#FFFFFF" align="center">
		  	<td align="center"><strong><?php echo $t; ?></strong></td>
			<?php
				$sDoblado 	= 0;
				$Media 		= 0;
				for($i=1; $i<=$n; $i++){
					$bdRegDob=$link->query("SELECT * FROM regDoblado Where CodInforme = '".$c."' and idItem = '".$t."' and tpMuestra = '".$m."' and nIndenta = '".$i."'");
					if($rowRegDob=mysqli_fetch_array($bdRegDob)){
						$vIndenta = $rowRegDob[vIndenta];
					}
					$sDoblado += $vIndenta;
					$Media = $sDoblado / $n;
					echo '<td width="8%">'.number_format($vIndenta, 1, ',', '.').'</td>';
				}
			?>
			<td width="8%"><?php echo number_format($Media, 1, '.', ','); ?></td>
		</tr>
	</table>
	<?php
}

function tablaOtra($c, $t, $m){
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
		  	<td width="15%" align="center">
				ID<br>
	      		ITEM
			</td>
		  	<td height="41" align="center">
				Otra
			</td>
		</tr>
	</table>
	<?php
}

function RefTablaDureza($c, $t, $m, $n){
	$por = $n * 8;
	?>
	<table width="100%" cellpadding="0" cellspacing="0" class="ftoTablaResultado">
		<tr bgcolor="#FFFFFF" style="font-weight:700; font-size:1.1em;">
			<td align="center" width="15%">&nbsp;</td>
		  	<td align="center" width="<?php echo $por; ?>%" colspan="<?php echo $n; ?>"><strong>Referencia según especificación del cliente</strong></td>
			<td align="center" width="8%">&nbsp;</td>
  		</tr>
	</table>
	<?php 
}

?>
