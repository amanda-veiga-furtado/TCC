<?php
// FRAÇÕES DISPONÍVEIS
    // 1/2 = 0.500
    // 1/3 = 0.333
    // 2/3 = 0.667
    // 1/4 = 0.250
    // 3/4 = 0.750
    // 1/8 = 0.125
    // 1/16 = 0.063

$FRACOES = [
    'todas' => ['1/2','1/3','2/3','1/4','3/4','1/8','1/16'],

    'parcial_1' => ['1/2'],

    'parcial_2' => ['1/2','1/3','1/4'],

    'nenhuma' => []
];

//REGRAS – ingrediente_quantidade

$INGREDIENTE_QUANTIDADE = [

    //USAM TODAS AS FRAÇÕES
    12 => 'todas', // colher(s) de café
    13 => 'todas', // colher(s) de chá
    14 => 'todas', // colher(s) de sobremesa
    15 => 'todas', // colher(s) de sopa
    9  => 'todas', // copo(s)
    16 => 'todas', // copo(s) americano
    17 => 'todas', // copo(s) requeijão
    19 => 'todas', // xícara(s)
    10 => 'todas', // litro(s)
    11 => 'todas', // mililitro(s)
    6  => 'todas', // quilo(s)

    //USAM APENAS ALGUMAS FRAÇÕES
    7  => 'parcial_1', // grama(s)
    4  => 'parcial_1', // fatia(s)
    2  => 'parcial_1', // pedaço(s)

    //NÃO USAM FRAÇÕES
    1  => 'nenhuma', // a gosto
    45 => 'nenhuma', // bola(s)
    48 => 'nenhuma', // borrifada(s)
    37 => 'nenhuma', // caixa(s)
    46 => 'nenhuma', // cubo(s)
    47 => 'nenhuma', // embalagem(s)
    26 => 'nenhuma', // garrafa(s)
    38 => 'nenhuma', // lata(s)
    42 => 'nenhuma', // maço(s)
    18 => 'nenhuma', // pacote(s)
    5  => 'nenhuma', // pitada(s)
    3  => 'nenhuma', // punhado(s)
    43 => 'nenhuma', // ramo(s)
    27 => 'nenhuma', // saco(s)
    44 => 'nenhuma', // talo(s)
    8  => 'nenhuma', // unidade(s)
];

//REGRAS – porcao_quantidade

$PORCAO_QUANTIDADE = [

    //USAM TODAS AS FRAÇÕES
    1  => 'todas', // porção(s)
    9  => 'todas', // copo(s)
    12 => 'todas', // xícara(s)
    10 => 'todas', // litro(s)
    11 => 'todas', // mililitro(s)
    6  => 'todas', // quilo(s)

    //USAM APENAS ALGUMAS FRAÇÕES
    7  => 'parcial_1', // grama(s)
    4  => 'parcial_1', // fatia(s)
    2  => 'parcial_1', // pedaço(s)

    //NÃO USAM FRAÇÕES
    5  => 'nenhuma', // pessoa(s)
    3  => 'nenhuma', // prato(s)
    8  => 'nenhuma', // unidade(s)
];
