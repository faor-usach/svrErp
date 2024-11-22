
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="../touch-icon-iphone.png" />
		<link rel="apple-touch-icon" href="../touch-icon-ipad.png" />
		<link rel="apple-touch-icon" href="../touch-icon-iphone4.png" />
		<title>Simet</title>
		<link rel="stylesheet" href="themes/gris.min.css" />

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  		
	</head>
	<body>
		<div data-role="page" data-theme="a" id="inicio">
			<div data-role="header" data-position="inline">
				<a href="index.php" data-role="button" data-icon="arrow-l" data-iconpos="notext" class="ui-btn-left">Volver</a>
				<h1>Simet</h1>
				<a href="index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">Inicio</a>
			</div>
			<div data-role="content" data-theme="a">
			
				<ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
					<li data-role="list-divider">Menú Principal</li>
					<li><a href="quienes.htm" data-transition="pop" >Quienes Somos</a></li>
					<li><a href="#coche" >Servicios</a></li>
					<li><a href="#avion" >Clientes</a></li>
					<li><a href="#avion" >Contacto</a></li>
					<li><a href="#avion" >Ubicación</a></li>			
					<li><a href="#avion" >Sugerencias</a></li>			
				</ul>
			</div>
			<div data-role="footer" data-position="fixed" data-theme="b">
   				<div data-role="navbar">
      				<ul>
         				<li><a href="http://erp.simet.cl/mobil/" 				data-icon="lock" data-transition="flip">Cerrar</a></li>
	         			<li><a href="http://simet.cl/contactenos.php" 			data-icon="plus"> Contacto </a></li>
	         			<li><a href="http://simet.cl/verificacioninforme.php" 	data-icon="grid" title="Verificación de Informe">Verificación</a></li>
	      			</ul>
	   			</div> <!-- /navbar -->
			</div> <!-- /footer -->					
		</div>
		
	</body>
</html>