<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css" >
    <title>Validador - Resultados da análise</title>
</head>
<body>
    <div class="container">

    <?php 
        require __DIR__ . './vendor/autoload.php';
        require './classes/BaseCep.php';
        require './classes/Validacao.php';

        $validador = new Validacao();

        // Carrega em um array a base de CEP dos correios.
        $baseCep = BaseCep::lerBaseCep('./BaseCEP/Lista_de_CEPs.xlsx', 'D', 'E');
        // diretório onde irá salvar o arquivo que será validado.
        $dir = "uploads/";
        // recebendo o arquivo multipart
        $file = $_FILES["arquivo"];
        $primeiraColuna = $_POST['primeiraColuna'];
        $segundaColuna = $_POST['segundaColuna'];

        //=====================================================================
        // Move o arquivo da pasta temporaria de upload para a pasta de destino
        // INICIA AS VALIDAÇÕES
        //=====================================================================
        if (move_uploaded_file($file["tmp_name"], "$dir/".$file["name"])) {
            if(!isset($primeiraColuna) || empty($primeiraColuna)){
                echo "<br><br><h1>Atenção, informe corretamente as colunas para análise!</h1>";
                echo "<p>Caso exista apenas uma coluna, informe no campo 'PRIMEIRA COLUNA'.</p>";
                die();
            }
            $arquivo = BaseCep::lerBaseCep("$dir/".$file["name"], $primeiraColuna, $segundaColuna);
            // INICIO DAS VALIDAÇÕES ==========================================
            $validador->validar($arquivo);
        }
        // CEPs diferentes
        else {
            echo "Erro, o arquivo não pode ser enviado.";
        }

        if(!isset($arquivo) || empty($arquivo)) {
            echo "<br><br><h1>Nenhum arquivo carregado! Retorne e envie o arquivo!</h1>";
            echo "<p>Que beleza ein... Tenha mais atenção né bixo!</p>";
            die();
        }

        //================================================================
        // VERIFICA SE O CEP EXISTE NA BASE DE DADOS
        //================================================================
        $resultadoComparacao = array_diff($arquivo, $baseCep);
        if(!empty($resultadoComparacao)){
            foreach ($resultadoComparacao as $value) {
                if (!in_array($value, $validador->ceps_incorretos)) {
                    array_push($validador->ceps_inexistentes, $value);
                }
            }
        }

        //========================================================
        // IMPRIME NO HTML OS RESULTADOS
        //========================================================
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
    ?>
    <br>
    </div>
</body>
</html>