<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Horizontal e Responsivo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Ajustes gerais do nav */
        html,
        body {
            font-family: Hack, monospace;
            margin: 0;
            padding: 0;
        }

        nav {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            width: 100%;
            background: var(--cinza-primario);
            padding: 10px 0;
            /* Removida altura fixa para mobile */
        }

        /* Menu horizontal desktop */
        .menuItems {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .menuItems li {
            display: flex;
            align-items: center;
            margin: 0 30px;
            position: relative;
        }

        .menuItems a {
            text-decoration: none;
            color: var(--cinza-secundario);
            font-size: 24px;
            font-weight: 400;
            text-transform: uppercase;
            position: relative;
            padding: 5px 0;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Hover gradiente */
        .menuItems a::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            bottom: -6px;
            background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario));
            visibility: hidden;
            transform: scaleX(0);
            transition: transform 0.3s ease, visibility 0s linear 0.3s;
        }

        .menuItems a:hover::before {
            visibility: visible;
            transform: scaleX(1);
            transition: transform 0.3s ease, visibility 0s linear;
        }

        /* Ícone Hamburger mobile */
        .menuIcon {
            display: none;
            font-size: 28px;
            cursor: pointer;
        }

        /* MOBILE */
        @media screen and (max-width: 768px) {
            nav {
                flex-direction: column;
                /* Menu vertical no mobile */
                align-items: flex-start;
                /* itens alinhados à esquerda */
                padding: 10px 20px;
            }

            .menuIcon {
                display: block;
                color: var(--cinza-secundario);
            }

            .menuItems {
                display: none;
                /* escondido por padrão */
                flex-direction: column;
                /* vertical */
                width: 100%;
                text-align: left;
                /* alinhamento limpo */
                margin: 0;
                padding: 0;
            }

            .menuItems.show {
                display: flex;
            }

            .menuItems li {
                margin: 10px 0;
                /* espaçamento uniforme */
            }

            .menuItems a {
                font-size: 20px;
                /* um pouco menor para caber no mobile */
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLogged = isset($_SESSION['id_usuario']);
    $isAdmin = $isLogged && isset($_SESSION['statusAdministrador_usuario']) && $_SESSION['statusAdministrador_usuario'] === 'a';
    ?>

    <nav>
        <!-- Ícone do menu mobile -->
        <div class="menuIcon" style="color: var(--cinza-secundario);">
            <i class="fa fa-bars"></i>
        </div>

        <!-- Menu -->
        <ul class="menuItems" id="myLinks">
            <li><a href="/TCC/src/home/home.php"><i class="fa fa-home"></i> Home</a></li>

            <?php if (!$isLogged): ?>
                <li><a href="/TCC/src/usuario/login.php">Login</a></li>
            <?php endif; ?>

            <li><a href="/TCC/src/receita/busca_ingrediente/busca_ingrediente.php">Busca por Ingrediente</a></li>
            <li><a href="/TCC/src/receita/listagem_receitas.php">Receitas</a></li>

            <?php if ($isLogged): ?>
                <li><a href="/TCC/src/receita/cadastrar_receita.php">Postar Receita</a></li>
                <li><a href="/TCC/src/receita/sugestao.php">Sugestão</a></li>
                <li><a href="/TCC/src/usuario/dashboard.php"><i class="fa fa-user"></i></a></li>
            <?php endif; ?>

            <?php if ($isAdmin): ?>
                <li><a href="/TCC/src/usuario/listagem_cadastros.php">Usuários <i class="fa fa-unlock"></i></a></li>
                <li><a href="/TCC/src/receita/listagem_receitas_admin.php">Receitas <i class="fa fa-unlock"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <script>
        // Toggle do menu mobile
        document.addEventListener("DOMContentLoaded", function () {
            const menuIcon = document.querySelector(".menuIcon");
            const menu = document.getElementById("myLinks");

            if (menuIcon && menu) {
                menuIcon.addEventListener("click", function () {
                    menu.classList.toggle("show");
                });
            }
        });
    </script>

</body>

</html>