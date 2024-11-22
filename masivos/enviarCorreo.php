<?php
    require_once('../PHPMailerByEndeos/config.php');

    $destinatarios  = '';
    $msg            = '';
	if(isset($_GET['destinatarios']))   { $destinatarios  	= $_GET['destinatarios']; 	}
	if(isset($_GET['msg']))             { $msg  	        = $_GET['msg']; 	        }
    
    $mail->ClearAllRecipients( );

    $mail_destinatario = $destinatarios;
    //$mail_destinatario = 'francisco.olivares@liceotecnologico.cl,francisco.olivares.rodriguez@gmail.com,administrador@liceotecnologico.cl,galerias@liceotecnologico.cl,francisco.olivares.r@usach.cl';
    $msgCorreo  = 'Estimados: <br><br>';
    $msgCorreo .= '<strong>'.$msg.'</strong><br><br>';
    $msgCorreo .= 'Attn.: <strong>SIMET-USACH</strong><br>';
    $msgCorreo .= 'simet@usach.cl <br>';
    $msgCorreo .= 'Fono: (56-2)23234780 - (56-2)27183221<br>';

    $cabeceras  = "MIME-Version: 1.0\n";
    $cabeceras .= "Content-Type: text/html; charset=iso-8859-1\n";
    $cabeceras .= "X-Priority: 3\n";
    $cabeceras .= "X-MSMail-Priority: Normal\n";
    $cabeceras .= "X-Mailer: php\n";
    $contacto = 'COMUNICADO SIMET-USACH';
    $cabeceras .= "From: \"".$contacto."\" <simet@usach.cl>\n";
    //$cabeceras .= "From: \"".$_POST['nombre']."\" <".$_POST['email'].">\n";
    //$cabeceras .= "Bcc: francisco.olivares.rodriguez@gmail.com \r\n"; 

    $titulo = 'COMUNICADO INTERNO';

    $mail->IsHTML(true);
    $mail->Subject = $contacto;
    //$mail->AddAddress('francisco.olivares@liceotecnologico.cl', 'francisco.olivares.rodriguez@gmail.com');

    $fd = explode(',',$mail_destinatario);
    foreach ($fd as $valor) {
        //echo $valor.'<br>';
        $mail->AddAddress($valor);
    }

    //$mail->AddReplyTo('alfredo.artigas@usach.cl','Alfredo Artigas');
    //$mail->AddBCC("alfredo.artigas@usach.cl");
    $mail->AddBCC ("francisco.olivares.r@usach.cl");
    $mail->AddBCC ("francisco.olivares.rodriguez@gmail.com");
    //$mail->AddBCC ("alfredo.artigas@usach.cl");
    $mail->Body    = $msgCorreo;

    if($mail->Send()){
        echo "<script>alert('Su mensaje a sido enviado correctamente, nos comunicaremos pronto con usted...')</script>";
        echo "<script>location.href='https://erp.simet.cl/masivos/plataformaMasivos.php';</script>";
    }else{ 
        echo "<script>alert('Error...')</script>";
        $msg = "Error...";
    }


/*
*/
    //echo $destinatarios.'<br>';
    echo $msg.'<br>';
?>