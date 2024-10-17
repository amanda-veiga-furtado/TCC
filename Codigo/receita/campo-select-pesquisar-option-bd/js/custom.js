// Função para pesquisar os produtos no banco de dados e carregar no formulário
async function carregarProdutos(valor) {

    // Acessa o IF quando usuário digitar 2 caracteres
    if (valor.length >= 2) {
        // console.log(valor);

        // Fazer a requisição para o arquivo PHP responsável em recuperar do banco de dados os produtos
        const dados = await fetch('listar_produtos.php?nome=' + valor);

        // Ler os valores retornado
        const resposta = await dados.json();

        // Abrir a lista de produtos
        var conteudoHTML = "<ul class='list-group position-fixed'>";

        if (resposta['status']) {

            // Percorrer a lista de produtos retornado do banco de dados
            for (i = 0; i < resposta['dados'].length; i++) {

                // Criar a lista de produtos
                conteudoHTML += "<li class='list-group-item list-group-itemaction' style='cursor: pointer;' onclick='getIdProduto(" + resposta['dados'][i].id + "," + JSON.stringify(resposta['dados'][i].nome) + ")'>" + resposta['dados'][i].nome + "</li>";
            }
        } else {
            // Criar o item da lista com o erro retornado do PHP
            conteudoHTML += "<li class='list-group-item disabled'>" + resposta['msg'] + "</li>";
        }

        // Fechar a lista de produtos 
        conteudoHTML += "</ul>";

        // Enviar para o HTML a lista de produtos
        document.getElementById('resultado-pesquisa').innerHTML = conteudoHTML;
    } else {
        // Fechar a lista de produtos ou o erro
        document.getElementById("resultado-pesquisa").innerHTML = "";
    }
}

function getIdProduto(id_produto, nome) {
    // Enviar o nome do produto para o campo produto o nome
    document.getElementById("produto").value = nome;

    // Enviar o ID do produto para o campo oculto
    document.getElementById("id_produto").value = id_produto;

    // Fechar a lista de produtos ou o erro
    document.getElementById("resultado-pesquisa").innerHTML = "";
}