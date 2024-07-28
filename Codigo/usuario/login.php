<?php
    include_once '../menu.php'; 
    include_once '../conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Login | Cadastro</title>
    <meta charset="UTF-8">
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
                <form id="loginForm" class="form" style="display: block;">
                    <h2>Login</h2> <!-- Título do formulário de login -->
                    <input type="text" placeholder="Email" required> <!-- Campo de entrada para email -->
                    <input type="password" placeholder="Senha" required> <!-- Campo de entrada para senha -->
                    <button type="submit">Entrar</button> <!-- Botão para enviar o formulário de login -->
                    <div class="div_link"><a href="">Recuperar Acesso</a></div>
                </form>
                <form id="signupForm" class="form" style="display: none;">
                    <h2>Cadastro</h2> <!-- Título do formulário de cadastro -->
                    <input type="text" placeholder="Nome de Usuario" required> <!-- Campo de entrada para nome de usuário -->
                    <input type="email" placeholder="Email" required> <!-- Campo de entrada para email -->
                    <input type="password" placeholder="Senha" required> <!-- Campo de entrada para senha -->
                    <button type="submit">Cadastrar</button> <!-- Botão para enviar o formulário de cadastro -->
                </form>
            </div>
        </div>
    </div>

    </body>
</html>