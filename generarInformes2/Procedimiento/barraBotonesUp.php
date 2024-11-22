<?php

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));

	
?>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../../plataformaErp.php" title="Menú Principal">
						<img src="../../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="../nominaInformes.php?CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $RAM; ?>"	>
						<img src="../../imagenes/actividades.png" 	width="50" title="Informes"	></a>
					<br>
					Informes
				</div>
				<div id="ImagenBarraLeft">
					<a href="../plataformaGenInf.php" title="PAMs">
						<img src="../../imagenes/Tablas.png"></a>
					<br>
					PAMs
				</div>
				<div id="ImagenBarraLeft">
					<a href="index.php?CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $RAM; ?>" title="Volver">
						<img src="../../imagenes/volver.png"></a>
					<br>
					Volver
				</div>
			</div>

