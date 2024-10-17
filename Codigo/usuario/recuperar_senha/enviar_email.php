<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Enviar e-mail com PHPMailer</title>
        </head>
        <body>
            <?php
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\SMTP;
                use PHPMailer\PHPMailer\Exception;

                require './lib/vendor/autoload.php';

                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();
                    $mail->Host = 'sandbox.smtp.mailtrap.io';
                    $mail->SMTPAuth = true;
                    $mail->Username = '935334b66d283a';
                    $mail->Password = '********96c0';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 2525;


                    $mail->setFrom('atendimento@tcc.com.br', 'Atendimento');
                    $mail->addAddress('cesar@tcc.com.br', 'Cesar');
                    
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Titulo do E-mail';
                    $mail->Body = "Corpo do E-mail";
                    $mail->AltBody = "Corpo do E-mail ( Texto alternativo para clientes que não suportam HTML)";

                    $mail->send();
                    
                    echo 'E-mail enviado com sucesso!<br>';
                } catch (Exception $e) {
                    echo "Erro: E-mail não enviado com sucesso. Error PHPMailer: {$mail->ErrorInfo}";
                    echo "Erro: E-mail não enviado com sucesso.<br>";
                }
            ?>
        </body>
    </html>
