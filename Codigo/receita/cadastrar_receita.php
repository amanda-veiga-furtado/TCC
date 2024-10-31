<?php
    session_start(); // Inicia a sessão para armazenar e gerenciar variáveis de sessão.
    ob_start(); // Inicia o buffer de saída para capturar e manipular a saída.

    include_once '../conexao.php';
    include '../css/functions.php';
    include_once '../menu.php';

    $erro = ""; // Inicializa a variável de erro como uma string vazia.
    $dados = []; // Inicializa o array de dados como um array vazio.

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se a requisição é do tipo POST
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);// Filtra e sanitiza os dados recebidos do formulário.

        if (!empty($dados['CadReceita'])) { // Verifica se o botão de cadastro foi clicado
            // Validação e preparação dos dados
            list($numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto) = validateAndPrepareData($dados);

            if (!empty($_SESSION['mensagem'])) {
                $erro = $_SESSION['mensagem']; // Se houver mensagem de erro, atribui a $erro
            }

            if (empty($erro)) { // Se não houver erros na validação
                $caminho_imagem = handleImageUpload($erro); // Manipula o upload da imagem

                if (empty($erro)) { // Se não houver erros no upload da imagem
                    try {
                        $id_receita = insertReceita($dados, $numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $caminho_imagem);// Insere a receita no banco de dados
                        
                        if ($id_receita) { // Se a receita for inserida com sucesso.
                            insertIngredientes($dados, $id_receita, $erro); // Insere os ingredientes associados à receita
                        } else {
                            $erro = "Erro ao cadastrar a receita. Por favor, tente novamente."; // Define mensagem de erro se falhar ao inserir a receita.
                        }

                        if (empty($erro)) {// Se não houver erros
                        echo "<script>alert('Receita e ingredientes cadastrados com sucesso!');</script>";
                        }
                    } catch (PDOException $err) { // Captura exceções de erro de PDO
                        $erro = "Erro: " . $err->getMessage();// Define mensagem de erro com detalhes da exceção
                    }
                }
            }
        }
    }
    function validateAndPrepareData($dados) {
        $erro = ""; // Inicializa a variável de erro como uma string vazia
        
        // Porção
        $numeroPorcao_receita = $dados['numeroPorcao_receita'] ?? null; // Obtém o número de porções ou define como null
        $tipoPorcao_receita = $dados['tipoPorcao_receita'] ?? null; // Obtém o tipo de porção ou define como null.

        // Tempo de Preparo
        $tempoPreparoHora = $dados['tempoPreparoHora_receita'] ?? 0;
        $tempoPreparoMinuto = $dados['tempoPreparoMinuto_receita'] ?? 0;

        // Validação do tempo de preparo
        if (($tempoPreparoHora == 0 && $tempoPreparoMinuto == 0) || ($tempoPreparoMinuto >= 60 && $tempoPreparoHora > 0)) {
            $_SESSION['mensagem'] = "Formato de tempo inválido. Verifique os valores de horas e minutos.";
        } else {
            $_SESSION['mensagem'] = ""; // Limpa a mensagem se a validação passar
        }
        return [$numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto];
    }
    function handleImageUpload(&$erro) {
        $caminho_imagem = ''; // Inicializa a variável do caminho da imagem como uma string vazia
        if (isset($_FILES['imagem_receita']) && $_FILES['imagem_receita']['error'] === UPLOAD_ERR_OK) { // Verifica se a imagem foi carregada com sucesso
            $imagem_temp = $_FILES['imagem_receita']['tmp_name'];//Obtém o nome do arquivo temporário
            $nome_imagem = basename($_FILES['imagem_receita']['name']);// Obtém o nome do arquivo de imagem
            // $mime_types = ['image/jpeg', 'image/png', 'image/gif']; // Define os tipos MIME permitidos.
            $mime_types = ['image/png']; // Define os tipos MIME permitidos.


            if (in_array(mime_content_type($imagem_temp), $mime_types)) {// Verifica se o tipo MIME da imagem é permitido
                $caminho_imagem = '../css/img/receita/' . $nome_imagem;// Define o caminho onde a imagem será salva
                if (!move_uploaded_file($imagem_temp, $caminho_imagem)) { // Move o arquivo da imagem para o diretório especificado
                    $erro = "Erro ao mover o arquivo da imagem. Por favor, tente novamente."; // Define mensagem de erro se falhar ao mover o arquivo
                }
            } else {
                //$erro = "Formato de imagem inválido. Use JPEG, PNG ou GIF.";// Define mensagem de erro se o formato da imagem for inválido
                $erro = "Formato de imagem inválido. Use PNG.";// Define mensagem de erro se o formato da imagem for inválido

            }
        }
        return $caminho_imagem;// Retorna o caminho da imagem
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

        $cad_receita->execute();// Executa a consulta para inserir a receita

        return $conn->lastInsertId(); // Retorna o ID da última receita inserida
    }
    function insertIngredientes($dados, $id_receita, &$erro) {
        global $conn;// Usa a variável global de conexão ao banco de dados

        $nome_ingredientes = $dados['nome_ingrediente'] ?? []; // Obtém os nomes dos ingredientes ou define como array vazio
        $quantidade_ingredientes = $dados['quantidadeIngrediente'] ?? []; // Obtém as quantidades dos ingredientes ou define como array vazio
        $tipo_ingredientes = $dados['tipoIngrediente'] ?? []; // Obtém os tipos dos ingredientes ou define como array vazio

        foreach ($nome_ingredientes as $index => $nome_ingrediente) { // Itera sobre os nomes dos ingredientes
            if (!empty($nome_ingrediente)) { // Se o nome do ingrediente não estiver vazio
                $qtdIngrediente_lista = $quantidade_ingredientes[$index];  // Obtém a quantidade do ingrediente
                $tipoQtdIngrediente_lista = $tipo_ingredientes[$index];// Obtém o tipo da quantidade do ingrediente

                $query_ingredientes = "
                    INSERT INTO lista_de_ingredientes (fk_id_receita, fk_id_ingrediente, qtdIngrediente_lista, tipoQtdIngrediente_lista) 
                    VALUES (:fk_id_receita, :fk_id_ingrediente, :qtdIngrediente_lista, :tipoQtdIngrediente_lista)";
                $cad_ingredientes = $conn->prepare($query_ingredientes);// Prepara a consulta SQL para inserir os ingredientes

                $cad_ingredientes->bindParam(':fk_id_receita', $id_receita);// Associa o parâmetro da consulta ao valor fornecido
                $cad_ingredientes->bindParam(':fk_id_ingrediente', $nome_ingrediente);  // Assume que o nome do ingrediente é um ID
                $cad_ingredientes->bindParam(':qtdIngrediente_lista', $qtdIngrediente_lista);
                $cad_ingredientes->bindParam(':tipoQtdIngrediente_lista', $tipoQtdIngrediente_lista);

                if (!$cad_ingredientes->execute()) {// Executa a consulta para inserir o ingrediente
                    $erro = "Erro ao cadastrar um ou mais ingredientes. Por favor, tente novamente.";// Define mensagem de erro se falhar ao inserir os ingredientes
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
                                // Inicializa os arrays de ingredientes a partir dos dados recebidos. 
                                // Se os dados não estiverem presentes, define um array vazio como padrão
                                $nome_ingredientes = $dados['nome_ingrediente'] ?? [];
                                $quantidade_ingredientes = $dados['quantidadeIngrediente'] ?? [];
                                $tipo_ingredientes = $dados['tipoIngrediente'] ?? [];

                                // Verifica se há algum ingrediente adicionado verificando a contagem dos nomes dos ingredientes.

                                if (count($nome_ingredientes) > 0) { // Itera sobre os nomes dos ingredientes usando seus índices.
                                    foreach ($nome_ingredientes as $index => $nome_ingrediente) {
                                    // Dentro deste loop, você pode acessar o nome, a quantidade e o tipo de ingrediente 
                                    // usando o índice atual. Aqui você pode gerar campos de formulário ou processar dados.
                                ?>
                                    <div class="ingrediente">
                                        <!-- <select name="nome_ingrediente[]" class="select-field " style="width: 45%;" > -->
                                        <select name="ingrediente" id="ingrediente" class="js-example-basic-single" style="" required>

                                            
                                            <!-- <option value="">Selecione um Ingrediente</option> -->
                                            <option value="" disabled selected></option>

                                            <?php
                                    foreach ($nome_ingredientes as $nome_ingrediente): 
                                ?>
                            <option value="
                                <?= $nome_ingrediente['id_ingrediente']; 
                                ?>"><?= htmlspecialchars($nome_ingrediente['nome_ingrediente']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                                    <!-- Quantidade Ingrediente -->

                                    <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" value="<?php echo htmlspecialchars($quantidade_ingredientes[$index], ENT_QUOTES); ?>" style="width: 15%;">
                                    
                                    <!-- Tipo da Quantidade -->

                                    <select class="select-field" name="tipoIngrediente[]" style="width: 38%;" >
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

                    
                                    <option value="" style="width: 38%;"">Selecione o tipo de medida</option>
    <?php
                        $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                        $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($porcao_opcoes as $option) {
                            $selected = (isset($dados['tipoPorcao_receita']) && $dados['tipoPorcao_receita'] == $option['id_ingrediente_quantidade']) ? 'selected' : '';
                            echo "<option value='{$option['id_ingrediente_quantidade']}' {$selected}>{$option['nome_plural_ingrediente_quantidade']}</option>";
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


                    
                    
                    <!-- Modo de Preparo -->
                    <?php $placeholder_text = file_get_contents('receita.txt'); ?>
                    <h2>Modo de Preparo</h2>
                    <textarea name="modoPreparo_receita" id="modoPreparo_receita" placeholder="<?php echo htmlspecialchars($placeholder_text, ENT_QUOTES, 'UTF-8'); ?>" required><?php echo isset($dados['modoPreparo_receita']) ? htmlspecialchars($dados['modoPreparo_receita'], ENT_QUOTES) : ''; ?></textarea><br>




                    <!-- Categoria -->
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

                    <input type="submit" name="CadReceita" value="Cadastrar Receita" class="button-long">
                </form>
            <!-- </div> -->
            <!-- </div> -->
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