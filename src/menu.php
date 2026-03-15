<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/menu_frontend.css">
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
        <div class="menuIcon">
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
                <li><a href="/TCC/src/admin/dashboard_admin.php"><i class="fa-solid fa-eye-slash"></i></a></li>
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