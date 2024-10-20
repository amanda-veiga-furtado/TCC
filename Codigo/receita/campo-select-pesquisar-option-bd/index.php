<?php
    session_start();
    ob_start();

    include_once '../../conexao.php';
    include_once '../../css/functions.php';

    // Query para buscar os ingredientes
    $query = "SELECT id_ingrediente, nome_ingrediente FROM ingrediente";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $nome_ingredientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_ingrediente = $_POST['ingrediente'];

        // Query para buscar detalhes do ingrediente selecionado
        $query = "SELECT * FROM ingrediente WHERE id_ingrediente = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id_ingrediente, PDO::PARAM_INT);
        $stmt->execute();
        $nome_ingrediente_selecionado = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Seleção de Ingrediente</title>
    </head>
    <body>
        <div class="container_background_image_medium">
            <div class="whitecard_form_type_1">
                <div class="container_form">
                    <form method="POST" action="">
                        <input type="text" name="nome_usuario" id="nome_usuario" placeholder="Nome de Usuario" required>
                        
                        <!-- <label for="ingrediente">Escolha um ingrediente:</label> -->
                        <select name="ingrediente" id="ingrediente" class="js-example-basic-single" style="" required>
                            <option value="" disabled selected></option>
                                <?php
                                    foreach ($nome_ingredientes as $nome_ingrediente): 
                                ?>
                            <option value="
                                <?= $nome_ingrediente['id_ingrediente']; 
                                ?>"><?= htmlspecialchars($nome_ingrediente['nome_ingrediente']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <br><button type="submit">Buscar</button>
                    </form>
                <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2({
                    placeholder: "Digite o Nome do Ingrediente e Selecione", // Placeholder para pesquisa
                    allowClear: true
                });
            });
        </script>
                </div>
            </div>
        </div>
    </body>
</html>
