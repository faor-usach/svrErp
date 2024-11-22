<!--
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="plataformaGenInf.php" title="PAMs">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					PAMs
				</div>
				<div id="ImagenBarraLeft">
					<a href="nominaInformes.php?RAM=<?php echo $RAM; ?>=&CodInforme=<?php echo $fi['0'].'-'.$fi['1']; ?>&accion=Actualizar&RutCli=<?php echo $RutCli; ?>" title="Informes">
						<img src="../imagenes/actividades.png"></a>
					<br>
					Informes
				</div>
				<div id="ImagenBarraLeft">
					<a href="edicionInformes.php?accion=Editar&RAM=<?php echo $RAM; ?>=&CodInforme=<?php echo $CodInforme; ?>" title="Informes">
						<img src="../imagenes/newPdf.png"></a>
					<br>
					Editar
				</div>
			</div>
-->
			<script>
				var CodInforme = '<?php echo $CodInforme; ?>';
				realizaProceso(CodInforme);
			</script>					
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>
			<span id="resultadoSubir"></span>
