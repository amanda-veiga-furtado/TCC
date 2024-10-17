<?php
session_start();
ob_start();

include_once '../../conexao.php';
include '../../css/functions.php';
include_once '../../menu.php';

$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1; // Verifica se o parâmetro 'pagina' está definido na URL, senão define como 1
$quantidade_pg = 6; // Define a quantidade de ingredientes por página
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

$stmt->bindValue(':inicio', intval($inicio), PDO::PARAM_INT); // Define o valor do início para a query
$stmt->bindValue(':quantidade_pg', intval($quantidade_pg), PDO::PARAM_INT); // Define a quantidade de registros por página para a query
$stmt->execute(); // Executa a query
$ingredientes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os registros como um array associativo

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Receita por Ingrediente</title>
    <style>
        .card {
            box-shadow: 2 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 20px;

            height: 300px; /* Define uma altura fixa para o card */
            display: flex;
            flex-direction: column; /* Flex direction para empilhar conteúdo verticalmente */            
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .card img {
    border-radius: 5px 5px 0 0;
    width: 100%;
    height: 170px; /* Altura fixa para a imagem */
    object-fit: cover; /* Mantém a proporção e cobre o espaço */
}
        .container {
            padding: 7px;
            text-align: center;
            flex-grow: 1; /* Preenche o espaço restante */
            flex-direction: column; /* Empilha elementos verticalmente */
            justify-content: space-between; /* Botões ficam na parte inferior */
        }
        .container_cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            /* margin: 5%; */
            margin-left: 5%;
            margin-right: 5%;
        }
        .card-wrapper {
            width: 16.6%; /* Aproximadamente 1/6 da largura para 6 por linha */
            box-sizing: border-box;
            padding: 5px;
        }
        .cart-container {
            position: fixed;
            right: -300px; /* Inicialmente fora da tela */
            top: 0;
            width: 300px;
            height: 100%;
            background-color: white;
            border-left: 1px solid #ccc;
            padding: 12px;
            box-shadow: -2px 0px 5px rgba(0, 0, 0, 0.5);
            transition: right 0.3s ease; /* Transição suave */
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
        .container h3{
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            margin: 0.5em 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #292929;

            overflow: hidden; /* Esconde o texto que ultrapassar o limite */
            text-overflow: ellipsis; /* Adiciona "..." se o texto for muito longo */
            white-space: nowrap; /* Não quebra a linha */




        }
    </style>
</head>
<body>
    <div style="display: flex;">  <!-- Título, Barra de Pesquisar, Carrinho -->
        <div style="width: 50%;">
            <div class="form-title-big" style="margin:3%;">
                <button style="font-size: 30px;">Buscar Receitas pelos seus Ingredientes</button>
                <div style="position: absolute; bottom: -5px; left: 85%; width: 85%; height: 3px; background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario)); 
 transition: transform 0.3s; transform: translateX(-91%);"></div>
            </div>
        </div>

        <div style="width: 40%; display: flex; justify-content: center; align-items: center;">
            <div style="width: 90%; position: relative;">
                <br>
                <form id="searchForm" name="searchForm" method="GET" action="" style="width: 100%; position: relative;">
                    <div style="display: flex;">
                    <label for="exampleInputName2" class="sr-only">Pesquisar</label>
                        <input type="text" name="pesquisar" id="exampleInputName2" placeholder="Pesquisar Ingrediente..." style="width: 100%; padding-right: 40px; height: 40px; border-radius: 8px; border: 1px solid #ccc;" value="<?php echo htmlspecialchars($pesquisar); ?>">
                        <button type="submit" class="button-search" aria-label="Pesquisar" style="position: absolute; right: 0; top: 0; height: 40px; width: 10%; border-radius: 0 8px 8px 0;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div style="display: flex; justify-content: center; align-items: center;">
            <div class="form-title-big" style="margin:3%;">
                <button id="cartButton" style="margin-right: 70px;">
                    <i class="fa-solid fa-cart-shopping" id="cartIcon" style="color: #36cedc;"></i>
                </button>
            </div> 
        </div>
    </div>

    <div class="container_cards">
        <?php if (empty($ingredientes)) { ?>
            <p>Nenhum ingrediente encontrado.</p>
        <?php } else { ?>
            <?php foreach ($ingredientes as $ingrediente) { ?>
                <div class="card-wrapper">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($ingrediente['imagem_ingrediente']); ?>" alt="Ingrediente Image">
                        <div class="container">
    <h3 title="<?php echo htmlspecialchars($ingrediente['nome_ingrediente']); ?>"> 
        <?php 
            $nome_ingrediente = htmlspecialchars($ingrediente['nome_ingrediente']); 
            echo mb_strlen($nome_ingrediente) > 16 ? mb_substr($nome_ingrediente, 0, 16) . '...' : $nome_ingrediente; 
        ?>
    </h3>
    <br>
    <button class="button-short" data-id="<?php echo htmlspecialchars($ingrediente['id_ingrediente']); ?>" data-name="<?php echo htmlspecialchars($ingrediente['nome_ingrediente']); ?>" style="margin-bottom: 10px;">Adicionar</button>
</div>

                    </div>
                </div>
            <?php } ?>
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

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="cart-container">
        <div class="cart-header">
            <h4><br>Carrinho<br><br></h4>
            <span id="closeCart" class="cart-close">&times;</span>
        </div>
        <ul id="cartItems" class="cart-items"></ul>
        <div>
            <button id="pesquisarReceitaButton" class="btn btn-primary button-long" target="_blank">Pesquisar Receita</button>
        </div>
    </div>

    <script id="cartItemTemplate" type="text/x-custom-template">
        <li>
            <span class="item-name"></span>
            <span class="item-id" style="margin-left: 10px;"></span>
            <button class="button-short remove-from-cart" style="margin-left: auto;">Remover</button>
        </li>
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            var cartItemsArray = [];

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

            function addToCart(itemName, itemId) {
                cartItemsArray.push({name: itemName, id: itemId});
                addCartItemToDOM(itemName, itemId);
                saveCart();
            }

            function addCartItemToDOM(itemName, itemId) {
                var template = $('#cartItemTemplate').html();
                var newItem = $(template);
                newItem.find('.item-name').text(itemName);
                newItem.find('.item-id').text(itemId);
                $('#cartItems').append(newItem);
            }

            $('#cartButton').on('click', function() {
                var cartSidebar = $('#cartSidebar');
                var isVisible = cartSidebar.css('right') === '0px'; // Verifica se está visível
                cartSidebar.css('right', isVisible ? '-300px' : '0'); // Se visível, esconde; caso contrário, mostra
                loadCart(); // Carrega os itens do carrinho ao abrir
            });

            $('#closeCart').on('click', function() {
                $('#cartSidebar').css('right', '-300px'); // Esconde o carrinho
            });

            $('#cartItems').on('click', '.remove-from-cart', function() {
                var itemName = $(this).siblings('.item-name').text();
                var itemId = $(this).siblings('.item-id').text();
                cartItemsArray = cartItemsArray.filter(item => !(item.name === itemName && item.id == itemId));
                saveCart();
                $(this).parent().remove();
            });

            $('#pesquisarReceitaButton').on('click', function() {
                var selectedIngredients = cartItemsArray.map(item => item.name);
                var url = "listagem_receita_ingrediente.php=" + encodeURIComponent(selectedIngredients.join(','));
                window.open(url, '_blank');
            });


            $('.button-short').click(function(){
                var itemName = $(this).data('name');
                var itemId = $(this).data('id');
                if (!cartItemsArray.some(item => item.name === itemName && item.id == itemId)) {
                    addToCart(itemName, itemId);
                } else {
                    alert("Este ingrediente já foi adicionado ao carrinho.");
                }
            });

            loadCart(); // Carrega os itens do carrinho na inicialização
        });
    </script>
</body>
</html>
