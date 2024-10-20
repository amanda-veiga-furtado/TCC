<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Celke - Enviar e-mail com PHPMailer</title>
    </head>
    <body>
        <?php
        session_start();
        ob_start();

        include_once '../../conexao.php';
        include '../../css/functions.php';
        include_once '../../menu.php'; 

        require './lib/vendor/autoload.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'a7bd0a58204e66';
            $mail->Password = '********403e';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 2525;

            $mail->setFrom('atendimento@tcc.com.br', 'Atendimento');
            $mail->addAddress('cesar@tcc.com.br', 'Cesar');
            
            $mail->isHTML(true);                                 
            $mail->Subject = 'Titulo do E-mail';
            $mail->Body = "Olá Cesar, Sua solicitação sobre o <b>curso de PHP Developer</b>.<br>Texto da segunda linha.";
            $mail->AltBody = "Olá Cesar, Sua solicitação sobre o curso de PHP Developer.\nTexto da segunda linha.";

            $mail->send();
            
            echo 'E-mail enviado com sucesso!<br>';
        } catch (Exception $e) {
            echo "Erro: E-mail não enviado com sucesso. Error PHPMailer: {$mail->ErrorInfo}";
            //echo "Erro: E-mail não enviado com sucesso.<br>";
        }
        ?>
    </body>
</html>
