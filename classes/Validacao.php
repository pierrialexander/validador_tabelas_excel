<?php
namespace Classes;
/**
 * Classe responsável por fazer as validações do arquivo Excel.
 * @author Pierri Alexander Vidmar
 * @since 06/11/2022
 */
class Validacao {
    // Array que armazenará os CEPs com erros
    public $ceps_incorretos = [];

    // Array que armazenará os CEP inexistentes
    public $ceps_inexistentes = [];

    // Array que armazenará os CEP inexistentes
    public $ceps_duplicados = [];

    // Array que armazena os CEPs únicos
    public $ceps_unicos = [];

    /**
     * Método principal que centraliza a execução das validações de CEP.
     * @param $arquivo
     * @return void
     */
    public function validar($arquivo)
    {
        foreach ($arquivo as $item) {

            // VERIFICA SE EXISTEM CEPs DUPLICADOS
            $this->verificaExisteCEPDuplicado($item);

            // VERIFICA SE É SOMENTE NÚMEROS
            $this->verificaNumerico($item, $arquivo);

            // VERIFICA SE CONTÉM LETRAS E CARACTERES
            $this->verificaCaractere($item, $arquivo);

            // VERIFICA SE ALGUM ITEM EXISTENTE É VAZIO
            $this->verificaItemVazio($item, $arquivo);
        }
    }

    private function verificaExisteCEPDuplicado($item) {
        if (!in_array($item, $this->ceps_unicos)) {
            array_push($this->ceps_unicos, $item);
        } else {
            array_push($this->ceps_duplicados, $item);
        }
    }

    private function verificaNumerico($item, $arquivo) {
        if (!is_numeric($item)) {
            if (!in_array($item, $arquivo)) {
                array_push($this->ceps_incorretos, $item);
            }
        }
    }

    private function verificaCaractere($item, $arquivo) {
        $padrao = '/^(\d){8}$/';
        if (!preg_match($padrao, (string)$item)) {
            if (!in_array((int)$item, $arquivo)) {
                array_push($this->ceps_incorretos, $item);
            }
        }
    }

    private function verificaItemVazio($item, $arquivo) {
        if (empty($item) || is_null($item)) {
            if (!in_array((int)$item, $arquivo)) {
                array_push($this->ceps_incorretos, $item);
            }
        }
    }
}