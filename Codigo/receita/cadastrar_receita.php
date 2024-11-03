<?php
    session_start(); // Inicia a sessão para armazenar e gerenciar variáveis de sessão.
    ob_start(); // Inicia o buffer de saída para capturar e manipular a saída.

    include_once '../conexao.php';
    include '../css/functions.php';
    include_once '../menu.php';

    if (isset($_SESSION['cadastro_realizado']) && $_SESSION['cadastro_realizado'] === true) {
        header('Location: confirmacao.php'); // Redireciona para uma página de confirmação ou exibe uma mensagem
        exit();
    }

    $erro = ""; // Inicializa a variável de erro como uma string vazia.
    $dados = []; // Inicializa o array de dados como um array vazio.

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($dados['CadReceita'])) { 
            if (empty(array_filter($dados['nome_ingrediente'] ?? []))) {
                $erro = "Pelo menos um ingrediente deve ser informado.";
            } else {
                list($numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto) = validateAndPrepareData($dados);
                
                if (!empty($_SESSION['mensagem'])) {
                    $erro = $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']); // 🔄 Limpa a sessão após exibir a mensagem
                }
                
                if (empty($erro)) {
                    $caminho_imagem = handleImageUpload($erro);
                    
                    if (empty($erro)) {
                        try {
                            $id_receita = insertReceita($dados, $numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $caminho_imagem);
                            
                            if ($id_receita && empty($erro)) {
                                insertIngredientes($dados, $id_receita, $erro);
                                
                                if (empty($erro)) {
                                    $_SESSION['mensagem'] = "Receita e ingredientes cadastrados com sucesso!";
                                    header('Location: ' . $_SERVER['PHP_SELF']);
                                    exit();
                                } else {
                                    $conn->prepare("DELETE FROM receita WHERE id_receita = :id_receita")->execute([':id_receita' => $id_receita]);
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
    }
    
    function validateAndPrepareData($dados) {
        $erro = "";
        
        $numeroPorcao_receita = $dados['numeroPorcao_receita'] ?? null;
        $tipoPorcao_receita = $dados['tipoPorcao_receita'] ?? null;
    
        $tempoPreparoHora = $dados['tempoPreparoHora_receita'] ?? 0;
        $tempoPreparoMinuto = $dados['tempoPreparoMinuto_receita'] ?? 0;
    
        if (($tempoPreparoHora == 0 && $tempoPreparoMinuto == 0) || ($tempoPreparoMinuto >= 60 && $tempoPreparoHora > 0)) {
            $_SESSION['mensagem'] = "Formato de tempo inválido. Verifique os valores de horas e minutos.";
        } else {
            $_SESSION['mensagem'] = "";
        }
        return [$numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto];
    }
    

    function insertReceita($dados, $numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $caminho_imagem) {
        global $conn; // Usa a variável global de conexão ao banco de dados
    
        $categoria_receita = $dados['categoria_receita'] ?? null; // Captura o valor de categoria_receita
    
        $query_receita = "INSERT INTO receita 
            (nome_receita, numeroPorcao_receita, tipoPorcao_receita, tempoPreparoHora_receita, tempoPreparoMinuto_receita, modoPreparo_receita, imagem_receita, categoria_receita) 
            VALUES (:nome_receita, :numeroPorcao_receita, :tipoPorcao_receita, :tempoPreparoHora_receita, :tempoPreparoMinuto_receita, :modoPreparo_receita, :imagem_receita, :categoria_receita)";
    
        $cad_receita = $conn->prepare($query_receita); // Prepara a consulta SQL para inserir a receita
        $cad_receita->bindParam(':nome_receita', $dados['nome_receita']); // Associa o parâmetro da consulta ao valor fornecido
        $cad_receita->bindParam(':numeroPorcao_receita', $numeroPorcao_receita);
        $cad_receita->bindParam(':tipoPorcao_receita', $tipoPorcao_receita);
        $cad_receita->bindParam(':tempoPreparoHora_receita', $tempoPreparoHora);
        $cad_receita->bindParam(':tempoPreparoMinuto_receita', $tempoPreparoMinuto);
        $cad_receita->bindParam(':modoPreparo_receita', $dados['modoPreparo_receita']);
        $cad_receita->bindParam(':imagem_receita', $caminho_imagem);
        $cad_receita->bindParam(':categoria_receita', $categoria_receita); // Adiciona categoria_receita
    
        $cad_receita->execute(); // Executa a consulta para inserir a receita
    
        return $conn->lastInsertId(); // Retorna o ID da última receita inserida
    }
    function insertIngredientes($dados, $id_receita, &$erro) {
        global $conn; // Usa a variável global de conexão ao banco de dados
        
        $nome_ingredientes = $dados['nome_ingrediente'] ?? [];
        $quantidade_ingredientes = $dados['quantidadeIngrediente'] ?? [];
        $tipo_ingredientes = $dados['tipoIngrediente'] ?? [];
    
        // Verifica se pelo menos um ingrediente foi informado
        if (empty(array_filter($nome_ingredientes))) {
            $erro = "Pelo menos um ingrediente deve ser informado.";
            return; // Sai da função se nenhum ingrediente for informado
        }
    
        // Verifica se há ingredientes repetidos
        $ingredientesUnicos = [];
        foreach ($nome_ingredientes as $nome_ingrediente) {
            if (in_array($nome_ingrediente, $ingredientesUnicos)) {
                $erro = "Ingredientes não podem ser repetidos.";
                return; // Sai da função se encontrar um ingrediente repetido
            }
            $ingredientesUnicos[] = $nome_ingrediente;
        }
    
        // Insere cada ingrediente no banco de dados
        foreach ($nome_ingredientes as $index => $nome_ingrediente) {
            if (!empty($nome_ingrediente)) {
                $qtdIngrediente_lista = $quantidade_ingredientes[$index];
                $tipoQtdIngrediente_lista = $tipo_ingredientes[$index];
    
                $query_ingredientes = "
                    INSERT INTO lista_de_ingredientes (fk_id_receita, fk_id_ingrediente, qtdIngrediente_lista, tipoQtdIngrediente_lista) 
                    VALUES (:fk_id_receita, :fk_id_ingrediente, :qtdIngrediente_lista, :tipoQtdIngrediente_lista)";
                $cad_ingredientes = $conn->prepare($query_ingredientes);
    
                $cad_ingredientes->bindParam(':fk_id_receita', $id_receita);
                $cad_ingredientes->bindParam(':fk_id_ingrediente', $nome_ingrediente);
                $cad_ingredientes->bindParam(':qtdIngrediente_lista', $qtdIngrediente_lista);
                $cad_ingredientes->bindParam(':tipoQtdIngrediente_lista', $tipoQtdIngrediente_lista);
    
                if (!$cad_ingredientes->execute()) {
                    $erro = "Erro ao cadastrar um ou mais ingredientes. Por favor, tente novamente.";
                    return;
                }
                
            }
        }
    }
    function handleImageUpload(&$erro) {
        $caminho_imagem = ''; // Inicializa o caminho da imagem como vazio
    
        // Verifica se um arquivo foi enviado e se não houve erros no upload
        if (isset($_FILES['imagem_receita']) && $_FILES['imagem_receita']['error'] === UPLOAD_ERR_OK) {
            $imagem_temp = $_FILES['imagem_receita']['tmp_name'];
            $nome_imagem = basename($_FILES['imagem_receita']['name']);
    
            // Define os tipos MIME permitidos e tamanhos máximos
            $mime_types = ['image/png'];
            $tamanho_maximo = 2 * 1024 * 1024; // 2MB
    
            // Verifica o tamanho do arquivo
            if ($_FILES['imagem_receita']['size'] > $tamanho_maximo) {
                $erro = "O arquivo é muito grande. O tamanho máximo permitido é de 2MB.";
                return '';
            }
    
            // Verifica se o tipo MIME da imagem é permitido
            if (in_array(mime_content_type($imagem_temp), $mime_types)) {
                $extensao = pathinfo($nome_imagem, PATHINFO_EXTENSION);
                $novo_nome_imagem = uniqid('receita_', true) . '.' . $extensao;
                $caminho_imagem = '../css/img/receita/' . $novo_nome_imagem;
    
                if (!is_dir('../css/img/receita/')) {
                    mkdir('../css/img/receita/', 0777, true);
                }
    
                if (!move_uploaded_file($imagem_temp, $caminho_imagem)) {
                    $erro = "Erro ao mover o arquivo da imagem. Verifique se é um PNG e não excede 2MB.";
                    return '';
                }
            } else {
                $erro = "Formato de imagem inválido. Use PNG.";
                return '';
            }
        }
    
        return $caminho_imagem; // Retorna o caminho ou uma string vazia se nenhuma imagem foi enviada
    }
    
    
    
    
        
    ?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastrar Receita</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container_background_image_grow">
        <div class="container_whitecard_grow">
            <div class="container_form">
                <div class="form-title-big">
                    <button>Compartilhe Sua Receita</button>
                    <div class="toggle-line-big"></div>
                </div>
                <?php
                if (!empty($erro)) {
                    echo "<script>alert('$erro');</script>";
                } elseif (isset($_SESSION['mensagem'])) {
                    echo "<script>alert('{$_SESSION['mensagem']}');</script>";
                    unset($_SESSION['mensagem']); // 🔄 Garante que o alerta não seja exibido novamente
                }
                ?>
                <form name="cad-receita" id="cad-receita" method="POST" action="" enctype="multipart/form-data">
                    
                    <h2>Nome da Receita</h2>
                    <input type="text" name="nome_receita" id="nome_receita" placeholder="Bolo de Cenoura com Cobertura de Chocolate Amargo" value="<?php echo isset($dados['nome_receita']) ? htmlspecialchars($dados['nome_receita'], ENT_QUOTES) : ''; ?>" style="width: 100%;"required><br>

                    <h2>Porção</h2>
                    <input type="number" name="numeroPorcao_receita" id="numeroPorcao_receita" min="0.001" step="0.001" value="<?php echo isset($dados['numeroPorcao_receita']) ? htmlspecialchars($dados['numeroPorcao_receita'], ENT_QUOTES) : '1'; ?>" style="width: 15%;" required>

                    <select name="tipoPorcao_receita" id="tipoPorcao_receita" style="width: 84%;" required>
                        <option value="">Selecione o tipo de porção</option>
                        <?php
                        $query = $conn->query("SELECT id_porcao, nome_plural_porcao FROM porcao_quantidade ORDER BY nome_plural_porcao ASC");
                        $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($porcao_opcoes as $option) {
                            $selected = (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] == $option['id_porcao']) ? 'selected' : '';
                            echo "<option value='{$option['id_porcao']}' {$selected}>{$option['nome_plural_porcao']}</option>";
                        }
                        ?>
                </select><br>

                    <!-- Tempo de Preparo -->
                        <h2>Tempo de Preparo</h2>

                        <!-- Hora -->
                            <input type="number" name="tempoPreparoHora_receita" id="tempoPreparoHora_receita" min="0" value="<?php echo isset($dados['tempoPreparoHora_receita']) ? htmlspecialchars($dados['tempoPreparoHora_receita'], ENT_QUOTES) : '0'; ?>" 
                            style="width: 15%;"> Hora(s) :
                        
                        <!-- Minuto -->
                            <input type="number" name="tempoPreparoMinuto_receita" id="tempoPreparoMinuto_receita" min="0" value="<?php echo isset($dados['tempoPreparoMinuto_receita']) ? htmlspecialchars($dados['tempoPreparoMinuto_receita'], ENT_QUOTES) : '0'; ?>" 
                            style="width: 15%;"> Minuto(s)<br>

                    <!-- Imagem -->
                        <h2>Imagem da Receita</h2>
                        <input type="file" name="imagem_receita" id="imagem_receita" style="width: 100%;"><br>

                    <!-- Ingredientes -->
                        <h2>Ingrediente</h2>

                        <div id="ingredientes-container">
    <?php
        $nome_ingredientes = $dados['nome_ingrediente'] ?? [];
        $quantidade_ingredientes = $dados['quantidadeIngrediente'] ?? [];
        $tipo_ingredientes = $dados['tipoIngrediente'] ?? [];
    
        // Exibe os ingredientes preenchidos, se houver
        foreach ($nome_ingredientes as $index => $nome_ingrediente) {
            $quantidade = $quantidade_ingredientes[$index] ?? '1';
            $tipo = $tipo_ingredientes[$index] ?? '';
            ?>
            <div class="ingrediente">
                <!-- Campo de seleção do nome do ingrediente -->
                <select name="nome_ingrediente[]" class="select-field" style="width: 45%;" required>
                    <option value="">Selecione um Ingrediente</option>
                    <?php
                    // Exibe todos os ingredientes disponíveis como opções
                    $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                    $ingredientes_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($ingredientes_opcoes as $option) {
                        $selected = ($nome_ingrediente == $option['id_ingrediente']) ? 'selected' : '';
                        echo "<option value='{$option['id_ingrediente']}' $selected>{$option['nome_ingrediente']}</option>";
                    }
                    ?>
                </select>
    
                <!-- Campo de quantidade -->
                <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" value="<?php echo htmlspecialchars($quantidade, ENT_QUOTES); ?>" style="width: 15%;" required>
                
                <!-- Campo de tipo de quantidade -->
                <select class="select-field" name="tipoIngrediente[]" style="width: 38%;" required>
                    <?php
                    $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                    $tipo_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tipo_opcoes as $option) {
                        $selected = ($tipo == $option['id_ingrediente_quantidade']) ? 'selected' : '';
                        echo "<option value='{$option['id_ingrediente_quantidade']}' $selected>{$option['nome_plural_ingrediente_quantidade']}</option>";
                    }
                    ?>
                </select>
            </div>
            <?php
        }
    
        // Exibe um campo em branco para adicionar um novo ingrediente, se nenhum estiver preenchido
        if (empty($nome_ingredientes)) {
            ?>
            <div class="ingrediente">
                <select name="nome_ingrediente[]" class="select-field" style="width: 45%;" required>
                    <option value="">Selecione um Ingrediente</option>
                    <?php
                    $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                    $ingredientes_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($ingredientes_opcoes as $option) {
                        echo "<option value='{$option['id_ingrediente']}'>{$option['nome_ingrediente']}</option>";
                    }
                    ?>
                </select>
                <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" value="1" style="width: 15%;" required>
                <select class="select-field" name="tipoIngrediente[]" style="width: 38%;" required>
                    <?php
                    $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                    $tipo_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tipo_opcoes as $option) {
                        echo "<option value='{$option['id_ingrediente_quantidade']}'>{$option['nome_plural_ingrediente_quantidade']}</option>";
                    }
                    ?>
                </select>
            </div>
            <?php
        }
    ?>
</div>

                    <button type="button" id="add-ingrediente" class="button-round button-plus" title="Adicione 1 Ingrediente a Sua Receita"><i class="fa-solid fa-pencil"></i></button>

                    <button type="button" id="remove-ingrediente" class="button-round button-minus" title="Remova 1 Ingrediente da Sua Receita"><i class="fa-solid fa-trash"></i></button>

                    <?php $placeholder_text = file_get_contents('receita.txt'); ?>
                    <h2>Modo de Preparo</h2>
                    <textarea name="modoPreparo_receita" id="modoPreparo_receita" placeholder="<?php echo htmlspecialchars($placeholder_text, ENT_QUOTES, 'UTF-8'); ?>" required><?php echo isset($dados['modoPreparo_receita']) ? htmlspecialchars($dados['modoPreparo_receita'], ENT_QUOTES) : ''; ?></textarea><br>

                    <h2>Categoria</h2>
                    <select name="categoria_receita" id="categoria_receita" style="width: 100%;" required>
                        <option value="">Selecione a categoria da receita</option>
                        <?php
                        $query = $conn->query("SELECT id_categoria_culinaria, nome_categoria_culinaria FROM categoria_culinaria ORDER BY nome_categoria_culinaria ASC");
                        $categoria_culinaria_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categoria_culinaria_opcoes as $option) {
                            $selected = (isset($dados['categoria_receita']) && $dados['categoria_receita'] == $option['id_categoria_culinaria']) ? 'selected' : '';
                            echo "<option value='{$option['id_categoria_culinaria']}' {$selected}>{$option['nome_categoria_culinaria']}</option>";
                        }
                        ?>
                    </select><br>

                    <input type="submit" name="CadReceita" value="Cadastrar Receita" class="button-long" style="margin-bottom: 11px;">
                </form>
        </div>
        </div>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2({
    placeholder: "Digite o Nome do Ingrediente e Selecione", // Placeholder para pesquisa
    allowClear: true
    });
});
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
</body>
<?php
if (isset($_SESSION['mensagem'])) {
    echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
    unset($_SESSION['mensagem']);
}
?>
</html>