<?php
session_start();
ob_start();

include_once '../../conexao.php';
include '../../css/functions.php';
include_once '../../menu.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas Compatíveis Com Sua Pesquisa</title>
</head>
<body>
<div class="container_background_image_grow_2">
    <div class="container_whitecard_grow">
        <div class="container_form">
            <div class="form-title-big">
                <button>Receitas Compatíveis Com</button>
                <div class="toggle-line-big"></div>
            </div>
            <?php
            try {
                // Inicializa o array de ingredientes selecionados
                $selectedIngredients = isset($_GET['ingredientes']) ? explode(',', urldecode($_GET['ingredientes'])) : [];

                // Exibir ingredientes selecionados
                if (!empty($selectedIngredients)) {
                    echo '<div class="form-title-big" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top:0;">'; // Flexbox para exibir na mesma linha

                    foreach ($selectedIngredients as $id) {
                        $stmt = $conn->prepare("SELECT * FROM ingrediente WHERE id_ingrediente = :id");
                        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
                        $stmt->execute();
                        $ingrediente = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Exibir o ingrediente
                        if ($ingrediente) {
                            echo '<button style="font-size: 16px;">' . htmlspecialchars($ingrediente['nome_ingrediente']) . '</button>';
                        }
                    }
                    echo '</div>';
                }

                // Consulta para obter os ingredientes e receitas
                $query_lista_ingrediente = "SELECT fk_id_receita, fk_id_ingrediente FROM lista_de_ingredientes";
                $result_lista_ingrediente = $conn->prepare($query_lista_ingrediente);
                $result_lista_ingrediente->execute();

                $receitasIngredientes = [];

                // Processar os resultados
                while ($row_lista_ingrediente = $result_lista_ingrediente->fetch(PDO::FETCH_ASSOC)) {
                    $idReceita = $row_lista_ingrediente['fk_id_receita'];
                    $idIngrediente = $row_lista_ingrediente['fk_id_ingrediente'];
                    $receitasIngredientes[$idReceita][] = $idIngrediente;
                }
                $matchingReceitas = [];
                foreach ($receitasIngredientes as $idReceita => $ingredientes) {
                    if (empty(array_diff($ingredientes, $selectedIngredients))) {
                        $matchingReceitas[] = $idReceita;
                    }
                }

                if (!empty($matchingReceitas)) {
                    $query_matching_receitas = "SELECT id_receita, nome_receita, imagem_receita FROM receita WHERE id_receita IN (" . implode(',', $matchingReceitas) . ")";
                    $result_matching_receitas = $conn->prepare($query_matching_receitas);
                    $result_matching_receitas->execute();

                    // Exibir as receitas correspondentes
                    while ($row_matching_receita = $result_matching_receitas->fetch(PDO::FETCH_ASSOC)) {
                        $idReceita = $row_matching_receita['id_receita'];
                        $nomeReceita = htmlspecialchars($row_matching_receita['nome_receita']);
                        $imagemReceita = htmlspecialchars($row_matching_receita['imagem_receita']);
                        $linkReceita = "registro_receita.php?id_receita=" . $idReceita;

                        echo "<div class='projcard-smal'>";
                        echo "<div class='projcard-innerbox'>"; // Agora tudo ficará dentro deste div

                        echo "<a href='$linkReceita' style='text-decoration: none; display: block;'>";
                        echo "<h3>$nomeReceita</h3>";
                        echo "</a>";

                        // Exibir os ingredientes da receita
                        echo "<h4>Ingredientes:</h4>";
                        $query_ingredientes_receita = "SELECT ingrediente.nome_ingrediente 
                                                       FROM lista_de_ingredientes 
                                                       JOIN ingrediente ON lista_de_ingredientes.fk_id_ingrediente = ingrediente.id_ingrediente 
                                                       WHERE lista_de_ingredientes.fk_id_receita = :id_receita";
                        $result_ingredientes_receita = $conn->prepare($query_ingredientes_receita);
                        $result_ingredientes_receita->bindParam(':id_receita', $idReceita, PDO::PARAM_INT);
                        $result_ingredientes_receita->execute();

                        while ($row_ingrediente_receita = $result_ingredientes_receita->fetch(PDO::FETCH_ASSOC)) {
                            echo "- " . htmlspecialchars($row_ingrediente_receita['nome_ingrediente']) . "<br>";
                        }

                        // Exibir a imagem da receita
                        if (!empty($imagemReceita)) {
                            echo "<br><img src='$imagemReceita' alt='Imagem da Receita' class='lista-receita-imagem'><br>";
                        } else {
                            echo "<p style='color: #f00;'>Nenhuma imagem disponível</p>";
                        }

                        // Link para a receita
                        echo "<a href='$linkReceita' class='botao'>Ver Receita</a>";

                        echo "</div>"; // Fechamento do 'projcard-innerbox'
                        echo "</div>"; // Fechamento do 'projcard-smal'
                    }
                } else {
                    $_SESSION['mensagem'] = "Nenhuma receita corresponde aos ingredientes selecionados";
                }
            } catch (Exception $e) {
                echo "<p style='color: #f00;'>Erro ao buscar receitas: " . $e->getMessage() . "</p>";
            }
            ?>

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
