<?php
// Inclui o menu e a conexão com o banco de dados
include_once '../menu.php'; 
include_once '../conexao.php';

session_start();
ob_start();

// Função para converter frações
// function converteFracao($numero) {
//     if ($numero != floor($numero)) {
//         $partes = explode('.', $numero);
//         $inteiro = $partes[0];
        
//         // Ensure there is a decimal part before accessing it
//         if (isset($partes[1]) && $partes[1] == 5) {
//             return $inteiro . ' e 1/2';
//         }
//     }
//     return $numero;
// }


// Sanitiza e valida o ID da receita recebido via GET
$id_receita = filter_input(INPUT_GET, 'id_receita', FILTER_SANITIZE_NUMBER_INT);

if (empty($id_receita)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Receita não encontrada!<br><br></p>";
    header("Location: listagem_receita.php");
    exit();
}

// Prepara e executa a consulta para buscar os dados da receita
$query_receita = "SELECT nome_receita, numeroPorcao_receita, tipoPorcao_receita, modoPreparo_receita, tempoPreparo_receita, imagem_receita FROM receita WHERE id_receita = :id_receita LIMIT 1";
$result_receita = $conn->prepare($query_receita);
$result_receita->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
$result_receita->execute();

$row_receita = $result_receita->fetch(PDO::FETCH_ASSOC);

if (!$row_receita) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Receita não encontrada!<br><br></p>";
    header("Location: listagem_receitas.php");
    exit();
}

// Consulta para buscar os ingredientes da receita
$query_ingredientes = "SELECT i.nome_ingrediente, li.qtdIngrediente_lista
                       FROM lista_de_ingredientes li
                       INNER JOIN ingrediente i ON li.fk_id_ingrediente = i.id_ingrediente
                       WHERE li.fk_id_receita = :id_receita";
$result_ingredientes = $conn->prepare($query_ingredientes);
$result_ingredientes->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
$result_ingredientes->execute();

$ingredientes = $result_ingredientes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title><?php echo htmlspecialchars($row_receita['nome_receita'], ENT_QUOTES, 'UTF-8'); ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    // Define o caminho da imagem padrão
    $imagem_padrao = "../css/img/receita/imagem.png";

    // Caminho da imagem vindo do banco de dados
    $imagem_receita = !empty($row_receita['imagem_receita']) ? $row_receita['imagem_receita'] : $imagem_padrao;

    // Exibe a imagem da receita ou a imagem padrão
    echo "<div class='banner' style='background-image: url(\"" . htmlspecialchars($imagem_receita, ENT_QUOTES, 'UTF-8') . "\");'></div>";
    ?>

    <div class="conteudo">
        <?php
        if (!empty($row_receita)) {
            echo '<div class="conteiner1">';
            echo '    <div class="form">';
            echo '        <div class="form-toggle2">';
            echo '            <button>' . htmlspecialchars($row_receita['nome_receita'], ENT_QUOTES, 'UTF-8') . '</button>';
            echo '            <div class="toggle-line2"></div>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';

            echo "<div class='card'>";
            echo "<h1>Porção</h1>" . floatval($row_receita['numeroPorcao_receita']) . " " . htmlspecialchars($row_receita['tipoPorcao_receita'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "</div>";

            echo "<div class='card'>";
            echo "<h1>Tempo de Preparo</h1>" . htmlspecialchars($row_receita['tempoPreparo_receita'], ENT_QUOTES, 'UTF-8') . "<br>";
            echo "</div>";

            echo "<div class='card'>";
            echo "<h1>Ingredientes</h1>";
            if (!empty($ingredientes)) {
                foreach ($ingredientes as $ingrediente) {
                    echo htmlspecialchars($ingrediente['qtdIngrediente_lista'], ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($ingrediente['nome_ingrediente'], ENT_QUOTES, 'UTF-8') . "<br>";
                }
            } else {
                echo "Nenhum ingrediente encontrado.<br>";
            }
            echo "</div>";

            echo "<div class='card'>";
            echo "<h1>Modo de Preparo</h1>" . nl2br(htmlspecialchars($row_receita['modoPreparo_receita'], ENT_QUOTES, 'UTF-8')) . "<br><br>";
            echo "</div>";

            echo "<div class='container'>";
            echo "<div class='box'>";
            echo "<a href='editar_receita.php?id_receita=$id_receita' class='botao'>Editar</a>";
            echo "</div>";

            echo "<div class='box'>";
            echo "<a href='deletar_receita.php?id_receita=$id_receita' class='botao'>Deletar</a>";
            echo "</div>";

            echo "<div class='box'>";
            echo "<a href='listagem_receitas.php' class='botao'>Voltar</a>";
            echo "</div><br><br>";
            echo "</div>"; // fecha container
        }
        ?>
    </div>

    <?php
    // Termina a sessão após definir a mensagem de erro
    session_unset();
    session_destroy();
    ?>

    <div class="card">
        <?php
        // Exibe mensagem de erro ou sucesso armazenada na sessão
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
    </div>
</body>
</html>
