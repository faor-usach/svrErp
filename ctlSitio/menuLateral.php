<?php
	switch ($_SESSION['Perfil']) {
		case 'WebMaster':
		?>
			<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="/imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Men�
				</div>
				<ul>
					<li><a href="/ctlSitio" 						title="Inicio">			<img src="/imagenes/school_128.png" 		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
					<li><a href="/ctlSitio/cerrarsesion.php" 		title="Cerrar Sesi�n">	<img src="/imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesi�n</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="/imagenes/acreditacion.png"			style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Head
				</div>
				<ul>
					<li>
						<a href="/encuesta/plataformaEncuesta.php"	title="Head P�gina">			
							<img src="/imagenes/todo.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encabezado			
						</a>
					</li>
				</ul>
				
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="/imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="30px">				
					Body
				</div>
				<ul>
					<li><a href="/ctlSitio/links"	title="Links Sitio"><img src="/imagenes/icono-descargas.png" style="margin:2px;" align="absmiddle" width="30px"> Links		</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/talleres.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Footer
				</div>
				<ul>
					<li><a href="tallerPM/pTallerPM.php" title="Taller Ensayos Mec�nicos">	<img src="imagenes/probeta.png" style="margin:2px;" align="absmiddle" width="22px" height="22px"> Ensayos Mec�nicos	</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/settings_32.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Configuraci�n
				</div>
				<ul>
					<li><a href="datosEmpresa.php" 	 					title="Datos de la Instituci�n">	<img src="imagenes/of.png" 					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Instituci�n</a>	</li>
					<li><a href="docencia/plataformaFacturas.php"		title="M�dulo de Docencia">			<img src="imagenes/acreditacion.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Docencia			</a></li>
					<li><a href="proyectos/plataformaProyectos.php" 	title="Datos de los Proyectos">		<img src="imagenes/viewtimetables_48.png" 	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Proyectos	</a></li>
					<li><a href="tablaRangos.php" 	 					title="Rangos">						<img src="imagenes/indicadores.png" 		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Rango Metas		</a></li>
					<li><a href="usuarios/plataformaUsuarios.php" 		title="Usuarios">					<img src="imagenes/class_32.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Usuarios			</a></li>
					<li><a href="estadistica/estadisticas.php" 			title="Estad�stica">				<img src="imagenes/Mostrar.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Estad�sticas		</a></li>
				</ul>

			</div>
			<?php
			break;
}
?>