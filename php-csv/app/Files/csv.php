<?php
namespace App\Files;

class CSV {
    /**
     * Método responsável por ler um arquivo CSV e retornar um array de dados
     * @param string $arquivo
     * @param boolean $cabecalho
     * @param string $delimitador
     * @return array $dados
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
        $cabecalhoDados = $cabecalho ? fgetcsv($csv, 0, $delimitador) : [];

        // Itera o arquivo lendo cada linha
        // Verifica se tem cabeçalho, se sim, combina eles (somando eles)
        while($linha = fgetcsv($csv, 0, $delimitador)){
            //$dados[] = $linha;
            $dados[] = $cabecalhoDados ? array_combine($cabecalhoDados, $linha) : $linha;
        }

        return $dados;
    }


    private function validaCaracteres($item) {

    }


    public static function criarArquivoCSVCorrigido($arquivo, $dados, $delimitador = ',') {
        $csv = fopen($arquivo, 'w');

        foreach($dados as $linha) {
            $novaLinhaCorrigida = [];

            // desmonta o array da linha, faz as validações de caractere e remonta a linha
            foreach($linha as $item) {
                $caracteresIncorretos = ['ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç','-','(',')',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º',"'"];
                $substituir = ['a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','','','','','','',',','','','','','','','','','','','','','',''];
                $itemVerificado = str_replace($caracteresIncorretos, $substituir, $item);
                array_push($novaLinhaCorrigida, trim($itemVerificado));
            }

            fputcsv($csv, $novaLinhaCorrigida, $delimitador);
        }

        fclose($csv);

        return true;
    }





















}