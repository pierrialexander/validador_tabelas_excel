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

        // Carrega em um array a base de CEP dos correios.
        $baseCep = BaseCep::lerBaseCep('./BaseCEP/Lista_de_CEPs.xlsx', 'D', 'E');

        // diretório onde irá salvar o arquivo que será validado.
        $dir = "uploads/"; 
        // recebendo o arquivo multipart 
        $file = $_FILES["arquivo"];

        $primeiraColuna = $_POST['primeiraColuna'];
        $segundaColuna = $_POST['segundaColuna'];

        // Array que armazenará os CEPs com erros
        $ceps_incorretos = [];
        // Array que armazenará os CEP inexistentes
        $ceps_inexistentes = [];
        // Array que armazenará os CEP inexistentes
        $ceps_duplicados = [];

        $ceps_unicos = [];

        //=====================================================================
        // Move o arquivo da pasta temporaria de upload para a pasta de destino 
        // INICIA AS VALIDAÇÕES
        //=====================================================================
        if (move_uploaded_file($file["tmp_name"], "$dir/".$file["name"])) { 

            $arquivo = BaseCep::lerBaseCep("$dir/".$file["name"], $primeiraColuna, $segundaColuna);

            // INICIO DAS VALIDAÇÕES ==========================================
            foreach ($arquivo as $item) {

                // VERIFICA SE EXISTEM CEPs DUPLICADOS
                if(!in_array($item, $ceps_unicos)){
                    array_push($ceps_unicos, $item);
                }
                else {
                    array_push($ceps_duplicados, $item);
                }

                // VERIFICA SE É SOMENTE NÚMEROS
                if(!is_numeric($item)) {
                    if(!in_array($item, $arquivo)){
                        array_push($ceps_incorretos, $item);
                    }
                }

                // VERIFICA SE CONTÉM LETRAS E CARACTERES
                $padrao = '/^(\d){8}$/';
                if(!preg_match($padrao, (string) $item)) {
                    if(!in_array((int)$item, $arquivo)){
                        array_push($ceps_incorretos, $item);
                    }
                }

                // VERIFICA SE ALGUM ITEM EXISTENTE É VAZIO
                if(empty($item) || is_null($item)) {
                    if(!in_array((int)$item, $arquivo)){
                        array_push($ceps_incorretos, $item);
                    }
                }

                
            }
        }
        // CEPs diferentes
        else { 
            echo "Erro, o arquivo não pode ser enviado."; 
        }

        //================================================================
        // VERIFICA SE O CEP EXISTE NA BASE DE DADOS
        //================================================================
        $resultadoComparacao = array_diff($arquivo, $baseCep);
        if(!empty($resultadoComparacao)){
            foreach ($resultadoComparacao as $value) {
                if (!in_array($value, $ceps_incorretos)) {
                    array_push($ceps_inexistentes, $value);
                }
            }
        }  
        
        //========================================================
        // IMPRIME NO HTML OS RESULTADOS
        //========================================================
        echo "<br><h3>CEPs com caracteres incorretos: </h3>";
        echo '<p class="totais">Total: ' . count($ceps_incorretos) . "</p>";
        foreach ($ceps_incorretos as $items) {
            echo "$items<br>";
        }       
        echo "<br><h3>CEPs não encontrados na base dos correios: </h3>";
        echo '<p class="totais">Total: ' . count($ceps_inexistentes) . "</p>";
        foreach ($ceps_inexistentes as $items) {
            echo "$items<br>";
        }
        echo "<br><h3>CEPs Duplicados: </h3>";
        echo '<p class="totais">Total: ' . count($ceps_duplicados) . "</p>";
        foreach ($ceps_duplicados as $items) {
            echo "$items<br>";
        } 
    
    ?>
    <br>
    </div>
</body>
</html>