			<!-- Inicio Barra de Opciones -->
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft" align="center">
					<a href="../plataformaErp.php" title="Men� Principal">
						<img src="../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="../vales" title="Registro de Vales">
						<img src="../imagenes/vales.png"></a>
					<br>
					Vales
				</div>
<!--
				<div id="ImagenBarraLeft" align="center">
					<a href="newVale.php?accion=Agregar" title="Registrar Vale">
						<img src="../imagenes/valeNegro.png"></a>
					<br>
					+ Vales
				</div>
-->				
				<?php if($accion == 'Borrar'){?>
					<div id="ImagenBarraLeft" align="center">
						<button name="Borrar">
							<img src="../imagenes/inspektion.png"></a>
						</button>
						<br>
						Borrar
					</div>
				<?php }else{ ?>
					<div id="ImagenBarraLeft" align="center">
						<button name="guardar">
							<img src="../imagenes/guardar.png"></a>
						</button>
						<br>
						Guardar
					</div>
				<?php } ?>
			</div>
			<!-- Fin Barra de Opciones -->
