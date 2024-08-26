<?php
session_start();
ob_start();

include_once '../menu.php';
include_once '../conexao.php';

// Função para converter frações
function converteFracao($numero) {
    if ($numero != floor($numero)) {
        $partes = explode('.', $numero);
        $inteiro = $partes[0];
        
        // Ensure there is a decimal part before accessing it
        if (isset($partes[1]) && $partes[1] == 5) {
            return $inteiro . ' e 1/2';
        }
    }
    return $numero;
}

$erro = "";
$dados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // Recebe os dados do formulário

    if (!empty($dados['CadReceita'])) {

        // Porção
        $numeroPorcao_receita = isset($dados['numeroPorcao_receita']) ? $dados['numeroPorcao_receita'] : null;
        $tipoPorcao_receita = isset($dados['tipoPorcao_receita']) ? $dados['tipoPorcao_receita'] : null;

        // Tempo de Preparo
        $tempoPreparoHora = isset($dados['tempoPreparoHora_receita']) ? $dados['tempoPreparoHora_receita'] : 0;
        $tempoPreparoMinuto = isset($dados['tempoPreparoMinuto_receita']) ? $dados['tempoPreparoMinuto_receita'] : 0;

        // Validação do tempo de preparo
        if (($tempoPreparoHora == 0 && $tempoPreparoMinuto == 0) ||
            ($tempoPreparoMinuto >= 60 && $tempoPreparoHora > 0)) {
            $erro = "Formato de tempo inválido. Verifique os valores de horas e minutos.";
        }

        if (empty($erro)) {
            // Imagem
            $caminho_imagem = '';
            if (isset($_FILES['imagem_receita']) && $_FILES['imagem_receita']['error'] === UPLOAD_ERR_OK) {
                $imagem_temp = $_FILES['imagem_receita']['tmp_name'];
                $nome_imagem = $_FILES['imagem_receita']['name'];

                // Verifica se o arquivo é uma imagem válida
                $check = getimagesize($imagem_temp);
                if ($check !== false) {
                    $caminho_imagem = '../css/img/receita/' . basename($nome_imagem);
                    if (!move_uploaded_file($imagem_temp, $caminho_imagem)) {
                        $erro = "Erro ao mover o arquivo da imagem. Por favor, tente novamente.";
                    }
                }
            }

            if (empty($erro)) {
                // Insere os dados no banco de dados
                try {
                    $query_receita = "INSERT INTO receita (nome_receita, numeroPorcao_receita, tipoPorcao_receita, tempoPreparoHora_receita, tempoPreparoMinuto_receita, modoPreparo_receita, imagem_receita) 
                                      VALUES (:nome_receita, :numeroPorcao_receita, :tipoPorcao_receita, :tempoPreparoHora_receita, :tempoPreparoMinuto_receita, :modoPreparo_receita, :imagem_receita)";
                                      
                    $cad_receita = $conn->prepare($query_receita);
                    $cad_receita->bindParam(':nome_receita', $dados['nome_receita']);
                    $cad_receita->bindParam(':numeroPorcao_receita', $numeroPorcao_receita);
                    $cad_receita->bindParam(':tipoPorcao_receita', $tipoPorcao_receita);
                    $cad_receita->bindParam(':tempoPreparoHora_receita', $tempoPreparoHora);
                    $cad_receita->bindParam(':tempoPreparoMinuto_receita', $tempoPreparoMinuto);
                    $cad_receita->bindParam(':modoPreparo_receita', $dados['modoPreparo_receita']);
                    $cad_receita->bindParam(':imagem_receita', $caminho_imagem);

                    // Executa a inserção
                    if ($cad_receita->execute()) {
                        // Obtém o ID da receita recém-criada
                        $id_receita = $conn->lastInsertId();

                        // Insere os ingredientes
                        $nome_ingredientes = isset($dados['nome_ingrediente']) ? (array) $dados['nome_ingrediente'] : [];
                        $quantidade_ingredientes = isset($dados['quantidadeIngrediente']) ? (array) $dados['quantidadeIngrediente'] : [];
                        $tipo_ingredientes = isset($dados['tipoIngrediente']) ? (array) $dados['tipoIngrediente'] : [];

                        foreach ($nome_ingredientes as $index => $nome_ingrediente) {
                            if (!empty($nome_ingrediente)) {
                                $qtdIngrediente_lista = converteFracao($quantidade_ingredientes[$index]) . ' ' . $tipo_ingredientes[$index];

                                // Obtém o ID do ingrediente selecionado
                                $query_id_ingrediente = "SELECT id_ingrediente FROM ingrediente WHERE id_ingrediente = :nome_ingrediente";
                                $stmt = $conn->prepare($query_id_ingrediente);
                                $stmt->bindParam(':nome_ingrediente', $nome_ingrediente);
                                $stmt->execute();
                                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                                $id_ingrediente = $resultado['id_ingrediente'];

                                // Insere os dados na tabela lista_de_ingredientes
                                $query_ingredientes = "INSERT INTO lista_de_ingredientes (fk_id_receita, fk_id_ingrediente, qtdIngrediente_lista) 
                                                       VALUES (:fk_id_receita, :fk_id_ingrediente, :qtdIngrediente_lista)";
                                $cad_ingredientes = $conn->prepare($query_ingredientes);
                                $cad_ingredientes->bindParam(':fk_id_receita', $id_receita);
                                $cad_ingredientes->bindParam(':fk_id_ingrediente', $id_ingrediente);
                                $cad_ingredientes->bindParam(':qtdIngrediente_lista', $qtdIngrediente_lista);

                                if (!$cad_ingredientes->execute()) {
                                    $erro = "Erro ao cadastrar um ou mais ingredientes. Por favor, tente novamente.";
                                }
                            }
                        }

                        if (empty($erro)) {
                            echo "<p style='color: green; margin-left: 10px;'>Receita e ingredientes cadastrados com sucesso!</p>";
                        }
                    } else {
                        $erro = "Erro ao cadastrar a receita. Por favor, tente novamente.";
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
    <title>Cadastrar Receita</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="conteiner1">
        <div class="form">
            <div class="form-toggle2">
                <button>Compartilhe Sua Receita</button>
                <div class="toggle-line2"></div>
            </div>
            <br>
            <?php
            if (!empty($erro)) {
                echo "<p style='color: red; margin-left: 10px;'>$erro</p>";
            }
            ?>
            <form name="cad-receita" id="cad-receita" method="POST" action="" enctype="multipart/form-data">
                
                <!-- Nome da Receita -->
                <h2>Nome da Receita</h2>
                <input type="text" name="nome_receita" id="nome_receita" placeholder="Bolo de Cenoura com Cobertura de Chocolate Amargo" value="<?php echo isset($dados['nome_receita']) ? htmlspecialchars($dados['nome_receita'], ENT_QUOTES) : ''; ?>" required><br>

                <!-- Porção -->
                <h2>Porção</h2>
                <input type="number" name="numeroPorcao_receita" id="numeroPorcao_receita" min="0" step="0.01" value="<?php echo isset($dados['numeroPorcao_receita']) ? htmlspecialchars($dados['numeroPorcao_receita'], ENT_QUOTES) : '1'; ?>" style="width: 13%;">
                <select name="tipoPorcao_receita" id="tipoPorcao_receita" style="width: 25%;">
                    <option value="porção(ões)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'porção(ões)') ? 'selected' : ''; ?>>porção(ões)</option>
                    <option value="pedaço(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'pedaço(s)') ? 'selected' : ''; ?>>pedaço(s)</option>
                    <option value="prato(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'prato(s)') ? 'selected' : ''; ?>>prato(s)</option>
                    <option value="fatia(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'fatia(s)') ? 'selected' : ''; ?>>fatia(s)</option>
                    <option value="pessoa(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'pessoa(s)') ? 'selected' : ''; ?>>pessoa(s)</option>
                    <option value="quilo(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'quilo(s)') ? 'selected' : ''; ?>>quilo(s)</option>
                    <option value="grama(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'grama(s)') ? 'selected' : ''; ?>>grama(s)</option>
                    <option value="unidade(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'unidade(s)') ? 'selected' : ''; ?>>unidade(s)</option>
                    <option value="copo(s)" <?php echo (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] === 'copo(s)') ? 'selected' : ''; ?>>copo(s)</option>
                </select><br>

                <!-- Tempo de Preparo -->
                <h2>Tempo de Preparo</h2>
                <input type="number" name="tempoPreparoHora_receita" id="tempoPreparoHora_receita" min="0" value="<?php echo isset($dados['tempoPreparoHora_receita']) ? htmlspecialchars($dados['tempoPreparoHora_receita'], ENT_QUOTES) : '0'; ?>" style="width: 10%;"> Hora(s) :
                <input type="number" name="tempoPreparoMinuto_receita" id="tempoPreparoMinuto_receita" min="0" value="<?php echo isset($dados['tempoPreparoMinuto_receita']) ? htmlspecialchars($dados['tempoPreparoMinuto_receita'], ENT_QUOTES) : '0'; ?>" style="width: 10%;"> Minuto(s)<br>

                <!-- Imagem -->
                <h2>Imagem da Receita</h2>
                <input type="file" name="imagem_receita" id="imagem_receita"><br>

                <!-- Ingredientes -->
                <h2>Ingrediente</h2>
                <div id="ingredientes-container">
                    <?php
                    $nome_ingredientes = isset($dados['nome_ingrediente']) ? (array) $dados['nome_ingrediente'] : [];
                    $quantidade_ingredientes = isset($dados['quantidadeIngrediente']) ? (array) $dados['quantidadeIngrediente'] : [];
                    $tipo_ingredientes = isset($dados['tipoIngrediente']) ? (array) $dados['tipoIngrediente'] : [];

                    if (count($nome_ingredientes) > 0) {
                        foreach ($nome_ingredientes as $index => $nome_ingrediente) {
                            ?>
                            <div class="ingrediente">
                                <select name="nome_ingrediente[]" class="select-field">
                                    <option value="">Selecione um Ingrediente</option>
                                    <?php
                                    $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                                    $registros = $query->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($registros as $option) {
                                        $selected = ($option['id_ingrediente'] == $nome_ingrediente) ? 'selected' : '';
                                        echo "<option value='{$option['id_ingrediente']}' {$selected}>{$option['nome_ingrediente']}</option>";
                                    }
                                    ?>
                                </select>
                                <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.5" step="0.5" value="<?php echo htmlspecialchars($quantidade_ingredientes[$index], ENT_QUOTES); ?>" style="width: 50px;">
                                <select class="select-field" name="tipoIngrediente[]">
                                    <option value="colher(es) de café" <?php echo ($tipo_ingredientes[$index] == 'colher(es) de café') ? 'selected' : ''; ?>>colher de café</option>
                                    <option value="colher(es) de chá" <?php echo ($tipo_ingredientes[$index] == 'colher(es) de chá') ? 'selected' : ''; ?>>colher de chá</option>
                                    <!-- Add other options similarly -->
                                </select>
                            </div>
                            <?php
                        }
                    } else {
                        // Default one ingredient field
                        ?>
                        <div class="ingrediente">
                            <select name="nome_ingrediente[]" class="select-field">
                                <option value="">Selecione um Ingrediente</option>
                                <?php
                                $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                                $registros = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($registros as $option):
                                    ?>
                                    <option value="<?php echo $option['id_ingrediente']; ?>"><?php echo $option['nome_ingrediente']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.5" step="0.5" value="1" style="width: 50px;">
                            <select class="select-field" name="tipoIngrediente[]">
                                <option value="colher(es) de café">colher de café</option>
                                <!-- Add other options -->
                            </select>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <!-- Add/Remove Buttons -->
                <button type="button" id="add-ingrediente" class="button-redondo button-mais">+</button>
                <button type="button" id="remove-ingrediente" class="button-redondo button-menos">-</button>

                <!-- Modo de Preparo -->
                <?php $placeholder_text = file_get_contents('receita.txt'); ?>
                <h2>Modo de Preparo</h2>
                <textarea name="modoPreparo_receita" id="modoPreparo_receita" placeholder="<?php echo htmlspecialchars($placeholder_text, ENT_QUOTES, 'UTF-8'); ?>" required><?php echo isset($dados['modoPreparo_receita']) ? htmlspecialchars($dados['modoPreparo_receita'], ENT_QUOTES) : ''; ?></textarea><br>

                <input type="submit" name="CadReceita" value="Cadastrar Receita" class="botao-enviar">
            </form>
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

            // Clone options from the first select elements
            const selectIngredienteOptions = cloneSelectOptions(document.querySelector('.ingrediente select[name="nome_ingrediente[]"]'));
            const selectTipoOptions = cloneSelectOptions(document.querySelector('.ingrediente select[name="tipoIngrediente[]"]'));

            // Set the new innerHTML including both selects and the input
            newIngrediente.innerHTML = `
                <select name="nome_ingrediente[]" class="select-field">${selectIngredienteOptions}</select>
                <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.5" step="0.5" value="1" style="width: 50px;">
                <select class="select-field" name="tipoIngrediente[]">${selectTipoOptions}</select>
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
</body>
</html>
