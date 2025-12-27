<?php

session_start(); // Iniciar a sessão

ob_start();

// Incluir o arquivo com a conexao com banco de dados
include_once "./conexao.php";

// Receber os dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//**************** INICIO CRIAR NOVO CARRINHO PARA CADA PRODUTO CADASTRADO ***************/
/*
// QUERY cadastrar novo carrinho para o usuário
$query_carrinho = "INSERT INTO carrinhos (usuario_id) VALUES (:usuario_id)";

// Preparar a QUERY
$cad_carrinho = $conn->prepare($query_carrinho);

// Subtituir o link da QUERY pelo valor enviado pela URL
$cad_carrinho->bindParam(':usuario_id', $dados['usuario_id']);

// Executar a QUERY com PDO
$cad_carrinho->execute();

// Acessa o IF quando cadastrar com sucesso no BD
if($cad_carrinho->rowCount()){

    // Recuperar o último id cadastrado com PDO
    $ultimo_carrinho = $conn->lastInsertId();

    // QUERY para cadastrar o produto no carrinho
    $query_car_prod = "INSERT INTO carrinhos_produtos (carrinho_id, produto_id) VALUES (:carrinho_id, :produto_id)";

    // Preparar a QUERY
    $cad_car_prod = $conn->prepare($query_car_prod);

    // Subtituir o link da QUERY pelo valor enviado pela URL
    $cad_car_prod->bindParam(':carrinho_id', $ultimo_carrinho);
    $cad_car_prod->bindParam(':produto_id', $dados['id_produto']);

    // Executar a QUERY com PDO
    $cad_car_prod->execute();

    // Acessa o IF quando cadastrar com sucesso no BD
    if($cad_car_prod->rowCount()){

        // Criar a SESSÃO com o mensagem de sucesso
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Produto colocado no carrinho</div>";

        // Redirecionar o usuário
        header("Location: index.php");
    }else{
        // Criar a SESSÃO com o mensagem de erro
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Produto não colocado no carrinho</div>";

        // Redirecionar o usuário
        header("Location: index.php");
    }
}else{
    // Criar a SESSÃO com o mensagem de erro
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Produto não colocado no carrinho</div>";

    // Redirecionar o usuário
    header("Location: index.php");
}*/

//**************** INICIO CRIAR NOVO CARRINHO PARA CADA PRODUTO CADASTRADO ***************/



//**************** INICIO CADASTRADO PRODUTO NO CARRINHO INDICADO NO FORMULÁRIO ***************/

// QUERY para cadastrar o produto no carrinho
$query_car_prod = "INSERT INTO carrinhos_produtos (carrinho_id, produto_id) VALUES (:carrinho_id, :produto_id)";

// Preparar a QUERY
$cad_car_prod = $conn->prepare($query_car_prod);

// Subtituir o link da QUERY pelo valor enviado pela URL
$cad_car_prod->bindParam(':carrinho_id', $dados['carrinho_id']);
$cad_car_prod->bindParam(':produto_id', $dados['id_produto']);

// Executar a QUERY com PDO
$cad_car_prod->execute();

// Acessa o IF quando cadastrar com sucesso no BD
if ($cad_car_prod->rowCount()) {

    // Criar a SESSÃO com o mensagem de sucesso
    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Produto colocado no carrinho</div>";

    // Redirecionar o usuário
    header("Location: index.php");
} else {

    // Criar a SESSÃO com o mensagem de erro
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Produto não colocado no carrinho</div>";

    // Redirecionar o usuário
    header("Location: index.php");
}

//**************** FIM CADASTRADO PRODUTO NO CARRINHO INDICADO NO FORMULÁRIO ***************/
