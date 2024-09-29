<?php
    session_start(); // Inicia a sessão para gerenciar dados do usuário
    ob_start(); // Ativa o buffer de saída para manipulação de conteúdo

    include_once '../conexao.php'; 
    include '../css/functions.php';
    include_once '../menu.php'; 

    $erro = ""; // Inicializa uma variável para armazenar mensagens de erro
    $dados = []; // Inicializa uma variável para armazenar mensagens de erro

    $id_receita = filter_input(INPUT_GET, 'id_receita', FILTER_VALIDATE_INT); // Obtém o ID da receita da URL e valida se é um inteiro

    if (!$id_receita) { // Verifica se o ID da receita é válido
        echo "ID de receita inválido!"; // Mensagem de erro se o ID não for válido 
        exit(); // Encerra a execução do script
    }

    $query = "SELECT * FROM receita WHERE id_receita = :id_receita"; // Consulta para selecionar dados da receita pelo ID
    $statement = $conn->prepare($query); // Prepara a consulta
    $statement->bindParam(':id_receita', $id_receita); // Liga o ID à consulta
    $statement->execute(); // Executa a consulta
    $dados = $statement->fetch(PDO::FETCH_ASSOC); // Obtém os dados da receita

    $query_ingredients = "SELECT li.fk_id_ingrediente, li.qtdIngrediente_lista, li.tipoQtdIngrediente_lista 
                        FROM lista_de_ingredientes li 
                        WHERE li.fk_id_receita = :id_receita"; // Consulta para selecionar os ingredientes da receita
    $statement_ingredients = $conn->prepare($query_ingredients); // Prepara a consulta
    $statement_ingredients->bindParam(':id_receita', $id_receita); // Liga o ID à consulta
    $statement_ingredients->execute(); // Executa a consulta
    $ingredientes = $statement_ingredients->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os ingredientes

    if (!$dados) { // Verifica se a receita foi encontrada
        echo "Receita não encontrada!"; // Mensagem de erro se a receita não for encontrada
        exit(); // Encerra a execução do script
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o formulário foi enviado via POST
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // Obtém os dados do formulário

        if (!empty($dados['EditReceita'])) { // Verifica se o botão de edição da receita foi pressionado
            list($numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $erro) = validateAndPrepareData($dados); // Valida e processa os dados recebidos

            if (empty($erro)) { // Verifica se há erros na validação
                $caminho_imagem = $dados['imagem_atual']; // Armazena a imagem atual da receita
                if (!empty($_FILES['imagem_receita']['name'])) { // Se uma nova imagem foi enviada, trata o upload
                    $caminho_imagem = handleImageUpload($erro);
                }

                if (empty($erro)) {
                    try {
                        // Handle category selection
                        $categoryValue = ($dados['categoria_receita'] === 'NULL') ? null : $dados['categoria_receita'];

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
                        $statement_update->bindValue(':categoria_receita', $categoryValue, is_null($categoryValue) ? PDO::PARAM_NULL : PDO::PARAM_INT);
                        $statement_update->bindParam(':id_receita', $id_receita);

                        $statement_update->execute();

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
</head>
<body>
    <div class="container_form_type_2">
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
                    <h2>Nome da Receita</h2>
                    <input type="text" name="nome_receita" value="<?php echo htmlspecialchars($dados['nome_receita'], ENT_QUOTES); ?>" style="width: 100%;" required>

                    <h2>Porção</h2>
                    <input type="number" name="numeroPorcao_receita" id="numeroPorcao_receita" min="0.001" step="0.001" value="<?php echo htmlspecialchars($dados['numeroPorcao_receita'], ENT_QUOTES); ?>"  style="width: 15%;" required>
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

                    <h2>Tempo de Preparo</h2>
                    <input type="number" name="tempoPreparoHora_receita" id="tempoPreparoHora_receita" min="0" value="<?php echo htmlspecialchars($dados['tempoPreparoHora_receita'], ENT_QUOTES); ?>" style="width: 15%;" required> Hora(s) : 
                    <input type="number" name="tempoPreparoMinuto_receita" id="tempoPreparoMinuto_receita" min="0" value="<?php echo htmlspecialchars($dados['tempoPreparoMinuto_receita'], ENT_QUOTES); ?>" style="width: 15%;" required> Minuto(s)

                    <h2>Imagem</h2>
                    <input type="file" name="imagem_receita">
                    <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($dados['imagem_receita'] ?? '', ENT_QUOTES); ?>">
                    <img src="<?php echo $dados['imagem_receita'] ?? 'caminho_para_imagem_placeholder.png'; ?>" alt="Imagem da Receita" style="width: 100%;">

                    <h2>Ingredientes</h2>
                    <div id="ingredientes-container">
                        <?php
                        if (!empty($ingredientes)) {
                            foreach ($ingredientes as $ingrediente) {
                                ?>
                                <div class="ingrediente">
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
                                    <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" 
                                           value="<?php echo htmlspecialchars($ingrediente['qtdIngrediente_lista'] ?? '', ENT_QUOTES); ?>" 
                                           style="width: 15%;">
                                    <select class="select-field" name="tipoIngrediente[]" style="width: 38%;">
                                        <?php
                                        $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                                        $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($porcao_opcoes as $option) {
                                            $selected = ($option['id_ingrediente_quantidade'] == $ingrediente['tipoQtdIngrediente_lista']) ? 'selected' : '';
                                            echo "<option value='{$option['id_ingrediente_quantidade']}' {$selected}>{$option['nome_plural_ingrediente_quantidade']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                            }
                        } else {
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
                    <button type="button" id="add-ingrediente" class="button-redondo button-mais">+</button>
                    <button type="button" id="remove-ingrediente" class="button-redondo button-menos">-</button>

                    <!-- Modo de Preparo -->
                    <?php $placeholder_text = file_get_contents('receita.txt'); ?>
                    <h2>Modo de Preparo</h2>
                    <textarea name="modoPreparo_receita" id="modoPreparo_receita" placeholder="<?php echo htmlspecialchars($placeholder_text, ENT_QUOTES, 'UTF-8'); ?>" required><?php echo htmlspecialchars($dados['modoPreparo_receita'], ENT_QUOTES); ?></textarea><br>

                    <h2>Categoria</h2>
                    <select name="categoria_receita" id="categoria_receita" style="width: 100%;">
                        <option value="NULL">Não Desejo Selecionar Nenhuma Categoria</option>
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxIngredientes = 20;
        let ingredientesCount = document.querySelectorAll('.ingrediente').length;

        function cloneSelectOptions(selectElement) {
            return selectElement.innerHTML;
        }

        document.getElementById('add-ingrediente').addEventListener('click', function () {
            if (ingredientesCount < maxIngredientes) {
                const container = document.getElementById('ingredientes-container');
                const newIngrediente = document.createElement('div');
                newIngrediente.className = 'ingrediente';

                const selectIngredienteOptions = cloneSelectOptions(document.querySelector('.ingrediente select[name="nome_ingrediente[]"]'));
                const selectTipoOptions = cloneSelectOptions(document.querySelector('.ingrediente select[name="tipoIngrediente[]"]'));

                newIngrediente.innerHTML = `
                    <select name="nome_ingrediente[]" class="select-field" style="width: 45%;">${selectIngredienteOptions}</select>
                    <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.5" step="0.5" value="1" style="width: 15%;">
                    <select class="select-field" name="tipoIngrediente[]" style="width: 38%;">${selectTipoOptions}</select>
                `;
                container.appendChild(newIngrediente);
                ingredientesCount++;
            } else {
                alert('Você só pode adicionar até 20 ingredientes.');
            }
        });

        document.getElementById('remove-ingrediente').addEventListener('click', function () {
            const container = document.getElementById('ingredientes-container');
            if (ingredientesCount > 1) {
                container.lastElementChild.remove();
                ingredientesCount--;
            }
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoriaSelect = document.getElementById('categoria_receita');
        const nomeReceitaInput = document.getElementById('nome_receita');

        categoriaSelect.addEventListener('change', function () {
            if (categoriaSelect.value === "") {
                nomeReceitaInput.value = ""; // Limpa o campo de nome da receita
            }
        });
    });
    </script>

</body>
</html>

<?php
function validateAndPrepareData($dados) {
    $numeroPorcao_receita = ltrim($dados['numeroPorcao_receita'], '0');
    $numeroPorcao_receita = filter_var($dados['numeroPorcao_receita'], FILTER_VALIDATE_FLOAT);
    $tipoPorcao_receita = filter_var($dados['tipoPorcao_receita'], FILTER_VALIDATE_INT);

    $tempoPreparoHora = (int) $dados['tempoPreparoHora_receita'];
    $tempoPreparoMinuto = (int) $dados['tempoPreparoMinuto_receita'];

    $erro = "";

    if ($numeroPorcao_receita <= 0) {
        $erro .= "Porção deve ser maior que zero. ";
    }
    if (($tempoPreparoHora == 0 && $tempoPreparoMinuto == 0) || ($tempoPreparoMinuto >= 60 && $tempoPreparoHora > 0)) {
        $erro .= "Formato de tempo inválido. Verifique os valores de horas e minutos.";
    }

    return [$numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $erro];
}



function handleImageUpload(&$erro) {
    $extensao = strtolower(pathinfo($_FILES['imagem_receita']['name'], PATHINFO_EXTENSION));
    if (!in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
        $erro .= "Formato de imagem inválido. ";
        return null;
    }

    $novo_nome = uniqid() . '.' . $extensao;
    $caminho = '../css/img/receita/' . $novo_nome;

    if (!is_dir('../css/img/receita')) {
        mkdir('../css/img/receita', 0777, true);
    }

    if (!move_uploaded_file($_FILES['imagem_receita']['tmp_name'], $caminho)) {
        $erro .= "Erro ao fazer upload da imagem. ";
        return null;
    }

    return $caminho;
}

function insertIngredientes($dados, $id_receita, &$erro) {
    global $conn;

    if (!empty($dados['nome_ingrediente'])) {
        foreach ($dados['nome_ingrediente'] as $index => $ingrediente) {
            $quantidade = $dados['quantidadeIngrediente'][$index] ?? 0;
            $tipo = $dados['tipoIngrediente'][$index] ?? null;

            if (!empty($ingrediente) && $quantidade > 0 && !empty($tipo)) {
                $query_insert = "INSERT INTO lista_de_ingredientes (fk_id_receita, fk_id_ingrediente, qtdIngrediente_lista, tipoQtdIngrediente_lista) 
                                 VALUES (:fk_id_receita, :fk_id_ingrediente, :qtdIngrediente_lista, :tipoQtdIngrediente_lista)";
                $statement_insert = $conn->prepare($query_insert);
                $statement_insert->bindParam(':fk_id_receita', $id_receita);
                $statement_insert->bindParam(':fk_id_ingrediente', $ingrediente);
                $statement_insert->bindParam(':qtdIngrediente_lista', $quantidade);
                $statement_insert->bindParam(':tipoQtdIngrediente_lista', $tipo);

                $statement_insert->execute();
            }
        }
    }
}
?>
