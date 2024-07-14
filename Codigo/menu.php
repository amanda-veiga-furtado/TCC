<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        body {
            display: flex; /* Usa flexbox para alinhar conteúdo verticalmente */
            flex-direction: column; /* Coluna principal */
            justify-content: center; /* Centraliza verticalmente */
            align-items: center; /* Centraliza horizontalmente */
            position: relative; /* Define a posição relativa para o body */
            font-family: Hack, monospace; /* Define a fonte para todo o documento */
        }

        nav {
            width: 100%; /* Faz a navbar preencher toda a largura da tela */
            margin: 0px; /* Margem zero para remover espaçamento padrão */
            /* background: red; */ /* Comentado: fundo vermelho desativado */
            background: #f9f9f9; /* Cor de fundo da barra de navegação */
            padding: 0px; /* Padding zero para remover espaçamento interno */
        }

        .menuItems {
            list-style: none; /* Remove marcadores de lista */
            display: flex; /* Usa flexbox para alinhar itens da lista */
            justify-content: center; /* Centraliza horizontalmente os itens da lista */
        }

        .menuItems li {
            margin: 30px; /* Margem entre os itens da lista */
            position: relative; /* Define a posição relativa para os itens da lista */
        }

        .menuItems a {
            text-decoration: none; /* Remove sublinhado dos links */
            color: #8f8f8f; /* Cor do texto dos links */
            font-size: 24px; /* Tamanho da fonte dos links */
            font-weight: 400; /* Peso normal da fonte */
            text-transform: uppercase; /* Transforma o texto em maiúsculas */
            position: relative; /* Define a posição relativa para os links */
        }

        .menuItems a::before {
            content: ''; /* Conteúdo vazio para o pseudoelemento ::before */
            position: absolute; /* Posição absoluta para o pseudoelemento */
            width: 100%; /* Largura total */
            height: 3px; /* Altura do traço arco-íris */
            bottom: -6px; /* Posicionamento abaixo do texto */
            background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Gradiente arco-íris */
            visibility: hidden; /* Inicia invisível */
            transform: scaleX(0); /* Inicia sem largura (escala zero) */
            transition: transform 0.3s ease, visibility 0s linear 0.3s; /* Transição suave */
        }

        .menuItems a:hover::before {
            visibility: visible; /* Torna o traço visível ao passar o mouse */
            transform: scaleX(1); /* Expande o traço para a largura total do link */
            transition: transform 0.3s ease, visibility 0s linear; /* Transição suave */
        }
    </style>
</head>
<body>
    <nav>
        <ul class="menuItems">
            <li><a href='#' data-item='Home'>Home</a></li> <!-- Item de menu "Home" -->
            <li><a href='#' data-item='About'>About</a></li> <!-- Item de menu "About" -->
            <li><a href='#' data-item='Projects'>Projects</a></li> <!-- Item de menu "Projects" -->
            <li><a href='#' data-item='Blog'>Blog</a></li> <!-- Item de menu "Blog" -->
            <li><a href='#' data-item='Contact'>Contact</a></li> <!-- Item de menu "Contact" -->
        </ul>
    </nav>
</body>
</html>
