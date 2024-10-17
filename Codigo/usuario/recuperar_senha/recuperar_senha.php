<?php
    session_start();
    ob_start();

    include_once '../../conexao.php';
    include '../../css/functions.php';
    include_once '../../menu.php'; 

    require 'lib/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
</head>
<body>
<div class="container_background_type_1">
            <div class="whitecard_form_type_1">
                <div class="container_form">
                <div class="form_switch">
                        <div class="form-toggle">
                            <button id="loginBtn" onclick="showLogin()">Login</button> <!-- Exibir o formulário de login -->

                            <div id="toggleLine" class="toggle-line-big"></div> <!-- Linha colorida de seleção atual -->
                    </div>
                    <h1>Recuperar Senha</h1>
                    <?php
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                    if (!empty($dados['SendRecupSenha'])) {
                        // var_dump($dados);
                        $query_usuario = "SELECT id_usuario, nome_usuario, email_usuario 
                                        FROM usuario 
                                        WHERE email_usuario =:email_usuario 
                                        LIMIT 1";
                        $result_usuario = $conn->prepare($query_usuario);
                        $result_usuario->bindParam(':email_usuario', $dados['email_usuario'], PDO::PARAM_STR);
                        $result_usuario->execute();

                        if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
                            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                            $chave_recuperar_senha = password_hash($row_usuario['id_usuario'], PASSWORD_DEFAULT);
                            // echo "Chave $chave_recuperar_senha <br>";

                            $query_up_usuario = "UPDATE usuario 
                                                SET recuperar_senha =:recuperar_senha 
                                                WHERE id_usuario =:id_usuario
                                                LIMIT 1";
                            $result_up_usuario = $conn->prepare($query_up_usuario);
                            $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
                            $result_up_usuario->bindParam(':id_usuario', $row_usuario['id_usuario'], PDO::PARAM_INT);

                            if ($result_up_usuario->execute()) {
                                // echo "http://localhost/TCC/Codigo/usuario/recuperar_senha/atualizar_senha.php?chave=$chave_recuperar_senha";

                                $link = "http://localhost/TCC/Codigo/usuario/recuperar_senha/atualizar_senha.php?chave=$chave_recuperar_senha";

                                try {
                                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                $mail->CharSet = 'UTF-8';
                                $mail->isSMTP();
                                $mail->Host = 'sandbox.smtp.mailtrap.io';
                                $mail->SMTPAuth = true;
                                $mail->Username = '09e8f0f06b22a2';
                                $mail->Password = '********88ee';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port = 2525;

                                $mail->setFrom('atendimento@tcc.com', 'Atendimento');
                                $mail->addAddress($row_usuario['email_usuario'], $row_usuario['nome_usuario']);
                                $mail->isHTML(true);                              
                                $mail->Subject = 'Recuperar Senha';
                                $mail->Body    = 'Prezado(a) ' . $row_usuario['nome_usuario'] .".<br><br>Você solicitou alteração de senha.<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
                                $mail->AltBody = 'Prezado(a) ' . $row_usuario['nome_usuario'] ."\n\nVocê solicitou alteração de senha.\n\nPara continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";

                                $mail->send();

                                $_SESSION['msg'] = "<p style='color: green'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
                                    header("Location: ../login.php");
                                } catch (Exception $e) {
                                    echo "Erro: E-mail não enviado sucesso. Mailer Error: {$mail->ErrorInfo}";
                                }
                            } else {
                                echo  "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
                            }
                        } else {
                            echo "<p style='color: #ff0000'>Erro: Usuário não encontrado!</p>";
                        }
                    }
                    
                    if (isset($_SESSION['msg_rec'])) {
                        echo $_SESSION['msg_rec'];
                        unset($_SESSION['msg_rec']);
                    }

                    ?>

                    <form method="POST" action="">
                        <?php
                        $email_usuario = "";
                        if (isset($dados['email_usuario'])) {
                            $email_usuario = $dados['email_usuario'];
                            // var_dump($dados);
                        } ?>

                        <!-- <label>E-mail</label> -->
                        <input type="text" name="email_usuario" placeholder="Email" value="<?php echo $email_usuario; ?>"><br><br>

                        <input type="submit" value="Recuperar" name="SendRecupSenha">
                    </form>

                    <br>
                    Lembrou? <a href="../login.php">Clique Aqui</a> para Logar
                </div>
            </div>
        </div>
    </body>
</html>