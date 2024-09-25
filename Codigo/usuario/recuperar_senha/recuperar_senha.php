<?php
    session_start(); // Inicia a sessão

    include_once '../conexao.php'; 
    include '../css/functions.php';
    include_once '../menu.php'; 
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

                        <button id="loginBtn" onclick="showLogin()">Recuperar Senha</button> <!-- Exibir o formulário de login -->

                        <div id="toggleLine" class="toggle-line2"></div> <!-- Linha colorida de seleção atual -->

                    </div>
                    
                                   
                    <form id="loginForm" class="form" method="POST" action="" style="display: block;">
                        <h2>Recuperar Senha</h2> <!-- Título do formulário de login -->
                        <input type="email" name="email_usuario"  placeholder="Email" required> <!-- Campo de entrada para email -->

                        <input type="submit" name="SendLogin" value="Entrar" class="botao-enviar"> <!-- Botão para enviar o formulário de login -->
                        
                        <!-- <div class="div_link"><a href="recuperar_senha.php">Recuperar Acesso</a></div> -->
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
