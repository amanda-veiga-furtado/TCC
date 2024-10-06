<?php
include_once '../conexao.php';
include_once '../menu.php'; 
include '../css/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cadastrados</title>
    <link rel="stylesheet" href="style.css"> <!-- Adicione seu CSS -->
</head>
<body>
    <div class="container_form_type_2">  
        <div class="whitecard_form_type_2">      
            <div class="div_form">
                <div class="form-toggle2">
                    <button>Lista de Cadastrados</button>
                    <div class="toggle-line-big"></div>
                </div>
                <?php
                // Paginação
                $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $pagina = ($pagina_atual && $pagina_atual > 0) ? $pagina_atual : 1;
                $limite_resultado = 5;
                $inicio = ($limite_resultado * $pagina) - $limite_resultado;

                $query_usuario = "SELECT id_usuario, nome_usuario, email_usuario FROM usuario LIMIT :inicio, :limite";
                $result_usuario = $conn->prepare($query_usuario);
                $result_usuario->bindValue(':inicio', $inicio, PDO::PARAM_INT);
                $result_usuario->bindValue(':limite', $limite_resultado, PDO::PARAM_INT);
                $result_usuario->execute();

                if ($result_usuario->rowCount() > 0) {                            
                    while ($row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_usuario);
                        echo "<p>ID: $id_usuario</p>";
                        echo "<p>Nome de Usuário: $nome_usuario</p>";
                        echo "<p>Email: $email_usuario</p><br>";
                        echo "<a href='registro_usuario.php?id_usuario=$id_usuario' class='button-short'>Visualizar</a>";
                        echo "<br><br><hr><br>"; // Linha divisória
                    }

                    // Contar a quantidade de registros no BD
                    $query_qnt_registros = "SELECT COUNT(id_usuario) AS num_result FROM usuario";
                    $result_qnt_registros = $conn->prepare($query_qnt_registros);
                    $result_qnt_registros->execute();
                    $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);
                    $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);
                    $maximo_link = 2;

                    echo "<div class='pagination'>";
                    echo "<a href='registro_cadastrar.php?page=1'>Primeira</a> ";

                    for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                        if ($pagina_anterior >= 1) {
                            echo "<a href='registro_cadastrar.php?page=$pagina_anterior'>$pagina_anterior</a> ";
                        }
                    }

                    echo "<a href='#' class='current'>$pagina</a> ";

                    for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                        if ($proxima_pagina <= $qnt_pagina) {
                            echo "<a href='registro_cadastrar.php?page=$proxima_pagina'>$proxima_pagina</a> ";
                        }
                    }

                    echo "<a href='registro_cadastrar.php?page=$qnt_pagina'>Última</a> ";
                    echo "</div>";
                } else {
                    echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
