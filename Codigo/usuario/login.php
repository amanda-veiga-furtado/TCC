<!DOCTYPE html>
<html lang="pt-br"> <!-- Declaração do tipo de documento e o idioma da página -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define o comportamento da página em diferentes tamanhos de tela -->
    <title>Document</title> <!-- Define o título da página -->
    <style>
* {
    padding: 0; /* Remove o padding padrão de todos os elementos */
    margin: 0; /* Remove a margem padrão de todos os elementos */
    box-sizing: border-box; /* Inclui padding e border na largura e altura total dos elementos */
}

/* menu.php */

nav {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    font-family: Hack, monospace;
    width: 100%;
    margin: 0px;
    background: #f9f9f9;
    padding: 0px;
}

.menuItems {
    list-style: none;
    display: flex;
    justify-content: center;
}

.menuItems li {
    display: flex; /* Adiciona flexbox ao li */
    align-items: center; /* Centraliza verticalmente os itens */
    margin: 30px;
    position: relative;
    text-align: center;
}

.menuItems a {
    text-decoration: none;
    color: #8f8f8f;
    font-size: 24px;
    font-weight: 400;
    text-transform: uppercase;
    position: relative;
}

.menuItems a::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 3px;
    bottom: -6px;
    background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);
    visibility: hidden;
    transform: scaleX(0);
    transition: transform 0.3s ease, visibility 0s linear 0.3s;
}

.menuItems a:hover::before {
    visibility: visible;
    transform: scaleX(1);
    transition: transform 0.3s ease, visibility 0s linear;
}

/* sugestao.php */
.container_sugestao {
    width: 100vw;
    height: 85.3vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-size: cover;
    background-position: center;
    background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);

}

.container {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 710px;
    height: 410px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 25px 30px 55px #5557;
    border-radius: 13px;
    overflow: hidden;
}

.form-container {
    position: relative;
    width: 100%;
}

.form-toggle {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    width: 100%;
    position: relative;
    
}

.form-toggle button {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    padding: 10px 20px;
    color: #888;
    transition: color 0.3s;
    flex-grow: 1;
    text-align: center;
        /* font-family: Hack, monospace; */

}

.form-toggle button:hover,
.form-toggle button:focus {
    color: #333;
}

.toggle-line {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50%;
    height: 3px;
    background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);
    transition: transform 0.3s;
}

.form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.form h2 {
    margin-bottom: 15px;
    color: #333;
    font-size: 24px;
}

.form input {
    margin-bottom: 15px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    width: 100%;
    box-sizing: border-box;
}

.form input:focus {
    border-color: #36cedc;
    outline: none;
}

.form button {
    padding: 12px;
    border: none;
    border-radius: 8px;
    background-color: #a587ca;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
}

.form button:hover {
    background-color: #8c6db6;
}

.div_link{
    margin-top: 0.3cm;
    text-align: center;

}
a {
    color: #8c6db6;
    text-decoration: none;
}

a.forgot {
    padding-bottom: 3px;
    border-bottom: 2px solid #a587ca;
}





    </style>
</head>
<body>
<nav>
    <ul class="menuItems">
        <li><a href='#' data-item='Home'>Home</a></li> <!-- Link de navegação para Home -->
        <li><a href='#' data-item='About'>About</a></li> <!-- Link de navegação para About -->
        <li><a href='#' data-item='Projects'>Projects</a></li> <!-- Link de navegação para Projects -->
        <li><a href='#' data-item='Blog'>Blog</a></li> <!-- Link de navegação para Blog -->
        <li><a href='#' data-item='Contact'>Contact</a></li> <!-- Link de navegação para Contact -->
        <li><a href='#' data-item='Login | Cadastro'>Login | Cadastro</a></li> <!-- Link de navegação para Login/Cadastro -->
    </ul>
</nav>
<div class="container_sugestao">
    <div class="container">
        <div class="form-container">
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
<script>
    function showLogin() {
        document.getElementById('loginForm').style.display = 'block'; // Mostra o formulário de login -->
        document.getElementById('signupForm').style.display = 'none'; // Esconde o formulário de cadastro 
        document.getElementById('toggleLine').style.transform = 'translateX(0)'; // Move a linha indicadora para a posição do login
    }

    function showSignup() {
        document.getElementById('loginForm').style.display = 'none'; <!-- Esconde o formulário de login -->
        document.getElementById('signupForm').style.display = 'block'; // Mostra o formulário de cadastro 
        document.getElementById('toggleLine').style.transform = 'translateX(100%)'; // Move a linha indicadora para a posição do cadastro
        
    }
</script>
</body>
</html>