<?php
    include_once '../menu.php'; 
    include_once '../conexao.php'; 
    session_start(); // Inicia a sessão

    // Verifica se o usuário está logado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver logado
        exit();
    }

    // Recupera os dados do usuário da sessão
    $id_usuario = $_SESSION['id_usuario'];
    $nome_usuario = $_SESSION['nome_usuario'];
    $email_usuario = $_SESSION['email_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container_form">
        <div class="whitecard_form">
            <div class="container_login">
                <h1>Bem-vindo(a) <?php echo $email_usuario; ?>!</h1>
                <!-- <p>ID do Usuário: <?php echo $id_usuario; ?></p> -->
                <!-- <p>Nome do Usuário: <?php echo $nome_usuario; ?></p> -->
                <!-- <p>Email do Usuário: <?php echo $email_usuario; ?></p> -->
            </div>
        </div>
    </div>

</body>
</html>
