			<div id="BarraFiltro">
				<img src="imagenes/data_filter_128.png" width="28" height="28">

					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){ 		$Items 		= $_GET['Items'];	}else{ $Items 	= "Gastos"; 		}
							if(isset($_GET['Recurso'])){ 	$Recurso 	= $_GET['Recurso']; }else{ $Recurso = "Recursos"; 		}

							$Proyecto = "Proyectos";
							if(isset($_GET['Proyecto'])){
								$Proyecto = $_GET['Proyecto'];
								echo "<option selected value='plataformaintranet.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."'>".$Proyecto."</option>";
							}else{
								echo "<option selected value='plataformaintranet.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."'>".$Proyecto."</option>";
							}
							echo "<option value='plataformaintranet.php?Proyecto=Proyectos&Items=".$Items."&Recurso=".$Recurso."'>Proyectos</option>";
							$link=Conectarse();
							$bdPr=mysql_query("SELECT * FROM Proyectos");
							if ($row=mysql_fetch_array($bdPr)){
								DO{
			    					echo "	<option value='plataformaintranet.php?Proyecto=".$row['IdProyecto']."&Items=".$Items."&Recurso=".$Recurso."'>".$row['IdProyecto']."</option>";
								}WHILE ($row=mysql_fetch_array($bdPr));
							}
							mysql_close($link);
						?>
					</select>

					<!-- Fitra por Tipo de Gasto -->
	  				<select name="TpGasto" id="TpGasto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){
								$Items = $_GET['Items'];
								echo "<option selected value='plataformaintranet.php?Items=".$Items."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$Items."</option>";
							}else{
								echo "<option selected value='plataformaintranet.php?Items=".$Items."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$Items."</option>";
							}
							echo "<option value='plataformaintranet.php?Items=Gastos&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>Gastos</option>";
							$link=Conectarse();
							$bdIt=mysql_query("SELECT * FROM ItemsGastos Order By Items");
							if ($row=mysql_fetch_array($bdIt)){
								DO{
			    					echo "	<option value='plataformaintranet.php?Items=".$row['Items']."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$row['Items']."</option>";
								}WHILE ($row=mysql_fetch_array($bdIt));
							}
							mysql_close($link);
						?>
					</select>
					<!-- Fin Filtro -->

					<!-- Fitra por Recurso -->
	  				<select name="TpGasto" id="TpGasto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$Recurso = "Recursos";
							if(isset($_GET['Recurso'])){
								$Recurso = $_GET['Recurso'];
								echo "<option selected value='plataformaintranet.php?Recurso=".$Recurso."&Proyecto=".$Proyecto."&Items=".$Items."'>".$Recurso."</option>";
							}else{
								echo "<option selected value='plataformaintranet.php?Recurso=".$Recurso."&Proyecto=".$Proyecto."&Items=".$Items."'>".$Recurso."</option>";
							}
							echo "<option value='plataformaintranet.php?Recurso=Recursos&Proyecto=".$Proyecto."&Items=".$Items."'>Recursos</option>";
							$link=Conectarse();
							$bdRec=mysql_query("SELECT * FROM Recursos");
							if ($row=mysql_fetch_array($bdRec)){
								DO{
			    					echo "	<option value='plataformaintranet.php?Recurso=".$row['Recurso']."&Proyecto=".$Proyecto."&Items=".$Items."'>".$row['Recurso']."</option>";
								}WHILE ($row=mysql_fetch_array($bdRec));
							}
							mysql_close($link);
						?>
					</select>
					<!-- Fin Filtro -->

					<!-- Fitra por Historico -->
	  					<select name='Estado' id='Estado' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php 
							if($Estado=='N'){
								echo "	<option selected 	value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=N'>No Informados	</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=I'>Informados		</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=T'>Todos			</option>";
							}
							if($Estado=='I'){
								echo "	<option selected 	value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=I'>Informados		</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=N'>No Informados	</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=T'>Todos			</option>";
							}
							if($Estado=='T'){
								echo "	<option selected 	value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=T'>Todos			</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=N'>No Informados	</option>";
								echo "	<option 			value='plataformaintranet.php?Recurso=$Recurso&Proyecto=$Proyecto&Items=$Items&Estado=I'>Informados		</option>";
							}
							?>
						</select>
					<!-- Fin Filtro -->


			</div>
