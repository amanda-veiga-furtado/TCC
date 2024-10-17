<?php

// Incluir o arquivo com a conexao com banco de dados
include_once "./conexao.php";

$nome_produto = filter_input(INPUT_GET, "nome", FILTER_DEFAULT);

// Acessa o IF quando existe o nome do produto no parâmetro enviado pela URL
if (!empty($nome_produto)) {

    // Criar a variável com % para pesquisar com LIKE
    $pesq_produtos = "%" . $nome_produto . "%";

    // Buscar no banco de dados os produtos
    $query_produtos = "SELECT id, nome FROM produtos WHERE nome LIKE :nome LIMIT 10";

    // Preparar a QUERY
    $result_produtos = $conn->prepare($query_produtos);

    // Subtituir o link da QUERY pelo valor enviado pela URL
    $result_produtos->bindParam(':nome', $pesq_produtos);

    // Executar a QUERY com PDO
    $result_produtos->execute();

    // Acessa o IF quando encontrou produto no banco de dados
    if (($result_produtos) and ($result_produtos->rowCount() != 0)) {

        // Ler os registros retornado do banco de dados
        while ($row_produto = $result_produtos->fetch(PDO::FETCH_ASSOC)) {

            // Atribuir os dados do produto para a variável dados
            $dados[] = $row_produto;
        }

        // Criar o array com o status e retornar os dados
        $retorna = ['status' => true, 'dados' => $dados];
    } else {

        // Criar o array com o status e retornar a mensagem de erro
        $retorna = ['status' => false, 'msg' => "Erro: nenhum produto encontrado!"];
    }
} else {
    // Criar o array com o status e retornar a mensagem de erro
    $retorna = ['status' => false, 'msg' => "Erro: nenhum produto encontrado!"];
}

// Retornar os dados
echo json_encode($retorna);
