<script>
function myFunction()
{
	var x=document.getElementById("Ind");
	var nInd	= $("#Ind").val();
	var vItem	= $("#Item").val();
	var n		= 0;
	var sSuma	= 0;
	var vMedia	= 0;
	var valInd  = 0;

	for(n = 1; n<=nInd; n++) { 
		 var el_vIndenta	= 'vIndenta_'+n+'-'+vItem;
		 var vIndenta = $("#"+el_vIndenta).val();
		 var sSuma = sSuma + parseFloat(vIndenta);
		 var vMedia = sSuma/n;
	}
	//alert(sSuma);
	var vMedia=Math.round(vMedia*10)/10;
	document.form.Media.value 		= vMedia;
/*
	var vValorUF	= $("#ValorUF").val();
	var vTotal		= vCantidad * vValorUF;
*/
}

function myImpactos()
{
	var x=document.getElementById("Ind");
	var nInd	= $("#Ind").val();
	var vItem	= $("#Item").val();
	var n		= 0;
	var sSuma	= 0;
	var vMedia	= 0;
	var valInd  = 0;

	for(n = 1; n<=nInd; n++) { 
		 var el_vIndenta	= 'vImpacto_'+n+'-'+vItem;
		 var vIndenta = $("#"+el_vIndenta).val();
		 var sSuma = sSuma + parseFloat(vIndenta);
		 var vMedia = sSuma/n;
	}
	//alert(sSuma);
	var vMedia=Math.round(vMedia*10)/10;
	document.form.Media.value 		= vMedia;
/*
	var vValorUF	= $("#ValorUF").val();
	var vTotal		= vCantidad * vValorUF;
*/
}

</script>

			<?php
			//if($_GET[idEnsayo]=='Qu' and $_GET[tpMuestra]=='Ac' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Qu' and $_GET[tpMuestra]=='Ac'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-Q'.$i;
					if($i<10){ $tq = $ta[1].'-Q0'.$i; }
					
					$campoidItem 	= 'idItem'.$tq;
					$el_cC 			= 'cC'.$tq;
					$el_cSi			= 'cSi'.$tq;
					$el_cMn			= 'cMn'.$tq;
					$el_cP			= 'cP'.$tq;
					$el_cS			= 'cS'.$tq;
					$el_cCr			= 'cCr'.$tq;
					$el_cNi			= 'cNi'.$tq;
					$el_cMo			= 'cMo'.$tq;
					$el_cAl			= 'cAl'.$tq;
					$el_cCu			= 'cCu'.$tq;
					$el_cCo			= 'cCo'.$tq;
					$el_cTi			= 'cTi'.$tq;
					$el_cNb			= 'cNb'.$tq;
					$el_cV			= 'cV'.$tq;
					$el_cW			= 'cW'.$tq;
					$el_cSn			= 'cSn'.$tq;
					$el_cB			= 'cB'.$tq;
					$el_cFe			= 'cFe'.$tq;

					$link=Conectarse();
					$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."'");
					if($rowRegQui=mysql_fetch_array($bdRegQui)){
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
					mysql_close($link);

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
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
							<td height="30">&nbsp;</td>
							<td><input style="text-align:center;" name="<?php echo $el_cC; ?>" 		type="text" size="9" maxlength="9" value="<?php echo $cC;  ?>" autofocus />	</td>
							<td><input style="text-align:center;" name="<?php echo $el_cSi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cSi; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cMn; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cMn; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cP; ?>" 		type="text" size="9" maxlength="9" value="<?php echo $cP;  ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cS; ?>" 		type="text" size="9" maxlength="9" value="<?php echo $cS;  ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cCr; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cCr; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cNi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cNi; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cMo; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cMo; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cAl; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cAl; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cCu; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cCu; ?>" />			</td>
						</tr>
						<tr style="font-weight:700;" align="center">
							<td height="28" align="center" bgcolor="#FFFFFF">
								<strong>
									<?php echo $tq; //$campoidItem; ?>
									<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
								</strong>
							</td>
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
							<td height="30">&nbsp;</td>
							<td><input style="text-align:center;" name="<?php echo $el_cCo; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cCo; ?>" autofocus />	</td>
							<td><input style="text-align:center;" name="<?php echo $el_cTi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cTi; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cNb; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cNb; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cV; ?>" 		type="text" size="9" maxlength="9" value="<?php echo $cV;  ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cW; ?>" 		type="text" size="9" maxlength="9" value="<?php echo $cW;  ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cSn; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cSn;  ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cB; ?>" 		type="text" size="9" maxlength="9" value="<?php echo $cB;  ?>" />			</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><input style="text-align:center;" name="<?php echo $el_cFe; ?>" 	type="text" size="9" maxlength="9" value="<?php echo 'Resto';  ?>" />		</td>
						</tr>
					</table>
					<?php
				}
			}


			//if($_GET[idEnsayo]=='Qu' and $_GET[tpMuestra]=='Co' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Qu' and $_GET[tpMuestra]=='Co'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-Q'.$i;
					if($i<10){ $tq = $ta[1].'-Q0'.$i; }
					
					$campoidItem 	= 'idItem'.$tq;
					$el_cC 			= 'cC'.$tq;
					$el_cSi			= 'cSi'.$tq;
					$el_cMn			= 'cMn'.$tq;
					$el_cP			= 'cP'.$tq;
					$el_cS			= 'cS'.$tq;
					$el_cCr			= 'cCr'.$tq;
					$el_cNi			= 'cNi'.$tq;
					$el_cMo			= 'cMo'.$tq;
					$el_cAl			= 'cAl'.$tq;
					$el_cCu			= 'cCu'.$tq;
					$el_cCo			= 'cCo'.$tq;
					$el_cTi			= 'cTi'.$tq;
					$el_cNb			= 'cNb'.$tq;
					$el_cV			= 'cV'.$tq;
					$el_cW			= 'cW'.$tq;
					$el_cSn			= 'cSn'.$tq;
					$el_cB			= 'cB'.$tq;
					$el_cFe			= 'cFe'.$tq;

					$el_cZn 		= 'cZn'.$tq;
					$el_cPb 		= 'cPb'.$tq;
					$el_cMg 		= 'cMg'.$tq;
					$el_cTe 		= 'cTe'.$tq;
					$el_cAs 		= 'cAs'.$tq;
					$el_cSb 		= 'cSb'.$tq;
					$el_cCd 		= 'cCd'.$tq;
					$el_cBi 		= 'cBi'.$tq;
					$el_cAg 		= 'cAg'.$tq;
					$el_cAi 		= 'cAi'.$tq;
					$el_cZr 		= 'cZr'.$tq;
					$el_cAu 		= 'cAu'.$tq;
					$el_cSe 		= 'cSe'.$tq;

					$link=Conectarse();
					$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."'");
					if($rowRegQui=mysql_fetch_array($bdRegQui)){
						$cZn = $rowRegQui[cZn];
						$cPb = $rowRegQui[cPb];
						$cMg = $rowRegQui[cMg];
						$cTe = $rowRegQui[cTe];
						$cAs = $rowRegQui[cAs];
						$cSb = $rowRegQui[cSb];
						$cCd = $rowRegQui[cCd];
						$cBi = $rowRegQui[cBi];
						$cAg = $rowRegQui[cAg];
						$cAi = $rowRegQui[cAi];
						$cZr = $rowRegQui[cZr];
						$cAu = $rowRegQui[cAu];
						$cSe = $rowRegQui[cSe];
						
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
					mysql_close($link);

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
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
							<td height="30">&nbsp;</td>
							<td><input name="<?php echo $el_cZn; ?>" 	type="text" id="<?php echo $el_cZn; ?>" style="text-align:center;" value="<?php echo $cZn;  ?>" size="9" maxlength="9" autofocus />	</td>
							<td><input name="<?php echo $el_cPb; ?>" 	type="text" id="<?php echo $el_cPb; ?>" style="text-align:center;" value="<?php echo $cPb; ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cSn; ?>" 	type="text" id="<?php echo $el_cSn; ?>" style="text-align:center;" value="<?php echo $cSn; ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cP; ?>" 	type="text" id="<?php echo $el_cP; ?>"  style="text-align:center;" value="<?php echo $cP;  ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cMn; ?>" 	type="text" id="<?php echo $el_cMn; ?>" style="text-align:center;" value="<?php echo $cMn;  ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cFe; ?>" 	type="text" id="<?php echo $el_cFe; ?>" style="text-align:center;" value="<?php echo $cFe; ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cNi; ?>" 	type="text" id="<?php echo $el_cNi; ?>" style="text-align:center;" value="<?php echo $cNi; ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cSi; ?>" 	type="text" id="<?php echo $el_cSi; ?>" style="text-align:center;" value="<?php echo $cSi; ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cMg; ?>" 	type="text" id="<?php echo $el_cMg; ?>" style="text-align:center;" value="<?php echo $cMg; ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cCr; ?>" 	type="text" id="<?php echo $el_cCr; ?>" style="text-align:center;" value="<?php echo $cCr; ?>"  size="9" maxlength="9" />			</td>
						</tr>
						<tr style="font-weight:700;" align="center">
							<td height="28" align="center" bgcolor="#FFFFFF">
								<strong>								</strong>
							</td>
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
							<td height="30"><strong><?php echo $tq; //$campoidItem; ?>
                                <input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
                            </strong></td>
							<td><input name="<?php echo $el_cTe; ?>" 	type="text" id="<?php echo $el_cTe; ?>" style="text-align:center;" value="<?php echo $cTe; ?>" 	size="9" maxlength="9" autofocus />	</td>
							<td><input name="<?php echo $el_cAs; ?>" 	type="text" id="<?php echo $el_cAs; ?>" style="text-align:center;" value="<?php echo $cAs; ?>" 	size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cSb; ?>" 	type="text" id="<?php echo $el_cSb; ?>" style="text-align:center;" value="<?php echo $cSb; ?>" 	size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cCd; ?>" 	type="text" id="<?php echo $el_cCd; ?>" style="text-align:center;" value="<?php echo $cCd;  ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cBi; ?>" 	type="text" id="<?php echo $el_cBi; ?>" style="text-align:center;" value="<?php echo $cBi;  ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cAg; ?>" 	type="text" id="<?php echo $el_cAg; ?>" style="text-align:center;" value="<?php echo $cAg;  ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cCo; ?>" 	type="text" id="<?php echo $el_cCo; ?>" style="text-align:center;" value="<?php echo $cCo;  ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cAi; ?>" 	type="text" id="<?php echo $el_cAi; ?>" style="text-align:center;" value="<?php echo $cAi;  ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cS; ?>" 	type="text" id="<?php echo $el_cS; ?>"  style="text-align:center;" value="<?php echo $cS;  ?>"  size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cZr; ?>" 	type="text" id="<?php echo $el_cZr; ?>" style="text-align:center;" value="<?php echo $cZr;  ?>" size="9" maxlength="9" />			</td>
						</tr>

						<tr style="font-weight:700;" align="center">
							<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;
							</td>
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
							<td height="30">&nbsp;</td>
							<td><input name="<?php echo $el_cAu; ?>" 	type="text" id="<?php echo $el_cAu; ?>" style="text-align:center;" value="<?php echo $cAu; ?>" size="9" maxlength="9" autofocus />	</td>
							<td><input name="<?php echo $el_cB; ?>" 	type="text" id="<?php echo $el_cB; ?>" style="text-align:center;" value="<?php echo $cB; ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cTi; ?>" 	type="text" id="<?php echo $el_cTi; ?>" style="text-align:center;" value="<?php echo $cTi; ?>" size="9" maxlength="9" />			</td>
							<td><input name="<?php echo $el_cSe; ?>" 		type="text" id="<?php echo $el_cSe; ?>" style="text-align:center;" value="<?php echo $cSe;  ?>" size="9" maxlength="9" />			</td>
							<td>&nbsp;			</td>
							<td>&nbsp;			</td>
							<td>&nbsp;			</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><input name="<?php echo $el_cCu; ?>" 	type="text" id="<?php echo $el_cCu; ?>" style="text-align:center;" value="<?php echo$cCu;  ?>" size="9" maxlength="9" />		</td>
						</tr>
					</table>
					<?php
				}
			}


			//if($_GET[idEnsayo]=='Qu' and $_GET[tpMuestra]=='Al' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Qu' and $_GET[tpMuestra]=='Al'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-Q'.$i;
					if($i<10){ $tq = $ta[1].'-Q0'.$i; }
					
					$campoidItem 	= 'idItem'.$tq;
					$el_cC 			= 'cC'.$tq;
					$el_cSi			= 'cSi'.$tq;
					$el_cMn			= 'cMn'.$tq;
					$el_cP			= 'cP'.$tq;
					$el_cS			= 'cS'.$tq;
					$el_cCr			= 'cCr'.$tq;
					$el_cNi			= 'cNi'.$tq;
					$el_cMo			= 'cMo'.$tq;
					$el_cAl			= 'cAl'.$tq;
					$el_cCu			= 'cCu'.$tq;
					$el_cCo			= 'cCo'.$tq;
					$el_cTi			= 'cTi'.$tq;
					$el_cNb			= 'cNb'.$tq;
					$el_cV			= 'cV'.$tq;
					$el_cW			= 'cW'.$tq;
					$el_cSn			= 'cSn'.$tq;
					$el_cB			= 'cB'.$tq;
					$el_cFe			= 'cFe'.$tq;
					$el_cMg			= 'cMg'.$tq;
					$el_cZn			= 'cZn'.$tq;
					$el_cPb			= 'cPb'.$tq;
					$el_cBi			= 'cBi'.$tq;
					$el_cZr			= 'cZr'.$tq;

					$link=Conectarse();
					$bdRegQui=mysql_query("SELECT * FROM regQuimico Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."'");
					if($rowRegQui=mysql_fetch_array($bdRegQui)){
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
						
						$cMg = $rowRegQui[cMg];
						$cZn = $rowRegQui[cZn];
						$cPb = $rowRegQui[cPb];
						$cBi = $rowRegQui[cBi];
						$cZr = $rowRegQui[cZr];
					}
					mysql_close($link);

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
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
							<td height="30">&nbsp;</td>
							<td><input style="text-align:center;" name="<?php echo $el_cSi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cSi;  ?>" autofocus />	</td>
							<td><input style="text-align:center;" name="<?php echo $el_cFe; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cFe; ?>" 	/>				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cCu; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cCu; ?>" 	/>				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cMn; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cMn;  ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cMg; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cMg;  ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cCr; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cCr; ?>" 	/>				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cNi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cNi; ?>" 	/>				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cZn; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cZn; ?>" 	/>				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cTi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cTi; ?>" 	/>				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cPb; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cPb; ?>" 	/>				</td>
						</tr>
						<tr style="font-weight:700;" align="center">
							<td height="28" align="center" bgcolor="#FFFFFF">
								<strong>
									<?php echo $tq; //$campoidItem; ?>
									<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
								</strong>
							</td>
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
							<td height="30">&nbsp;</td>
							<td><input style="text-align:center;" name="<?php echo $el_cSn; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cSn; ?>" autofocus />	</td>
							<td><input style="text-align:center;" name="<?php echo $el_cBi; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cBi; ?>" />			</td>
							<td><input style="text-align:center;" name="<?php echo $el_cZr; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cZr; ?>" />			</td>
						  	<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><input style="text-align:center;" name="<?php echo $el_cAl; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cAl;  ?>" />		</td>
						</tr>
					</table>
					<?php
				}
			}


			//Tracción Plana
			//if($_GET[idEnsayo]=='Tr' and $_GET[tpMuestra]=='Pl' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Tr' and $_GET[tpMuestra]=='Pl'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-T'.$i;
					if($i<10){ $tq = $ta[1].'-T0'.$i; }
					
					$campoidItem 	= 'idItem'.$tq;
					$el_aIni 	= 'aIni'.$tq;
					$el_cFlu	= 'cFlu'.$tq;
					$el_cMax	= 'cMax'.$tq;
					$el_tFlu	= 'tFlu'.$tq;
					$el_tMax	= 'tMax'.$tq;
					$el_aSob	= 'aSob'.$tq;

					$link=Conectarse();
					$bdRegTra=mysql_query("SELECT * FROM regTraccion Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."'");
					if($rowRegTra=mysql_fetch_array($bdRegTra)){
						$aIni  = $rowRegTra[aIni];
						$cFlu  = $rowRegTra[cFlu];
						$cMax  = $rowRegTra[cMax];
						$tFlu  = $rowRegTra[tFlu];
						$tMax  = $rowRegTra[tMax];
						$aSob  = $rowRegTra[aSob];
					}
					mysql_close($link);

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
						<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
							<td align="center" width="15%">ID<br>ITEM</td>
							<td align="center" width="8%">Área<br>Inicial<br>(mm<sup>2</sup>)			</td>
							<td align="center" width="8%">Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</td>
							<td align="center" width="8%">Carga<br>Máxima<br>(Kgf) 						</td>
							<td align="center" width="8%">Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</td>
							<td align="center" width="8%">Tensión<br>Máxima<br>(MPa) 					</td>
							<td align="center" width="8%">Alarg,<br>Sobre 50<br>mm<br>(%) 				</td>
						</tr>
						<tr bgcolor="#FFFFFF" align="center">
							<td height="30"><strong><?php echo $tq; //$campoidItem; ?>
                                <input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
                            </strong></td>
							<td><input style="text-align:center;" name="<?php echo $el_aIni; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $aIni; ?>" autofocus />	</td>
							<td><input style="text-align:center;" name="<?php echo $el_cFlu; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cFlu; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cMax; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cMax; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_tFlu; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $tFlu; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_tMax; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $tMax; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_aSob; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $aSob; ?>" />				</td>
						</tr>
					</table>
					<?php
				}
			}

			//Tracción Redonda
			//if($_GET[idEnsayo]=='Tr' and $_GET[tpMuestra]=='Re' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Tr' and $_GET[tpMuestra]=='Re'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-T'.$i;
					if($i<10){ $tq = $ta[1].'-T0'.$i; }
					
					$campoidItem 	= 'idItem'.$tq;
					$el_aIni 	= 'aIni'.$tq;
					$el_cFlu	= 'cFlu'.$tq;
					$el_cMax	= 'cMax'.$tq;
					$el_tFlu	= 'tFlu'.$tq;
					$el_tMax	= 'tMax'.$tq;
					$el_aSob	= 'aSob'.$tq;
					$el_rAre	= 'rAre'.$tq;

					$link=Conectarse();
					$bdRegTra=mysql_query("SELECT * FROM regTraccion Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."'");
					if($rowRegTra=mysql_fetch_array($bdRegTra)){
						$aIni  = $rowRegTra[aIni];
						$cFlu  = $rowRegTra[cFlu];
						$cMax  = $rowRegTra[cMax];
						$tFlu  = $rowRegTra[tFlu];
						$tMax  = $rowRegTra[tMax];
						$aSob  = $rowRegTra[aSob];
						$rAre  = $rowRegTra[rAre];
					}
					mysql_close($link);

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
						<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
							<td align="center" width="15%">ID<br>ITEM</td>
							<td align="center" width="8%">Área<br>Inicial<br>(mm<sup>2</sup>)			</td>
							<td align="center" width="8%">Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</td>
							<td align="center" width="8%">Carga<br>Máxima<br>(Kgf) 						</td>
							<td align="center" width="8%">Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</td>
							<td align="center" width="8%">Tensión<br>Máxima<br>(MPa) 					</td>
							<td align="center" width="8%">Alarg,<br>Sobre 50<br>mm<br>(%) 				</td>
							<td align="center" width="8%">Red.<br>de Área<br>%) 						</td>
						</tr>
						<tr bgcolor="#FFFFFF" align="center">
							<td height="30"><strong><?php echo $tq; //$campoidItem; ?>
                                <input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
                            </strong></td>
							<td><input style="text-align:center;" name="<?php echo $el_aIni; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $aIni; ?>" autofocus />	</td>
							<td><input style="text-align:center;" name="<?php echo $el_cFlu; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cFlu; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_cMax; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $cMax; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_tFlu; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $tFlu; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_tMax; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $tMax; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_aSob; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $aSob; ?>" />				</td>
							<td><input style="text-align:center;" name="<?php echo $el_rAre; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $rAre; ?>" />				</td>
						</tr>
					</table>
					<?php
				}
			}


			//Dureza Hrc Hrb Hr
			//if($_GET[idEnsayo]=='Du' and $_GET[tpMuestra]=='Hrc' and $_GET[Ref]=='SR'){
			//if($_GET[idEnsayo]=='Du' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Du'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-D'.$i;
					if($i<10){ $tq = $ta[1].'-D0'.$i; }
					
					$campoidItem 	= 'idItem'.$tq;

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
						<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
							<td align="center" width="15%">ID<br>ITEM</td>
							<td colspan="<?php echo $Ind; ?>" align="center">
								Dureza<br>Rockwell <?php echo strtoupper(substr($_GET[tpMuestra],2,1)); ?>
						    </td>
							<td align="center">
								Promedio
						    </td>
						</tr>
						<tr bgcolor="#FFFFFF" align="center">
							<td height="30">
								<strong>
									<?php echo $tq; //$campoidItem; 
									?>
                                	<input name="<?php echo $campoidItem; ?>" id="Item" type="hidden" 	value="<?php echo $tq; 	?>" />
                                	<input name="Ind" id="Ind" type="text" 	value="<?php echo $Ind; 	?>" />
                            	</strong>
							</td>
							<?php
								$sDureza = 0;
								$mDureza = 0;
								for($in=1; $in<=$Ind; $in++) { 
									$el_vIndenta	= 'vIndenta_'.$in.'-'.$tq;
									$el_nIndenta 	= 'nIndenta_'.$in.'-'.$tq;
									$link=Conectarse();
									$bdRegDob=mysql_query("SELECT * FROM regDoblado Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."' and nIndenta = '".$in."'");
									if($rowRegDob=mysql_fetch_array($bdRegDob)){
										$nIndenta  = $rowRegDob[nIndenta];
										$vIndenta  = $rowRegDob[vIndenta];
									}
									mysql_close($link);
									$sDureza += $vIndenta;
									$Media = $sDureza / $in;
									?>
									<td>
										<input style="text-align:center;" name="<?php echo $el_vIndenta; ?>" id="<?php echo $el_vIndenta; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $vIndenta; ?>" autofocus onKeyUp="myFunction();" />
									</td>
									<?php
								}
							?>
							<td>
								<?php //echo number_format($mDureza, 1, '.', ','); ?>
								<input style="text-align:center;" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
							</td>
						</tr>
					</table>
					<?php
				}
			}


			//Charpy
			//if($_GET[idEnsayo]=='Du' and $_GET[tpMuestra]=='Hrc' and $_GET[Ref]=='SR'){
			//if($_GET[idEnsayo]=='Ch' and $_GET[Ref]=='SR'){
			if($_GET[idEnsayo]=='Ch'){
				for($i=1; $i<=$cEnsayos; $i++){
					$ta = explode('-',$CodInforme);
					$tq = $ta[1].'-Ch'.$i;
					if($i<10){ $tq = $ta[1].'-Ch0'.$i; }
					
/*
					$link=Conectarse();
					$bdTabEns=mysql_query("SELECT * FROM OTAMs Where Otam = '".$tq."'");
					if($rowTabEns=mysql_fetch_array($bdTabEns)){
						$Ind = $rowTabEns['Ind'];
					}
*/					
					$campoidItem 	= 'idItem'.$tq;

					?>
					
					<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
						<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
						  	<td width="15%" rowspan="2" align="center">
								ID<br>
					      		ITEM
							</td>
						  	<td colspan="<?php echo $Ind+1; ?>" align="center">Energía de impacto a <?php echo $Tem; ?><br>
								(Joule) 
							</td>
					  	</tr>
						<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
							<?php for($in=1; $in<=$Ind; $in++) { ?>
								<td align="center">
									Muestra <?php echo 'N° '.$in; ?>
								</td>
							<?php } ?>
							<td align="center">
								Promedio
						    </td>
						</tr>
						<tr bgcolor="#FFFFFF" align="center">
							<td height="30">
								<strong>
									<?php echo $tq; //$campoidItem; 
									?>
                                	<input name="<?php echo $campoidItem; ?>" id="Item" type="hidden" 	value="<?php echo $tq; 	?>" />
                                	<input name="Ind" id="Ind" type="hidden" 	value="<?php echo $Ind; 	?>" />
                            	</strong>
							</td>
							<?php
								$sImpactos 	= 0;
								$Media 		= 0;
								for($in=1; $in<=$Ind; $in++) { 
									$el_vImpacto	= 'vImpacto_'.$in.'-'.$tq;
									$el_nImpacto 	= 'nImpacto_'.$in.'-'.$tq;
									$link=Conectarse();
									$bdRegDob=mysql_query("SELECT * FROM regCharpy Where CodInforme = '".$CodInforme."' and idItem = '".$tq."' and tpMuestra = '".$tpMuestra."' and nImpacto = '".$in."'");
									if($rowRegDob=mysql_fetch_array($bdRegDob)){
										$nImpacto  = $rowRegDob[nImpacto];
										$vImpacto  = $rowRegDob[vImpacto];
									}
									mysql_close($link);
									$sImpactos += $vImpacto;
									$Media = $sImpactos / $in;
									?>
									<td>
										<input style="text-align:center;" name="<?php echo $el_vImpacto; ?>" id="<?php echo $el_vImpacto; ?>" 	type="text" size="9" maxlength="9" value="<?php echo $vImpacto; ?>" autofocus onKeyUp="myFunction();" />
									</td>
									<?php
								}
							?>
							<td>
								<?php //echo number_format($mDureza, 1, '.', ','); ?>
								<input style="text-align:center;" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
							</td>
						</tr>
					</table>
					<?php
				}
			}
			
			?>