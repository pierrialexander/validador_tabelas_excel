<?php

require __DIR__ . '/vendor/autoload.php';
use \App\Files\CSV;

$dados = [
    [
        'ID',
        'Nome     ',
        'Descricão'
    ],
    [
        1,
        'Produto Têste',
        '   Produto de teste de integracao'
    ],
    [
        2,
        'Produto Qualidade%%%%',
        'Produto de qual$idade de integracao'
    ]
];

$sucesso = CSV::criarArquivo(__DIR__ . '\files\arquivo-escrita.csv', $dados, ',');

echo '<pre>';
var_dump($sucesso);
echo '</pre>';