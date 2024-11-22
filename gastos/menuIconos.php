			<div class="row bg-danger text-white p-2">
				<div class="col-sm-12">
					<a href="plataformaintranet.php" title="Principal">
						<img src="imagenes/room_48.png" width="32" height="32" style="padding:5px;" align="middle"></a>
						
					<?php echo '<span style="font-size:24px; color:#FFFFFF;">'.$nomModulo.'</span>'; ?>
					<div id="ImagenBarra">
						<a href="cerrarsesion.php" title="Cerrar Sesión">
							<img src="imagenes/preview_exit_32.png" width="32" height="32">
						</a>
					</div>
					<?php
					if(isset($_GET['Estado'])){ 	$Estado 	= $_GET['Estado']; 	}else{ $Estado 	= "N"; 	}
					?>
				</div>
				
				
			</div>
