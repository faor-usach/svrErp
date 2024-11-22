		<?php 
			$accion = '';
			if(isset($_GET['accion'])) 	{ $accion = $_GET['accion']; }
			if(isset($_POST['accion'])) { $accion = $_POST['accion'];}

			if(isset($_POST['imagenesLinks'])) { 
				$accion = 'imagenes';
			}
			echo $accion;
		?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="20%" valign="top">
					<?php include_once('../menuLateral.php'); ?>
				</td>
				<td width="80%" valign="top">
					<?php 
						if($accion == ''){
							include_once('muestraLinks.php'); 
						}
						if($accion == 'Actualizar' or $accion == 'Eliminar'){
							include_once('datosLinks.php'); 
						}
						if($accion == 'imagenes'){
							include_once('imgsLinks.php'); 
						}
					?>
				</td>
			</tr>
		</table>
