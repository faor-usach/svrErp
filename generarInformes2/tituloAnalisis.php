<?php
	header("Content-Type: text/html;charset=utf-8");
	include_once("../conexionli.php");
	if(isset($_GET['CodInforme'])) 	{ $CodInforme = $_GET['CodInforme']; }
	if(isset($_GET['tpEnsayo'])) 	{ $tpEnsayo = $_GET['tpEnsayo']; 	}
	$link=Conectarse();
	$actSQL="UPDATE amInformes SET ";
	$actSQL.="tpEnsayo			='".$tpEnsayo.			"'";
	$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
	$bdCot=$link->query($actSQL);
	$link->close();
	if($tpEnsayo == 1){?>
		<script>
			$('#infoTitFalla').hide();
		</script>
		<?php
	}else{?>
		<script>
			$('#infoTitFalla').show();
		</script>
		<?php
			despliegaTablaTituloAnalisis($CodInforme);
	}
?>

<?php	
function despliegaTablaTituloAnalisis($CodInforme){
	$link=Conectarse();
	$bdInf=$link->query("Select * From amInformes Where CodInforme = '".$CodInforme."'");
	if($rowInf=mysqli_fetch_array($bdInf)){
		$Titulo 	= $rowInf['Titulo'];
		$palsClaves = $rowInf['palsClaves'];
		?>
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaAnalisis">
				<tr>
					<td width="10%">TITULO 			</td>
					<td width="90%">
						<?php
						$txtDefault = '';
						$txtDefault = "Titulo...";
						?>
						<input name="Titulo" id="Titulo" size="100" maxlength="100" placeholder="<?php echo $txtDefault; ?>" value="<?php echo $Titulo; ?>" required />
					</td>
				</tr>
				<tr>
					<td>AUTORES</td>
					<td>
						<?php
							$bdUs=$link->query("Select * From Usuarios Where usr = '".$rowInf['ingResponsable']."'");
							if($rowUs=mysqli_fetch_array($bdUs)){
								echo $rowUs['usuario'];
							}
							$bdUs=$link->query("Select * From Usuarios Where usr = '".$rowInf['cooResponsable']."'");
							if($rowUs=mysqli_fetch_array($bdUs)){
								echo ' y '.$rowUs['usuario'];
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Palabras Claves </td>
					<td>
						<?php
						$txtDefault = '';
						$txtDefault = "Palabras claves...";
						?>
						<input name="palsClaves" id="palsClaves" size="100" maxlength="100" placeholder="<?php echo $txtDefault; ?>" value="<?php echo $rowInf['palsClaves']; ?>" required />
					</td>
				</tr>
			</table>
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaResumen">
				<tr>
					<td>
						<div id="divResumen">
							<b><u>RESUMEN</u></b>
							<hr>
							<div style="font-size: 14px; font-weight: bold;">
								Objetivos:
							</div>
							<div style="margin-left:20px;">
								<?php
								$Objetivos = '';
								if($rowInf['Objetivos']){
									$Objetivos = $rowInf['Objetivos'];
								}else{
									$Objetivos = 'Realizar estudio de análisis de falla y determinación de probables causas.';
								}	
								?>
								<textarea name="Objetivos" id="Objetivos" rows="5" cols="150"><?php echo $Objetivos; ?></textarea>
								<script>
									CKEDITOR.replace( 'Objetivos' );
								</script>
							</div>

							<div style="font-size: 14px; font-weight: bold;">
								Metodología:
							</div>
							<div style="margin-left:20px;">
								<?php
								$Metodologia = '';
								if($rowInf['Metodologia']){
									$Metodologia = $rowInf['Metodologia'];
								}else{
									$Metodologia = '<p>Para realizar el análisis, se procedió inicialmente a una inspección visual y análisis de la condición de falla de la muestra recibida, de tal manera de tomar antecedentes del incidente.
<br><br>Posteriormente se realizaron análisis por microscopía electrónica de barrido, químicos, dureza, microdureza y ensayos de resistencia.
<br><br>
Finalmente se realizaron análisis metalográficos, de tal manera de conocer la condición microestructural del material, para lo cual se tomaron muestras en distintas zonas del componente.
<br><br>
Para la obtención de las muestras, se realizó corte con sistema de refrigeración.</p>
';
								}
								?>
								<textarea name="Metodologia" id="Metodologia" rows="10" cols="150"><?php echo $Metodologia; ?></textarea>
								<script>
									CKEDITOR.replace( 'Metodologia' );
								</script>
							</div>

							<div style="font-size: 14px; font-weight: bold;">
								<u>Comentarios:</u>
							</div>
							<div style="margin-left:20px;">
								<textarea name="Comentarios" id="Comentarios" rows="20" cols="150"><?php echo $rowInf['Comentarios']; ?></textarea>
								<script>
									CKEDITOR.replace( 'Comentarios' );
								</script>
							</div>

							<div style="font-size: 14px; font-weight: bold;">
								<u>Resumen:</u>
							</div>
							<div style="margin-left:20px;">
								<textarea name="Resumen" id="Resumen" rows="15" cols="150"><?php echo $rowInf['Resumen']; ?></textarea>
								<script>
									CKEDITOR.replace( 'Resumen' );
								</script>
							</div>

							
						</div>
					</td>
				</tr>
			</table>
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="cajaResumen">
				<tr>
					<td>
						<div id="divResumen">
							<div style="font-size: 14px; font-weight: bold;">
								Antecedentes:
							</div>
							<div style="margin-left:20px;">
								<?php
								$Antecedentes = '';
								if($rowInf['Antecedentes']){
									$Antecedentes = $rowInf['Antecedentes'];
								}else{
									$Antecedentes = '<p>Por antecedentes entregados por el cliente, se cuenta con la siguiente información:<br><br>
<li>	Antecedente entregado por el cliente 1.</li>
<li>	Antecedente entregado por el cliente 1.</li>
<li>	Antecedente entregado por el cliente 1.</li>
<li>	Antecedente entregado por el cliente 1.</li>
</p>';
								}
								?>
								<textarea name="Antecedentes" id="Antecedentes" rows="5" cols="150"><?php echo $Antecedentes; ?></textarea>
								<script>
									CKEDITOR.replace( 'Antecedentes' );
								</script>
							</div>
						
						</div>
					</td>
				</tr>
			</table>
		<?php
	}
}
?>