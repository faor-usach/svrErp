<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Emisi&oacute;n de Formularios</title>

<script>
    function open_factura(){
		window.open("F3B-00001.pdf");
	}
</script>
<script>
		open_factura();
</script>

</head>
<body>
<?php
$pdf = "F3B-00001.pdf";
echo '
	<input type="button" value="Abrir" onclick="open_factura()">
';
?>
</body>
</html>

