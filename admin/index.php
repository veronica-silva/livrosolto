<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../visualizacoes/bootstrap.css">
    <title>Area administrativa</title>
</head>
<header>
<?php
use Projeto\ControleDeAcesso;
require_once "./vendor/autoload.php";
$sessao = new ControleDeAcesso;

if(isset($_SESSION['id'])){
    require_once "../inc/cabecalho-logado.php";
    } else {
    require_once "../inc/cabecalho-geral.php";
    }

?>
</header>
<body>


<section>
    <h1>Administrador</h1>
    <div>
        <a class="btn btn-primary" href="livros.php">Administrar livros</a>
        <a class="btn btn-success" href="usuarios.php">Administrar usuários</a>
    </div>
</section>
</body>
<?php
    require_once "../inc/rodape-geral.php"

?>
<script src="../visualizacoes/bootstrap.bundle.js"></script>
<script src="../js/confirm.js"></script>
</body>
</html>