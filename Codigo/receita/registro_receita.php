<?php
    session_start();
    ob_start();

    include_once '../conexao.php';
    include '../css/functions.php';
    include_once '../menu.php';
    

    // Sanitiza e valida o ID da receita recebido via GET
    $id_receita = filter_input(INPUT_GET, 'id_receita', FILTER_SANITIZE_NUMBER_INT);

    if (empty($id_receita)) {
        $_SESSION['msg'] = "<p style='color: red;'>Erro: Receita não encontrada!<br><br></p>";
        header("Location: listagem_receitas.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container_form_type_2">
        <div class="whitecard_form_type_2">
            <div class="div_form">
                <?php
                    // Prepara e executa a consulta para buscar os dados da receita
                    $query_receita = "SELECT id_receita, nome_receita, numeroPorcao_receita, tipoPorcao_receita, tempoPreparoHora_receita, tempoPreparoMinuto_receita, modoPreparo_receita, imagem_receita, categoria_receita FROM receita WHERE id_receita = :id_receita LIMIT 1";
                    $result_receita = $conn->prepare($query_receita);
                    $result_receita->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
                    $result_receita->execute();

                    if ($result_receita && $result_receita->rowCount()) {
                    $row_receita = $result_receita->fetch(PDO::FETCH_ASSOC);

                    // Consulta para buscar os nomes singular e plural da porção
                    $query_porcao = "SELECT nome_singular_porcao, nome_plural_porcao FROM porcao_quantidade WHERE id_porcao = :tipoPorcao_receita";
                    $result_porcao = $conn->prepare($query_porcao);
                    $result_porcao->bindParam(':tipoPorcao_receita', $row_receita['tipoPorcao_receita'], PDO::PARAM_INT);
                    $result_porcao->execute();
                
                    $row_porcao = $result_porcao->fetch(PDO::FETCH_ASSOC);

                    // Verifica a quantidade da porção e exibe o nome correto (singular ou plural)
                    $porcao = ($row_receita['numeroPorcao_receita'] > 1) ? $row_porcao['nome_plural_porcao'] : $row_porcao['nome_singular_porcao'];

                    // Consulta para buscar o nome da categoria culinária
                    $query_categoria_receita = "SELECT nome_categoria_culinaria FROM categoria_culinaria WHERE id_categoria_culinaria = :categoria_receita";
                    $result_categoria_receita = $conn->prepare($query_categoria_receita);
                    $result_categoria_receita->bindParam(':categoria_receita', $row_receita['categoria_receita'], PDO::PARAM_INT);
                    $result_categoria_receita->execute();

                    // Armazena o nome da categoria culinária
                    $row_categoria_receita = $result_categoria_receita->fetch(PDO::FETCH_ASSOC);
                    // $categoria = $row_categoria_receita['nome_categoria_culinaria'];

//-------------------- Exibe os dados da receita -------------------------------------------------------------------------

                    echo '<div class="form-toggle2">';
                        // echo "ID: " . $row_receita['id_receita'] . "<br>";
                        // echo "Nome Receita: " . $row_receita['nome_receita'] . "<br>";

                        echo '<button>' . htmlspecialchars($row_receita['nome_receita'], ENT_QUOTES, 'UTF-8') . ' (ID: ' . htmlspecialchars($row_receita['id_receita'], ENT_QUOTES, 'UTF-8') . ')</button>';
                        echo '<div class="toggle-line-big"></div>';                        
                    echo '</div>';

                    // Exibe a porção
                    
                    echo "<h2>Porção</h2>" . floatval($row_receita['numeroPorcao_receita']) . " " . htmlspecialchars($porcao, ENT_QUOTES, 'UTF-8') . "<br>";

                // Exibe o tempo de preparo
                echo "<h1>Tempo de Preparo</h1>";
                if ($row_receita['tempoPreparoHora_receita'] > 1 ) {
                    echo $row_receita['tempoPreparoHora_receita'] . " horas e ";
                } else {
                    echo $row_receita['tempoPreparoHora_receita'] . " hora e ";
                }
                if ($row_receita['tempoPreparoMinuto_receita'] > 1 ) {
                    echo $row_receita['tempoPreparoMinuto_receita'] . " minutos" . "<br><br>";
                } else {
                    echo $row_receita['tempoPreparoMinuto_receita'] . " minuto" . "<br><br>";
                }

                // Exibe o modo de preparo
                echo "Modo de Preparo: " . nl2br(htmlspecialchars($row_receita['modoPreparo_receita'], ENT_QUOTES, 'UTF-8')) . "<br><br>";

                // Exibe a imagem da receita
                $imagem_padrao = "../css/img/receita/imagem.png";
                $imagem_receita = !empty($row_receita['imagem_receita']) ? $row_receita['imagem_receita'] : $imagem_padrao;
                echo "<div class='banner' style='background-image: url(\"" . htmlspecialchars($imagem_receita, ENT_QUOTES, 'UTF-8') . "\");'></div>";

                // Exibe a categoria culinária
                // echo "<h1>Categoria</h1>" . htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') . "<br>";

                // Consulta para buscar os ingredientes
                $query_ingredientes = "SELECT i.nome_ingrediente, li.qtdIngrediente_lista
                                    FROM lista_de_ingredientes li
                                    INNER JOIN ingrediente i ON li.fk_id_ingrediente = i.id_ingrediente
                                    WHERE li.fk_id_receita = :id_receita";
                $result_ingredientes = $conn->prepare($query_ingredientes);
                $result_ingredientes->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
                $result_ingredientes->execute();

                if ($result_ingredientes && $result_ingredientes->rowCount()) {
                    $ingredientes = $result_ingredientes->fetchAll(PDO::FETCH_ASSOC);
                    echo "<div class='card'>";
                    echo "<h1>Ingredientes</h1>";
                    foreach ($ingredientes as $ingrediente) {
                        echo htmlspecialchars($ingrediente['qtdIngrediente_lista'], ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($ingrediente['nome_ingrediente'], ENT_QUOTES, 'UTF-8') . "<br>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='card'>Nenhum ingrediente encontrado.<br></div>";
                }

            } else {
                $_SESSION['msg'] = "<p style='color: red;'>Erro: Receita não encontrada!<br><br></p>";
                header("Location: listagem_receitas.php");
                exit();
            }
            echo '<div class="button-container">';
                // echo '<div class="div-1-3">';
                    echo "<a href='editar_receita.php?id_receita=$id_receita' class='button-short'>Editar</a>";
                // echo "</div>";
                // echo '<div class="div-2-3">';
                    echo "<a href='deletar_receita.php?id_receita=$id_receita' class='button-short'>Deletar</a>";
                // echo "</div>";
                // echo '<div class="div-3-3">';
                    echo "<a href='deletar_receita.php?id_receita=$id_receita' class='button-short'>Voltar</a>";
                // echo "</div>";
            echo "</div>";

        ?>

        <!-- <a href='editar_receita.php?id_receita=$id_receita' class='button-short'>Editar</a> -->

            <!-- <div class="container">
                <div class="box">
                    <a href="editar_receita.php?id_receita=<?php echo $id_receita; ?>" class="botao">Editar</a>
                </div>
                echo "<a href='editar_receita.php?id_receita=$id_receita' class='botao'>Editar</a>";

                <div class="box">
                    <a href="deletar_receita.php?id_receita=<?php echo $id_receita; ?>" class="botao">Deletar</a>
                </div>

                <div class="box">
                    <a href="listagem_receitas.php" class="botao">Voltar</a>
                </div> -->
            </div>

            <?php
                // Exibe mensagem de erro ou sucesso armazenada na sessão
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                // Termina a sessão após definir a mensagem de erro
                session_unset();
                session_destroy();
            ?>
        </div>
    </div>
</body>
</html>
