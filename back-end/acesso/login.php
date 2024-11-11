<?php

require_once __DIR__ . "/../database/conexao-mysql.php";
require_once "autenticacao.php";

class Response {
  public $success;
  public $redirect;
  public $message;

  public function __construct($success, $redirect, $message = '') {
    $this->success = $success;
    $this->redirect = $redirect;
    $this->message = $message;
  }
}

session_start();

$request = file_get_contents('php://input');
$_POST = json_decode($request, true);

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
  // TODO: arrumar a rota de redirect
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(new Response(true, '/front-end/pages/meus-anuncios.html'));
}
else {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(new Response(false, '', 'Email ou senha inválidos'));
}

exit();