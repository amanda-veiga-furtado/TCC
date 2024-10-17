<?php
    session_start();
    ob_start();

    include_once '../conexao.php';

    $id_receita = filter_input(INPUT_GET, 'id_receita', FILTER_VALIDATE_INT);

    if (!$id_receita) {
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

        // Adiciona uma mensagem de sucesso à sessão
        $_SESSION['mensagem'] = "Receita excluída com sucesso!";

        // Redireciona de volta para a página de origem
        $referer = $_SERVER['HTTP_REFERER'] ?? 'listagem_receitas.php'; // Default fallback

        if (strpos($referer, 'listagem_receitas_admin.php') !== false) {
            header("Location: listagem_receitas_admin.php");
        } else {
            header("Location: listagem_receitas.php");
        }
        exit();


    } catch (PDOException $err) {
        // Desfaz a transação em caso de erro
        $conn->rollBack();
        echo "<p style='color: red;'>Erro ao excluir receita: " . htmlspecialchars($err->getMessage()) . "</p>";
    }
    // Display session message, if any
    if (isset($_SESSION['mensagem'])) {
        echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
        unset($_SESSION['mensagem']);
    }
