<?php
require __DIR__ . './vendor/autoload.php';
require './classes/BaseCep.php';

$lista = BaseCep::lerBaseCep('./BaseCEP/Lista_de_CEPs.xlsx', 'D', 'E');

$_FILES