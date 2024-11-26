<?php   
session_start(); // Inicia a sessão
ob_start();

include_once '../conexao.php'; 
include '../css/frontend.php';
include_once '../menu.php';

$id_receita = filter_input(INPUT_GET, "id_receita", FILTER_SANITIZE_NUMBER_INT); // Obtém o ID da receita da URL

if (empty($id_receita)) { // Verifica se o ID da receita está vazio
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Receita não encontrada!</p>";
    header("Location: listagem_receitas.php");
    exit();
}

try {
    // Query SQL para buscar os detalhes da receita
    $query_receita = "
        SELECT 
            r.id_receita, r.nome_receita, r.numeroPorcao_receita, r.tempoPreparoHora_receita, r.tempoPreparoMinuto_receita, r.modoPreparo_receita, r.imagem_receita,
            c.nome_categoria_culinaria,
            p.nome_singular_porcao, p.nome_plural_porcao,
            u.nome_usuario,
            u.id_usuario AS fk_id_usuario
        FROM 
            receita r
        JOIN 
            categoria_culinaria c ON r.categoria_receita = c.id_categoria_culinaria
        JOIN 
            porcao_quantidade p ON r.tipoPorcao_receita = p.id_porcao
        JOIN 
            usuario u ON r.fk_id_usuario = u.id_usuario
        WHERE 
            r.id_receita = :id_receita
    ";

    // Preparar e executar a query
    $result_receita = $conn->prepare($query_receita);
    $result_receita->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
    $result_receita->execute();

    // Verificar se a receita foi encontrada
    if ($result_receita && $result_receita->rowCount() > 0) {
        $row_receita = $result_receita->fetch(PDO::FETCH_ASSOC);
        $fk_id_usuario = $row_receita['fk_id_usuario'];

         // Consulta para buscar os ingredientes
     // Consulta para buscar os ingredientes com as quantidades
     $query_ingredientes = "
     SELECT 
         i.nome_ingrediente, 
         li.qtdIngrediente_lista,
         iq.nome_singular_ingrediente_quantidade,
         iq.nome_plural_ingrediente_quantidade
     FROM 
         lista_de_ingredientes li
     INNER JOIN 
         ingrediente i ON li.fk_id_ingrediente = i.id_ingrediente
     LEFT JOIN 
         ingrediente_quantidade iq ON li.tipoQtdIngrediente_lista = iq.id_ingrediente_quantidade
     WHERE 
         li.fk_id_receita = :id_receita
 ";

 $result_ingredientes = $conn->prepare($query_ingredientes);
 $result_ingredientes->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
 $result_ingredientes->execute();


        // Definindo as variáveis a partir dos dados da receita
        $imagem_receita = $row_receita['imagem_receita'];
        $nome_receita = $row_receita['nome_receita'];
        $categoria = $row_receita['nome_categoria_culinaria'];
        $usuario = $row_receita['nome_usuario'];
        $numeroPorcao = $row_receita['numeroPorcao_receita'];
        // $porcao_nome = ($numeroPorcao == 1) ? $row_receita['nome_singular_porcao'] : $row_receita['nome_plural_porcao'];
        // Formata o número de porções para remover casas decimais desnecessárias
        $numeroPorcao_formatado = ($numeroPorcao == floor($numeroPorcao)) ? (int)$numeroPorcao : $numeroPorcao;

        // Exibe o nome no singular ou plural conforme a quantidade de porções
        $porcao_nome = ($numeroPorcao_formatado < 2) ? $row_receita['nome_singular_porcao'] : $row_receita['nome_plural_porcao'];
        $numeroPorcao_formatado = str_replace('.', ',', $numeroPorcao_formatado); // Substitui $numeroPorcao_formatado = str_replace('.', ',', $numeroPorcao_formatado);
        if (strpos($numeroPorcao_formatado, ',') !== false) {
            $numeroPorcao_formatado = rtrim($numeroPorcao_formatado, '0');
            $numeroPorcao_formatado = rtrim($numeroPorcao_formatado, ','); // Remove a vírgula se restar apenas zero
        }


        $tempoHora = $row_receita['tempoPreparoHora_receita'];
        $tempoMinuto = $row_receita['tempoPreparoMinuto_receita'];
        $modoPreparo = $row_receita['modoPreparo_receita'];

    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Receita não encontrada!</p>";
        header("Location: listagem_receitas.php");
        exit();
    }
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receita</title>
    <style>
        /* Garantir que a imagem ocupe toda a largura do card */
        .container_form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%; /* Ocupa 100% da largura disponível */
            padding: 0;
        }
        .container_form img {
            width: 100%; /* A imagem ocupará toda a largura do card */
            height: auto; /* Mantém a proporção da imagem */
            border-radius: 10px 10px 0 0; /* Aplica o arredondamento no topo da imagem */
        }
        .container_background_image_grow {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg') no-repeat center center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container_whitecard_grow {
            position: relative;
            background: white;
            padding: 0; /* Remove o padding do card para a imagem ocupar toda a largura */
            border-radius: 12px;
            width: 710px;
            min-height: 410px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 25px 30px 55px #5557;
            border-radius: 13px;
            overflow: hidden;
            z-index: 10;
        }
        /* Garante que o card fique embaixo da imagem */
        .container_whitecard_grow .container_form {
            margin-top: 0; /* Remove o espaço em cima */
        }
        .container_conteudo_receita {
            display: flex;
            /* background-color: pink; */
            flex-direction: column;
            align-items: center;
            width: 88%;
            height: 93.5%;
            /* background-color: #30B5C2; */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 1.9vh; 
            /* margin-bottom: 1vh; */
        }
      /* Estilo para as checkboxes */
/* Estilo para as checkboxes */
.checkbox-custom {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    background-color: #FEE5EB; /* Cor base (rosa claro) */
    border: 2px solid #FB6F92; /* Cor de borda */
    position: relative;
    transition: background-color 0.3s ease, border-color 0.3s ease;
    cursor: pointer;
    outline: none;
    display: inline-block;
    vertical-align: middle;
}

/* Estado quando a checkbox está selecionada (checked) */
.checkbox-custom:checked {
    background-color: #FE8FAA; /* Cor de fundo quando selecionado */
    border-color: #FB6F92; /* Cor da borda quando selecionado */
}

/* Adiciona o ícone de marcação dentro da checkbox */
.checkbox-custom:checked::before {
    content: "✔"; /* Símbolo de check */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 16px;
    color: white;
}

/* Estado quando a checkbox não está selecionada */
.checkbox-custom::before {
    content: ""; /* Remove o check quando não selecionado */
}

/* Estilo do label para um bom alinhamento com a checkbox */
.checkbox-container {
    display: flex;
    align-items: center;
    font-size: 16px;
    color: #5E5E5E;
    cursor: pointer;
}

.checkbox-container label {
    margin-left: 10px;
    font-size: 18px;
}
/* Estilo para a lista de ingredientes */
ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

/* Estilo para os itens da lista */
li {
    display: flex;
    align-items: center;  /* Alinha a checkbox e o texto verticalmente */
    margin-bottom: 10px;  /* Espaçamento entre os itens */
}

/* Estilo para a checkbox personalizada */
.checkbox-custom {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 18px;
    height: 18px;
    margin-right:  10px;
    border-radius: 4px;
    background-color: white; /* Cor base (rosa claro) */
    border: 2px solid #FE8FAA; /* Cor de borda */
    position: relative;
    transition: background-color 0.3s ease, border-color 0.3s ease;
    cursor: pointer;
    outline: none;
    display: inline-block;
    vertical-align: middle;
}

/* Estado quando a checkbox está selecionada (checked) */
.checkbox-custom:checked {
    background-color: #FE8FAA; /* Cor de fundo quando selecionado */
    border-color: #FE8FAA; /* Cor da borda quando selecionado */
}

/* Adiciona o ícone de marcação dentro da checkbox */
.checkbox-custom:checked::before {
    content: "✔"; /* Símbolo de check */
    position: absolute;
    top: 46%;
    left: 54%;
    transform: translate(-50%, -50%);
    font-size: 16px;
    color: white;
}

/* Estado quando a checkbox não está selecionada */
.checkbox-custom::before {
    content: ""; /* Remove o check quando não selecionado */
}

/* Estilo do label para um bom alinhamento com a checkbox */
.checkbox-container {
    display: flex;
    font-size: 16px;
    color: #5E5E5E;
    cursor: pointer;
}

.checkbox-container label {
    margin-left: 10px;
    font-size: 18px;
    display: inline-block;
    text-align: left; /* Alinha o texto dos ingredientes à esquerda */

      /* Faz o texto ocupar apenas o espaço necessário */
}


    </style>
</head>
<body>
<div class="container_background_image_grow">
    <div class="container_whitecard_grow">
        <div class="container_form">

            <!-- Imagem da Receita -->
            <img src="<?php echo htmlspecialchars($imagem_receita) ? htmlspecialchars($imagem_receita) : '../css/img/receita/imagem.png'; ?>" alt="Imagem da Receita">

            <div class="container_conteudo_receita">           
                <div class="form-title-big">
                        <button><?php echo htmlspecialchars($nome_receita); ?></button>
                        <div class="toggle-line-big"></div>
                </div>

                <div style="display: flex; width: 100%;">
                    <div style="flex: 0 0 49.4%; margin-right: 10px;  padding: 10px;  font-size: 20px;color:#5E5E5E">
                        <?php
                            echo '<div style="margin-bottom: 10px;">' .                                 '<i class="fa-solid fa-bookmark" style="color: #a587ca;"></i>&nbsp;&nbsp;' . htmlspecialchars($categoria) . '</div>';
                            echo '<div style="margin-bottom: 0px;">' . '<i class="fa-solid fa-user" style="color: #36cedc;"></i>&nbsp;&nbsp;' . htmlspecialchars($usuario) . '</div>';
                        ?>
                    </div>
                    <div style="flex: 0 0 49.4%; margin-right: 10px; padding: 10px; font-size: 20px;color:#5E5E5E">
                        <?php
                        echo '<div style="margin-bottom: 10px;">' . '<i class="fa-solid fa-utensils" style="color: #fe797b;"></i>&nbsp;&nbsp;' . htmlspecialchars($numeroPorcao_formatado) . " " . htmlspecialchars($porcao_nome) . '</div>';
                        echo '<div style="margin-bottom: 0px;">' . '<i class="fa-solid fa-clock" style="color: #ffb750;"></i>&nbsp;&nbsp;' .                                  htmlspecialchars($tempoHora) . "h " . htmlspecialchars($tempoMinuto) . "min" . '</div>';
                        ?>
                    </div>
                </div>

                <!-- <h2>Ingredientes</h2> -->
                <div style="display: flex; width: 100%;">
    <div style="flex: 0 0 100%; margin-right: 10px; margin-top:10px; padding: 10px;  font-size: 20px;color:#5E5E5E">
        <ul style="list-style-type: none;">
        <?php
// Loop para exibir os ingredientes
if ($result_ingredientes->rowCount() > 0) {
    while ($row_ingrediente = $result_ingredientes->fetch(PDO::FETCH_ASSOC)) {
        // Formata a quantidade para exibir sem casas decimais desnecessárias
        $quantidade = $row_ingrediente['qtdIngrediente_lista'];
        $quantidade_formatada = ($quantidade == floor($quantidade)) ? (int)$quantidade : $quantidade;

        // Define o nome do ingrediente e o tipo de quantidade (singular ou plural)
        if ($quantidade_formatada == 1) {
            $nomeIngrediente = $row_ingrediente['nome_ingrediente']; // Nome do ingrediente
            $tipoQuantidade = htmlspecialchars($row_ingrediente['nome_plural_ingrediente_quantidade']); // Plural para quantidade igual a 1
        } else {
            $nomeIngrediente = $row_ingrediente['nome_ingrediente'];
            $tipoQuantidade = htmlspecialchars($row_ingrediente['nome_singular_ingrediente_quantidade']); // Singular normalmente
        }

        // Formata a quantidade para substituir o ponto por vírgula
        $quantidade_formatada = str_replace('.', ',', $quantidade_formatada);
        if (strpos($quantidade_formatada, ',') !== false) {
            $quantidade_formatada = rtrim($quantidade_formatada, '0');
            $quantidade_formatada = rtrim($quantidade_formatada, ','); // Remove a vírgula se restar apenas zero
        }

        if ($tipoQuantidade != 1) {
            echo "<li><input type='checkbox' class='checkbox-custom' id='ingrediente_$nomeIngrediente'>
                  <label for='ingrediente_$nomeIngrediente'>" . $quantidade_formatada . " " . $tipoQuantidade . " de " . strtolower(str_replace(' | ', '/', $nomeIngrediente)) . "</label></li>";
        } else {
            echo "<li><input type='checkbox' class='checkbox-custom' id='ingrediente_$nomeIngrediente'>
                  <label for='ingrediente_$nomeIngrediente'>" . $tipoQuantidade . " " . strtolower(str_replace(' | ', '/', $nomeIngrediente)) . "</label></li>";
        }
    }
} else {
    echo '<p>Ingredientes não disponíveis.</p>';
}


?>



        </ul>
    </div>
</div>


                    <!-- Modo de Preparo -->
                    <!-- <h2>Modo de Preparo</h2> -->
                    <div style="display: flex; width: 100%;">
                        <div style="flex: 0 0 100%; margin-right: 10px; padding: 10px;  font-size: 20px;color:#5E5E5E">
                            <ul style="list-style-type: none;">
                                <?php
                                echo nl2br(htmlspecialchars($modoPreparo));
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
  // Centralizar os botões
  echo '<div style="display: flex; justify-content: center; gap: 15px; margin-bottom: 30px;">';
                    
  // Botão "Deletar"
  // echo '<button class="button-orange" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px;">Deletar</button>';
  echo '<a href="deletar_receita.php?id_receita=' . htmlspecialchars($id_receita) . '" class="button-red" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Deletar Receita Permanentemente">';
  echo '<i class="fa-solid fa-trash"></i>';
  echo '</a>';
  
  // Botão com link para o usuário
  echo '<a href="../usuario/registro_usuario.php?id_usuario=' . htmlspecialchars($fk_id_usuario) . '" class="button-purple" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;" title="Ver criador da receita">';
  echo '<i class="fa-solid fa-pencil"></i>';
  echo '</a>';
  
  echo '<a href="registro_receita.php?id_receita=' . htmlspecialchars($id_receita) . '" class="button-purple" style="width: 9.3vw; margin-bottom: 10px; margin-top: 10px; text-align: center;"title="Ver Receita">';
  echo '<i class="fa-solid fa-arrow-right fa-xl"></i>';
  echo '</a>';

  echo '</div>';

                    ?>
            </div>
        </div>
    </div>
</div>
<?php
// Exibe mensagem da sessão, se existir
if (isset($_SESSION['mensagem'])) {
    echo "<script>window.onload = function() { alert('" . $_SESSION['mensagem'] . "'); }</script>";
    unset($_SESSION['mensagem']);
}
?>
</body>
</html>
