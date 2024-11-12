<?php
// Usei usuário como sendo sinônimo de anunciante, que é o usuário que precisará estar logado

require_once __DIR__ . "/../database/conexao-mysql.php";
require_once __DIR__ . "/../classes/redirect-response.php";

$pdo = mysqlConnect();

$request = file_get_contents('php://input');
$_POST = json_decode($request, true);

// Seta as variáveis com o que veio do front
$nome = $_POST["nome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";
$telefone = $_POST["telefone"] ?? "";

$hashSenha = password_hash($senha, PASSWORD_DEFAULT);

$cadastraUsuario = <<<SQL
  INSERT INTO ANUNCIANTE (NOME, CPF, EMAIL, SENHA_HASH, TELEFONE)
  VALUES (?, ?, ?, ?, ?)
  SQL;

try {
  $pdo->beginTransaction();

  $cpf = preg_replace('/[^0-9]/', '', $cpf); // Remove caracteres não numéricos

  $stmt1 = $pdo->prepare($cadastraUsuario);
  $stmt1->execute([$nome, $cpf, $email, $hashSenha, $telefone]);

  $pdo->commit();

  echo json_encode(new Response(true, '/front-end/pages/login.html'));
  exit();
} 
catch (Exception $e) {
  $pdo->rollBack();
  if ($e->errorInfo[1] === 1062)
    echo json_encode(new Response(false, '', 'Dados já cadastrados'));
  else
  echo json_encode(new Response(false, '', 'Erro ao cadastrar usuário'));
}