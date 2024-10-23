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

if ($pesquisar) {
    // Prepara a query para contar o número de registros encontrados pela pesquisa no nome do ingrediente ou nome da categoria
    $stmt = $conn->prepare("
        SELECT COUNT(*) 
        FROM ingrediente 
        LEFT JOIN categoria_ingrediente ON ingrediente.fk_id_categoria_ingrediente = categoria_ingrediente.id_categoria_ingrediente 
        WHERE nome_ingrediente LIKE :pesquisar OR nome_categoria_ingrediente LIKE :pesquisar
    ");

    $stmt->bindValue(':pesquisar', "%$pesquisar%", PDO::PARAM_STR);
    } 
else {
    // Contar todos os registros sem filtro
    $stmt = $conn->query("
    SELECT COUNT(*) 
    FROM ingrediente 
    INNER JOIN categoria_ingrediente ON ingrediente.fk_id_categoria_ingrediente = categoria_ingrediente.id_categoria_ingrediente
    ");
}

$stmt->execute(); // Executa a query
$total_ingrediente = $stmt->fetchColumn(); // Obtém o número total de registros
$num_pagina = ceil($total_ingrediente / $quantidade_pg); // Calcula o número total de páginas

if ($pesquisar) {
    // Prepara a query para buscar ingredientes pelo nome ou pela categoria, com prioridade para ingredientes
    $stmt = $conn->prepare("
        SELECT ingrediente.*, categoria_ingrediente.nome_categoria_ingrediente, 
            CASE 
                WHEN nome_ingrediente LIKE :pesquisar THEN 1 
                ELSE 2 
            END AS prioridade
        FROM ingrediente 
        LEFT JOIN categoria_ingrediente ON ingrediente.fk_id_categoria_ingrediente = categoria_ingrediente.id_categoria_ingrediente 
        WHERE nome_ingrediente LIKE :pesquisar OR nome_categoria_ingrediente LIKE :pesquisar
        ORDER BY prioridade, nome_ingrediente
        LIMIT :inicio, :quantidade_pg
        ");
        $stmt->bindValue(':pesquisar', "%$pesquisar%", PDO::PARAM_STR);
    } else {
        // Prepara a query para buscar todos os ingredientes com limite de paginação
        $stmt = $conn->prepare("
            SELECT ingrediente.*, categoria_ingrediente.nome_categoria_ingrediente 
            FROM ingrediente 
            LEFT JOIN categoria_ingrediente ON ingrediente.fk_id_categoria_ingrediente = categoria_ingrediente.id_categoria_ingrediente 
            LIMIT :inicio, :quantidade_pg
        ");
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
            flex: 0 1 calc(33.33% - 20px); /* 3 cards por linha com espaço entre eles */
            margin: 10px; /* Ajuste a margem conforme necessário */
            box-sizing: border-box; /* Para garantir que a largura do card inclui a margem 

            box-shadow: 2 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 20px;
            height: 300px; 
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
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* ou space-around */
            margin: 0 -10px; /* Ajuste conforme a margem desejada */

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

        .card-container.less-than-six .card {
            flex: 0 1 calc(33.33% - 20px); /* Define a largura dos cards quando há menos de 6 */
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
                    <label for="exampleInputName2" class="sr-only"></label>
                        <input type="text" name="pesquisar" id="exampleInputName2" placeholder="Pesquisar Ingrediente ou Tipo de Ingrediente" style="width: 100%; padding-left: 12px; padding-right: 40px; height: 40px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px;" value="<?php echo htmlspecialchars($pesquisar); ?>">
                        <button type="submit" class="button-search" style="position: absolute; right: 0; top: 0; height: 40px; width: 10%; border-radius: 0 8px 8px 0;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div style="display: flex; justify-content: center; align-items: center;">
            <div class="form-title-big" style="margin-top: 20px; margin-bottom: 0px; margin-left: 7px;" >
                <!-- style="margin:3%;" -->
                <button id="cartButton">
                    <i class="fa-solid fa-cart-shopping" id="cartIcon" style="color: #36cedc;"></i>
                </button>
            </div> 
        </div>
    </div>

    <div class="container_cards">
        <?php if (empty($ingredientes)) {
            $_SESSION['mensagem'] = "Nenhum ingrediente encontrado.";

 } else { ?>
            <?php foreach ($ingredientes as $ingrediente) { ?>
                <div class="card-wrapper">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($ingrediente['imagem_ingrediente']); ?>" alt="Ingrediente Image">
                        <div class="container">
                        <h3 title="<?php 
    echo htmlspecialchars($ingrediente['nome_ingrediente']); 
    if (!empty($ingrediente['nome_categoria_ingrediente'])) {
        echo ' - ' . htmlspecialchars($ingrediente['nome_categoria_ingrediente']);
    }
?>"> 
    <?php 
        $nome_ingrediente = htmlspecialchars($ingrediente['nome_ingrediente']); 
        echo mb_strlen($nome_ingrediente) > 15 ? mb_substr($nome_ingrediente, 0, 16) . '...' : $nome_ingrediente;
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
        <span id="closeCart" class="cart-close"><i class="fa-solid fa-square-xmark"></i></span>
        <div class="cart-header" >
            <div class="form-title-big"  >
                <button style="margin-left: auto;margin-right: auto; font-size: 30px;">Carrinho</button>
                <!-- linha -->


                <div style="position: absolute; top: 10; bottom: -5px; left: 85%; width: 85%; height: 3px; background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario)); 
 transition: transform 0.3s; transform: translateX(-91%);"></div>
            </div>
        </div>
<!-- 
        <div class="cart-header">
    <div class="form-title-big" style="margin-bottom: 0;">
        <button style="margin: 0 auto; font-size: 30px; display: block;">Carrinho</button>
        <div style="position: relative; margin-top: -5px; width: 85%; height: 3px; background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario)); 
        transition: transform 0.3s; transform: translateX(0); margin-left: auto; margin-right: auto;"></div>
    </div>
</div> -->


        <ul id="cartItems" class="cart-items"></ul>
        <div>
            <button id="pesquisarReceitaButton" class="btn btn-primary button-long" target="_blank">Pesquisar Receita</button>
        </div>
    </div>

    <script id="cartItemTemplate" type="text/x-custom-template">
        <li>
            <span class="item-name"></span>
            <span class="item-id" style="margin-left: 10px;"></span>
            <button class="button remove-from-cart" style=" padding: 6px;  border: none; border-radius: 8px; margin-left: auto; margin-bottom:10px; color: white;                 font-size: 16px;justify-content: center;                align-items: center; 
            text-align: center; 
            
             background-color: var(--laranja-primario);              
                
               
                
                cursor: pointer;
                transition: background-color 0.3s;
                margin-left: auto; margin-right: 0;
                 ">Remover</button>
        </li>
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


    const cartItemsArray = []; // Array para armazenar itens do carrinho

    $(document).ready(function(){
            var cartItemsArray = [];

            function saveCart() {
                sessionStorage.setItem('cartItems', JSON.stringify(cartItemsArray));
            }



function loadCart() {
    // Limpa os itens existentes na lista do carrinho
    $('#cartItems').empty();
    var storedCartItems = sessionStorage.getItem('cartItems');
    if (storedCartItems) {
        cartItemsArray = JSON.parse(storedCartItems);
        cartItemsArray.forEach(function(item) {
            addCartItemToDOM(item.name, item.id);
            // Desabilita o botão "Adicionar" para os itens que já estão no carrinho
            $('button[data-id="' + item.id + '"]')
                .prop('disabled', true)
                .html('<i class="fa-solid fa-cart-shopping" style="color: #8f8f8f;"></i>') // Usando html para incluir o ícone
                .css('background-color', '#f9f9f9') // Mudando a cor de fundo para um tom de cinza claro
                .attr('title', 'Ingrediente já adicionado'); // Definindo o título (tooltip)
        });
    } else {
        // Adicionar ingredientes padrão ao carrinho somente uma vez
        addDefaultIngredientsToCart();
    }
}

function addDefaultIngredientsToCart() {
    <?php
    // Mantém os ingredientes padrão como um array
    $ingredientesPadrao = [];
    $stmt = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente WHERE id_ingrediente IN 
        (94, 396, 97, 98, 393, 394, 395, 189, 275, 276, 277, 215)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ingredientesPadrao[] = $row;
    }

    ?>

    <?php foreach ($ingredientesPadrao as $ingrediente) { ?>
        // Adiciona os ingredientes padrão somente se ainda não estiverem no carrinho
        if (!cartItemsArray.some(item => item.id == <?php echo htmlspecialchars($ingrediente['id_ingrediente']); ?>)) {
            addToCart('<?php echo htmlspecialchars($ingrediente['nome_ingrediente']); ?>', <?php echo htmlspecialchars($ingrediente['id_ingrediente']); ?>);
        }
    <?php } ?>
}

// function addToCart(itemName, itemId) {
    // Verifica se o ingrediente já está no carrinho
//     if (!cartItemsArray.some(item => item.id == itemId)) {
//         cartItemsArray.push({name: itemName, id: itemId});
//         addCartItemToDOM(itemName, itemId);
//         saveCart();

//                 // Desabilita o botão "Adicionar" após a adição ao carrinho
//                 $('button[data-id="' + item.id + '"]')
//     .prop('disabled', true)
//     .html('<i class="fa-solid fa-cart-shopping" style="color: #8f8f8f;"></i>') // Usando html para incluir o ícone
//     .css('background-color', '#f9f9f9') // Mudando a cor de fundo para um tom de cinza claro
//     .attr('title', 'Ingrediente já Adicionado'); // Definindo o título (tooltip)


//     } else {
//         alert("Este ingrediente já foi adicionado ao carrinho.");
//     }
// }
function addToCart(itemName, itemId) {
    // Verifica se o ingrediente já está no carrinho
    if (!cartItemsArray.some(item => item.id == itemId)) {
        cartItemsArray.push({name: itemName, id: itemId});
        addCartItemToDOM(itemName, itemId);
        saveCart();
        disableAddButton(itemId); // Desabilita o botão após adicionar ao carrinho
    } else {
        alert("Este ingrediente já foi adicionado ao carrinho.");
    }
}
function disableAddButton(itemId) {
    // Desabilita o botão "Adicionar" para um determinado item
    $('button[data-id="' + itemId + '"]')
        .prop('disabled', true)
        .html('<i class="fa-solid fa-cart-shopping" style="color: #8f8f8f;"></i>') // Usando html para incluir o ícone
        .css('background-color', '#f9f9f9') // Mudando a cor de fundo para um tom de cinza claro
        .attr('title', 'Ingrediente já Adicionado'); // Definindo o título (tooltip)
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
                // updateSearchButtonState(); 
                // Atualiza o estado do botão após remover item

            });


$('#pesquisarReceitaButton').on('click', function() {
    console.log(cartItemsArray); // Verifica o conteúdo do array
    if (cartItemsArray.length === 0) {
        alert("Adicione ao menos um ingrediente antes de pesquisar."); // Alerta se o carrinho estiver vazio
        return false; // Impede o redirecionamento
    }

    // Coleta os IDs dos ingredientes selecionados
    var selectedIngredients = cartItemsArray.map(item => item.id);
    
    // Forma a URL para enviar os IDs como um array
    var url = "listagem_receita_ingrediente.php?ingredientes=" + encodeURIComponent(selectedIngredients.join(','));
    window.open(url, '_blank');
});






$('.button-short').click(function() {
    var itemName = $(this).data('name');
    var itemId = $(this).data('id');

    // Verifica se o ingrediente já está no carrinho
    if (!cartItemsArray.some(item => item.name === itemName && item.id == itemId)) {
        addToCart(itemName, itemId);
    } else {
        alert("Este ingrediente já foi adicionado ao carrinho.");
    }
});


            loadCart(); // Carrega os itens do carrinho na inicialização
        });
        function getCartItems() {
    const selectedIngredients = [];
    const checkboxes = document.querySelectorAll('input[name="ingredient"]:checked');
    checkboxes.forEach((checkbox) => {
        selectedIngredients.push({
            id: checkbox.value,
            name: checkbox.nextSibling.nodeValue.trim() // obtém o nome do ingrediente
        });
    });
    return selectedIngredients;
}
// window.addEventListener('beforeunload', function() {
//     sessionStorage.removeItem('cartItems');
// });
window.addEventListener('unload', function() {
       if (sessionStorage.getItem('cartClosed')) {
           localStorage.removeItem('cartItems'); // Limpa o carrinho ao fechar a página
           sessionStorage.removeItem('cartClosed'); // Limpa o flag de fechamento
       }
   });

    </script>
            <?php
            if (isset($_SESSION['mensagem'])) {
                echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
                unset($_SESSION['mensagem']);
            }
        ?>
</body>
</html>
