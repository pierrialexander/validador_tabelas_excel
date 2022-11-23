<?php
namespace Classes;

/**
 * Classe responsável por conter as rotinas de Verificações e Edições dos arquivos CSV das tabelas de transporte.
 * @author Pierri Alexander Vidmar
 * @since 22/11/2022
 */
class CSV {
    /**
     * Método responsável por ler um arquivo CSV e retornar um array de dados
     * @param string $arquivo
     * @param boolean $cabecalho
     * @param string $delimitador
     * @return array $dados
     * @author Pierri Alexander Vidmar
     */
    public static function lerArquivo($arquivo, $cabecalho = true, $delimitador = ',') {
        if(!file_exists($arquivo)) {
            die('Arquivo não encontrado!\n');
        }

        // Dados das linhas do arquivos
        $dados = [];

        // Abrir o Arquivo
        $csv = fopen($arquivo, 'r');

        // CABEÇALHO DOS DADOS (primeira linha)
        //$cabecalhoDados = $cabecalho ? fgetcsv($csv, 0, $delimitador) : [];

        // Itera o arquivo lendo cada linha
        // Verifica se tem cabeçalho, se sim, combina eles (somando eles)
        while($linha = fgetcsv($csv, 0, $delimitador)){
            $dados[] = $linha;
            //$dados[] = $cabecalhoDados ? array_combine($cabecalhoDados, $linha) : $linha;
        }

        return $dados;
    }


    /**
     * Método responsável por validar os caracteres do item do array
     * @param $item
     * @return array|string
     */
    public static function validaCaracteres($item): array|string
    {
        $caracteresIncorretos = ['ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç','-','(',')',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º',"'"];
        $substituir = ['a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','','','','','','',',','','','','','','','','','','','','','',''];
        $itemVerificado = str_replace($caracteresIncorretos, $substituir, $item);
        trim($itemVerificado);
        return $itemVerificado;
    }


    /**
     * Método responsável por criar o novo arquivo CSV com todas as validações executadas.
     * @param $arquivo
     * @param $dados
     * @param $delimitador
     * @return bool
     * @author Pierri Alexander Vidmar
     */
    public static function criarArquivoCSVCorrigido($arquivo, $dados, $delimitador = ',') {
        $csv = fopen($arquivo, 'w');

        foreach($dados as $linha) {
            $novaLinhaCorrigida = [];

            // desmonta o array da linha, faz as validações de caractere e remonta a linha
            foreach($linha as $item) {
                array_push($novaLinhaCorrigida, trim(csv::validaCaracteres($item)));
            }

            fputcsv($csv, $novaLinhaCorrigida, $delimitador);
        }

        fclose($csv);

        return true;
    }





















}