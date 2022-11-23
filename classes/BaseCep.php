<?php
//require '../vendor/autoload.php';
namespace Classes;
use PhpOffice\PhpSpreadsheet\Reader;

/**
 * Classe responsável por executar as rotinas para a Base de CEP.
 * @author Pierri Alexander Vidmar
 * @since 25/10/2022
 */
class BaseCep {

    /**
     * Faz a leitura dos CEPs existentes no arquivo Excel e retorna um array com os dados. 
     * @param $arquivo
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

}