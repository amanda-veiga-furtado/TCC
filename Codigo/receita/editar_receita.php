<?php
session_start(); // Start the session
ob_start(); // Start output buffering

include_once '../conexao.php'; // Database connection
include '../css/functions.php'; // Include validation functions
include_once '../menu.php'; // Include menu

$erro = "";
$dados = [];

// Fetch the id_receita from the URL
$id_receita = filter_input(INPUT_GET, 'id_receita', FILTER_VALIDATE_INT);

if (!$id_receita) {
    echo "ID de receita inválido!";
    exit();
}

// Retrieve the recipe's current information
$query = "SELECT * FROM receita WHERE id_receita = :id_receita";
$statement = $conn->prepare($query);
$statement->bindParam(':id_receita', $id_receita);
$statement->execute();
$dados = $statement->fetch(PDO::FETCH_ASSOC);

// Fetch all ingredients associated with this recipe
$query_ingredients = "SELECT * FROM lista_de_ingredientes WHERE fk_id_receita = :id_receita";
$statement_ingredients = $conn->prepare($query_ingredients);
$statement_ingredients->bindParam(':id_receita', $id_receita);
$statement_ingredients->execute();
$ingredientes = $statement_ingredients->fetchAll(PDO::FETCH_ASSOC);

// Check if recipe exists
if (!$dados) {
    echo "Receita não encontrada!";
    exit();
}

// Handle form submission to update recipe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['EditReceita'])) {
        // Validate and process data
        list($numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $erro) = validateAndPrepareData($dados);

        if (empty($erro)) {
            $caminho_imagem = $dados['imagem_atual'];
            if (!empty($_FILES['imagem_receita']['name'])) {
                $caminho_imagem = handleImageUpload($erro);
            }

            if (empty($erro)) {
                try {
                    // Update recipe information
                    $query_update = "UPDATE receita 
                                    SET nome_receita = :nome_receita, numeroPorcao_receita = :numeroPorcao_receita, 
                                    tipoPorcao_receita = :tipoPorcao_receita, tempoPreparoHora_receita = :tempoPreparoHora_receita, 
                                    tempoPreparoMinuto_receita = :tempoPreparoMinuto_receita, 
                                    modoPreparo_receita = :modoPreparo_receita, imagem_receita = :imagem_receita, 
                                    categoria_receita = :categoria_receita
                                    WHERE id_receita = :id_receita";
                    $statement_update = $conn->prepare($query_update);
                    $statement_update->bindParam(':nome_receita', $dados['nome_receita']);
                    $statement_update->bindParam(':numeroPorcao_receita', $numeroPorcao_receita);
                    $statement_update->bindParam(':tipoPorcao_receita', $tipoPorcao_receita);
                    $statement_update->bindParam(':tempoPreparoHora_receita', $tempoPreparoHora);
                    $statement_update->bindParam(':tempoPreparoMinuto_receita', $tempoPreparoMinuto);
                    $statement_update->bindParam(':modoPreparo_receita', $dados['modoPreparo_receita']);
                    $statement_update->bindParam(':imagem_receita', $caminho_imagem);
                    $statement_update->bindParam(':categoria_receita', $dados['categoria_receita']);
                    $statement_update->bindParam(':id_receita', $id_receita);

                    $statement_update->execute();

                    // Handle updating ingredients (delete old and insert new ones)
                    $query_delete_ingredients = "DELETE FROM lista_de_ingredientes WHERE fk_id_receita = :id_receita";
                    $statement_delete = $conn->prepare($query_delete_ingredients);
                    $statement_delete->bindParam(':id_receita', $id_receita);
                    $statement_delete->execute();

                    // Insert updated ingredients
                    insertIngredientes($dados, $id_receita, $erro);

                    if (empty($erro)) {
                        echo "<p style='color: green;'>Receita atualizada com sucesso!</p>";
                    }
                } catch (PDOException $err) {
                    $erro = "Erro: " . $err->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Editar Receita</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../css/myscripts.js"></script>
</head>
<body>
    <div class="container_form2">
        <div class="whitecard_form_type_2">
            <div class="form">
                <div class="form-toggle2">
                    <button>Editar Sua Receita</button>
                    <div class="toggle-line2"></div>
                </div>
                <?php
                if (!empty($erro)) {
                    echo "<p style='color: red; margin-left: 10px;'>$erro</p>";
                }
                ?>
                <form name="" id="" method="POST" action="" enctype="multipart/form-data">
                    
                    <!-- Nome da Receita -->
                    <h2>Nome da Receita</h2>
                    <input type="text" name="nome_receita" value="<?php echo htmlspecialchars($dados['nome_receita'], ENT_QUOTES); ?>" style="width: 100%;" required>

                    <!-- Porção -->
                    <h2>Porção</h2>
                    <input type="number" name="numeroPorcao_receita" value="<?php echo htmlspecialchars($dados['numeroPorcao_receita'], ENT_QUOTES); ?>"  style="width: 15%;" required>

                    <select name="tipoPorcao_receita" style="width: 84%;" required>
                    <?php
                    $query = $conn->query("SELECT id_porcao, nome_plural_porcao FROM porcao_quantidade ORDER BY nome_plural_porcao ASC");
                    $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($porcao_opcoes as $option) {
                        $selected = ($option['id_porcao'] == $dados['tipoPorcao_receita']) ? 'selected' : '';
                        echo "<option value='{$option['id_porcao']}' {$selected}>{$option['nome_plural_porcao']}</option>";
                    }
                    ?>
                    </select>

                    <!-- Tempo de Preparo -->
                    <h2>Tempo de Preparo</h2>
                    <input type="number" name="tempoPreparoHora_receita" value="<?php echo htmlspecialchars($dados['tempoPreparoHora_receita'], ENT_QUOTES); ?>" style="width: 15%;" required> Hora(s)
                    <input type="number" name="tempoPreparoMinuto_receita" value="<?php echo htmlspecialchars($dados['tempoPreparoMinuto_receita'], ENT_QUOTES); ?>" style="width: 15%;" required> Minuto(s)

                    <!-- Imagem -->
                    <h2>Imagem</h2>
                    <input type="file" name="imagem_receita">
                    <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($dados['imagem_receita'], ENT_QUOTES); ?>">
                    <img src="<?php echo $dados['imagem_receita']; ?>" alt="Imagem da Receita" style="width: 100%;">

<!-- Ingredientes -->
<h2>Ingredientes</h2>
<div id="ingredientes-container">
    <?php
    if (!empty($ingredientes)) {
        foreach ($ingredientes as $ingrediente) {
            ?>
            <div class="ingrediente">
                <!-- Nome Ingrediente -->
                <select name="nome_ingrediente[]" class="select-field" style="width: 45%;">
                    <option value="">Selecione um Ingrediente</option>
                    <?php
                    $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                    $registros = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($registros as $option) {
                        $selected = ($option['id_ingrediente'] == $ingrediente['fk_id_ingrediente']) ? 'selected' : '';
                        echo "<option value='{$option['id_ingrediente']}' {$selected}>{$option['nome_ingrediente']}</option>";
                    }
                    ?>
                </select>

                <!-- Quantidade Ingrediente -->
                <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" 
                       value="<?php echo htmlspecialchars($ingrediente['quantidade_ingrediente'] ?? '', ENT_QUOTES); ?>" 
                       style="width: 15%;">

                <!-- Tipo de Ingrediente (Unidade de Medida) -->
                <select class="select-field" name="tipoIngrediente[]" style="width: 38%;">
                    <?php
                    $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                    $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($porcao_opcoes as $option) {
                        $selected = ($option['id_ingrediente_quantidade'] == $ingrediente['fk_id_quantidade']) ? 'selected' : '';
                        echo "<option value='{$option['id_ingrediente_quantidade']}' {$selected}>{$option['nome_plural_ingrediente_quantidade']}</option>";
                    }
                    ?>
                </select>
            </div>
            <?php
        }
    } else {
        // Initialize empty ingredient fields if no ingredients exist yet
        ?>
        <div class="ingrediente">
            <select name="nome_ingrediente[]" class="select-field" style="width: 45%;">
                <option value="">Selecione um Ingrediente</option>
                <?php
                $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                $registros = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($registros as $option) {
                    echo "<option value='{$option['id_ingrediente']}'>{$option['nome_ingrediente']}</option>";
                }
                ?>
            </select>

            <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" value="1" style="width: 15%;">

            <select class="select-field" name="tipoIngrediente[]" style="width: 38%;">
                <option value="">Selecione o tipo de medida</option>
                <?php
                $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($porcao_opcoes as $option) {
                    echo "<option value='{$option['id_ingrediente_quantidade']}'>{$option['nome_plural_ingrediente_quantidade']}</option>";
                }
                ?>
            </select>
        </div>
        <?php
    }
    ?>
</div>


                    <!-- Botões + e - -->
                    <button type="button" id="add-ingrediente" class="button-redondo button-mais">+</button>
                    <button type="button" id="remove-ingrediente" class="button-redondo button-menos">-</button>

                    <!-- Modo de Preparo -->
                    <h2>Modo de Preparo</h2>
                    <textarea name="modoPreparo_receita" id="modoPreparo_receita" required><?php echo htmlspecialchars($dados['modoPreparo_receita'], ENT_QUOTES); ?></textarea><br>

                    <!-- Categoria -->
                    <h2>Categoria</h2>
                    <select name="categoria_receita" id="categoria_receita" style="width: 100%;">
                        <?php
                        $query = $conn->query("SELECT id_categoria_culinaria, nome_categoria_culinaria FROM categoria_culinaria ORDER BY nome_categoria_culinaria ASC");
                        $categoria_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categoria_opcoes as $option) {
                            $selected = ($option['id_categoria_culinaria'] == $dados['categoria_receita']) ? 'selected' : '';
                            echo "<option value='{$option['id_categoria_culinaria']}' {$selected}>{$option['nome_categoria_culinaria']}</option>";
                        }
                        ?>
                    </select>

                    <input type="submit" name="EditReceita" value="Atualizar Receita" class="botao-enviar">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
