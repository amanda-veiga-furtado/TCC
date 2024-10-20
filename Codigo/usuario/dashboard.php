<?php
session_start(); 
ob_start(); 

include_once '../conexao.php'; 
include '../css/functions.php';
include_once '../menu.php'; 

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Definindo o $id_usuario antes de utilizá-lo
$id_usuario = $_SESSION['id_usuario'];

// Verifica se o usuário é administrador ou é o próprio usuário logado
if (isset($_SESSION['id_usuario']) && ($_SESSION['id_usuario'] == $id_usuario || $_SESSION['statusAdministrador_usuario'] === 'a')) {
    include_once '../menu_admin.php'; 
}

$nome_usuario = $_SESSION['nome_usuario'];
$email_usuario = $_SESSION['email_usuario'];

// Processa a atualização do perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $novo_nome_usuario = trim($_POST['nome_usuario']);
    $imagem_usuario = $_FILES['imagem_usuario']['name'];
    $imagem_tamanho = $_FILES['imagem_usuario']['size']; 

    // Limite de tamanho do arquivo e extensões permitidas
    $limite_tamanho = 2 * 1024 * 1024;
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    // Verifica se o novo nome de usuário já está em uso
    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE nome_usuario = :nome_usuario AND id_usuario != :id_usuario");
    $stmt->bindParam(':nome_usuario', $novo_nome_usuario);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['mensagem'] = "Erro: Nome de usuário já está em uso!";
    } else {
        if ($imagem_usuario) {
            $file_extension = strtolower(pathinfo($imagem_usuario, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $extensoes_permitidas)) {
                $_SESSION['mensagem'] = "Erro: Apenas arquivos JPG, PNG e GIF são permitidos.";
            } elseif ($imagem_tamanho > $limite_tamanho) {
                $_SESSION['mensagem'] = "Erro: O arquivo é muito grande. O tamanho máximo permitido é de 2MB.";
            } else {
                // Diretório de destino e validação de diretório
                $target_dir = "../css/img/usuario/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                $target_file = $target_dir . basename($imagem_usuario);
                
                if (move_uploaded_file($_FILES['imagem_usuario']['tmp_name'], $target_file)) {
                    $relative_path = "css/img/usuario/" . basename($imagem_usuario);
                    $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = :nome_usuario, imagem_usuario = :imagem_usuario WHERE id_usuario = :id_usuario");
                    $stmt->bindParam(':imagem_usuario', $relative_path);
                } else {
                    $_SESSION['mensagem'] = "Erro ao fazer o upload da imagem. Tente novamente.";
                }
            }
        } else {
            $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = :nome_usuario WHERE id_usuario = :id_usuario");
        }
        
        // Executa a atualização do nome de usuário e imagem
        $stmt->bindParam(':nome_usuario', $novo_nome_usuario);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $_SESSION['nome_usuario'] = $novo_nome_usuario;
        header("Location: dashboard.php");
        exit();
    }
}

// Busca a imagem do usuário
$stmt = $conn->prepare("SELECT imagem_usuario FROM usuario WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$imagem_usuario = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container_background_image_medium">
        <div class="whitecard_form_type_1">
        <div class="container_form">

            <div class="form_switch">
                <h1>Bem-vindo(a) <?php echo htmlspecialchars($nome_usuario); ?>!</h1><br>
                <img src="<?php echo !empty($imagem_usuario) ? "../$imagem_usuario" : '../images/default_profile.png'; ?>" alt="Foto de perfil" style="width:150px;height:150px;"><br>
                
                <?php if (isset($_SESSION['mensagem'])): ?>
                    <p class="error-message"><?php echo htmlspecialchars($_SESSION['mensagem']); ?></p>
                    <?php unset($_SESSION['mensagem']); ?>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="nome_usuario"  value="<?php echo htmlspecialchars($nome_usuario); ?>" required>
                    <input type="file" name="imagem_usuario">
                    <br>
                    <input type="submit" name="update_profile" value="Atualizar Perfil" class="button-long">
                </form>

            </div>
            </div>

        </div>
    </div>
</body>
</html>
