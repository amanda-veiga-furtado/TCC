<?php
session_start();
ob_start();

include_once '../conexao.php';
include '../css/frontend.php';
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
    <div class="container_background_image_grow">
        <div class="container_whitecard_grow">
            <div class="container_form">
                <div class="form-title-big">
                    <button style="font-size: 31px;">Receitas Compatíveis Com Sua Pesquisa</button>
                    <div class="toggle-line-big"></div>
                </div>

                <!-- Caixa de Pesquisa -->
                <div style="position: relative; width: 90%; align-items: center;">
                    <form method="GET" action="">
                        <input type="text" name="search" id="search" placeholder="Pesquisar Receita ou Categoria" 
                               style="width: 100%; padding-right: 40px; height: 40px; border-radius: 8px; 
                               border: 1px solid #ccc; box-sizing: border-box;">
                        <button type="submit" class="button-search" 
                                style="position: absolute; right: 0; top: 0; height: 40px; width: 10%; 
                                border-radius: 0 8px 8px 0; border: none;">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>

                <?php
                // Captura a busca do usuário
                $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

                // Página atual
                $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $pagina = !empty($pagina_atual) ? $pagina_atual : 1;

                // Limite de resultados por página
                $limite_resultado = 5;

                // Calcular ponto inicial para consulta
                $inicio = ($limite_resultado * $pagina) - $limite_resultado;

                try {
                    // Consulta para buscar receitas com base na busca
                    $query_receita = "SELECT r.id_receita, r.nome_receita, r.numeroPorcao_receita, 
                    p.nome_singular_porcao, p.nome_plural_porcao, 
                    r.tempoPreparoHora_receita, r.tempoPreparoMinuto_receita, 
                    r.modoPreparo_receita, r.imagem_receita, 
                    c.nome_categoria_culinaria, r.fk_id_usuario
                    FROM receita r
                    LEFT JOIN categoria_culinaria c ON r.categoria_receita = c.id_categoria_culinaria
                    JOIN porcao_quantidade p ON r.tipoPorcao_receita = p.id_porcao
                    WHERE (r.nome_receita LIKE :search 
                    OR c.nome_categoria_culinaria LIKE :search)
                    OR r.categoria_receita IS NULL
                    LIMIT :inicio, :limite";
  
  
                    
                    $result_receita = $conn->prepare($query_receita);
                    $search_param = "%{$search}%";
                    $result_receita->bindParam(':search', $search_param, PDO::PARAM_STR);
                    $result_receita->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                    $result_receita->bindParam(':limite', $limite_resultado, PDO::PARAM_INT);
                    $result_receita->execute();
                   
                    if ($result_receita->rowCount() > 0) {
                        while ($row_receita = $result_receita->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_receita);

                            // Certifique-se de que os valores não são nulos
                            $nome_receita = $nome_receita ?? 'Nome da Receita Indisponível';
                            $numeroPorcao_receita = $numeroPorcao_receita ?? 'Porção Indisponível';
                            $tempoPreparoHora_receita = $tempoPreparoHora_receita ?? '0';
                            $tempoPreparoMinuto_receita = $tempoPreparoMinuto_receita ?? '0';
                            $imagem_receita = $imagem_receita ?? 'caminho/default_image.jpg';
                            $categoria_receita = $nome_categoria_culinaria ?? 'Categoria não disponível';

                            $numeroPorcao = intval($numeroPorcao_receita);

                            // Verificar quantidade de porções para determinar plural ou singular
                            $porcao_nome = ($numeroPorcao_receita > 1) ? $nome_plural_porcao : $nome_singular_porcao;

                            $nome_receita = (strlen($nome_receita) > 17) ? substr($nome_receita, 0, 17) . '...' : $nome_receita;

                            // Exibir as receitas e categorias encontradas
                            ?>
                            <div class="projcard-small">
                                <a href="registro_receita.php?id_receita=<?php echo htmlspecialchars($id_receita); ?>" 
                                   style="text-decoration: none; display: block;">
                                    <div class="projcard-innerbox">
                                        <img class="projcard-img" src="<?php echo htmlspecialchars($imagem_receita); ?>" 
                                             alt="Imagem da receita">
                                        <div class="projcard-textbox">
                                            <div class="projcard-title" style="color: var(--cinza-secundario); margin-bottom: 10px; margin-top: 10px" title="<?php echo htmlspecialchars($nome_receita); ?>">
                                                <?php echo htmlspecialchars($nome_receita); ?>
                                            </div>

                                            <div class="projcard-subtitle">
                                                <?php echo '<i class="fa-solid fa-utensils" style="color: #fe797b;"></i>&nbsp' 
                                                . htmlspecialchars($numeroPorcao) . " " 
                                                . htmlspecialchars($porcao_nome) . '<span style="margin-left: 10px;"></span><i class="fa-solid fa-clock" style="color: #ffb750;"></i>&nbsp' . htmlspecialchars($tempoPreparoHora_receita) . "h e " . htmlspecialchars($tempoPreparoMinuto_receita) . "min"; ?>
                                            </div>
                                            <div class="projcard-bar"></div>
                                            <div class="projcard-description">
                                                <?php 
                                                echo '<div style="margin-bottom: 5px;">' . 
                                                '<i class="fa-solid fa-bookmark" style="color: #a587ca;"></i>&nbsp' . htmlspecialchars($categoria_receita) . 
                                                '</div>';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }

                        // Total de receitas para calcular a paginação
                        $query_total = "SELECT COUNT(*) as total FROM receita 
                                        JOIN categoria_culinaria c ON receita.categoria_receita = c.id_categoria_culinaria 
                                        WHERE receita.nome_receita LIKE :search 
                                        OR c.nome_categoria_culinaria LIKE :search";
                        $result_total = $conn->prepare($query_total);
                        $result_total->bindParam(':search', $search_param, PDO::PARAM_STR);
                        $result_total->execute();
                        $row_total = $result_total->fetch(PDO::FETCH_ASSOC);
                        $total_receitas = $row_total['total'];

                        // Calcular o número total de páginas
                        $total_paginas = ceil($total_receitas / $limite_resultado);

                        echo '<div class="pagination">';
                        if ($pagina > 1) {
                            echo '<a href="?search=' . urlencode($search) . '&page=' . ($pagina - 1) . '">Anterior</a>';
                        }

                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina) {
                                echo '<strong>' . $i . '</strong>';
                            } else {
                                echo '<a href="?search=' . urlencode($search) . '&page=' . $i . '">' . $i . '</a>';
                            }
                        }

                        if ($pagina < $total_paginas) {
                            echo '<a href="?search=' . urlencode($search) . '&page=' . ($pagina + 1) . '">Próximo</a>';
                        }
                        echo '</div>';
                    } else {
                        $_SESSION['mensagem'] = "Nenhuma receita compatível encontrada.";
                    }
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    echo '<p>Ocorreu um erro ao buscar as receitas. Por favor, tente novamente mais tarde.</p>';
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    echo '<p>Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
        // Display session message, if any
        if (isset($_SESSION['mensagem'])) {
            echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
            unset($_SESSION['mensagem']);
        }
    ?>
</body>
</html>
