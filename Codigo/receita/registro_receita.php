<?php
session_start(); // Inicia a sessão
ob_start();

include_once '../conexao.php'; // Inclui a conexão com o banco de dados
include '../css/functions.php'; // Funções de estilo
include_once '../menu.php'; 

$id_receita = filter_input(INPUT_GET, "id_receita", FILTER_SANITIZE_NUMBER_INT); // Obtém o ID da receita da URL

if (empty($id_receita)) { // Verifica se o ID da receita está vazio
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Receita não encontrada!</p>";
    header("Location: listagem_receitas.php");
    exit();
}

try {
    // Query SQL para buscar os detalhes da receita
    $query_receita = "
        SELECT 
            r.id_receita, r.nome_receita, r.numeroPorcao_receita, r.tempoPreparoHora_receita, r.tempoPreparoMinuto_receita, r.modoPreparo_receita, r.imagem_receita,
            c.nome_categoria_culinaria,
            p.nome_singular_porcao, p.nome_plural_porcao,
            u.nome_usuario,
            u.id_usuario AS fk_id_usuario
        FROM 
            receita r
        JOIN 
            categoria_culinaria c ON r.categoria_receita = c.id_categoria_culinaria
        JOIN 
            porcao_quantidade p ON r.tipoPorcao_receita = p.id_porcao
        JOIN 
            usuario u ON r.fk_id_usuario = u.id_usuario
        WHERE 
            r.id_receita = :id_receita
    ";

    // Preparar e executar a query
    $result_receita = $conn->prepare($query_receita);
    $result_receita->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
    $result_receita->execute();

    // Verificar se a receita foi encontrada
    if ($result_receita && $result_receita->rowCount() > 0) {
        $row_receita = $result_receita->fetch(PDO::FETCH_ASSOC);
        $fk_id_usuario = $row_receita['fk_id_usuario']; // Definindo a variável aqui

        // Consulta para buscar os ingredientes
        $query_ingredientes = "
            SELECT 
                i.nome_ingrediente, 
                li.qtdIngrediente_lista 
            FROM 
                lista_de_ingredientes li 
            INNER JOIN 
                ingrediente i 
            ON 
                li.fk_id_ingrediente = i.id_ingrediente 
            WHERE 
                li.fk_id_receita = :id_receita
        ";

        $result_ingredientes = $conn->prepare($query_ingredientes);
        $result_ingredientes->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
        $result_ingredientes->execute();
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Receita não encontrada!</p>";
        header("Location: listagem_receitas.php");
        exit();
    }
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receita</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Inclua o arquivo de estilos aqui -->
</head>
<body>
<div class="container_background_image_grow">
    <div class="container_whitecard_grow">
        <div class="container_form">
            <?php
            // Exibe os dados da receita
            echo '<div class="form-title-big">';
            echo '<button>' . htmlspecialchars($row_receita['nome_receita'], ENT_QUOTES, 'UTF-8') . ' (ID: ' . htmlspecialchars($row_receita['id_receita'], ENT_QUOTES, 'UTF-8') . ')</button>';
            echo '<div class="toggle-line-big"></div>';
            echo '</div>';

            // Exibe o nome do criador da receita
            echo "<h2>Criado por</h2>" . htmlspecialchars($row_receita['nome_usuario'], ENT_QUOTES, 'UTF-8') . "<br>";

            // Exibe a categoria culinária da receita
            echo "<h2>Categoria Culinária</h2>" . htmlspecialchars($row_receita['nome_categoria_culinaria'], ENT_QUOTES, 'UTF-8') . "<br>";

            // Exibe a porção com singular ou plural
            $numeroPorcao = intval($row_receita['numeroPorcao_receita']);
            $porcao_nome = ($numeroPorcao > 1) ? $row_receita['nome_plural_porcao'] : $row_receita['nome_singular_porcao'];
            echo "<h2>Porção</h2>" . $numeroPorcao . " " . htmlspecialchars($porcao_nome, ENT_QUOTES, 'UTF-8') . "<br>";

            // Exibe o tempo de preparo
            echo "<h1>Tempo de Preparo</h1>";
            $hora_texto = ($row_receita['tempoPreparoHora_receita'] > 1) ? " horas e " : " hora e ";
            $minuto_texto = ($row_receita['tempoPreparoMinuto_receita'] > 1) ? " minutos" : " minuto";
            echo $row_receita['tempoPreparoHora_receita'] . $hora_texto . $row_receita['tempoPreparoMinuto_receita'] . $minuto_texto . "<br><br>";

            // Exibe o modo de preparo
            echo "<h2>Modo de Preparo</h2>" . nl2br(htmlspecialchars($row_receita['modoPreparo_receita'], ENT_QUOTES, 'UTF-8')) . "<br><br>";

            // Exibe a imagem da receita
            $imagem_padrao = "../css/img/receita/imagem.png";
            $imagem_receita = !empty($row_receita['imagem_receita']) ? $row_receita['imagem_receita'] : $imagem_padrao;
            echo "<div class='banner' style='background-image: url(\"" . htmlspecialchars($imagem_receita, ENT_QUOTES, 'UTF-8') . "\");'></div>";

            // Exibir os ingredientes da receita
            if ($result_ingredientes->rowCount() > 0) {
                echo "<h1>Ingredientes</h1>";
                while ($row_ingredientes = $result_ingredientes->fetch(PDO::FETCH_ASSOC)) {
                    echo htmlspecialchars($row_ingredientes['qtdIngrediente_lista'], ENT_QUOTES, 'UTF-8') . " de " . htmlspecialchars($row_ingredientes['nome_ingrediente'], ENT_QUOTES, 'UTF-8') . "<br>";
                }
            } else {
                echo "<p>Nenhum ingrediente encontrado para esta receita.</p>";
            }

            // Centralizar os botões
            echo '<div style="display: flex; justify-content: center; gap: 15px;">';

            // Verificar se o usuário é o criador da receita ou um administrador
            // if (isset($_SESSION['id_usuario']) && ($_SESSION['id_usuario'] == $fk_id_usuario || $_SESSION['statusAdministrador_usuario'] === 'a')) {
                // Botão "Deletar"
                echo '<a href="deletar_receita.php?id_receita=' . htmlspecialchars($id_receita) . '" class="button-orange" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Deletar Receita Permanentemente">';
                echo '<i class="fa-solid fa-trash"></i>';
                echo '</a>';
            // }

            // Botão com link para o usuário
            echo '<a href="../usuario/registro_usuario.php?id_usuario=' . htmlspecialchars($fk_id_usuario, ENT_QUOTES, 'UTF-8') . '" class="button-yellow" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Ver criador da receita">';
            echo '<i class="fa-solid fa-user"></i>';
            echo '</a>';
            
            // Botão para ver a receita
            echo '<a href="registro_receita.php?id_receita=' . htmlspecialchars($id_receita) . '" class="button-yellow" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Ver Receita">';
            echo '<i class="fa-solid fa-spoon"></i>';
            echo '</a>';

            echo '</div>';
            ?>
        </div>
    </div>
</div>
<?php
// Display session message, if any
if (isset($_SESSION['mensagem'])) {
    echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
    unset($_SESSION['mensagem']);
}
?>
</body>
</html>
