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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            font-family: Hack, monospace;
        }

        nav {
            width: 100%; /* Faz a navbar preencher toda a largura da tela */
            margin: 0px;
            /* background: red; */
            background: #f9f9f9;
            padding: 0px;
        }

        .menuItems {
            list-style: none;
            display: flex;
            justify-content: center; /* Centraliza os itens dentro da navbar */
        }

        .menuItems li {
            margin: 30px;
            position: relative; /* Posição relativa para o efeito de traço */
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
            height: 3px; /* Altura do traço */
            bottom: -6px; /* Posicionamento abaixo da palavra */
            background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Gradiente arco-íris */
            visibility: hidden;
            transform: scaleX(0); /* Inicia sem visibilidade */
            transition: transform 0.3s ease, visibility 0s linear 0.3s;
        }

        .menuItems a:hover::before {
            visibility: visible;
            transform: scaleX(1); /* Exibe o traço ao passar o mouse */
            transition: transform 0.3s ease, visibility 0s linear;
        }
    </style>
</head>
<body>
    <nav>
        <ul class="menuItems">
            <li><a href='#' data-item='Home'>Home</a></li>
            <li><a href='#' data-item='About'>About</a></li>
            <li><a href='#' data-item='Projects'>Projects</a></li>
            <li><a href='#' data-item='Blog'>Blog</a></li>
            <li><a href='#' data-item='Contact'>Contact</a></li>
        </ul>
    </nav>
</body>
</html>
