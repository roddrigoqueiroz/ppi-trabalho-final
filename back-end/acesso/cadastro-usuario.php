<?php
// Usei usuário como sendo sinônimo de anunciante, que é o usuário que precisará estar logado

require "../database/conexao-mysql.php";
$pdo = mysqlConnect();

// Seta as variáveis com o que veio do front
$nome = $_POST["nome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";
$telefone = $_POST["telefone"] ?? "";

$hashSenha = password_hash($senha, PASSWORD_DEFAULT);

$cadastraUsuario = <<<SQL
  INSERT INTO ANUNCIANTE (NOME, CPF, EMAIL, SENHA_HASH, TELEFONE)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

try {
  $pdo->beginTransaction();

  $stmt1 = $pdo->prepare($cadastraUsuario);
  if (!$stmt1->execute([$nome, $cpf, $email, $hashSenha, $telefone]))
    throw new Exception('Falha na primeira inserção');

  if(filter_has_var(INPUT_POST,'checkBox')){
    $stmt3 = $pdo->prepare($sql3);
    if (!$stmt3->execute([
      $idNovaPessoa, $especialidade, $crm
    ])) throw new Exception('Falha na terceira inserção');
  }

  $pdo->commit();

  header("location: home.php");
  exit();
} 
catch (Exception $e) {
  $pdo->rollBack();
  if ($e->errorInfo[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}