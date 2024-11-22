			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="preCAM.php" title="PreCAM">
						<img src="../imagenes/consulta.png"><br>
					</a>
					Head
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="#" title="+ PreCAM" onClick="registraActividad(0, 'Agrega')">
						<img src="../imagenes/mail_html.png"><br>
					</a>
					Body
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="../cotizaciones/plataformaCotizaciones.php" title="+ Cotizar">
						<img src="../imagenes/other_48.png"><br>
					</a>
					Footer
				</div>
			</div>

				<script>
					var usrRes 		= '<?php echo $usrRes; 	 ?>';
					var tpAccion 	= '<?php echo $tpAccion; ?>';
					realizaProceso(usrRes, tpAccion);
				</script>					

			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>