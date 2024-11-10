<?php
// Usei usuário como sendo sinônimo de anunciante, que é o usuário que precisará estar logado

require_once __DIR__ . "/../database/conexao-mysql.php";
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

  $stmt1 = $pdo->prepare($cadastraUsuario);
  print "Nome: $nome, CPF: $cpf, Email: $email, Senha: $hashSenha, Telefone: $telefone";
  $stmt1->execute([$nome, $cpf, $email, $hashSenha, $telefone]);

  $pdo->commit();

  header("location: ../../front-end/pages/meus-anuncios.html");
  exit();
} 
catch (Exception $e) {
  $pdo->rollBack();
  if ($e->errorInfo[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}