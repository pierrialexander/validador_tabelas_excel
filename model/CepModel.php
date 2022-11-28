<?php
namespace Model;
class CepModel extends Model
{
    private $cepInfo;

    public function getCep($cep) {
        $sql = $this->db->prepare("SELECT * FROM enderecos WHERE cep = :cep");
        $sql->bindValue(':cep', $cep);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $this->cepInfo = $sql->fetch();
            return true;
        }
    }
}