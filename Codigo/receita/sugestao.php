<?php 
session_start();
ob_start();

include_once '../conexao.php'; 
include '../css/frontend.php';
include_once '../menu.php'; 

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../usuario/login.php'); // Redireciona para a página de login
    $_SESSION['mensagem'] = "Para prosseguir, é necessário estar logado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Sugestão</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
if (!empty($dados['SendSugerir'])) {
    if (empty($dados['nome_sugestao'])) {
            // echo "<p style='color: red;'>O campo de sugestão não pode ser vazio.</p>";
    } else {
        // Recuperar o id_usuario da sessão
        $id_usuario = $_SESSION['id_usuario'];
            
        // Incluir o id_usuario no INSERT
        $query_sugerir = "INSERT INTO sugestao (nome_sugestao, categoria_sugestao, fk_id_usuario) 
                              VALUES (:nome_sugestao, :categoria_sugestao, :fk_id_usuario)";
            
        $send_sugerir = $conn->prepare($query_sugerir);
        $send_sugerir->bindParam(':nome_sugestao', $dados['nome_sugestao'], PDO::PARAM_STR);
        $send_sugerir->bindParam(':categoria_sugestao', $dados['categoria_sugestao'], PDO::PARAM_STR);
        $send_sugerir->bindParam(':fk_id_usuario', $id_usuario, PDO::PARAM_INT);
            
        $send_sugerir->execute();

        // Mensagem de sucesso
        $_SESSION['mensagem'] = "Sugestão enviada com sucesso! Agradecemos pela sua contribuição.";
    }
}
?>
<div class="container_background_image_medium">
    <div class="whitecard_form_type_1">
        <div class="container_form">
            <div class="form_switch">
                <div class="form-toggle">
                    <button style="font-size: 27px;" id="loginBtn" onclick="showLogin()">Sugestões</button> <!-- Exibir o formulário de login -->
                    <div class="toggle-line-big"></div>
                </div>
                <form name="send-sugerir" class="form" method="POST" action="" style="display: block;">
                    <h2>Sugira novos ingredientes e categorias!</h2>
                    <input type="text" name="nome_sugestao" id="nome_sugestao" placeholder="Sugira um ingrediente, uma categoria de ingrediente ou uma categoria culinária" required>
                    <select name="categoria_sugestao" id="categoria_sugestao" style="width:100%;">
                        <option value="Ingrediente">Ingrediente</option>
                        <option value="Categoria de Ingrediente">Categoria de Ingrediente</option>
                        <option value="Categoria Culinária">Categoria Culinária</option>
                    </select>                        
                    <div class="container-button-long">
                        <input type="submit" name="SendSugerir" value="Sugerir" class="button-long">
                        <div class="div_link">
                            <a href="recuperar_senha/recuperar_senha.php" style="color: white; pointer-events: none;">Recuperar Acesso</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>          
<?php
if (isset($_SESSION['mensagem'])) {
    echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
    unset($_SESSION['mensagem']);
}
?>
</body>
</html>
