<?php
//require '../vendor/autoload.php';
ini_set('memory_limit', '1024M');
use PhpOffice\PhpSpreadsheet\Reader;

/**
 * Classe responsável por tratar das manipulação do arquivo Base de CEPs
 */
class BaseCep {
    
    
    /**
     * Faz a leitura dos CEPs existentes no arquivo Excel e retorna um array com os dados. 
     * @param [type] $arquivo
     * @return array
     */
    public static function lerBaseCep($arquivo, $primeriaColuna, $segundaColuna = '') {

        $array_cep = [];
      
        $reader = new reader\xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($arquivo);

        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();
        //$highestColumn = $worksheet->getHighestColumn();
               
        for ($row = 2; $row <= $highestRow; ++$row) {
            array_push($array_cep, $worksheet->getCell($primeriaColuna . $row)->getValue());
        }

        if($segundaColuna) {
            for ($row = 2; $row <= $highestRow; ++$row) {
                array_push($array_cep, $worksheet->getCell($segundaColuna . $row)->getValue());
            }
        }

                       
        return $array_cep;
    }

    // public static function verificaCepsBrasil($baseCep, $arquivo, $primeriaColuna, $segundaColuna = '') {
    //     $ceps_brasil = [];



    //     return $ceps_brasil;
    // }
}