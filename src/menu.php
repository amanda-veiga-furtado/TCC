<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLogged = isset($_SESSION['id_usuario']);

$isAdmin = $isLogged &&
           isset($_SESSION['statusAdministrador_usuario']) &&
           $_SESSION['statusAdministrador_usuario'] === 'a';
?>

<nav>
    <ul class="menuItems">
        <li>
            <a href="/TCC/src/home/home.php">
                <i class="fa-solid fa-house fa-sm"></i> Home
            </a>
        </li>

        <?php if (!$isLogged): ?>
            <li>
                <a href="/TCC/src/usuario/login.php">Login</a>
            </li>
        <?php endif; ?>

        <li>
            <a href="/TCC/src/receita/busca_ingrediente/busca_ingrediente.php">
                Busca por Ingrediente
            </a>
        </li>

        <li>
            <a href="/TCC/src/receita/listagem_receitas.php">Receitas</a>
        </li>

        <?php if ($isLogged): ?>
            <li>
                <a href="/TCC/src/receita/cadastrar_receita.php">
                    Postar Receita
                </a>
            </li>

            <li>
                <a href="/TCC/src/receita/sugestao.php">Sugestão</a>
            </li>

            <li>
                <a href="/TCC/src/usuario/dashboard.php">
                    <i class="fa-solid fa-circle-user fa-lg"></i>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
            <li>
                <a href="/TCC/src/usuario/listagem_cadastros.php">
                    Usuários <i class="fa-solid fa-lock-open"></i>
                </a>
            </li>

            <li>
                <a href="/TCC/src/receita/listagem_receitas_admin.php">
                    Receitas <i class="fa-solid fa-lock-open"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
