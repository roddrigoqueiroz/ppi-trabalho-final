<?php

require_once "../MySQL/conexaoMysql.php";
require_once "../Login/autenticacao.php";
session_start();

class LoginResponse
{
  public $success;
  public $redirectTo;

  function __construct($success, $redirectTo)
  {
    $this->success = $success;
    $this->redirectTo = $redirectTo;
  }
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$pdo = mysqlConnect();
if ($senhaHash = checkPassword($pdo, $email, $senha)) {
  // Define o parâmetro 'httponly' para o cookie de sessão, para que o cookie
  // possa ser acessado apenas pelo navegador nas requisições http (e não por código JavaScript).
  // Aumenta a segurança evitando que o cookie de sessão seja roubado por eventual
  // código JavaScript proveniente de ataq. X S S.
  $cookieParams = session_get_cookie_params();
  $cookieParams['httponly'] = true;
  session_set_cookie_params($cookieParams);

  // Armazena dados úteis para confirmação 
  // de login em outros scripts PHP
  // TODO RODRIGO: ver o que eu preciso armazenar aqui
  $_SESSION['emailUsuario'] = $email;
  $_SESSION['loginString'] = hash('sha512', $senhaHash . $_SERVER['HTTP_USER_AGENT']);  
  // TODO: arrumar a rota de redirect
  $response = new LoginResponse(true, '../acessoRestrito/home.php');
}
else
  $response = new LoginResponse(false, ''); 

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
exit();