<?php
    session_start();
    ob_start();
    
    include_once '../conexao.php';
    include '../css/functions.php';
    include_once '../menu.php';
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
    <div class="div_form">
        <h1>SUGERIR</h1>

        <?php
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            
            if (!empty($dados['SendSugerir'])) {
                if (empty($dados['nome_sugestao'])) {
                    echo "<p style='color: red;'>O campo de sugestão não pode ser vazio.</p>";
                } else {
                    $query_sugerir = "INSERT INTO sugestao (nome_sugestao, categoria_sugestao) VALUES ('" . $dados['nome_sugestao'] . "','" . $dados['categoria_sugestao'] . "')";
                    $send_sugerir = $conn->prepare($query_sugerir); 
                    $send_sugerir->execute();
                    echo "<p style='color: green;'>Sugestão enviada com sucesso!</p>";
                }
            }
        
        ?>
        <form name="send-sugerir" method="POST" action="">
            <input type="text" name="nome_sugestao" id="nome_sugestao" placeholder="Sugestão">
            <select name="categoria_sugestao" id="categoria_sugestao" style="width:100%;">
                <option value="Ingrediente">Ingrediente</option>
                <option value="Categoria de Ingrediente">Categoria de Ingrediente</option>
                <option value="Categoria Culinaria">Categoria Culinaria</option>
            </select>



            
            <input type="submit" value="Sugerir" name="SendSugerir" class="button-long">
        </form>
    </div>
</body>
</html>
