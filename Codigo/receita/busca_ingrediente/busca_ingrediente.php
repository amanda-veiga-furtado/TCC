<?php
    ob_start(); // Inicia o buffer de saída
    session_start(); // Inicia a sessão
    include_once '../../menu.php';
    include_once '../../conexao.php';

    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1; // Verifica se o parâmetro 'pagina' está definido na URL, senão define como 1
    $quantidade_pg = 12; // Define a quantidade de ingredientes por página
    $inicio = ($quantidade_pg * $pagina) - $quantidade_pg; // Calcula o início da seleção dos registros

    $pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : ''; // Verifica se o parâmetro 'pesquisar' está definido na URL

    if ($pesquisar) { // Prepara a query para contar o número de registros encontrados na pesquisa
        $stmt = $conn->prepare("SELECT COUNT(*) FROM ingrediente WHERE nome_ingrediente LIKE :pesquisar");
        $stmt->bindValue(':pesquisar', "%$pesquisar%", PDO::PARAM_STR);
    } else { // Se não houver pesquisa, conta o total de registros sem filtro
        $stmt = $conn->query("SELECT COUNT(*) FROM ingrediente");
    }

    $stmt->execute(); // Executa a query
    $total_ingrediente = $stmt->fetchColumn(); // Obtém o número total de registros
    $num_pagina = ceil($total_ingrediente / $quantidade_pg); // Calcula o número total de páginas

    if ($pesquisar) {
        // Prepara a query para selecionar os registros encontrados na pesquisa com limitação
        $stmt = $conn->prepare("SELECT * FROM ingrediente WHERE nome_ingrediente LIKE :pesquisar LIMIT :inicio, :quantidade_pg");
        $stmt->bindValue(':pesquisar', "%$pesquisar%", PDO::PARAM_STR); 
    } else {
        // Prepara a query para selecionar todos os registros com limitação
        $stmt = $conn->prepare("SELECT * FROM ingrediente LIMIT :inicio, :quantidade_pg");
    }

    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT); // Define o valor do início para a query
    $stmt->bindValue(':quantidade_pg', $quantidade_pg, PDO::PARAM_INT); // Define a quantidade de registros por página para a query
    $stmt->execute(); // Executa a query
    $ingredientes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os registros como um array associativo
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../css/bootstrap/home/bootstrap.min.css" rel="stylesheet">
    <title>Pesquisar Receita por Ingrediente</title>
    <style>
        /* Ajustes nos botões */
        .botao-enviar {
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #a587ca;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            /* width: 100%;    */
        }
        .botao-enviar:hover {
            background-color: #8c6db6;
        }

        /* Tamanho e ajustes da imagem no card */
        .thumbnail img {
            height: 150px;
            object-fit: cover;
        }

        /* .caption {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        } */
        /* Texto do card */
        .caption h3 {
            font-size: 1.5rem;
            margin: 0.5em 0;
        }

        .cart-container {
            position: fixed;
            right: -300px;
            top: 0;
            width: 300px;
            height: 100%;
            background-color: white;
            border-left: 1px solid #ccc;
            padding: 12px;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
            transition: right 0.3s ease;
            overflow-y: auto;
            z-index: 1000;
            border-radius: 8px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-close {
            cursor: pointer;
            color: red;
        }

        .cart-items {
            list-style: none;
            padding: 0;
        }

        .cart-items li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .show-cart {
            right: 0;
        }

        /* Ajustes do campo de pesquisa */

        .form input,
        input[type="text"] {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .form input:focus, .form select:focus, .form textarea:focus {
            border-color: #36cedc;
            outline: none;
        } 

        .align-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }






        /* Estilo genérico para botões, se necessário */
        /* button, .btn {
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        } */
         /* Centralizar paginação */

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

.pagination li {
    display: inline-block;
    margin: 0 2px;
}

/* Mudar a cor de azul para roxo */
.pagination li a, .pagination li span {
    color: #a587ca; /* Cor roxa */
    background-color: white;
    border: 1px solid #a587ca;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

.pagination li a:hover, .pagination li.active span {
    background-color: #8c6db6; /* Cor roxa mais escura no hover ou quando ativo */
    color: white;
    border-color: #8c6db6;
}
/*menu.php______________________________________________________*/
nav {
        display: flex; /* Usa flexbox para alinhar conteúdo verticalmente */
        flex-direction: column; /* Coluna principal */
        justify-content: center; /* Centraliza verticalmente */
        align-items: center; /* Centraliza horizontalmente */
        position: relative; /* Define a posição relativa para o body */
        font-family: Hack, monospace; /* Define a fonte para todo o documento */
        width: 100%; /* Faz a navbar preencher toda a largura da tela */
        margin: 0px; /* Margem zero para remover espaçamento padrão */
        background: #f9f9f9; /* Cor de fundo da barra de navegação */
        padding: 0px; /* Padding zero para remover espaçamento interno */
    }
    .menuItems {
        list-style: none; /* Remove marcadores de lista */
        display: flex; /* Usa flexbox para alinhar itens da lista */
        justify-content: center; /* Centraliza horizontalmente os itens da lista */
    }
    .menuItems li {
        display: flex; /* Adiciona flexbox ao li */
        align-items: center; /* Centraliza verticalmente os itens */
        margin: 30px; /* Margem entre os itens da lista */
        position: relative; /* Define a posição relativa para os itens da lista */
        text-align: center;
    }
    .menuItems a {
        text-decoration: none; /* Remove sublinhado dos links */
        color: #8f8f8f; /* Cor do texto dos links */
        font-size: 24px; /* Tamanho da fonte dos links */
        font-weight: 400; /* Peso normal da fonte */
        text-transform: uppercase; /* Transforma o texto em maiúsculas */
        position: relative; /* Define a posição relativa para os links */
    }
    .menuItems a::before {
        content: ''; /* Conteúdo vazio para o pseudoelemento ::before */
        position: absolute; /* Posição absoluta para o pseudoelemento */
        width: 100%; /* Largura total */
        height: 3px; /* Altura do traço arco-íris */
        bottom: -6px; /* Posicionamento abaixo do texto */
        background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Gradiente arco-íris */
        visibility: hidden; /* Inicia invisível */
        transform: scaleX(0); /* Inicia sem largura (escala zero) */
        transition: transform 0.3s ease, visibility 0s linear 0.3s; /* Transição suave */
    }
    .menuItems a:hover::before {
        visibility: visible; /* Torna o traço visível ao passar o mouse */
        transform: scaleX(1); /* Expande o traço para a largura total do link */
        transition: transform 0.3s ease, visibility 0s linear; /* Transição suave */
    }
/* Caso precise ajustar o padding para a paginação */
/* .pagination li a {
    padding: 8px 15px;
    font-size: 16px;
    font-weight: bold;
} */

    </style>
</head>
<body>
    <div class="container theme-showcase" role="main">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <h1>Ingredientes</h1>
                </div>
                <div class="col-sm-6 col-md-6 align-right">
                    <form id="searchForm" class="form-inline form" method="GET" action="">
                        <button id="cartButton" class="btn btn-primary botao-enviar" style="margin-right: 10px;">Carrinho</button>
                        <div class="form-group">
                            <label for="exampleInputName2" class="sr-only">Pesquisar</label>
                            <input type="text" name="pesquisar" class="form-control" id="exampleInputName2" placeholder="Pesquisar..." value="<?php echo htmlspecialchars($pesquisar); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary botao-enviar">Pesquisar</button>
                    </form> 
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($ingredientes as $ingrediente) { ?>
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail">
                        <img src="<?php echo htmlspecialchars($ingrediente['imagem_ingrediente']); ?>" alt="Ingrediente Image">


                        <div class="caption text-center">
                            <h3><?php echo htmlspecialchars($ingrediente['nome_ingrediente']); ?></h3>
                            <p><button class="btn btn-primary add-to-cart botao-enviar" data-id="<?php echo htmlspecialchars($ingrediente['id_ingrediente']); ?>" data-name="<?php echo htmlspecialchars($ingrediente['nome_ingrediente']); ?>">Adicionar</button></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $num_pagina; $i++) { ?>
                    <li class="<?php echo ($pagina == $i) ? 'active' : ''; ?>">
                        <a href="?pagina=<?php echo $i; ?>&pesquisar=<?php echo htmlspecialchars($pesquisar); ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="cart-container">
        <div class="cart-header">
            <h4><br>Carrinho<br><br></h4>
            <span id="closeCart" class="cart-close">&times;</span>
        </div>
        <ul id="cartItems" class="cart-items"></ul>
        <div>
            <button id="pesquisarReceitaButton" class="btn btn-primary botao-enviar" target="_blank">Pesquisar Receita</button>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script id="cartItemTemplate" type="text/x-custom-template">
        <li>
            <span class="item-name"></span>
            <span class="item-id" style="margin-left: 10px;"></span>
            <button class="btn btn-danger btn-sm remove-from-cart" style="margin-left: auto;">Remover</button>
        </li>
    </script>

    <script>
    $(document).ready(function(){
        function saveCart() {
            localStorage.setItem('cartItems', JSON.stringify(cartItemsArray));
        }

        function loadCart() {
            var storedCartItems = localStorage.getItem('cartItems');
            if (storedCartItems) {
                cartItemsArray = JSON.parse(storedCartItems);
                cartItemsArray.forEach(function(item) {
                    addCartItemToDOM(item.name, item.id);
                });
            }
        }

        var cartItemsArray = [];

        function addToCart(itemName, itemId) {
            cartItemsArray.push({name: itemName, id: itemId});
            addCartItemToDOM(itemName, itemId);
            saveCart();
        }

        function addCartItemToDOM(itemName, itemId) {
            var cartItemTemplate = $('#cartItemTemplate').html();
            var $cartItem = $(cartItemTemplate);
            $cartItem.find('.item-name').text(itemName);
            $cartItem.find('.item-id').text(`(ID: ${itemId})`);
            $('#cartItems').append($cartItem);
        }

        loadCart();

        $('#cartButton').click(function(event){
            event.preventDefault();
            $('#cartSidebar').toggleClass('show-cart');
        });

        $('#closeCart').click(function(){
            $('#cartSidebar').removeClass('show-cart');
        });

        $('.add-to-cart').click(function(){
            var itemName = $(this).data('name');
            var itemId = $(this).data('id');
            
            if (!cartItemsArray.some(item => item.name === itemName && item.id == itemId)) {
                addToCart(itemName, itemId);
            } else {
                alert("Este ingrediente já foi adicionado ao carrinho.");
            }
        });

        $('#cartItems').on('click', '.remove-from-cart', function(){
            var itemName = $(this).closest('li').find('.item-name').text();
            var itemId = $(this).closest('li').find('.item-id').text().replace('(ID: ', '').replace(')', '');
            cartItemsArray = cartItemsArray.filter(item => !(item.name === itemName && item.id == itemId));
            $(this).closest('li').remove();
            saveCart();
        });

        // Clear cart when the tab is closed
        $(window).on('beforeunload', function(){
            localStorage.removeItem('cartItems');
        });

        // Preserve cart items on pagination and search
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var pageUrl = $(this).attr('href');
            loadPage(pageUrl);
        });

        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            var pesquisar = $('#exampleInputName2').val();
            loadPage('?pesquisar=' + encodeURIComponent(pesquisar));
        });

        function loadPage(url) {
            $(window).off('beforeunload');
            window.location.href = url;
        }

        $('#pesquisarReceitaButton').click(function() {
            var cartItems = JSON.stringify(cartItemsArray);
            var form = $('<form action="listagem_receita_ingrediente.php" method="post" target="_blank">' +
                        '<input type="hidden" name="cartItems" value=\'' + cartItems + '\'>' +
                        '</form>');
            $('body').append(form);
            form.submit();
        });
    });
    </script>
</body>
</html>
