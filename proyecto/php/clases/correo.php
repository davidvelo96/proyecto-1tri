<?php
use PHPMailer\PHPMailer\PHPMailer;

include_once "../../vendor/autoload.php";

class mail
{

    public static function correo($usuario)
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();

        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;
        // introducir usuario de google
        $mail->Username   = "djvdaw@gmail.com";
        // introducir clave
        $mail->Password   = "David123daw.";
        $mail->SetFrom('djvdaw@gmail.com', 'Correo de activacion de usuario');
        // asunto
        $mail->Subject = "Correo de activacion de usuario";
        // cuerpo
        $mail->IsHTML(true);
        $mail->Body = "Pincha en el siguiente enlace para activar su usuario: <br> http://localhost/proyecto-1tri/proyecto/php/confirmarPasswd.php?confirma=" . $usuario;

        $address = "djimvel554@g.educaand.es";
        $mail->AddAddress($address, "Test");
        // enviar
        $resul = $mail->Send();
        if (!$resul) {
            echo "Error" . $mail->ErrorInfo;
        } else {
            echo " Correo enviado";
        }
    }
}
