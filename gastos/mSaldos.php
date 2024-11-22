<?php
echo '<div id="Saldos">';
		$link=Conectarse();
		$bdCh=$link->query("SELECT * FROM Recursos Where IdRecurso = '1'");
		if ($rowCh=mysqli_fetch_array($bdCh)){
			echo 'Saldo $ '.number_format($rowCh['Saldo'], 0, ',', '.');
		}
		$link->close();
echo '</div>';
?>
