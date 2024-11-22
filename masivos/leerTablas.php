<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

require_once('../PHPMailerByEndeos/config.php');
include_once("../conexionli.php");

if($dato->accion == 'cargarClientes'){
    $link=Conectarse();
    $outp = "";
    $SQL = "SELECT * FROM Clientes Where cFree != 'on' or Docencia != 'on' and Estado != 'off' Order By Cliente";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        $SQLContacto = "SELECT * FROM contactosCli Where Contacto != '' and Email != '' and RutCli = '".$rs['RutCli']."'";
        $bdc=$link->query($SQLContacto);
        while($rsc=mysqli_fetch_array($bdc)){
            $SQLMvo = "SELECT * FROM Masivos Where Email = '".$rsc['Email']."' and RutCli = '".$rs['RutCli']."'";
            $bdMv=$link->query($SQLMvo);
            if($rsMv=mysqli_fetch_array($bdMv)){

            }else{
                if ($outp != "") {$outp .= ",";}
                $outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 			'",';
                $outp .= '"Cliente":' 		        . json_encode($rs['Cliente'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
                $outp .= '"Contacto":' 		        . json_encode($rsc['Contacto'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
                $outp .= '"Email":"'. 				$rsc["Email"]. 			'"}';
            }

        }
    }
    $link->close();
    $outp ='{"records":['.$outp.']}';
    echo ($outp);
}

if($dato->accion == 'cargarMasivos'){
    $link=Conectarse();
    $outp = "";
    $SQL = "SELECT * FROM Masivos Order By Contacto";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 			'",';
        $outp .= '"Contacto":' 		        . json_encode($rs['Contacto'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp .= '"Email":"'. 				$rs["Email"]. 			'"}';
    }
    $link->close();
    $outp ='{"records":['.$outp.']}';
    echo ($outp);
}

if($dato->accion == 'enviarCorreo'){
    
    $mail->ClearAllRecipients( );
	$mail_destinatario = 'francisco.olivares.rodriguez@gmail.com';
	$msgCorreo  = 'Estimados: <br><br>';
	$msgCorreo .= '<strong>Prueba correos masivos....</strong><br><br>';
    
	$contacto = 'Cliente Apellido ';
    
	$mail->IsHTML(true);
    $mail->Subject = 'Información';
    $mail->AddAddress($mail_destinatario);
    //$mail->AddReplyTo($mail_copia, 'Fran');
    //$mail->AddBCC ("francisco.olivares.rodriguez@gmail.com");
    $mail->Body    = $msgCorreo;
    
	if($mail->Send()){
        $msgCorreo = 'Nos contactaremos a la brevedad con usted';
        echo "<script>alert('Su mensaje a sido enviado correctamente, nos comunicaremos pronto con usted...')</script>";
	}else{ 
        echo "<script>alert('Error...')</script>";
	}
    /*
    $mail->Subject = 'Laboratorio SIMET-USACH';
    $mail->AddAddress($mail_copia);
    $mail->Body    = $msgCorreo;
    $mail->Send();
*/




/*
    $email		= 'simet@usach.cl'; 
    $empresa    = 'SIMET-USACH ';
    $headers    = "MIME-Version: 1.0\n";
    $headers    .= "Content-Type: text/html; charset=iso-8859-1\n"; 
    $headers    .= "X-Priority: 3\n";
    $headers    .= "X-MSMail-Priority: Normal\n";
    $headers    .= "X-Mailer: php\n";
    $headers    .= "From: \"".$empresa."\" <".$email.">\n";
    $themessage = '<br> Estimados <br>'; 
    $themessage .= '<pre style="font-size:14; font-family:Geneva, Arial, Helvetica, sans-serif;">'.$dato->msg.'</pre><br>'; 

    $result=mail($dato->destinatario, "Información ", $themessage,$headers); 
*/
}

if($dato->accion == 'cargarDestinatarios'){
    $res            = '';
    $destinatarios  = '';
    $destinatarios = 'francisco.olivares.rodriguez@gmail.com, francisco.olivares@liceotecnologico.cl';
    $link=Conectarse();
    $SQL = "SELECT * FROM Masivos Order By Contacto";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($destinatarios != "") {$destinatarios .= ",";}
        $destinatarios .= $rs['Email'];
    }
    $link->close();

    $res.= '{"destinatarios":"'		.	$destinatarios.				'"}';
	echo $res;	
}

if($dato->accion == 'agregarContacto'){
    $link=Conectarse();
    $SQL   = "SELECT * FROM contactosCli Where Email = '$dato->Email' and RutCli = '$dato->RutCli'";
    $bd    = $link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $SQLMv   = "SELECT * FROM Masivos Where Email = '$dato->Email' and RutCli = '$dato->RutCli'";
        $bdMv    = $link->query($SQLMv);
        if($rsMv = mysqli_fetch_array($bdMv)){
        }else{
            $Contacto = $rs['Contacto'];
            $link->query("insert into Masivos ( RutCli          ,
                                                Contacto        ,
                                                Email
                                            ) 
                                values 		(	'$dato->RutCli' ,
                                                '$Contacto'     ,
                                                '$dato->Email'
            )");
        }
    }
    $link->close();
}

if($dato->accion == 'quitarContacto'){
    $link=Conectarse();
    $bdAct=$link->query("Delete From Masivos Where RutCli = '$dato->RutCli' and Email = '$dato->Email'");	
    $link->close();
}

if($dato->accion == 'borrarDestinatarios'){
    $link=Conectarse();
    $bdAct=$link->query("Delete From Masivos Where 1");	
    $link->close();
}

if($dato->accion == 'todosDestinatarios'){
    $link=Conectarse();
    $outp = "";
    $SQL = "SELECT * FROM Clientes Where cFree != 'on' or Docencia != 'on' and Estado != 'off' Order By Cliente";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        $SQLContacto = "SELECT * FROM contactosCli Where Contacto != '' and Email != '' and RutCli = '".$rs['RutCli']."'";
        $bdc=$link->query($SQLContacto);
        while($rsc=mysqli_fetch_array($bdc)){
            $RutCli     = $rs['RutCli'];
            $Contacto   = $rsc['Contacto'];
            $Email      = $rsc['Email'];
            $link->query("insert into Masivos ( RutCli          ,
                                                    Contacto        ,
                                                    Email
                                                ) 
                                    values 		(	'$RutCli' ,
                                                    '$Contacto'     ,
                                                    '$Email'
            )");
        }
    }
    $link->close();
}


?>