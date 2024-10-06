<?php
    session_start(); 
    ob_start(); // Inicia o buffer de saída


    include_once '../conexao.php'; 
    include '../css/functions.php';
    include_once '../menu.php'; 


    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];
    $nome_usuario = $_SESSION['nome_usuario'];
    $email_usuario = $_SESSION['email_usuario'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
        $novo_nome_usuario = $_POST['nome_usuario'];
        $imagem_usuario = $_FILES['imagem_usuario']['name'];
        $imagem_tamanho = $_FILES['imagem_usuario']['size']; // Tamanho do arquivo em bytes

        // Limite de tamanho do arquivo em bytes (exemplo: 2MB)
        $limite_tamanho = 2 * 1024 * 1024;

        // Extensões permitidas
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        // Verifica se o novo nome de usuário já está em uso por outro usuário
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE nome_usuario = :nome_usuario AND id_usuario != :id_usuario");
        $stmt->bindParam(':nome_usuario', $novo_nome_usuario);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['mensagem'] = "Erro: Nome de usuário já está em uso!";
        } else {
            if ($imagem_usuario) {
                // Get the file extension using pathinfo
                $file_extension = strtolower(pathinfo($imagem_usuario, PATHINFO_EXTENSION));

                // Verifica se a extensão do arquivo é permitida
                if (!in_array($file_extension, $extensoes_permitidas)) {
                    $_SESSION['mensagem'] = "Erro: Apenas arquivos JPG, PNG e GIF são permitidos.";
                } elseif ($imagem_tamanho > $limite_tamanho) {
                    // Exibir mensagem de erro se o arquivo for muito grande
                    $_SESSION['mensagem'] = "Erro: O arquivo é muito grande. O tamanho máximo permitido é de 2MB.";
                } else {
                    // Define o diretório de destino correto
                    $target_dir = "../css/img/usuario/";
                    // Gera o caminho completo para salvar a imagem
                    $target_file = $target_dir . basename($imagem_usuario);

                    // Move o arquivo para o diretório desejado
                    if (move_uploaded_file($_FILES['imagem_usuario']['tmp_name'], $target_file)) {
                        // Salva o caminho da imagem relativo à raiz do projeto
                        $relative_path = "css/img/usuario/" . basename($imagem_usuario);

                        $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = :nome_usuario, imagem_usuario = :imagem_usuario WHERE id_usuario = :id_usuario");
                        $stmt->bindParam(':imagem_usuario', $relative_path);
                    } else {
                        // Mensagem de erro detalhada
                        $_SESSION['mensagem'] = "Erro ao fazer o upload da imagem. Por favor, tente novamente com uma imagem diferente.";
                    }
                }
            } else {
                $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = :nome_usuario WHERE id_usuario = :id_usuario");
            }

            $stmt->bindParam(':nome_usuario', $novo_nome_usuario);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();

            $_SESSION['nome_usuario'] = $novo_nome_usuario;
            header("Location: dashboard.php");
            exit();
        }
    }

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
    <link rel="stylesheet" href="../css/style.css">
    <script src="../css/myscripts.js"></script>
</head>
<body>
    <div class="container_form">
        <div class="whitecard_form">
            <div class="form_switch">
                <h1>Bem-vindo(a) <?php echo $nome_usuario; ?>!</h1><br>
                <img src="<?php echo $imagem_usuario ? "../$imagem_usuario" : '../images/default_profile.png'; ?>" alt="Foto de perfil" style="width:150px;height:150px;"><br>
                <?php
                if (isset($_SESSION['mensagem'])) {
                    echo "<p>" . $_SESSION['mensagem'] . "</p>";
                    unset($_SESSION['mensagem']);
                }
                ?>
                <!-- <form method="POST" enctype="multipart/form-data"> -->
                    <!-- <input type="text" name="nome_usuario" value="<?php echo $nome_usuario; ?>" required>  -->
                    <!-- <br> -->

                    <!-- <input type="file" name="imagem_usuario"><br><br> -->
                    <!-- <input type="submit" name="update_profile" value="Atualizar Perfil" class="button-long"> -->
                    
                <!-- </form> -->
                <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nome_usuario" value="<?php echo $nome_usuario; ?>" required>
        <input type="file" name="imagem_usuario">
    <br>
    <input type="submit" name="update_profile" value="Atualizar Perfil" class="button-long">
</form>


            </div>
        </div>
    </div>
</body>
</html>
