<?php
    session_start();
    ob_start();

    include_once '../../conexao.php'; 
    include '../../css/functions.php';
    include_once '../../menu.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Recuperar Senha</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container_form">
            <div class="whitecard_form">
                <div class="div_form">
                    <div class="form_switch">
                        <div class="form-toggle">
                            <button id="loginBtn" onclick="showLogin()">Recuperar Senha</button> <!-- Exibir o formulário de login -->

                            <div id="toggleLine" class="toggle-line-big"></div> <!-- Linha colorida de seleção atual -->
                    </div>
                    
                    <!-- Login --------------------------------------------------------------------------->
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SendLogin'])) {
                            $email_usuario = $_POST['email_usuario'];
                            $senha_usuario = $_POST['senha_usuario'];

                            try {
                                $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha_usuario FROM usuario WHERE email_usuario = :email_usuario");
                                $stmt->bindParam(':email_usuario', $email_usuario);
                                $stmt->execute();

                                if ($stmt->rowCount() > 0) {
                                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if (password_verify($senha_usuario, $usuario['senha_usuario'])) {
                                        $_SESSION['id_usuario'] = $usuario['id_usuario'];
                                        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                                        $_SESSION['email_usuario'] = $email_usuario;
                                        header("Location: dashboard.php");
                                        exit();
                                    } else {
                                        // $_SESSION['mensagem'] = "Senha incorreta!";
                                        $_SESSION['mensagem'] = "Login Invalido!";

                                    }
                                } else {
                                    // $_SESSION['mensagem'] = "Usuário não encontrado!";
                                    $_SESSION['mensagem'] = "Login Invalido!";

                                }
                            } catch (PDOException $e) {
                                $_SESSION['mensagem'] = "Erro ao verificar o usuário!";
                            }
                        }
                    ?>
                    <form id="loginForm" class="form" method="POST" action="" style="display: block;">
                        <h2>Recuperar Senha</h2>
                        <input type="email" name="email_usuario"  placeholder="Email" required>
                        <input type="password" name="senha_usuario" placeholder="Senha" required>

                        <input type="submit" name="SendLogin" value="Entrar" class="button-long">
                        
                        <!-- <div class="div_link"><a href="recuperar_senha/recuperar_senha.php">Recuperar Acesso</a></div> -->
                    </form>

                    <!-- Cadastro ------------------------------------------------------------------------>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['CadUsuario'])) {
                            $nome_usuario = $_POST['nome_usuario'];
                            $email_usuario = $_POST['email_usuario'];
                            $senha_usuario = $_POST['senha_usuario'];

                            $senha_hash = password_hash($senha_usuario, PASSWORD_DEFAULT);

                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE nome_usuario = :nome_usuario OR email_usuario = :email_usuario");
                                $stmt->bindParam(':nome_usuario', $nome_usuario);
                                $stmt->bindParam(':email_usuario', $email_usuario);
                                $stmt->execute();
                                $count = $stmt->fetchColumn();

                                if ($count > 0) {
                                    $_SESSION['mensagem'] = "Erro: Nome de usuário ou email já cadastrados!";
                                } else {
                                    $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario) VALUES (:nome_usuario, :email_usuario, :senha_usuario)");

                                    $stmt->bindParam(':nome_usuario', $nome_usuario);
                                    $stmt->bindParam(':email_usuario', $email_usuario);
                                    $stmt->bindParam(':senha_usuario', $senha_hash);
                                    $stmt->execute();

                                    $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
                                }
                            } catch (PDOException $e) {
                                $_SESSION['mensagem'] = "Erro: Usuário não cadastrado com sucesso!";
                            }

                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                    ?>


                </div>
                </div>
            </div>
        </div>

        <!-- Exibir a mensagem como alerta, caso exista -->
        <?php
            if (isset($_SESSION['mensagem'])) {
                echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
                unset($_SESSION['mensagem']);
            }
        ?>
    </body>
</html>
