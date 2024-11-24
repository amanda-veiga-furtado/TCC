// RFN003 - Os campos de texto, com exceção dos de e-mail e senha, não aceitarão caracteres como , /, @, <, >, #, $, %, &, *, {, }, [ e ]

var inputs = document.querySelectorAll('input[type="text"], textarea');

inputs.forEach(function (input) {
    input.addEventListener("keypress", function (e) {
        if (!checkChar(e)) {
            e.preventDefault(); // Impede a entrada do caractere
        }
    });
});

function checkChar(e) {
    var char = e.key; // Obtém a tecla pressionada

    console.log(char); // Para depuração, exibe o caractere no console

    // Expressão regular que permite apenas os caracteres definidos
    var pattern = /^[a-zA-Z0-9çÇ^~´ªºãõáéíóúâêîôûàèìòù.,;:!?“”()\- ]$/;

    // Verifica se o caractere corresponde ao padrão
    return pattern.test(char);
}
