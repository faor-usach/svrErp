<?php
	session_start(); 
	include_once("conexion.php");
	$idEnsayo = $_GET[idEnsayo];
?>
	<select name="tpMuestra" id="tpMuestra">
		<?php
			$link=Conectarse();
			$bdEns=mysql_query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'");
			if($rowEns=mysql_fetch_array($bdEns)){
				do{
					?>
						<option value="<?php echo $rowEns[tpMuestra];?>"><?php echo $rowEns[Muestra]; ?></option>
					<?php
				}while($rowEns=mysql_fetch_array($bdEns));
			} 
			mysql_close($link);
		?>
	</select>
