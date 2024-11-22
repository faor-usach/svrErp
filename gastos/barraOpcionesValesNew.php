			<!-- Inicio Barra de Opciones -->
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft" align="center">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="plataformaintranet.php" title="Solicitudes de Rembolsos y Pago de Facturas">
						<img src="imagenes/room_48.png"></a>
					<br>
					Forms
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="registragastos.php" title="Registrar Gastos">
						<img src="../imagenes/group_48.png"></a>
					<br>
					Gastos
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="igastos.php" title="Registro de Gastos">
						<img src="imagenes/todo.png"></a>
					<br>
					Registro
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="proveedores.php" title="Proveedores">
						<img src="imagenes/contactus_128.png"></a>
					<br>
					Proveedores
				</div>
<!--				
				<div id="ImagenBarraLeft" align="center">
					<a href="eformularios.php" title="Imprimir Formularios">
						<img src="imagenes/printer_128_hot.png"></a>
					<br>
					Imprimir
				</div>
-->
				<div id="ImagenBarraLeft" align="center">
					<a href="eformulariosAjax.php" title="Imprimir Formularios Nueva Version">
						<img src="../imagenes/impressora.png"></a>
					<br>
					Imprimir
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="/gastos/ipdf.php" title="Formularios Emitidos">
						<img src="../imagenes/informes.png"></a>
					<br>
					Solicitudes
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="regVales.php" title="Registro de Vales">
						<img src="../imagenes/blank_128.png"></a>
					<br>
					Vales
				</div>
				<div id="ImagenBarraLeft" align="center">
					<a href="newVale.php" title="Registrar Vale">
						<img src="imagenes/AgregarVale.png"></a>
					<br>
					+ Vales
				</div>
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
