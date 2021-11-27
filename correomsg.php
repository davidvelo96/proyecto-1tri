<?php   
    use PHPMailer\PHPMailer\PHPMailer;
    require "vendor/autoload.php";
    
    $mail = new PHPMailer();
    $mail->IsSMTP();

    // cambiar a 0 para no ver mensajes de error
    $mail->SMTPDebug  = 2;                          
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "tls";                 
    $mail->Host       = "smtp.gmail.com";    
    $mail->Port       = 587;                 
    // introducir usuario de google
    $mail->Username   = "djvdaw@gmail.com"; 
    // introducir clave
    $mail->Password   = "David123daw.";       
    $mail->SetFrom('djvdaw@gmail.com', 'Correo de prueba');
    // asunto
    $mail->Subject    = "Correo con imagen";
    // cuerpo
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage("img.png","imagen","file/imagen.jpg","base64");
    $mail->Body = file_get_contents("prueba.html");
    
    // $mail->MsgHTML('Prueba.html');
    // adjuntos
    // $mail->addAttachment("adjunto.txt");

    // destinatario
    // $address = "jve@ieslasfuentezuelas.com";
    $address = "djimvel554@g.educaand.es";

    $mail->AddAddress($address, "Test");
    // enviar
    $resul = $mail->Send();
    if(!$resul) {
      echo "Error" . $mail->ErrorInfo;
    } else {
      echo "Enviado";
    }