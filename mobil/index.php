<!doctype html>
<html lang="es">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Simet</title>
	<link rel="stylesheet" href="themes/gris.min.css" />
  	<link rel="stylesheet" href="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
 
<body> 
<div data-role="page" data-theme="a" id="inicio">
	<div data-role="header" data-position="inline">
		<a href="http://erp.simet.cl/mobil" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">Inicio</a>
		<h1>Acceso Intranet Simet</h1>
	</div>
    
	<div data-role="content" data-theme="a">
			<form id="formulario" >
      			<?php echo $_SESSION['usr']; ?>
      			<label> Usuario </label>
      			<input type="text" id="nombredeusuario" name="nombredeusuario">
      
      			<label> Password </label>
     			<input type="password" id="clave" name="clave" >
 
      			<input type="submit" value="Login" id="botonLogin" data-icon="lock">
      
    		</form>		
			<div data-role="footer" data-position="fixed" data-theme="a">
   				<div data-role="navbar">
      				<ul>
         				<li><a href="http://www.udesantiago.cl/" data-icon="star" data-transition="flip">USACH</a></li>
	         			<li><a href="http://simet.cl/contactenos.php" data-icon="plus"> Contacto </a></li>
	         			<li><a href="http://simet.cl/verificacioninforme.php" data-icon="grid" title="Verificación de Informe">Verificación</a></li>
	      			</ul>
	   			</div> <!-- /navbar -->
			</div> <!-- /footer -->					
	</div>
	 
</div>
 
<div data-role="page" id="home">
 
	<div data-role="header" data-position="inline">
		<a href="http://erp.simet.cl/mobil" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">Inicio</a>
		<h1>ERP Simet</h1>
	</div>
 
	<div data-role="content">	
		<h2> Bienvenido a la aplicacion <?php echo $_SESSION['usr']; ?></h2>
		<h3> Su usuario y password son válidos</h3>
	</div>
 
</div>
 
<script>

$('#formulario').submit(function() { 
	
	 
	// recolecta los valores que inserto el usuario
	var datosUsuario = $("#nombredeusuario").val()
	var datosPassword = $("#clave").val()
	
  	archivoValidacion = "valLogin.php?jsoncallback=?"

	$.getJSON( archivoValidacion, { usuario:datosUsuario ,password:datosPassword})
	.done(function(respuestaServer) {
		
		if(respuestaServer.validacion == "ok"){
		  
		 	/// si la validacion es correcta, muestra la pantalla "home"
			//$.mobile.changePage("#home")
			$.mobile.changePage("quienes.php")
		  
		}else{
		  
		alert(respuestaServer.mensaje + "\nGenerado en: " + respuestaServer.hora + "\n" +respuestaServer.generador)
		
		  /// ejecutar una conducta cuando la validacion falla
		}
  
	})
	return false;
})
	
</script>
 
</body>
</html>