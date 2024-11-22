<!doctype html>
<html lang="es">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>grid-layout demo</title>
	<link rel="stylesheet" href="themes/gris.min.css" />
  	<link rel="stylesheet" href="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
 
<div data-role="page" id="inicio" data-theme="a">
	<div data-role="header" data-position="inline">
		<a href="http://erp.simet.cl/mobil" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">Inicio</a>
		<h1>ERP Simet</h1>
	</div>
	<div data-role="content" data-theme="a">
			<form id="formulario" >
      			<?php echo $_SESSION['usr']; ?>
      			<label> Usuario </label>
      			<input type="text" id="nombredeusuario" name="nombredeusuario">
      
      			<label> Password </label>
     			<input type="password" id="clave" name="clave" >
 
      			<input type="submit" value="Login" id="botonLogin" data-icon="lock" data-mini="true">
      
    		</form>		
			
			<a href="#" data-role="button" data-inline="true" data-theme="a">Tiene el mismo ancho del texto</a>

			<label for="slider">Slider Simple: </label>
			<input type="range" name="slider" id="slider" max="100" min="1" value="25" />
			
			<select name="slider" id="flip1" data-role="slider">
			   <option value="off">Off</option>
			   <option value="on">On</option>
			</select>

			<div data-role="collapsible">
				<h3>Elemento Collapsible simple</h3>
				<p>Este es el contenido del collapsible el cual podemos ocultar</p>
			</div>			
			
			
			<div data-role="footer" data-position="fixed" data-theme="e">
   				<div data-role="navbar">
      				<ul>
         				<li><a href="http://www.udesantiago.cl/" data-icon="star" data-transition="flip">USACH</a></li>
	         			<li><a href="http://simet.cl/contactenos.php" data-icon="plus"> Contacto </a></li>
	         			<li><a href="http://simet.cl/verificacioninforme.php" data-icon="grid" title="Verificación de Informe">Verificaci&oacute;n</a></li>
	      			</ul>
	   			</div> <!-- /navbar -->
			</div> <!-- /footer -->					
		
  </div>
</div>
 
</body>
</html>