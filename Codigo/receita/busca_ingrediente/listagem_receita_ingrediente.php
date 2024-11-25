<?php
session_start(); // Inicia a sessão do usuário.
ob_start(); // Inicia o buffer de saída.

include_once '../../conexao.php'; // Inclui o arquivo de conexão ao banco de dados.
include '../../css/frontend.php'; // Inclui funções auxiliares de um arquivo CSS.
include_once '../../menu.php'; // Inclui o menu de navegação.

// Verifica se nenhum ingrediente foi passado na URL
if (empty($_GET['ingredientes'])) {
    $_SESSION['mensagem'] = "Nenhum ingrediente foi selecion.";
    header("Location: busca_ingrediente.php");
    exit;
}

// Função para exibir os ingredientes selecionados
function exibirIngredientes($ingredientes)
{
    if (!empty($ingredientes)) {
        echo '<div class="form-title-big" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top:0;">';
        global $conn;
        foreach ($ingredientes as $id) {
            $stmt = $conn->prepare("SELECT nome_ingrediente FROM ingrediente WHERE id_ingrediente = :id");
            $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
            $stmt->execute();
            $ingrediente = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ingrediente) {
                echo '<button style="font-size: 16px;">' . htmlspecialchars($ingrediente['nome_ingrediente']) . '</button>';
            }
        }
        echo '</div>';
    }
}

// Função para buscar os IDs dos ingredientes de uma receita específica
function buscarIngredientesDaReceita($idReceita)
{
    global $conn;
    $stmt = $conn->prepare("SELECT li.fk_id_ingrediente FROM lista_de_ingredientes li WHERE li.fk_id_receita = :id_receita");
    $stmt->bindValue(':id_receita', $idReceita, PDO::PARAM_INT);
    $stmt->execute();
    $ingredientes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $ingredientes ? $ingredientes : [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Receitas Compatíveis Com Sua Pesquisa</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container_background_image_grow_2">
        <div class="container_whitecard_grow">
            <div class="container_form">
                <div class="form-title-big">
                    <button style="font-size: 31px;">Receitas Compatíveis Com Sua Pesquisa</button>
                    <div class="toggle-line-big"></div>
                </div>

                <?php
                $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
                $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $pagina = !empty($pagina_atual) ? $pagina_atual : 1;
                $limite_resultado = 5;
                $inicio = ($limite_resultado * $pagina) - $limite_resultado;

                $selectedIngredients = isset($_GET['ingredientes']) ? explode(',', urldecode($_GET['ingredientes'])) : [];
                exibirIngredientes($selectedIngredients);

                $receitasComIngredientes = [];
                $matchingReceitas = [];

                try {
                    // Obter receitas que têm os ingredientes selecionados
                    $query_matching_receitas = "
                        SELECT li.fk_id_receita 
                        FROM lista_de_ingredientes li 
                        WHERE li.fk_id_ingrediente IN (" . implode(',', array_map('intval', $selectedIngredients)) . ")
                        GROUP BY li.fk_id_receita";

                    $stmt = $conn->prepare($query_matching_receitas);
                    $stmt->execute();
                    $matchingReceitas = $stmt->fetchAll(PDO::FETCH_COLUMN);

                    foreach ($matchingReceitas as $idReceita) {
                        $ingredientesDaReceita = buscarIngredientesDaReceita($idReceita);
                        if (empty(array_diff($ingredientesDaReceita, $selectedIngredients))) {
                            $receitasComIngredientes[] = $idReceita; // Armazena apenas o ID da receita
                        }
                    }
                } catch (PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                }

                // Imprime o array de receitas compatíveis
                if (!empty($receitasComIngredientes)) {
                    foreach ($receitasComIngredientes as $idReceita) {
                        // Busca os detalhes da receita
                        try {
                            $query_receita_detalhes = "SELECT r.id_receita, r.nome_receita, r.numeroPorcao_receita, 
                                p.nome_singular_porcao, p.nome_plural_porcao, 
                                r.tempoPreparoHora_receita, r.tempoPreparoMinuto_receita, 
                                r.modoPreparo_receita, r.imagem_receita, 
                                c.nome_categoria_culinaria
                                FROM receita r
                                LEFT JOIN categoria_culinaria c ON r.categoria_receita = c.id_categoria_culinaria
                                JOIN porcao_quantidade p ON r.tipoPorcao_receita = p.id_porcao
                                WHERE r.id_receita = :id_receita";

                            $stmt_detalhes = $conn->prepare($query_receita_detalhes);
                            $stmt_detalhes->bindValue(':id_receita', $idReceita, PDO::PARAM_INT);
                            $stmt_detalhes->execute();
                            $receita = $stmt_detalhes->fetch(PDO::FETCH_ASSOC);

                            if ($receita) {
                                $id_receita = $receita['id_receita'];
                                $nome_receita = $receita['nome_receita'];
                                $numeroPorcao = $receita['numeroPorcao_receita'];
                                $porcao_nome = $receita['nome_singular_porcao']; // ou plural dependendo do contexto
                                $tempoPreparoHora_receita = $receita['tempoPreparoHora_receita'];
                                $tempoPreparoMinuto_receita = $receita['tempoPreparoMinuto_receita'];
                                $categoria_receita = $receita['nome_categoria_culinaria'];
                ?>

                                <div class="projcard-small">
                                    <a href="registro_receita.php?id_receita=<?php echo htmlspecialchars($id_receita); ?>"
                                        style="text-decoration: none; display: block;">
                                        <div class="projcard-innerbox">
                                            <img class="projcard-img" src="<?php echo htmlspecialchars('../' . $receita['imagem_receita']); ?>" alt="Imagem da receita">

                                            <div class="projcard-textbox">
                                                <div class="projcard-title" style="color: var(--cinza-secundario); margin-bottom: 10px; margin-top: 10px" title="<?php echo htmlspecialchars($nome_receita); ?>">
                                                    <?php echo htmlspecialchars($nome_receita ?? ''); ?>
                                                </div>

                                                <div class="projcard-subtitle">
                                                    <?php echo '<i class="fa-solid fa-utensils" style="color: #fe797b;"></i>&nbsp'
                                                        . htmlspecialchars($numeroPorcao ?? '0') . " "
                                                        . htmlspecialchars($porcao_nome ?? 'porções') . '<span style="margin-left: 10px;"></span><i class="fa-solid fa-clock" style="color: #ffb750;"></i>&nbsp' . htmlspecialchars($tempoPreparoHora_receita ?? '0') . "h e " . htmlspecialchars($tempoPreparoMinuto_receita ?? '0') . "min"; ?>
                                                </div>
                                                <div class="projcard-bar"></div>
                                                <div class="projcard-description">
                                                    <?php
                                                    echo '<div style="margin-bottom: 5px;">' .
                                                        '<i class="fa-solid fa-bookmark" style="color: #a587ca;"></i>&nbsp' . htmlspecialchars($categoria_receita ?? 'Sem Categoria') .
                                                        '</div>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                <?php
                            }
                        } catch (PDOException $e) {
                            echo "Erro ao buscar detalhes da receita: " . $e->getMessage();
                        }
                    }
                } else {
                    echo "<p>Nenhuma receita encontrada com os ingredientes selecionados.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>