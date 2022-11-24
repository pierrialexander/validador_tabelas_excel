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
    
        use Classes\CSV;
        use Classes\Validacao;
        use Classes\BaseCep;

        // Instancia do Validador
        $validador = new Validacao();

        // recebendo o arquivo multipart
        $file = $_FILES["arquivo"];

        $dirFileName = "uploads/" . $file["name"];


        if ($file['type'] == 'text/csv') {
            if (move_uploaded_file($file["tmp_name"], $dirFileName)) {
                $dados = CSV::lerArquivo($dirFileName, true, ';');
                $resultado = CSV::criarArquivoCSVCorrigido($dirFileName, $dados, ';');

                echo "<br><br><h1>Arquivo CSV verificado e gerado com sucesso!!</h1>";
                echo "<br><h3>Clique no Link Abaixo para baixar o arquivo verificado</h3>";
                echo "<br><a href='{$dirFileName}' class='totais'>Baixar Arquivo CSV</a>";

                if($resultado) {

                    $baseCep = BaseCep::lerBaseCep('./BaseCEP/Lista_de_CEPs.xlsx', 'D', 'E');
                    $arrayCEP = CSV::montaArrayCEP($dirFileName, true, ';');

                    $validador->validar($arrayCEP);

                    //================================================================
                    // VERIFICA SE O CEP EXISTE NA BASE DE DADOS
                    //================================================================
                    $resultadoComparacao = array_diff($arrayCEP, $baseCep);
                    if (!empty($resultadoComparacao)) {
                        foreach ($resultadoComparacao as $value) {
                            if (!in_array($value, $validador->ceps_incorretos)) {
                                array_push($validador->ceps_inexistentes, $value);
                            }
                        }
                    }

                    //========================================================
                    // IMPRIME NO HTML OS RESULTADOS
                    //========================================================
                    echo '<br><br><hr>';
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

                die();
            }
        } else {
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