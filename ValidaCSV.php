<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Validador - Resultados da análise</title>
</head>

<body>
    <div class="container">

        <?php
        require __DIR__ . '/vendor/autoload.php';
        require __DIR__ . '/model/Model.php';

        use Classes\CSV;
        use Classes\Validacao;
        use Model\CepModel;

        // Registra o ínício do tempo de execução
        $start_time = microtime(true);

        // Instancia do Validador
        $validador = new Validacao();

        $cepModel = new CepModel();

        // recebendo o arquivo multipart de Prazo
        $filePrazo = $_FILES["arquivoPrazo"];

        // recebendo o arquivo multipart de Preço
        $filePreco = $_FILES["arquivoPreco"];

        $dirFileNamePrazo = "uploads/" . $filePrazo["name"];



        if(isset($filePreco["name"]) && !empty($filePreco["name"])) {
            $dirFileNamePreco = "uploads/" . $filePreco["name"];

            if (move_uploaded_file($filePreco["tmp_name"], $dirFileNamePreco)) {
                $dadosPreco = CSV::lerArquivo($dirFileNamePreco, true, ';');
                $resultadoPreco = CSV::criarArquivoCSVCorrigido($dirFileNamePreco, $dadosPreco, ';');
            }

        }


        if ($filePrazo['type'] == 'text/csv') {

            if (move_uploaded_file($filePrazo["tmp_name"], $dirFileNamePrazo)) {
                $dadosPrazo = CSV::lerArquivo($dirFileNamePrazo, true, ';');
                $resultadoPrazo = CSV::criarArquivoCSVCorrigido($dirFileNamePrazo, $dadosPrazo, ';');

                echo "<br><br><h1>Arquivo CSV verificado e gerado com sucesso!!</h1>";
                echo "<br><h3>Clique no Link Abaixo para baixar o arquivo corrigido</h3>";
                echo "<br><a href='{$dirFileNamePrazo}' class='totais'>Baixar Arquivo CSV de Prazo</a>";

                if(isset($filePreco["name"]) && !empty($filePreco["name"])) {
                    echo "<br><a href='{$dirFileNamePreco}' class='totais'>Baixar Arquivo CSV de Preço</a>";
                    //================================================================
                    //========= INICIA AS VERIFICAÇÕES DE SIGLAS
                    //================================================================
                    if(isset($filePreco["name"]) && !empty($filePreco["name"]) && isset($filePrazo["name"]) && !empty($filePrazo["name"])){
                        $arraySilglaPreco = CSV::montaArraySigla($dirFileNamePreco, true, ';');
                        $arraySilglaPrazo = CSV::montaArraySigla($dirFileNamePrazo, true, ';');
                        $validador->validarSiglas($arraySilglaPrazo, $arraySilglaPreco);
                    }
                }




                //================================================================
                //========= INICIA AS VERIFICAÇÕES DE CEP
                //================================================================
                if($resultadoPrazo) {

                    $arrayCEP = CSV::montaArrayCEP($dirFileNamePrazo, true, ';');

                    $validador->validar($arrayCEP);


                    //================================================================
                    // VERIFICA SE O CEP EXISTE NA BASE DE DADOS
                    //================================================================
                    foreach ($arrayCEP as $value) {
                        if (!in_array($value, $validador->ceps_incorretos)) {
                            if(!$cepModel->getCep($value)){
                                array_push($validador->ceps_inexistentes, $value);
                            }
                        }
                    }

                    //========================================================
                    // IMPRIME NO HTML OS RESULTADOS
                    //========================================================
                    echo '<br><br><hr>';
                    echo "<br><h3>Siglas Divergentes: </h3>";
                    echo '<p class="totais">Total: ' . count($validador->siglas_divergentes) . "</p>";
                    foreach($validador->siglas_divergentes as $item){
                        echo "$item<br>";
                    };
                    echo "<br><h3>CEPs com caracteres incorretos: </h3>";
                    echo '<p class="totais">Total: ' . count($validador->ceps_incorretos) . "</p>";
                    foreach ($validador->ceps_incorretos as $items) {
                        echo "$items<br>";
                    }
                    echo "<br><h3>CEPs não encontrados na base dos correios: </h3>";
                    echo '<p class="totais">Total: ' . count($validador->ceps_inexistentes) . "</p>";
                    foreach ($validador->ceps_inexistentes as $items) {
                        echo "$items<br>";
                    }
                    echo "<br><h3>CEPs Duplicados: </h3>";
                    echo '<p class="totais">Total: ' . count($validador->ceps_duplicados) . "</p>";
                    foreach ($validador->ceps_duplicados as $items) {
                        echo "$items<br>";
                    }
                }

                    function formatMicrotime($time) {
                        return date('i:s', (int) $time);
                    }

                    $end_time = microtime(true);
                    $total_time = ($end_time - $start_time);

                    $total_time_round = formatMicrotime($total_time);
                    //$total_time_round = number_format($total_time, 2, '.');

                    echo "<p class='timer'>Tempo total de execução {$total_time_round} minutos.</p>";


                }
        }
        else {
            echo "<br><br><h1>Nenhum arquivo carregado! Verifique se o formato é CSV!</h1>";
            echo "<p>Que beleza ein... Tenha mais atenção né bixo!</p>";
            echo "<p>Se deseja validar arquivos EXCEL, favor retornar e escolher a opção correta de envio!</p>";
            die();
        }


        ?>
        <br>
    </div>
</body>

</html>