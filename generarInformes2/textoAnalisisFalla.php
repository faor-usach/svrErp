<style>
#tablaAnalisisFalla{
	border		:4px solid #000; 
	width		:35.44em;
}
#tablaAnalisisFalla td{
	border		:1px double #000; 
	font-family	:Arial;
	font-size	:13,5px;
}
.col1{
	width		:8.3em;
	height		:0.97em;
}
#tablaResumen{
	border		:1px double #000; 
	width		:35.44em;
}
#cajaResumen{
	border		:3px solid #000; 
	width		:35.44em;
}
.textoEspacio15 {
	margin-left	: 5px;
	line-height	: 150%;
	text-align	: justify; 
	margin-right: 5px;
	text-indent: 1cm; /* Aplica Sangria al texto */
}
</style>
	<table cellpadding="0" cellspacing="0" id="tablaAnalisisFalla" align="center">
		<tr>
			<td class="col1"><b>TITULO</b></td>
			<td><b>&nbsp;: <?php echo utf8_decode($Titulo); ?></b></td>
		</tr>
		<tr>
			<td><b>AUTORES</b></td>
			<td><b>&nbsp;: 
				<?php
					$link=Conectarse();
					$bdUs=$link->query("Select * From Usuarios Where usr = '".$ingResponsable."'");
					if($rowUs=mysqli_fetch_array($bdUs)){
						echo utf8_decode($rowUs['usuario']);
					}
					$bdUs=$link->query("Select * From Usuarios Where usr = '".$cooResponsable."'");
					if($rowUs=mysqli_fetch_array($bdUs)){
						echo ' y '.utf8_decode($rowUs['usuario']);
					}
					$link->close();
				?>
				</b>
			</td>
		</tr>
		<tr>
			<td><b>Palabras Claves</b></td>
			<td><b>&nbsp;: <?php echo utf8_decode($palsClaves); ?></b></td>
		</tr>
	</table>
	<p class="blanco" >&nbsp;</p>
	<table cellpadding="0" cellspacing="0" id="tablaResumen" align="center">
		<tr>
			<td id="cajaResumen">
				<div style="margin-left: 5px;"><u><b>RESUMEN</b></u></div>
				<div class="textoEspacio15"><b>Objetivos:</b></div>
				<div class="textoEspacio15"><?php echo utf8_decode($Objetivos); ?></div>
				<div class="textoEspacio15"><b>Metodología:</b></div>
				<div class="textoEspacio15"><?php echo utf8_decode($Metodologia); ?></div>
				<div class="textoEspacio15"><b>Comentarios:</b></div>
				<div class="textoEspacio15">
					<?php 
/*
						$td = explode('-', $Comentarios);
						$tp = explode('-', $Comentarios);
						echo utf8_decode(stripcslashes(nl2br($td[0])));
						$i = 0;
						foreach($tp as $valor){
							if($i > 0){
								echo '<li>'.utf8_decode(stripcslashes(nl2br($valor))).'</li>'; 
							}
							$i++;
						}
*/
						echo utf8_decode(stripcslashes(nl2br($Comentarios)));
					?>
				</div>
				<div class="textoEspacio15"><b>En resumen,:</b></div>
				<div class="textoEspacio15"><?php echo utf8_decode($Resumen); ?></div>
			</td>
		</tr>
	</table>
	