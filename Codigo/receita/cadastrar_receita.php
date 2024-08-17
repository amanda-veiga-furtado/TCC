<?php
    session_start();
    ob_start();

    include_once '../menu.php';
    include_once '../conexao.php';

    // Função para converter frações
    function converteFracao($numero) {
        if ($numero != floor($numero)) {
            $partes = explode('.', $numero);
            $inteiro = $partes[0];
            
            // Ensure there is a decimal part before accessing it
            if (isset($partes[1]) && $partes[1] == 5) {
                return $inteiro . ' e 1/2';
            }
        }
        return $numero;
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // Recebe os dados do formulário

        if (!empty($dados['CadReceita'])) {
            
            // Porção
            $numero_porcoes = converteFracao($dados['quantidadePorcao']) . ' ' . $dados['tipoPorcao'];

            // Tempo de Preparo
            $tempo_preparo = "";
            if (!empty($dados['horas']) || !empty($dados['minutos'])) {
                $horas_texto = ($dados['horas'] == 1) ? 'Hora' : 'Horas';
                $minutos_texto = ($dados['minutos'] == 1) ? 'Minuto' : 'Minutos';
                $tempo_preparo = ($dados['horas'] == 0 ? '' : $dados['horas'] . " $horas_texto") . ($dados['horas'] == 0 || $dados['minutos'] == 0 ? '' : ' e ') . ($dados['minutos'] == 0 ? '' : $dados['minutos'] . " $minutos_texto");
                $tempo_preparo = str_replace(':', ' e ', $tempo_preparo);
            }

            // Imagem
            $caminho_imagem = '';
            if (isset($_FILES['imagem_receita']) && $_FILES['imagem_receita']['error'] === UPLOAD_ERR_OK) {
                $imagem_temp = $_FILES['imagem_receita']['tmp_name'];
                $nome_imagem = $_FILES['imagem_receita']['name'];

                // Verifica se o arquivo é uma imagem válida
                $check = getimagesize($imagem_temp);
                if ($check !== false) {
                    $caminho_imagem = '../css/img/receita/' . $nome_imagem;
                    move_uploaded_file($imagem_temp, $caminho_imagem);
                }
            }

            // Insere os dados no banco de dados
            try {
                $query_receita = "INSERT INTO receita (nome_receita, numeroPorcoes_receita, tempoPreparo_receita, modoPreparo_receita, imagem_receita) VALUES (:nome_receita, :numeroPorcoes_receita, :tempoPreparo_receita, :modoPreparo_receita, :imagem_receita)";
                $cad_receita = $conn->prepare($query_receita);
                $cad_receita->bindParam(':nome_receita', $dados['nome_receita']);
                $cad_receita->bindParam(':numeroPorcoes_receita', $numero_porcoes);
                $cad_receita->bindParam(':tempoPreparo_receita', $tempo_preparo);
                $cad_receita->bindParam(':modoPreparo_receita', $dados['modoPreparo_receita']);
                $cad_receita->bindParam(':imagem_receita', $caminho_imagem);

                // Executa a inserção
                if ($cad_receita->execute()) {
                    // Obtém o ID da receita recém-criada
                    $id_receita = $conn->lastInsertId();

                    // Insere os ingredientes
                    $nome_ingredientes = $dados['nome_ingrediente'];
                    $quantidade_ingredientes = $dados['quantidadeIngrediente'];
                    $tipo_ingredientes = $dados['tipoIngrediente'];

                    for ($i = 0; $i < count($nome_ingredientes); $i++) {
                        if (!empty($nome_ingredientes[$i])) {
                            $qtdIngrediente_lista = converteFracao($quantidade_ingredientes[$i]) . ' ' . $tipo_ingredientes[$i];

                            // Obtém o ID do ingrediente selecionado
                            $query_id_ingrediente = "SELECT id_ingrediente FROM ingrediente WHERE id_ingrediente = :nome_ingrediente";
                            $stmt = $conn->prepare($query_id_ingrediente);
                            $stmt->bindParam(':nome_ingrediente', $nome_ingredientes[$i]);
                            $stmt->execute();
                            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                            $id_ingrediente = $resultado['id_ingrediente'];

                            // Insere os dados na tabela lista_de_ingredientes
                            $query_ingredientes = "INSERT INTO lista_de_ingredientes (fk_id_receita, fk_id_ingrediente, qtdIngrediente_lista) VALUES (:fk_id_receita, :fk_id_ingrediente, :qtdIngrediente_lista)";
                            $cad_ingredientes = $conn->prepare($query_ingredientes);
                            $cad_ingredientes->bindParam(':fk_id_receita', $id_receita);
                            $cad_ingredientes->bindParam(':fk_id_ingrediente', $id_ingrediente);
                            $cad_ingredientes->bindParam(':qtdIngrediente_lista', $qtdIngrediente_lista);

                            if (!$cad_ingredientes->execute()) {
                                echo "<p style='color: red; margin-left: 10px;'>Erro ao cadastrar um ou mais ingredientes. Por favor, tente novamente.</p>";
                                return;
                            }
                        }
                    }

                    echo "<p style='color: green; margin-left: 10px;'>Receita e ingredientes cadastrados com sucesso!</p>";
                } else {
                    echo "<p style='color: red; margin-left: 10px;'>Erro ao cadastrar a receita. Por favor, tente novamente.</p>";
                }
            } catch (PDOException $err) {
                echo "<p style='color: red; margin-left: 10px;'>Erro: " . $err->getMessage() . "</p>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastrar Receita</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/style.css"> -->

    <style>
        * {
            padding: 0; /* Remove o padding padrão de todos os elementos */
            margin: 0; /* Remove a margem padrão de todos os elementos */
            box-sizing: border-box; /* Inclui padding e border na largura e altura total dos elementos */
        }
        /* Menu */
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
/* ------------------------------------------------------------------------------------------- */
        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }
        .form h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 24px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 15px;


        }
        .form h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }
        .form input {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        .form input:focus {
            border-color: #36cedc;
            outline: none;
        }

        .form select {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form select:focus {
            border-color: #36cedc;
            outline: none;
        }

        .form textarea {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            height: 600px;
            box-sizing: border-box;
        }
        .form textarea:focus {
            border-color: #36cedc;
            outline: none;
        }
        
        /* .form button {
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #a587ca;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        .form button:hover {
            background-color: #8c6db6;
        } */
        .botao-enviar{
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #a587ca;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;   
        }
        .botao-enviar:hover {
            background-color: #8c6db6;
        }
        .div_link{
            margin-top: 0.3cm;
            text-align: center;
        }
        a {
            color: #8c6db6;
            text-decoration: none;
        }
        a.forgot {
            padding-bottom: 3px;
            border-bottom: 2px solid #a587ca;
        }

        .toggle-line {
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50%;
        height: 3px;
        background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);
        transition: transform 0.3s;
    }
    /* ----- */

    .form-toggle2 {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    margin-top: 25px;

    width: 100%;
    position: relative;
}

.form-toggle2 button {
    background: none;
    border: none;
    font-size: 32px;
    cursor: pointer;
    padding: 10px 20px;
    color: #888;
    transition: color 0.3s;
    flex-grow: 1;
    text-align: center;
}

.form-toggle2 button:hover,
.form-toggle2 button:focus {
    color: #333;
}

.toggle-line2 {
    position: absolute;
    bottom: -5px;
    left: 50%;
    width: 50%;
    height: 3px;
    background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);
    transition: transform 0.3s;
    transform: translateX(-50%); /* Centraliza horizontalmente */

}
.button-redondo {
		border: none;
            	color: white;
            	padding: 0; /* Remova o padding para usar flexbox */
            	text-align: center;
            	text-decoration: none;
              	display: inline-block;
		/*display: flex;*/
            	justify-content: center; /* Centraliza horizontalmente */
            	align-items: center; /* Centraliza verticalmente */
            	font-size: 35px;
            	margin: 4px 2px;
            	cursor: pointer;
            	height: 40px;
            	width: 40px;
        }

        .button-mais {
            border-radius: 50%;
            background-color: #8fe968; /* Verde */
        }

        .button-menos {
            border-radius: 50%;
            background-color: #fe797b; /* Vermelho */
        }

        .button-mais:hover {
            background-color: #7BDB47;
        }

        .button-menos:hover {
            background-color: #FC445D;
        }

    </style>
</head>
<body>
    <div class="conteiner1">
        <div class="form">
            <div class="form-toggle2">
                <button>Compartilhe Sua Receita</button>
                <div class="toggle-line2"></div>
            </div>
            <br>
            <form name="cad-receita" id="cad-receita" method="POST" action="" enctype="multipart/form-data">
                
                <!-- Nome da Receita -->
                    <h2>Nome da Receita</h2>
                    <input type="text" name="nome_receita" id="nome_receita" placeholder="Bolo de Cenoura com Cobertura de Chocolate Amargo" required><br>

            <!-- Porção -->
                <h2>Porção</h2>
                <input type="number" name="quantidadePorcao" id="quantidadePorcao" min="0.5" step="0.5" value="1" style="width: 13%;">
                <select name="tipoPorcao" id="tipoPorcao" style="width: 25%;">
                    <option value="porção(ões)">porção(ões)</option>
                    <option value="pedaço(s)">pedaço(s)</option>
                    <option value="prato(s)">prato(s)</option>
                    <option value="fatia(s)">fatia(s)</option>
                    <option value="pessoa(s)">pessoa(s)</option>
                    <option value="quilo(s)">quilo(s)</option>
                    <option value="gramas(s)">grama(s)</option>
                    <option value="unidade(s)">unidade(s)</option>
                    <option value="copo(s)">copo(s)</option>
                </select><br>

            <!-- Tempo de Preparo -->
                <h2>Tempo de Preparo</h2>
                <input type="number" name="horas" id="horas" min="0" value="0"  style="width: 10%;"> Hora(s) :
                <input type="number" name="minutos" id="minutos" min="0" value="0"  style="width: 10%;"> Minuto(s)<br>

            <!-- Imagem -->
                <h2>Imagem da Receita</h2>
                <input type="file" name="imagem_receita" id="imagem_receita"><br>

                <!-- Ingredientes -->
                    <h2>Ingrediente</h2>
                    <div id="ingredientes-container">
                        <div class="ingrediente">
                            <select name="nome_ingrediente[]" class="select-field">
                                <option value="">Selecione um Ingrediente</option>
                                <?php
                                $query = $conn->query("SELECT id_ingrediente, nome_ingrediente FROM ingrediente ORDER BY nome_ingrediente ASC");
                                $registros = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($registros as $option):
                                ?>
                                    <option value="<?php echo $option['id_ingrediente']; ?>"><?php echo $option['nome_ingrediente']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Quantidade Ingrediente -->
                            <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.5" step="0.5" value="1" style="width: 50px;">

                            <!-- Tipo da Quantidade -->
                            <select              class="select-field" name="tipoIngrediente[]">
                                <option value="colher(es) de café">colher de café</option>
                                <option value="colher(es) de chá">colher de chá</option>
                                <option value="colher(es) de sobremesa">colher de sobremesa</option>
                                <option value="colher(es) de sopa">colher de sopa</option>
                                <option value="copo(s) americano(s)">copo americano</option>
                                <option value="copo(s) requeijão">copo requeijão</option>
                                <option value="xícara(s) de chá">xícara de chá</option>
                                <option value="grama(s)">grama</option>
                                <option value="quilograma(s)">quilograma</option>
                                <option value="mililitro(s)">mililitro</option>
                                <option value="litro(s)">litro</option>
                                <option value="pedaço(s)">pedaço</option>
                                <option value="fatia(s)">fatia</option>
                                <option value="punhado(s)">punhado</option>
                                <option value="pitada(s)">pitada</option>
                                <option value="a gosto">a gosto</option>
                                <option value="pacote(s)">pacote</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add/Remove Buttons -->
                    <button type="button" id="add-ingrediente" class="button-redondo button-mais">+</button>

                    <button type="button" id="remove-ingrediente" class="button-redondo button-menos">-</button>

                    <!-- Modo de Preparo -->

                    <h2>Modo de Preparo</h2>
                    <textarea name="modoPreparo_receita" id="modoPreparo_receita" placeholder="Digite o modo de preparo da sua receita." rows="15" required></textarea><br>

                    <input type="submit" name="CadReceita" value="Cadastrar Receita" class="botao-enviar">
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const maxIngredientes = 20;
    let ingredientesCount = 1;

    function cloneSelectOptions(selectElement) {
        return selectElement.innerHTML;
    }

    document.getElementById('add-ingrediente').addEventListener('click', function () {
        if (ingredientesCount < maxIngredientes) {
            const container = document.getElementById('ingredientes-container');
            const newIngrediente = document.createElement('div');
            newIngrediente.className = 'ingrediente';

            // Clone options from the first select elements
            const selectIngredienteOptions = cloneSelectOptions(document.querySelector('.ingrediente select[name="nome_ingrediente[]"]'));
            const selectTipoOptions = cloneSelectOptions(document.querySelector('.ingrediente select[name="tipoIngrediente[]"]'));

            // Set the new innerHTML including both selects and the input
            newIngrediente.innerHTML = `
                <select name="nome_ingrediente[]" class="select-field">${selectIngredienteOptions}</select>
                <input class="input-field" type="number" name="quantidadeIngrediente[]" min="0.5" step="0.5" value="1" style="width: 50px;">
                <select class="select-field" name="tipoIngrediente[]">${selectTipoOptions}</select>
            `;
            container.appendChild(newIngrediente);
            ingredientesCount++;
        } else {
            alert('Você só pode adicionar até 20 ingredientes.');
        }
    });

    document.getElementById('remove-ingrediente').addEventListener('click', function () {
        const container = document.getElementById('ingredientes-container');
        if (ingredientesCount > 1) {
            container.lastElementChild.remove();
            ingredientesCount--;
        }
    });
});

</script>
</body>
</html>
