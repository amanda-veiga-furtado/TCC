<!DOCTYPE html>
<html lang="en"> <!-- Declaração do tipo de documento e o idioma da página -->
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
    display: flex; /* Usa flexbox para alinhar conteúdo verticalmente */
    flex-direction: column; /* Define a direção principal dos itens como coluna */
    justify-content: center; /* Centraliza verticalmente os itens dentro do nav */
    align-items: center; /* Centraliza horizontalmente os itens dentro do nav */
    position: relative; /* Define a posição relativa para o nav */
    font-family: Hack, monospace; /* Define a fonte da navegação como Hack, com fallback monospace */
    width: 100%; /* Faz a barra de navegação ocupar toda a largura da tela */
    margin: 0px; /* Remove qualquer margem padrão */
    background: #f9f9f9; /* Define a cor de fundo da barra de navegação */
    padding: 0px; /* Remove qualquer padding padrão */
}

.menuItems {
    list-style: none; /* Remove os marcadores de lista */
    display: flex; /* Usa flexbox para alinhar os itens da lista horizontalmente */
    justify-content: center; /* Centraliza horizontalmente os itens da lista */
}
.menuItems li {
    margin: 30px; /* Define uma margem de 30px ao redor de cada item da lista */
    position: relative; /* Define a posição relativa para os itens da lista */
}

.menuItems a {
    text-decoration: none; /* Remove o sublinhado dos links */
    color: #8f8f8f; /* Define a cor do texto dos links */
    font-size: 24px; /* Define o tamanho da fonte dos links */
    font-weight: 400; /* Define o peso da fonte como normal */
    text-transform: uppercase; /* Transforma o texto dos links em maiúsculas */
    position: relative; /* Define a posição relativa para os links */
}

.menuItems a::before {
    content: ''; /* Define um conteúdo vazio para o pseudoelemento antes do link */
    position: absolute; /* Define a posição absoluta para o pseudoelemento */
    width: 100%; /* Define a largura total */
    height: 3px; /* Define a altura do traço arco-íris */
    bottom: -6px; /* Posiciona o pseudoelemento 6px abaixo do texto */
    background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Define um gradiente arco-íris como fundo */
    visibility: hidden; /* Inicialmente invisível */
    transform: scaleX(0); /* Inicialmente sem largura (escala zero) */
    transition: transform 0.3s ease, visibility 0s linear 0.3s; /* Define uma transição suave para a transformação e visibilidade */
}
.menuItems a:hover::before {
    visibility: visible; /* Torna o traço visível ao passar o mouse */
    transform: scaleX(1); /* Expande o traço para a largura total do link */
    transition: transform 0.3s ease, visibility 0s linear; /* Define uma transição suave para a transformação e visibilidade */
}

/* sugestao.php */
.container_sugestao {
    width: 100vw; /* Define a largura como 100% da largura da janela de visualização */
    height: 85.3vh; /* Define a altura como 85.3% da altura da janela de visualização */
    display: flex; /* Usa flexbox para centralizar o conteúdo */
    justify-content: center; /* Centraliza horizontalmente os itens dentro do container */
    align-items: center; /* Centraliza verticalmente os itens dentro do container */
    /* background-color: #36cedc; Define a cor de fundo */
    background-size: cover; /* Faz a imagem de fundo cobrir todo o container */
    background-position: center; /* Centraliza a imagem de fundo */
}

.container {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Define a fonte para o container */
    position: relative; /* Define a posição relativa para o container */
    background: white; /* Define a cor de fundo como branca */
    padding: 30px; /* Define um padding de 30px */
    border-radius: 12px; /* Define bordas arredondadas */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Define uma sombra ao redor do container */
    width: 710px; /* Define a largura do container */
    height: 410px; /* Define a altura do container */
    display: flex; /* Usa flexbox para organizar o conteúdo do container */
    flex-direction: column; /* Organiza o conteúdo em coluna */
    align-items: center; /* Centraliza horizontalmente os itens dentro do container */
    box-shadow: 25px 30px 55px #5557; /* Define uma sombra mais intensa */
    border-radius: 13px; /* Define bordas arredondadas */
    overflow: hidden; /* Oculta qualquer conteúdo que ultrapasse as bordas */
}

.form-container {
    position: relative; /* Define a posição relativa para o container do formulário */
    width: 100%; /* Define a largura como 100% do container pai */
}

.form-toggle {
    display: flex; /* Usa flexbox para organizar os botões */
    justify-content: space-between; /* Distribui os botões com espaço entre eles */
    margin-bottom: 25px; /* Define uma margem inferior de 25px */
    width: 100%; /* Define a largura como 100% do container pai */
    position: relative; /* Define a posição relativa */
}

.form-toggle button {
    background: none; /* Remove o fundo padrão do botão */
    border: none; /* Remove a borda padrão do botão */
    font-size: 18px; /* Define o tamanho da fonte */
    cursor: pointer; /* Define o cursor como pointer ao passar sobre o botão */
    padding: 10px 20px; /* Define o padding interno */
    color: #888; /* Define a cor do texto */
    transition: color 0.3s; /* Define uma transição suave para a cor */
    flex-grow: 1; /* Faz com que os botões cresçam igualmente */
    text-align: center; /* Centraliza o texto dentro do botão */
}

.form-toggle button:hover,
.form-toggle button:focus {
    color: #333; /* Altera a cor do texto ao passar o mouse ou focar no botão */
}

.toggle-line {
    position: absolute; /* Define a posição absoluta */
    bottom: -5px; /* Posiciona 5px abaixo do container pai */
    left: 0; /* Alinha à esquerda */
    width: 50%; /* Define a largura como 50% do container pai */
    height: 3px; /* Define a altura da linha */
    background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Define um gradiente arco-íris como fundo */
    transition: transform 0.3s; /* Define uma transição suave para a transformação */
}

.form {
    display: flex; /* Usa flexbox para organizar o conteúdo */
    flex-direction: column; /* Organiza o conteúdo em coluna */
    align-items: center; /* Centraliza horizontalmente os itens dentro do container */
    width: 100%; /* Define a largura como 100% do container pai */
}

.form h2 {
    margin-bottom: 15px; /* Define uma margem inferior de 15px */
    color: #333; /* Define a cor do texto */
    font-size: 24px; /* Define o tamanho da fonte */
}

.form input {
    margin-bottom: 15px; /* Define uma margem inferior de 15px */
    padding: 12px; /* Define o padding interno */
    border: 1px solid #ccc; /* Define uma borda cinza clara */
    border-radius: 8px; /* Define bordas arredondadas */
    font-size: 16px; /* Define o tamanho da fonte */
    width: 100%; /* Define a largura como 100% do container pai */
    box-sizing: border-box; /* Inclui padding e border na largura total do elemento */
}

.form input:focus {
    border-color: #36cedc; /* Altera a cor da borda ao focar no campo */
    outline: none; /* Remove o outline padrão */
}

.form button {
    padding: 12px; /* Define o padding interno */
    border: none; /* Remove a borda padrão */
    border-radius: 8px; /* Define bordas arredondadas */
    background-color: #a587ca; /* Define a cor de fundo */
    color: white; /* Define a cor do texto */
    font-size: 18px; /* Define o tamanho da fonte */
    cursor: pointer; /* Define o cursor como pointer ao passar sobre o botão */
    transition: background-color 0.3s; /* Define uma transição suave para a cor de fundo */
    width: 100%; /* Define a largura como 100% do container pai */
}

.form button:hover {
    background-color: #8c6db6; /* Altera a cor de fundo ao passar o mouse */
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
        document.getElementById('loginForm').style.display = 'block'; <!-- Mostra o formulário de login -->
        document.getElementById('signupForm').style.display = 'none'; <!-- Esconde o formulário de cadastro -->
        document.getElementById('toggleLine').style.transform = 'translateX(0)'; <!-- Move a linha indicadora para a posição do login -->
    }

    function showSignup() {
        document.getElementById('loginForm').style.display = 'none'; <!-- Esconde o formulário de login -->
        document.getElementById('signupForm').style.display = 'block'; <!-- Mostra o formulário de cadastro -->
        document.getElementById('toggleLine').style.transform = 'translateX(100%)'; <!-- Move a linha indicadora para a posição do cadastro -->
    }
</script>
</body>
</html>
