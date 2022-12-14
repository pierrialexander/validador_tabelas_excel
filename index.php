<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Validador - Tabelas de transporte</title>
</head>

<body>
    <!-- <div class="loading centralize">
        <label>Carregando...</label>
    </div> -->
    <div class="container">
        
        <h1 class="titulo">Validador - Tabelas de Tranportadoras</h1>

        <div class="card">

            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>Este procedimento é uma pré verificação dos dados contidos diretamente na tabela Excel ou CSV da transportadora.</p>
                    <footer class="blockquote-footer">Verificação de CEPs inválidos, duplicados e seus carácteres</footer>
                    <footer class="blockquote-footer">Verificação de siglas tarifárias, espaçamento entre carácteres e carácteres incorretos.</footer>
                </blockquote>
            </div>

        </div>

        <form enctype="multipart/form-data" action="ValidaCSV.php" method="POST">
            <h2>CSV</h2>
            <div class="form-group">
                <label for="exampleFormControlFile1">Selecione a tabela <strong>CSV</strong> de Prazo</label>
                <input type="file" class="form-control-file" name="arquivoPrazo" id="exampleFormControlFile1">
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Selecione a tabela <strong>CSV</strong> de Preço</label>
                <input type="file" class="form-control-file" name="arquivoPreco" id="exampleFormControlFile1">
            </div>
            <button type="submit" class="btn btn-secondary" onclick="showLoading()">Enviar e Validar</button>
        </form>


        <form enctype="multipart/form-data" action="Valida.php" method="POST">
            <h2>EXCEL</h2>
            <div class="form-group">
                <label for="exampleFormControlFile1">Selecione a tabela <strong>EXCEL</strong> da transportadora</label>
                <input type="file" class="form-control-file" name="arquivo" id="exampleFormControlFile1">
            </div>
            <div class="form-group">
                <label for="primeiraColuna">Letra da Primeira Coluna de CEPs</label>
                <input type="text" class="form-control letras" name="primeiraColuna" placeholder="Primeira Coluna de CEPs">
            </div>
            <div class="form-group">
                <label for="segundaColuna">Letra da Segunda Coluna de CEPs</label>
                <input type="text" class="form-control letras" name="segundaColuna" placeholder="Segunda Coluna de CEPs">
            </div>
            <button type="submit" class="btn btn-secondary">Enviar</button>
        </form>


    </div>
    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>