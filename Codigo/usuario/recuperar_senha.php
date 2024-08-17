<?php
    include_once '../menu.php'; 
    include_once '../conexao.php'; 
    session_start(); // Inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login | Cadastro</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <script src="../css/myscripts.js"></script>
    </head>
    <body>
        <div class="container_form">
            <div class="whitecard_form">
                <div class="container_login">
                    <div class="form-toggle">
                        <button id="loginBtn" onclick="showLogin()">Recuperar Senha</button> <!-- Botão para exibir o formulário de login -->

                        <div id="toggleLine" class="toggle-line"></div> <!-- Linha colorida para indicar a seleção atual -->
                    </div>
                    
                    <!-- Login ------------------------------------------------------------------------------------------------------------------------->
                    <?php
                        // Verifica se o formulário de login foi enviado
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SendLogin'])) {
                            $email_usuario = $_POST['email_usuario'];
                            $senha_usuario = $_POST['senha_usuario'];

                            try {
                                // Prepara a consulta SQL para selecionar o usuário
                                $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha_usuario FROM usuario WHERE email_usuario = :email_usuario");
                                $stmt->bindParam(':email_usuario', $email_usuario);
                                $stmt->execute();

                                // Verifica se o usuário foi encontrado
                                if ($stmt->rowCount() > 0) {
                                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                                    // Verifica a senha
                                    if (password_verify($senha_usuario, $usuario['senha_usuario'])) {
                                        // Define variáveis de sessão
                                        $_SESSION['id_usuario'] = $usuario['id_usuario'];
                                        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                                        $_SESSION['email_usuario'] = $email_usuario;
                                        header("Location: dashboard.php"); // Redireciona para a página de dashboard
                                        exit();
                                    } else {
                                        $_SESSION['mensagem'] = "Senha incorreta!";
                                    }
                                } else {
                                    $_SESSION['mensagem'] = "Usuário não encontrado!";
                                }
                            } catch (PDOException $e) {
                                $_SESSION['mensagem'] = "Erro ao verificar o usuário!";
                            }
                        }
                        // Exibe a mensagem de erro, se existir
                        if (isset($_SESSION['mensagem'])) {
                            echo "<p>" . $_SESSION['mensagem'] . "</p>";
                            unset($_SESSION['mensagem']); // Limpa a mensagem da sessão
                        }
                    ?>
                                    
                    <form id="loginForm" class="form" method="POST" action="" style="display: block;">
                        <h2>Login</h2> <!-- Título do formulário de login -->
                        <input type="email" name="email_usuario"  placeholder="Email" required> <!-- Campo de entrada para email -->
                        <input type="password" name="senha_usuario" placeholder="Senha" required> <!-- Campo de entrada para senha -->

                        <input type="submit" name="SendLogin" value="Entrar" class="botao-enviar"> <!-- Botão para enviar o formulário de login -->
                        
                        <div class="div_link"><a href="recuperar_senha.php">Recuperar Acesso</a></div>
                    </form>

                    <!-- Cadastro ---------------------------------------------------------------------------------------------------------------------->
                    <?php
                        // Verifica se o formulário foi enviado
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['CadUsuario'])) {
                            // Obtém os dados do formulário
                            $nome_usuario = $_POST['nome_usuario'];
                            $email_usuario = $_POST['email_usuario'];
                            $senha_usuario = $_POST['senha_usuario'];

                            // Hash da senha para armazenamento seguro
                            $senha_hash = password_hash($senha_usuario, PASSWORD_DEFAULT);

                            try {
                                // Prepara a consulta SQL para inserção
                                $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario) VALUES (:nome_usuario, :email_usuario, :senha_usuario)");

                                // Vincula os parâmetros e executa a consulta
                                $stmt->bindParam(':nome_usuario', $nome_usuario);
                                $stmt->bindParam(':email_usuario', $email_usuario);
                                $stmt->bindParam(':senha_usuario', $senha_hash);
                                $stmt->execute();

                                // Mensagem de sucesso
                                $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
                            } catch (PDOException $e) {
                                // Mensagem de erro
                                $_SESSION['mensagem'] = "Erro: Usuário não cadastrado com sucesso!";
                            }
                            
                            // Redireciona para a mesma página para limpar o formulário
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
