// RFN003 - Os campos de texto, com exceção dos de e-mail e senha, não aceitarão caracteres como , /, @, <, >, #, $, %, &, *, {, }, [ e ]

// Seleciona todos os inputs de texto e textareas, excluindo email e senha
var inputs = document.querySelectorAll('input[type="text"], textarea');

// Para cada input, adiciona listeners para eventos de entrada
inputs.forEach(function (input) {
    // Previne caracteres inválidos durante digitação
    input.addEventListener("keypress", function (e) {
        if (!isCharAllowed(e.key)) {
            e.preventDefault();
        }
    });

    // Trata colagem de texto, removendo caracteres inválidos
    input.addEventListener("paste", function (e) {
        e.preventDefault();
        var pastedText = (e.clipboardData || window.clipboardData).getData('text');
        var cleanedText = cleanText(pastedText);
        document.execCommand("insertText", false, cleanedText);
    });

    // Valida o valor completo ao perder foco
    input.addEventListener("blur", function () {
        input.value = cleanText(input.value);
    });
});

// Função para verificar se um caractere é permitido
function isCharAllowed(char) {
    // Regex que permite letras, números, acentos portugueses e pontuação básica
    var pattern = /^[a-zA-Z0-9çÇ^~´ªºãõáéíóúâêîôûàèìòù.,;:!?“”()\- ]$/;
    return pattern.test(char);
}

// Função para limpar texto, removendo caracteres não permitidos
function cleanText(text) {
    return text.replace(/[^a-zA-Z0-9çÇ^~´ªºãõáéíóúâêîôûàèìòù.,;:!?“”()\- ]/g, '');
}
