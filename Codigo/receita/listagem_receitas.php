<?php
    session_start();
    ob_start();

    include_once '../conexao.php';
    include '../css/functions.php';
    include_once '../menu.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Receitas Compatíveis Com Sua Pesquisa</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .projcard-container {
            margin: 15px 0; /*Margem vertical*/
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .projcard-container,
        .projcard-container * {
            box-sizing: border-box;
        }
        .projcard-container {
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }
        .projcard {
            position: relative;
            width: 90%;
            height: 300px;
            margin-bottom: 30px;
            border-radius: 10px;
            background-color: #fff;
            border: 2px solid #ddd;
            font-size: 18px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 21px -12px rgba(0, 0, 0, .66);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .projcard:hover {
            box-shadow: 0 34px 32px -33px rgba(0, 0, 0, .18);
            transform: translate(0px, -3px);
        }
        .projcard::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            /* background-image: linear-gradient(-70deg, #424242, transparent 50%); */
            opacity: 0.07;
        }
        .projcard-innerbox {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
        .projcard-img {
            position: absolute;
            height: 100%;
            width: 40%; /* Define que a imagem ocupará 40% do cartão */
            top: 0;
            left: 0;
            transition: transform 0.2s ease;
        }
        .projcard:nth-child(2n) .projcard-img {
            left: initial;
            right: 0;
        }
        .projcard-textbox {
            position: absolute;
            top: 7%;
            bottom: 7%;
            left: calc(40% + 30px); /* Ajusta a posição do texto para após a imagem */
            width: calc(60% - 30px); /* Define que o texto ocupará 60% */
            font-size: 17px;
            padding-right: 30px; /* Adicionando espaço à direita */   
        }
        .projcard:nth-child(2n) .projcard-textbox {
            left: 0; /* Alinha o texto à esquerda */
            right: calc(60% + 30px); /* Mantém o texto dentro do cartão */
            padding-left: 30px; /* Adiciona espaço à esquerda */
        }
        .projcard-textbox::before,
        .projcard-textbox::after {
            content: "";
            position: absolute;
            display: block;
            background: #ff0000bb;
            background: #fff;
            top: -20%;
            left: -55px;
            height: 140%;
            width: 60px;
            transform: rotate(8deg);
        }
        .projcard:nth-child(2n) .projcard-textbox::before {
            display: none;
        }
        .projcard-textbox::after {
            display: none;
            left: initial;
            right: -55px;
        }
        .projcard:nth-child(2n) .projcard-textbox::after {
            display: block;
        }
        .projcard-textbox * {
            position: relative;
        }
        .projcard-title {
            font-size: 24px;
        }
        .projcard-subtitle {
            color: #888;
        }
        .projcard-bar {
            left: -2px;
            width: 100%;
            height: 3px;
            margin: 10px 0;
            border-radius: 5px;
            background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Gradiente linear aplicado */
            transition: transform 0.3s;
        }
        .toggle-line-small {
                        position: absolute;
                        bottom: -5px;
                        left: 0;
                        width: 50%;
                    }
        .projcard-description,
        projcard-description:nth-child(2n){
            z-index: 10;
            font-size: 16px;
            color: #888;
            height: 125px;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: justify;
            text-justify: inter-word;
        }
        .projcard-tagbox {
            position: absolute;
            bottom: 3%;
            font-size: 14px;
            cursor: default;
            user-select: none;
            pointer-events: none;
        }
        .projcard-tag {
            display: inline-block;
            background: #E0E0E0;
            color: #777;
            border-radius: 3px 0 0 3px;
            line-height: 26px;
            padding: 0 10px 0 23px;
            position: relative;
            margin-right: 20px;
            cursor: default;
            user-select: none;
            transition: color 0.2s;
        }
        .projcard-tag::before {
            content: '';
            position: absolute;
            background: #fff;
            border-radius: 10px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
            height: 6px;
            left: 10px;
            width: 6px;
            top: 10px;
        }
        .projcard-tag::after {
            content: '';
            position: absolute;
            border-bottom: 13px solid transparent;
            border-left: 10px solid #E0E0E0;
            border-top: 13px solid transparent;
            right: -10px;
            top: 0;
        }
    </style>
</head>
<body>
    <div class="container_form_type_2">
        <div class="whitecard_form_type_2">
            <div class="div_form">
                <div class="form-toggle2">
                    <button>Receitas Compatíveis Com Sua Pesquisa</button>
                    <div class="toggle-line-big"></div>
                </div>
                <!-- Caixa de Pesquisa -->
                <div style="position: relative; width: 90%; align-items: center;">
                    <input type="text" name="search" id="search" placeholder="Pesquisar Receita.." style="width: 100%; padding-right: 40px; height: 40px; border-radius: 8px; border: 1px solid #ccc; box-sizing: border-box;">

                    <button type="submit" class="button-search" style="position: absolute; right: 0; top: 0; height: 40px; width: 10%; border-radius: 0 8px 8px 0; border: none;">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <?php
                // Get the current page number from the URL, default to 1 if not set
                $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $pagina = !empty($pagina_atual) ? $pagina_atual : 1;

                // Set the number of records per page
                $limite_resultado = 5;

                // Calculate the starting point for the query
                $inicio = ($limite_resultado * $pagina) - $limite_resultado;

                try {
                    // Prepare and execute the query to fetch the recipes
                    // $query_receita = "SELECT id_receita, nome_receita, numeroPorcao_receita, tipoPorcao_receita, tempoPreparoHora_receita, tempoPreparoMinuto_receita, modoPreparo_receita, imagem_receita, categoria_receita, fk_id_usuario FROM receita LIMIT :inicio, :limite";
                    $query_receita = "SELECT r.id_receita, r.nome_receita, r.numeroPorcao_receita, r.tipoPorcao_receita, r.tempoPreparoHora_receita, r.tempoPreparoMinuto_receita, r.modoPreparo_receita, r.imagem_receita, c.nome_categoria_culinaria, r.fk_id_usuario
                    FROM receita r
                    JOIN categoria_culinaria c ON r.categoria_receita = c.id_categoria_culinaria
                    LIMIT :inicio, :limite";
                    $result_receita = $conn->prepare($query_receita);
                    $result_receita->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                    $result_receita->bindParam(':limite', $limite_resultado, PDO::PARAM_INT);
                    $result_receita->execute();
                   
                    if ($result_receita->rowCount() > 0) {
                        while ($row_receita = $result_receita->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_receita);

                            // Certifique-se de que os valores não são nulos
                            $nome_receita = $nome_receita ?? 'Nome da Receita Indisponível';
                            $numeroPorcao_receita = $numeroPorcao_receita ?? 'Porção Indisponível';
                            $tipoPorcao_receita = $tipoPorcao_receita ?? 'Tipo Indisponível';
                            $tempoPreparoHora_receita = $tempoPreparoHora_receita ?? '0';
                            $tempoPreparoMinuto_receita = $tempoPreparoMinuto_receita ?? '0';
                            $modoPreparo_receita = $modoPreparo_receita ?? 'Modo de preparo não disponível';
                            $imagem_receita = $imagem_receita ?? 'caminho/default_image.jpg'; // Imagem padrão se for nula
                            $categoria_receita = $nome_categoria_culinaria ?? 'Categoria não disponível'; // Agora usando o nome da categoria


                            // Verifica se o ID da receita é par ou ímpar
                            if ($id_receita % 2 == 0) {
                                // Card Tipo 2 para IDs pares
                                ?>
                                <div class="projcard">
                                    <div class="projcard-innerbox">
                                        <img class="projcard-img" src="<?php echo htmlspecialchars($imagem_receita); ?>" alt="Imagem da receita">
                                        <div class="projcard-textbox">
                                            <div class="projcard-title"><?php echo htmlspecialchars($nome_receita); ?></div>
                                            
                                            <div class="projcard-subtitle"><?php echo '<i class="fa-solid fa-utensils" style="color: #fe797b;"></i> ' . htmlspecialchars($numeroPorcao_receita) . " " . htmlspecialchars($tipoPorcao_receita) . '<span style="margin-left: 10px;"></span><i class="fa-solid fa-clock" style="color: #ffb750;"></i> ' . htmlspecialchars ($tempoPreparoHora_receita) . "h e " .($tempoPreparoMinuto_receita) . "min"; ?></div>
                                            <div class="projcard-bar"></div>
                                            <div class="projcard-description">
   
                                            <?php 
    echo '<i class="fa-solid fa-bookmark fa" style="color: #a587ca;"></i> ' . htmlspecialchars($categoria_receita) . '<span style="margin-left: 10px;"></span><i class="fa-solid fa-user fa" style="color: #36cedc;"></i> ' . htmlspecialchars($fk_id_usuario); 
    ?>

                                            </div>


                                            
                                            <div class="projcard-description"><?php echo htmlspecialchars($modoPreparo_receita); ?></div>
                                            <div class="projcard-tagbox">
                                                <span class="projcard-tag">Tempo de preparo: <?php echo htmlspecialchars($tempoPreparoHora_receita) . " hora(s) e " . htmlspecialchars($tempoPreparoMinuto_receita) . " minuto(s)"; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                // Card Tipo 1 para IDs ímpares
                                ?>
                                <div class="projcard">
                                    <div class="projcard-innerbox">
                                        <img class="projcard-img" src="<?php echo htmlspecialchars($imagem_receita); ?>" alt="Imagem da receita">
                                        <div class="projcard-textbox">
                                            <div class="projcard-title"><?php echo htmlspecialchars($nome_receita); ?></div>
                                            <div class="projcard-subtitle"><?php echo htmlspecialchars($numeroPorcao_receita) . " " . htmlspecialchars($tipoPorcao_receita); ?></div>
                                            <div class="projcard-bar"></div>
                                            <div class="projcard-description">
                                            <?php 
    echo '<i class="fa-solid fa-bookmark fa" style="color: #a587ca;"></i> ' . htmlspecialchars($categoria_receita) . '<span style="margin-left: 10px;"></span><i class="fa-solid fa-user fa" style="color: #36cedc;"></i> ' . htmlspecialchars($fk_id_usuario); 
    ?>
     </div>
                                          <div class="projcard-description"><?php echo htmlspecialchars($modoPreparo_receita); ?></div>
                                            <div class="projcard-tagbox">
                                                <span class="projcard-tag">Tempo de preparo: <?php echo htmlspecialchars($tempoPreparoHora_receita) . "h " . htmlspecialchars($tempoPreparoMinuto_receita) . "min"; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        // Total de receitas para calcular a paginação
                        $query_total = "SELECT COUNT(*) as total FROM receita";
                        $result_total = $conn->prepare($query_total);
                        $result_total->execute();
                        $total_registros = $result_total->fetch(PDO::FETCH_ASSOC)['total'];

                        // Total de páginas
                        $total_paginas = ceil($total_registros / $limite_resultado);

                        // Links de navegação
                        echo '<div class="pagination">';
                        if ($pagina > 1) {
                            echo '<a href="?page=' . ($pagina - 1) . '">Anterior</a>';
                        }

                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina) {
                                echo '<strong>' . $i . '</strong>'; // Página atual
                            } else {
                                echo '<a href="?page=' . $i . '">' . $i . '</a>';
                            }
                        }

                        if ($pagina < $total_paginas) {
                            echo '<a href="?page=' . ($pagina + 1) . '">Próximo</a>';
                        }
                        echo '</div>'; // Fecha div.pagination

                    } else {
                        echo '<p>Nenhuma receita encontrada.</p>';
                    }
                } catch (PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                }
                ?>
            </div>
            </div>
        </div>
</body>
</html>