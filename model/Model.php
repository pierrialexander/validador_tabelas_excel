<?php
namespace Model;

use PDO;

class Model
{
    protected $db;

    public function __construct() {
        global $config;
        $this->db = new PDO("mysql:dbname=base_validador;host=localhost", "root", "ROOT");
    }
}