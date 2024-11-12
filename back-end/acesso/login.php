<?php

require_once __DIR__ . "/../database/conexao-mysql.php";
require_once "autenticacao.php";
require_once __DIR__ . "/../classes/redirect-response.php";

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

  $sql = <<<SQL
    SELECT ID
    FROM ANUNCIANTE
    WHERE EMAIL = ?
    SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  // Armazena dados úteis para confirmação 
  // de login em outros scripts PHP
  $_SESSION['emailUsuario'] = $email;
  $_SESSION['idUsuario'] = $stmt->fetchColumn();
  $_SESSION['loginString'] = hash('sha512', $senhaHash . $_SERVER['HTTP_USER_AGENT']);
  
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(new Response(true, '/front-end/pages/meus-anuncios.html'));
}
else {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(new Response(false, '', 'Email ou senha inválidos'));
}

exit();