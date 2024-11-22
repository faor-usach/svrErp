			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="/ctlSitio" title="Principal">
						<img src="/imagenes/school_128.png"><br>
					</a>
					Home
				</div>
				<div id="ImagenBarraLeft">
					<a href="/ctlSitio/links" title="Links">
						<img src="/imagenes/icono-descargas.png"><br>
					</a>
					Links
				</div>
			</div>

				<script>
					var usrRes 		= '<?php echo $usrRes; 	 ?>';
					var tpAccion 	= '<?php echo $tpAccion; ?>';
					realizaProceso(usrRes, tpAccion);
				</script>					

			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>