<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Projeto\Usuario;
use Projeto\ControleDeAcesso;
require_once "./vendor/autoload.php";


// require 'mailer/PHPMailerAutoload.php';

// Mensagem de feedback relacionada ao acesso 
if( isset($_GET['acesso_proibido'])){
	$feedback = "Você deve logar primeiro!";
} elseif ( isset($_GET['campos_obrigatorios'])) {
	$feedback = 'Você deve preencher os dois campos!';
} elseif ( isset($_GET['nao_encontrado'])){
	$feedback = 'Usuário não encontrado';
} elseif ( isset($_GET['senha_incorreta'])){
	$feedback = 'Senha Incorreta!';
} elseif ( isset($_GET['sair'])){
	$feedback = 'Você saiu do sistema';
} elseif ( isset($_GET['faca_o_login'])){
	$feedback = 'Cadastro feito com sucesso! Faça o login para entrar no "Livro Solto"!';
} elseif ( isset($_GET['nao_autorizado'])){
	$feedback = 'Esta página só pode ser acessada por administradores!';
} elseif ( isset($_GET['email_existente'])){
	$feedback = 'Este email não está disponível. Tente novamente!';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Faça seu login para liberar ou conseguir um livro">
    <meta name="keywords" content="login, entrar na conta, acesso a conta">
    <title>Livro Solto - Login</title>
    <link rel="shortcut icon" href="./imagens/logo-e-favicon/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="estilo.css">
</head>

<body class="body-login" style="background-color: #F2C335">

  
<main>
    <section class="vh-99" >
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
              <div class="row g-0 col-12">
                <div class="col-md-6 col-lg-5 d-none d-md-block">
                  <img src="./imagens/login_e_cadastro/garota-com-livro.jpg"
                    alt="Garota de blusa rosa e delineado amarelo com um livro na mão direita" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                  <div class="card-body p-4 p-lg-5 text-black">
    
                    <form action="" method="post" id="form-login" name="form-login">
    
                      <div class="d-flex align-items-center mb-3 pb-1">
                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                        <span class="h1 fw-bold mb-0"><a href="index.php"><img src="./imagens/logo-e-favicon/Logo-sem-fundo-2.png" alt="Letra L com bordas arredondas seguida de Livro Solto, indicando o logo do site" width="25%"></a></span>
                      </div>
    
                      <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Faça login com sua conta</h5>

                      <?php if(isset($feedback)){?>
				                <p class="my-2 alert alert-warning text-center">
			                	<?= $feedback?> <i class="bi bi-x-circle-fill"></i> </p>
                      <?php } ?>
    
                      <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg" />
                      </div>
    
                      <div class="form-outline mb-4">
                        <label class="form-label" for="senha">Senha</label>
                        <input type="password" name="senha" class="form-control form-control-lg" />
                      </div>
    
                      <div class="pt-1 mb-4">
                        <a href="listadelivros.php" alt="Link para visualizar livros disponíveis e entrar na conta"><button class="btn btn-lg btn-block btn-login" type="submit" name="entrar">Login</button></a>
                      </div>
                      <a class="small text-muted esqueceu-a-senha" href="recuperaSenha.php" type="button" title="recuperar senha">Esqueceu a senha?</a>
                      <a href="cadastro.php" alt="Link para cadastrar uma conta"><p class="mb-5 pb-lg-2 mt-2" >Não possui cadastro? Cadastre-se</p></a>
                      <a class="small text-muted termos mx-3" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Termos de uso</a>
                      <a href="#!" class="small text-muted privacidade" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalDois">Política de privacidade</a>
                    </form>
<?php
// Verificação de campos do formulário
if (isset($_POST['entrar'])){
if(empty($_POST['email']) || empty($_POST['senha'])){
	header("location:login.php?campos_obrigatorios");
} else {
  // Buscando um usuário no banco de dados para fazer o login 
  $usuario = new Usuario;
	$usuario->setEmail($_POST['email']);
  $dados = $usuario->buscar();
	if (!$dados)	{
		header ("location:login.php?nao_encontrado");
	} else {
		if(password_verify($_POST['senha'], $dados['senha'])){
      $sessao = new ControleDeAcesso;
			$sessao->login($dados['id'], $dados['nome'], $dados['tipo']);
			header("location:listadelivros.php");
		} else {
      header ("location:login.php?senha_incorreta");
		}
	}
}

// Criando sistema de recuperação de senha 


}



?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  
  <div class="modal fade campoModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Termos de uso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <ul>
        <li>Não será permitido a utilização do site para fins de vendas de produtos, mesmo de livros. Caso a prática seja identificada,
          a conta será imeditamanete banida.
        </li>
        <hr>
        <li>A LivroSolto preza pela honestidade e respeito, portanto, caso alguma troca ou doação sejam acordados e esse não seja devidamente cumprido,
          nos vemos no direito de suspender a conta pelo prazo de 3 dias úteis.
        </li>
        <hr>
        <li>A LivroSolto condena qualquer prática criminosa de preconceito, racisco, homofobia e assédio. Caso algum desses comportamentos sejam identificados, a LivroSolto
          se encontrará no direito de banir a conta permanentemente e repassar o ocorrido para autoridades.
        </li>
        <hr>
        <li>Não será tolerado contas com identidade fraudulentas. A consequência para tal caso, será o banimento imediato.</li>
        <hr>
        <li>Para todos usuários solicitamos o respeito, a honestidade e compromisso.</li>
      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade campoModal" id="exampleModalDois" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Política de privacidade</h5>
      

      </p>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <ul>
        <li>A livro solto se compromete com a segurança dos dados de seus usuários com padrões rigorosos.</li>
      <hr>
        <li>A livro solto se dispõe no direito de solicitar dados de seus usuários para efetuação do cadastro que será movimentado na utilização do site</li>
      <hr>
        <li>A livro solto se compromete a não utilizar os dados fornecidos pelos usuários, para realizar envios de propagandas, spam, ou ofertas de produtos.</li>
      <hr>
        <li>Todo e qualquer dado fornecido pelo usuário será utilizado apenas com intuito de utilização site e para a identificação do mesmo.</li>
    </ul>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade campoModal p-4" id="exampleModalSenha" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog p-4">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Recupere sua senha</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form class="p-4" action="" method="post">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Digite o email cadastrado para a recuperação</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="recSenha">
        <div id="emailHelp" class="form-text" aria-placeholder="exemplo@gmail.com.br">exemplo@gmail.com.br</div>
        <?php

if (isset($_POST['recuperar'])){

$mail = new PHPMailer();
$mail->CharSet = "UTF-8";
$recuperaEmail = $_POST['recSenha'];

try{
$mail->isSMTP();
$mail->Host = 'smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'c1495e88955fa0';
$mail->Password = '37e3f22486e5b5';
$mail->Port = 2525;


$mail->setFrom('suporte@livrosolto.com.br');
$mail->addReplyTo('no-reply@email.com.br');
$mail->addAddress($recuperaEmail, 'Nautico 700');
$mail->addCC('lunagabri@gmail.com', 'Gabriel');
// $mail->addBCC('email@email.com.br', 'Cópia Oculta');


$mail->isHTML(true);
$mail->Subject = 'Assunto do email';
$mail->Body    = 'Este é o conteúdo da mensagem em <b>HTML!</b>';
$mail->AltBody = 'Para visualizar essa mensagem acesse http://site.com.br/mail';
// $mail->addAttachment('/tmp/image.jpg', 'nome.jpg');

$mail->send();
  echo 'Mensagem enviada com sucesso.<br>';

} catch (Exception $e) {
  echo 'Erro: ' . $mail->ErrorInfo;}
};


?>
      </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      <button type="submit"  class="btn btn-primary ver-disponiveis" name="recuperar">Recuperar senha</button>
      </form>
      

        </div>
      </div>
    </div>
  </div>
  
    
  
<script src="bootstrap.bundle.js"></script>
<script src="nosso.js"></script>
</body>

</html>