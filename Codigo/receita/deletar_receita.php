<?php
session_start();
ob_start();

include_once '../conexao.php';

$id_receita = filter_input(INPUT_GET, 'id_receita', FILTER_VALIDATE_INT); // Obtém o ID da receita da URL

if (!$id_receita) { // Verifica se o ID da receita é válido
    echo "ID de receita inválido!";
    exit();
}

try {
    // Inicia uma transação
    $conn->beginTransaction();

    // Exclui todos os ingredientes da receita
    $query_delete_ingredients = "DELETE FROM lista_de_ingredientes WHERE fk_id_receita = :id_receita";
    $statement_delete_ingredients = $conn->prepare($query_delete_ingredients);
    $statement_delete_ingredients->bindParam(':id_receita', $id_receita);
    $statement_delete_ingredients->execute();

    // Exclui a receita
    $query_delete_receita = "DELETE FROM receita WHERE id_receita = :id_receita";
    $statement_delete_receita = $conn->prepare($query_delete_receita);
    $statement_delete_receita->bindParam(':id_receita', $id_receita);
    $statement_delete_receita->execute();

    // Confirma a transação
    $conn->commit();

    // Redireciona para a listagem de receitas após a exclusão
    header("Location: listagem_receitas.php");
    exit();

} catch (PDOException $err) {
    // Se ocorrer um erro, desfaz a transação
    $conn->rollBack();
    echo "<p style='color: red;'>Erro ao excluir receita: " . $err->getMessage() . "</p>";
}
?>
