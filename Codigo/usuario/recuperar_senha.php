<?php
    include_once '../menu.php'; 
    include_once '../conexao.php'; 
    session_start(); // Inicia a sessão
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Recuperar Senha</title>
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

                        <div id="toggleLine" class="toggle-line"></div> <!-- Linha colorida para indicar a seleção atual -->
                        <div id="toggleLine" class="toggle-line"></div> <!-- Linha colorida para indicar a seleção atual -->

                    </div>
                    
                    <!-- Login ------------------------------------------------------------------------------------------------------------------------->

                                    
                    <form id="loginForm" class="form" method="POST" action="" style="display: block;">
                        <h2>Login</h2> <!-- Título do formulário de login -->
                        <input type="email" name="email_usuario"  placeholder="Email" required> <!-- Campo de entrada para email -->

                        <button type="submit" name="SendLogin">Entrar</button> <!-- Botão para enviar o formulário de login -->
                        
                        <div class="div_link"><a href="login.php">Fazer Login</a></div>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>
