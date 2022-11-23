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

        // recebendo o arquivo multipart
        $file = $_FILES["arquivo"];

        var_dump($file['name']);

        //var_dump($file['type']);

        if ($file['type'] == 'text/csv') {
            if (move_uploaded_file($file["tmp_name"], "uploads/" . $file["name"])) {
                $dados = CSV::lerArquivo("uploads/" . $file["name"], true, ';');
                $resultado = CSV::criarArquivoCSVCorrigido("uploads/arquivo-verificado.csv", $dados, ';');
                echo "<br><br><h1>Arquivo CSV verificado e gerado com sucesso!!</h1>";
                echo "<br><h3>Clique no Link Abaixo para baixar o arquivo verificado</h3>";
                echo "<br><a href='uploads/arquivo-verificado.csv'>Acessar Arquivo CSV</a>";
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