<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Validador - Tabelas de transporte</title>
</head>

<body>
    <div class="container">
        <h1 class="titulo">Validador - Tabelas de Tranportadoras</h1>
        <div class="card">
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>Este procedimento é uma pré verificação dos dados contidos diretamente na tabela Excel ou CSV da transportadora.</p>
                    <footer class="blockquote-footer">Verificação de CEPs válidos e seus carácteres</footer>
                    <footer class="blockquote-footer">Espaçamentos entre caracteres e dados duplipados</footer>
                </blockquote>
            </div>
        </div>
        <form enctype="multipart/form-data" action="main.php" method="POST" >
            <div class="form-group">
                <label for="exampleFormControlFile1">Selecione a tabela da transportadora</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <button type="submit" class="btn btn-secondary">Enviar</button>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>