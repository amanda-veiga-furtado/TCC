<?php
session_start();
ob_start();

include_once '../conexao.php';
include '../css/frontend.php';
include_once '../menu.php';
include_once '../menu_admin.php';

// Debug para verificar o conteúdo da sessão
// var_dump($_SESSION);

//Verificar se o usuário está logado e se é administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['statusAdministrador_usuario'] !== 'a') {
    //Redireciona para uma página de login
    $_SESSION['mensagem'] = "Acesso negado! Somente administradores podem acessar esta página.";
    header("Location: http://localhost/TCC/Codigo/usuario/login.php");
    exit(); // Para garantir que o restante da página não será carregado
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Receitas Cadastradas</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container_background_image_grow">
        <div class="container_whitecard_grow">
            <div class="container_form">
                <div class="form-title-big">
                    <button>Receitas Cadastradas</button>
                    <div class="toggle-line-big"></div>
                </div>

                <!-- Caixa de Pesquisa -->
                <div style="position: relative; width: 90%; align-items: center;">
                    <form method="GET" action="">
                        <input type="text" name="search" id="search" placeholder="Pesquisar Nome da Receita ou ou Palavras do Modo de Preparo"
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
                // Paginação e pesquisa      
                $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $pagina = !empty($pagina_atual) ? $pagina_atual : 1;
                $limite_resultado = 5;
                $inicio = ($limite_resultado * $pagina) - $limite_resultado;

                // $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
                // Pesquisa
                $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $search_param = '%' . ($search ?? '') . '%';




                try {
                    // Consulta para buscar receitas com base na busca
                    $query_receita = "SELECT r.id_receita, r.nome_receita, r.numeroPorcao_receita, 
                    p.nome_singular_porcao, p.nome_plural_porcao, 
                    r.tempoPreparoHora_receita, r.tempoPreparoMinuto_receita, 
                    r.modoPreparo_receita, r.imagem_receita, 
                    c.nome_categoria_culinaria, r.fk_id_usuario, u.nome_usuario
                    FROM receita r
                    LEFT JOIN categoria_culinaria c ON r.categoria_receita = c.id_categoria_culinaria
                    JOIN porcao_quantidade p ON r.tipoPorcao_receita = p.id_porcao
                    JOIN usuario u ON r.fk_id_usuario = u.id_usuario
                    WHERE (r.nome_receita LIKE :search 
                    OR r.modoPreparo_receita LIKE :search)
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
                            <div class="projcard">
                                <a href="registro_receita.php?id_receita=<?php echo htmlspecialchars($id_receita); ?>"
                                    style="text-decoration: none; display: block;">
                                    <div class="projcard-innerbox">
                                        <img class="projcard-img" src="<?php echo htmlspecialchars($imagem_receita); ?>"
                                            alt="Imagem da receita">
                                        <div class="projcard-textbox">
                                            <div class="projcard-title" style="color: var(--cinza-secundario); margin-bottom: 10px; margin-top: 10px"
                                                title="<?php echo htmlspecialchars($nome_receita); ?>">
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
                                                    '<i class="fa-solid fa-bookmark" style="color: #a587ca;"></i>&nbsp; ' .
                                                    '<span style="color: #8f8f8f;">' . htmlspecialchars($categoria_receita) . '</span>' .
                                                    '</div>';


                                                // Centralizar os botões
                                                echo '<div style="display: flex; justify-content: center; gap: 15px;">';

                                                // Botão "Deletar"
                                                // echo '<button class="button-orange" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px;">Deletar</button>';
                                                echo '<a href="deletar_receita.php?id_receita=' . htmlspecialchars($id_receita) . '" class="button-orange" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Deletar Receita Permanentemente">';
                                                echo '<i class="fa-solid fa-trash"></i>';
                                                echo '</a>';

                                                // Botão com link para o usuário
                                                echo '<a href="../usuario/registro_usuario.php?id_usuario=' . htmlspecialchars($fk_id_usuario) . '" class="button-yellow" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Ver criador da receita">';
                                                echo '<i class="fa-solid fa-user"></i>';
                                                echo '</a>';

                                                echo '<a href="registro_receita.php?id_receita=' . htmlspecialchars($id_receita) . '" class="button-yellow" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;"title="Ver Receita">';
                                                echo '<i class="fa-solid fa-spoon"></i>';
                                                echo '</a>';

                                                echo '</div>';
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
                        $inicio = max(1, $pagina - 2);  // Garantir que a página inicial não seja menor que 1
                        $fim = min($total_paginas, $pagina + 2);  // Garantir que a página final não ultrapasse o total de páginas

                        echo '<div class="pagination">';

                        // Link "Anterior"
                        if ($pagina > 1) {
                            echo '<a href="?page=' . ($pagina - 1) . '&search=' . urlencode($search ?? '') . '">Anterior</a>';
                        }

                        // Exibe os números das páginas, com ... quando necessário
                        if ($inicio > 1) {
                            echo '<a href="?page=1&search=' . urlencode($search ?? '') . '">1</a>';
                            if ($inicio > 2) {
                                echo '<span>...</span>'; // Páginas ocultas
                            }
                        }

                        for ($i = $inicio; $i <= $fim; $i++) {
                            if ($i == $pagina) {
                                echo '<a href="#" class="active">' . $i . '</a>'; // Página ativa
                            } else {
                                echo '<a href="?page=' . $i . '&search=' . urlencode($search ?? '') . '">' . $i . '</a>';
                            }
                        }

                        // Exibe a última página com ... quando necessário
                        if ($fim < $total_paginas) {
                            if ($fim < $total_paginas - 1) {
                                echo '<span>...</span>'; // Páginas ocultas
                            }
                            echo '<a href="?page=' . $total_paginas . '&search=' . urlencode($search ?? '') . '">' . $total_paginas . '</a>';
                        }

                        // Link "Próximo"
                        if ($pagina < $total_paginas) {
                            echo '<a href="?page=' . ($pagina + 1) . '&search=' . urlencode($search ?? '') . '">Próximo</a>';
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