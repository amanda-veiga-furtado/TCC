<?php
session_start();
ob_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: http://localhost/TCC/Codigo/usuario/login.php');
    $_SESSION['mensagem'] = "Para prosseguir, é necessário estar logado.";
    exit();
}

include_once '../conexao.php';
include '../css/frontend.php';
include_once '../menu.php';

$erro = ""; // Inicializa uma variável para mensagens de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica envio do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['CadastrarReceita'])) { // Botão "Cadastrar Receita" foi pressionado
        list($numeroPorcao_receita, $tipoPorcao_receita, $tempoPreparoHora, $tempoPreparoMinuto, $erro) = validateAndPrepareData($dados);

        if (empty($erro)) {
            $caminho_imagem = ""; // Inicializa o caminho da imagem
            if (!empty($_FILES['imagem_receita']['name'])) { // Verifica se há imagem para upload
                $caminho_imagem = handleImageUpload($erro);
            }

            if (empty($erro)) {
                try {
                    $query_insert = "INSERT INTO receita 
                                    (nome_receita, numeroPorcao_receita, tipoPorcao_receita, tempoPreparoHora_receita, 
                                    tempoPreparoMinuto_receita, modoPreparo_receita, imagem_receita, categoria_receita, fk_id_usuario) 
                                    VALUES 
                                    (:nome_receita, :numeroPorcao_receita, :tipoPorcao_receita, :tempoPreparoHora_receita, 
                                    :tempoPreparoMinuto_receita, :modoPreparo_receita, :imagem_receita, :categoria_receita, :fk_id_usuario)";
                    
                    $statement_insert = $conn->prepare($query_insert);
                    $statement_insert->bindParam(':nome_receita', $dados['nome_receita']);
                    $statement_insert->bindParam(':numeroPorcao_receita', $numeroPorcao_receita);
                    $statement_insert->bindParam(':tipoPorcao_receita', $tipoPorcao_receita);
                    $statement_insert->bindParam(':tempoPreparoHora_receita', $tempoPreparoHora);
                    $statement_insert->bindParam(':tempoPreparoMinuto_receita', $tempoPreparoMinuto);
                    $statement_insert->bindParam(':modoPreparo_receita', $dados['modoPreparo_receita']);
                    $statement_insert->bindParam(':imagem_receita', $caminho_imagem);
                    $statement_insert->bindValue(':categoria_receita', $dados['categoria_receita'] === 'NULL' ? null : $dados['categoria_receita'], $dados['categoria_receita'] === 'NULL' ? PDO::PARAM_NULL : PDO::PARAM_INT);
                    $statement_insert->bindParam(':fk_id_usuario', $_SESSION['id_usuario']);

                    $statement_insert->execute();

                    // Obtém o ID da receita recém-inserida
                    $id_receita = $conn->lastInsertId();

                    // Insere os ingredientes
                    addIngredientes($dados, $id_receita, $erro);

                    if (empty($erro)) {
                        $_SESSION['mensagem'] = "Receita cadastrada com sucesso!";
                        header("Location: registro_receita.php?id_receita=$id_receita");
                        exit();
                    }
                } catch (PDOException $err) {
                    $erro = "Erro: " . $err->getMessage();
                }
            }
        }
    }
}

// Funções auxiliares
function validateAndPrepareData($dados)
{
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

function handleImageUpload(&$erro)
{
    $extensao = strtolower(pathinfo($_FILES['imagem_receita']['name'], PATHINFO_EXTENSION));
    if (!in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
        $erro .= "Formato de imagem inválido. Permitidos: jpg, jpeg, png, gif.";
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

function addIngredientes($dados, $id_receita, &$erro)
{
    global $conn;

    if (!empty($dados['nome_ingrediente'])) {
        foreach ($dados['nome_ingrediente'] as $index => $ingrediente) {
            $quantidade = $dados['quantidadeIngrediente'][$index] ?? 0;
            $tipo = $dados['tipoIngrediente'][$index] ?? null;

            if (!empty($ingrediente) && $quantidade > 0 && !empty($tipo)) {
                $query_add = "INSERT INTO lista_de_ingredientes 
                              (fk_id_receita, fk_id_ingrediente, qtdIngrediente_lista, tipoQtdIngrediente_lista) 
                              VALUES (:fk_id_receita, :fk_id_ingrediente, :qtdIngrediente_lista, :tipoQtdIngrediente_lista)";
                $statement_add = $conn->prepare($query_add);
                $statement_add->bindParam(':fk_id_receita', $id_receita);
                $statement_add->bindParam(':fk_id_ingrediente', $ingrediente);
                $statement_add->bindParam(':qtdIngrediente_lista', $quantidade);
                $statement_add->bindParam(':tipoQtdIngrediente_lista', $tipo);

                $statement_add->execute();
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
                    <button>Cadastrar Nova Receita</button>
                    <div class="toggle-line-big"></div>
                </div>
                <?php
                if (!empty($erro)) {
                    echo "<p style='color: red; margin-left: 10px;'>$erro</p>";
                }
                ?>
                <form name="" id="" method="POST" action="" enctype="multipart/form-data">
                    <h2>Nome da Receita</h2>
                    <input type="text" name="nome_receita" style="width: 100%;" required>

                    <h2>Porção</h2>
                    <input type="number" name="numeroPorcao_receita" min="0.001" step="0.001" style="width: 15%;" required>
                    <select name="tipoPorcao_receita" style="width: 84%;" required>
                        <!-- Preencha as opções a partir do banco -->
                        <?php
                        $query = $conn->query("SELECT id_porcao, nome_plural_porcao FROM porcao_quantidade ORDER BY nome_plural_porcao ASC");
                        $porcao_opcoes = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($porcao_opcoes as $option) {
                            echo "<option value='{$option['id_porcao']}'>{$option['nome_plural_porcao']}</option>";
                        }
                        ?>
                    </select>

                    <h2>Tempo de Preparo</h2>
                    <input type="number" name="tempoPreparoHora_receita" min="0" style="width: 15%;" required> Hora(s) :
                    <input type="number" name="tempoPreparoMinuto_receita" min="0" style="width: 15%;" required> Minuto(s)

                    <h2>Imagem</h2>
                    <input type="file" name="imagem_receita">

                    <h2>Ingredientes</h2>
                    <div id="ingredientes-container">
                        <div class="ingrediente">
                            <select name="nome_ingrediente[]" class="select-field" style="width: 45%;">
                                <!-- Preencha opções a partir do banco -->
                                <?php
                                $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                                $ingredientes = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($ingredientes as $option) {
                                    echo "<option value='{$option['id_ingrediente']}'>{$option['nome_ingrediente']}</option>";
                                }
                                ?>
                            </select>
                            <input type="number" name="quantidadeIngrediente[]" min="0.001" step="0.001" value="1" style="width: 15%;">
                            <select name="tipoIngrediente[]" style="width: 38%;">
                                <?php
                                $query = $conn->query("SELECT id_ingrediente_quantidade, nome_plural_ingrediente_quantidade FROM ingrediente_quantidade ORDER BY nome_plural_ingrediente_quantidade ASC");
                                $tipos = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($tipos as $option) {
                                    echo "<option value='{$option['id_ingrediente_quantidade']}'>{$option['nome_plural_ingrediente_quantidade']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="button" id="add-ingrediente" class="button-round button-plus" title="Adicione 1 Ingrediente a Sua Receita"><i class="fa-solid fa-pencil"></i></button>                    <button type="button" id="remove-ingrediente" class="button-round button-minus" title="Remova 1 Ingrediente da Sua Receita"><i class="fa-solid fa-trash"></i></button>


                    <?php $placeholder_text = file_get_contents('receita.txt'); ?>
                    <h2>Modo de Preparo</h2>
                    <textarea name="modoPreparo_receita" id="modoPreparo_receita" placeholder="<?php echo htmlspecialchars($placeholder_text, ENT_QUOTES, 'UTF-8'); ?>" required><?php echo isset($dados['modoPreparo_receita']) ? htmlspecialchars($dados['modoPreparo_receita'], ENT_QUOTES) : ''; ?></textarea><br>


                    <h2>Categoria</h2>
                    <select name="categoria_receita">
                        <?php
                        $query = $conn->query("SELECT id_categoria_culinaria, nome_categoria_culinaria FROM categoria_culinaria ORDER BY nome_categoria_culinaria ASC");
                        $categorias = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categorias as $option) {
                            echo "<option value='{$option['id_categoria_culinaria']}'>{$option['nome_categoria_culinaria']}</option>";
                        }
                        ?>
                    </select>

                    <input type="submit" name="CadastrarReceita" value="Cadastrar Receitaa" class="button-long" style="margin-bottom: 11px;">

                </form>
            </div>
            <?php
            if (!empty($_SESSION['mensagem'])) {
                echo "<p style='color: green; margin-left: 10px;'>{$_SESSION['mensagem']}</p>";
                unset($_SESSION['mensagem']);
            }
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxIngredientes = 20;
            let ingredientesCount = document.querySelectorAll('.ingrediente').length;

            // Função para verificar duplicatas
            function verificarDuplicados() {
                const selects = document.querySelectorAll('select[name="nome_ingrediente[]"]');
                const ingredientesSelecionados = [];

                for (const select of selects) {
                    const valor = select.value;
                    if (valor) {
                        if (ingredientesSelecionados.includes(valor)) {
                            alert('Você selecionou ingredientes duplicados. Por favor, escolha ingredientes únicos.');
                            return false;
                        }
                        ingredientesSelecionados.push(valor);
                    }
                }
                return true;
            }

            // Adicionar ingrediente
            document.getElementById('add-ingrediente').addEventListener('click', function() {
                if (ingredientesCount < maxIngredientes) {
                    const container = document.getElementById('ingredientes-container');
                    const newIngrediente = document.createElement('div');
                    newIngrediente.className = 'ingrediente';

                    const selectIngredienteOptions = document.querySelector('.ingrediente select[name="nome_ingrediente[]"]').innerHTML;
                    const selectTipoOptions = document.querySelector('.ingrediente select[name="tipoIngrediente[]"]').innerHTML;

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

            // Remover ingrediente
            document.getElementById('remove-ingrediente').addEventListener('click', function() {
                const container = document.getElementById('ingredientes-container');
                if (ingredientesCount > 1) {
                    container.lastElementChild.remove();
                    ingredientesCount--;
                }
            });

            // Verificar duplicatas ao enviar formulário
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!verificarDuplicados()) {
                    e.preventDefault(); // Impede o envio do formulário
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoriaSelect = document.getElementById('categoria_receita');
            const nomeReceitaInput = document.getElementById('nome_receita');

            categoriaSelect.addEventListener('change', function() {
                if (categoriaSelect.value === "") {
                    nomeReceitaInput.value = ""; // Limpa o campo de nome da receita
                }
            });
        });
    </script>
</body>
</html>
