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
                    <button id="loginBtn" onclick="showLogin()">Login</button> <!-- Botão para exibir o formulário de login -->
                    <button id="signupBtn" onclick="showSignup()">Cadastro</button> <!-- Botão para exibir o formulário de cadastro -->
                    <div id="toggleLine" class="toggle-line"></div> <!-- Linha colorida para indicar a seleção atual -->
                </div>
                
                <!-- Login -->
                <form id="loginForm" class="form" style="display: block;">
                    <h2>Login</h2> <!-- Título do formulário de login -->
                    <input type="text" placeholder="Email" required> <!-- Campo de entrada para email -->
                    <input type="password" placeholder="Senha" required> <!-- Campo de entrada para senha -->
                    <button type="submit">Entrar</button> <!-- Botão para enviar o formulário de login -->
                    <div class="div_link"><a href="">Recuperar Acesso</a></div>
                </form>

                <!-- Cadastro -->
                <?php
                    // Verifica se o formulário foi enviado
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['CadUsuario'])) {
                        // Obtém os dados do formulário
                        $nome_usuario = $_POST['nome_usuario'];
                        $email_usuario = $_POST['email_usuario'];
                        $senha_usuario = $_POST['senha_usuario'];

                        // Hash da senha para armazenamento seguro
                        $senha_hash = password_hash($senha_usuario, PASSWORD_BCRYPT);

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

                <?php
                    // Exibe a mensagem de sucesso ou erro, se existir
                    if (isset($_SESSION['mensagem'])) {
                        echo "<p>" . $_SESSION['mensagem'] . "</p>";
                        unset($_SESSION['mensagem']); // Limpa a mensagem da sessão
                    }
                ?>

                <form name="signupForm" id="signupForm" method="POST" action="" class="form" style="display: none;">
                    <h2>Cadastro</h2> <!-- Título do formulário de cadastro -->
                    <input type="text" name="nome_usuario" id="nome_usuario" placeholder="Nome de Usuario" required> <!-- Campo de entrada para nome de usuário -->
                    <input type="email" name="email_usuario" id="email_usuario" placeholder="Email" required> <!-- Campo de entrada para email -->
                    <input type="password" name="senha_usuario" id="senha_usuario" placeholder="Senha" required> <!-- Campo de entrada para senha -->
                    <button type="submit" name="CadUsuario">Cadastrar</button> <!-- Botão para enviar o formulário de cadastro -->
                </form>
            </div>
        </div>
    </div>
</body>
</html>
