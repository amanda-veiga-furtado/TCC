<?php
session_start();
ob_start();

// Verifica se existe uma mensagem no parâmetro da URL
if (isset($_GET['mensagem'])) {
    $mensagem = htmlspecialchars($_GET['mensagem']);
    echo "<script>alert('$mensagem');</script>";
}

include_once '../include_once.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login | Cadastro</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
        <script>
        // login.php (css)
        function showLogin() {
            document.getElementById('loginForm').style.display = 'block'; // Mostra o formulário de login -->
            document.getElementById('signupForm').style.display = 'none'; // Esconde o formulário de cadastro 
            document.getElementById('toggleLine').style.transform = 'translateX(0)'; // Move a linha indicadora para a posição do login
        }
        function showSignup() {
            document.getElementById('loginForm').style.display = 'none'; // Esconde o formulário de login -->
            document.getElementById('signupForm').style.display = 'block'; // Mostra o formulário de cadastro 
            document.getElementById('toggleLine').style.transform = 'translateX(100%)'; // Move a linha indicadora para a posição do cadastro
        }
    </script>
    <div class="container_background_image_medium">
        <div class="whitecard_form_type_1">
            <div class="container_form">
                <div class="form_switch">
                    <div class="form-toggle">
                        <button id="loginBtn" onclick="showLogin()">Calcular Quantidade</button> <!-- Exibir o formulário de login -->
                        <button id="signupBtn" onclick="showSignup()">Converter</button> <!-- Exibir form de cadastro -->

                        <div id="toggleLine" class="toggle-line-small"></div> <!-- Linha colorida de seleção atual -->
                    </div>

                    <!-- Login ----------------------------------------------------------------------->
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SendLogin'])) {
                        $email_usuario = $_POST['email_usuario'];
                        $senha_usuario = $_POST['senha_usuario'];

                        try {
                            $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha_usuario, statusAdministrador_usuario FROM usuario WHERE email_usuario = :email_usuario");

                            $stmt->bindParam(':email_usuario', $email_usuario);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                                // Adicionar logs para falhas de login
                                if ($usuario['statusAdministrador_usuario'] == 'b') {
                                    $_SESSION['mensagem'] = "Você foi suspenso pelo administrador!";
                                    error_log("Usuário suspenso tentou login: $email_usuario", 0);
                                } elseif (password_verify($senha_usuario, $usuario['senha_usuario'])) {
                                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                                    $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                                    $_SESSION['email_usuario'] = $email_usuario;
                                    $_SESSION['statusAdministrador_usuario'] = $usuario['statusAdministrador_usuario'];

                                    header("Location: dashboard.php");
                                    exit();
                                } else {
                                    $_SESSION['mensagem'] = "Senha incorreta!";
                                    error_log("Tentativa de login com senha incorreta: $email_usuario", 0);
                                }
                            } else {
                                $_SESSION['mensagem'] = "Usuário não encontrado!";
                                error_log("Tentativa de login com e-mail não cadastrado: $email_usuario", 0);
                            }
                        } catch (PDOException $e) {
                            $_SESSION['mensagem'] = "Erro ao verificar o usuário!";
                        }
                    }
                    ?>
                    <form id="loginForm" class="form" method="POST" action="" style="display: block;">
                        <h2>Bem-Vindo(a) de Volta!</h2>
                        <!-- <h2>Bem-Vindo(a) de Volta!</h2> -->
                        <!-- <h2>Bem-Vindo(a)! Faça login ou cadastre-se para acessar sua conta</h2> -->
                        <!-- <h2>Bem-Vindo(a)! Cadastre-se para criar sua conta ou faça login se já tiver uma</h2> -->
                        <!-- <h2>Bem-Vindo(a)! Faça login ou crie uma conta!</h2> -->


                        <input type="email" name="email_usuario" placeholder="Email" required>
                        <input type="password" name="senha_usuario" placeholder="Senha" required>
                        <div class="container-button-long">

                            <input type="submit" name="SendLogin" value="Entrar" class="button-long">
                        </div>
                    </form>

                    <!-- Cadastro ------------------------------------------------------------------------>


                    <form name="signupForm" id="signupForm" method="POST" action="" class="form" style="display: none;">
                        <!-- <h2>Cadastro</h2> -->
                        <input type="text" name="nome_usuario" id="nome_usuario" placeholder="Nome de Usuario" required>
                        <input type="email" name="email_usuario" id="email_usuario" placeholder="Email" required>
                        <input type="password" name="senha_usuario" id="senha_usuario" placeholder="Senha" required>

                        <div class="container-button-long">

                            <input type="submit" name="CadUsuario" value="Cadastrar" class="button-long">

                            <div class="div_link">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>