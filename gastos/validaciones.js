function valida_envia(){ 

	if (document.fichapostulacion.NomPos.value.length==0){
      	 alert("Tiene que escribir su nombre");
      	 document.fichapostulacion.NomPos.focus(); 
      	 return 0; 
   	} 

   	if (document.fichapostulacion.ApPatPos.value.length==0){ 
      	 alert("Tiene que escribir su Apellido");
      	 document.fichapostulacion.ApPatPos.focus(); 
      	 return 0; 
   	} 

   	if (document.fichapostulacion.ApMatPos.value.length==0){ 
      	 alert("Tiene que escribir su Apellido");
      	 document.fichapostulacion.ApMatPos.focus(); 
      	 return 0; 
   	} 

   	//valido la edad. tiene que ser entero mayor que 18 
   
    //edad = document.fvalida.edad.value 
   	//edad = validarEntero(edad) 
	//document.fvalida.edad.value=edad 

   	if (document.fichapostulacion.fNaPos.value.length==0){ 
	// if (fNaPos==""){ 
      	 alert("Tiene que introducir una fecha valida.");
      	 document.fichapostulacion.fNaPos.focus();
      	 return 0; 
   	} 

   	//el formulario se envia 
   	// alert("Muchas gracias por enviar el formulario"); 
   	// document.fichapostulacion.submit(); 
} 

function valida_run(){ 
	var run, f, s, i, r, sw;
   	if (document.formulario.Rut.value.length==10){
		sw="NO";
      	run=document.formulario.Rut.value;
		f="32765432";
		s=0;
		for (i=0;i<8;i++){
			s=s+(parseInt(run.substring(i,i+1))*parseInt(f.substring(i,i+1)));
		}
		r = 11 - ( s % 11 )
		if ((run.substring(9,10)=='k' || run.substring(9,10)=='K') && (r==10)) {
			sw="OK";
		} else { 
			if ((run.substring(9,10)=='0') && (r==11)) {
			sw="OK";
			} else { 
				if (parseInt(run.substring(9,10))==r){
					sw="OK";
				}
			}
		}
		if (sw=="NO"){
			alert("RUN Invalido...");
      		document.formulario.Rut.focus();
		}
      	return 0; 
   	}else{
   		if ((document.formulario.Rut.value.length > 0) && (document.formulario.Rut.value.length < 10)){
      		alert("Debe escribir un Run Valido SIN PUNTOS Ej. 99999999-X");
      	 	document.formulario.Rut.focus(); 
      	 	return 0; 
		}
	}
} 

function val_rut(x){ 
	var run, f, s, i, r, sw;
   	if (x.length==10){
		
		sw="NO";
      	run=x;
		f="32765432";
		s=0;
		for (i=0;i<8;i++){
			s=s+(parseInt(run.substring(i,i+1))*parseInt(f.substring(i,i+1)));
		}
		r = 11 - ( s % 11 )
		if ((run.substring(9,10)=='k' || run.substring(9,10)=='K') && (r==10)) {
			sw="OK";
		} else { 
			if ((run.substring(9,10)=='0') && (r==11)) {
			sw="OK";
			} else { 
				if (parseInt(run.substring(9,10))==r){
					sw="OK";
				}
			}
		}
		if (sw=="NO"){
      		return sw;
		}
      	return 0; 
   	}else{
   		if ((x.length==10 > 0) && (x.length==10 < 10)){
      	 	return sw; 
		}
	}
} 

function inicioformulario(){ 
	document.form.ProveedorB.focus();
	return;
}

function inicioformpost(){ 
	document.fichapostulacion.NomPos.focus();
	return;
}

function TelcaPulsada() {  
  
   if ( window.event != null)               //IE4+  
      tecla = window.event.keyCode;  
   else if ( e != null )                //N4+ o W3C compatibles  
      tecla = e.which;  
   else  
      return;  
      
   alert('Tecla: '+tecla);
}  

// Funciones
function reSize(){
	try{
		var oBody = ifrm.document.body;
		var oFrame = document.all("ifrm");
		if (window.innerHeight){ 
			oFrame.style.height = oBody.scrollHeight + (oBody.offsetHeight - oBody.innerHeight);
			oFrame.style.width = oBody.scrollWidth + (oBody.offsetWidth - oBody.clientWidth);
		} else {
			oFrame.style.height = oBody.scrollHeight + (oBody.offsetHeight - oBody.clientHeight);
			oFrame.style.width = oBody.scrollWidth + (oBody.offsetWidth - oBody.clientWidth);
		}
	}

	//An error is raised if the IFrame domain != its container's domain
	catch(e){
		window.status = 'Error: ' + e.number + '; ' + e.description;
		}
}

<!-- fin de funcion para cambiear los tamanhos del frame -->

