<?php
require_once __DIR__ . "/../classes/redirect-response.php";

function checkPassword($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT SENHA_HASH
    FROM ANUNCIANTE
    WHERE EMAIL = ?
    SQL;

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $senhaHash = $stmt->fetchColumn();

    if (!$senhaHash) 
      return false; // email não encontrado

    if (!password_verify($senha, $senhaHash))
      return false; // senha incorreta
      
    // email e senha corretos
    return $senhaHash;
  } 
  catch (Exception $e) {
    exit('ERRO: ' . $e->getMessage());
  }
}

function checkLogged($pdo)
{
  // Verifica se as variáveis de sessão criadas
  // no momento do login estão definidas
  if (!isset($_SESSION['emailUsuario'], $_SESSION['idUsuario'], $_SESSION['loginString']))
    return false;

  $email = $_SESSION['emailUsuario'];

  // Resgata a senha hash armazenada para conferência
  $sql = <<<SQL
    SELECT SENHA_HASH
    FROM ANUNCIANTE
    WHERE EMAIL = ?
    SQL;

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $senhaHash = $stmt->fetchColumn();
    if (!$senhaHash) 
      return false; // nenhum resultado (email não encontrado)

    // Gera uma nova string de login com base nos dados
    // atuais do navegador do usuário e compara com a
    // string de login gerada anteriormente no momento do login
    $loginStringCheck = hash('sha512', $senhaHash . $_SERVER['HTTP_USER_AGENT']);
    if (!hash_equals($loginStringCheck, $_SESSION['loginString']))
      return false;

    return true;
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

function exitIfNotLogged($pdo)
{
  if (!checkLogged($pdo)) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(new Response(false, '/front-end/pages/login.html'));
    exit();
  }
}

?>