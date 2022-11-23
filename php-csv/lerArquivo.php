<?php

require __DIR__ . '/vendor/autoload.php';
use \App\Files\CSV;

$dados = CSV::lerArquivo(__DIR__ . '\files\prazo.csv', true, ',');
$resultado = CSV::criarArquivoCSVCorrigido(__DIR__ . '\files\arquivo-escrita.csv', $dados, ',');

echo '<pre>';
var_dump($resultado);
echo '</pre>';