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
</head>
<body>
    <div class="container_form_type_2">
    <div class="whitecard_form_type_2">
        <div class="form">
            <div class="form-toggle2">
                <button>Receitas Compatíveis Com Sua Pesquisa</button>
                <div class="toggle-line2"></div>
            </div>
        </div>
        <?php
        // Get the current page number from the URL, default to 1 if not set
        $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
        $pagina = !empty($pagina_atual) ? $pagina_atual : 1;

        // Set the number of records per page
        $limite_resultado = 2;

        // Calculate the starting point for the query
        $inicio = ($limite_resultado * $pagina) - $limite_resultado;

        try {
            // Prepare and execute the query to fetch the recipes
            $query_receita = "SELECT id_receita, nome_receita, imagem_receita FROM receita LIMIT :inicio, :limite";
            $result_receita = $conn->prepare($query_receita);
            $result_receita->bindParam(':inicio', $inicio, PDO::PARAM_INT);
            $result_receita->bindParam(':limite', $limite_resultado, PDO::PARAM_INT);
            $result_receita->execute();

            // Check if any recipes were found
            if ($result_receita->rowCount() > 0) {
                while ($row_receita = $result_receita->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_receita);
                    echo "<div class='receita-item'>";
                    echo "<h3>ID: $id_receita</h3>";
                    echo "<p>$nome_receita<br><br></p>";

                    // Assume 'imagem_receita' contains just the filename, prepend the correct directory path
                    $image_path = "../images/$imagem_receita";

                    // Check if an image is available
                    if (!empty($imagem_receita) && file_exists($image_path)) {
                        echo "<img src='$image_path' alt='Imagem da Receita' class='lista-receita-imagem'><br><br><br>";
                    } else {
                        echo "<p style='color: #f00;'>Nenhuma imagem disponível</p><br><br>";
                    }

                    echo "<a href='registro_receita.php?id_receita=$id_receita' class='botao'>Visualizar</a>";
            
                    echo "<br><br><hr><br>";
                    echo "</div>";
                }

                // Pagination logic
                $query_qnt_registros = "SELECT COUNT(id_receita) AS num_result FROM receita";
                $result_qnt_registros = $conn->prepare($query_qnt_registros);
                $result_qnt_registros->execute();
                $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

                $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);
                $maximo_link = 2;

                echo "<div class='pagination'>";
                echo "<a href='listagem_receitas.php?page=1'>Primeira</a> ";

                for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                    if ($pagina_anterior >= 1) {
                        echo "<a href='listagem_receitas.php?page=$pagina_anterior'>$pagina_anterior</a> ";
                    }
                }

                // echo "<a href='#'>$pagina</a> ";
                echo "<a href='#'>♡</a> ";

                

                for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                    if ($proxima_pagina <= $qnt_pagina) {
                        echo "<a href='listagem_receitas.php?page=$proxima_pagina'>$proxima_pagina</a> ";
                    }
                }

                echo "<a href='listagem_receitas.php?page=$qnt_pagina'>Última</a>";
                echo "</div>";
            } else {
                echo "<p style='color: #f00;'>Erro: Nenhuma receita encontrada!<br><br></p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color: #f00;'>Erro: {$e->getMessage()}</p>";
        }
        ?>
    </div>
    </div>
</body>
</html>
