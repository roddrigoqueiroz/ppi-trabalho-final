<?php

require_once __DIR__ . "/../database/conexao-mysql.php";
require_once __DIR__ . "/../acesso/autenticacao.php";
require_once __DIR__ . "/../classes/generic-response.php";

session_start();
$pdo = mysqlConnect();
exitIfNotLogged($pdo);

$idUsuarioLogado = $_SESSION['idUsuario'];

$getAnunciosUsuario = <<<SQL
    SELECT MARCA, MODELO, ANO, CIDADE, VALOR, NOME_FOTO
    FROM ANUNCIO AS A
    JOIN FOTO AS B ON A.ID = B.ID_ANUNCIO
    WHERE A.ID_ANUNCIANTE = ? AND B.FLAG_CAPA 
    SQL;

try {
    // Não é necessário passar pelo prepare, pois estou pegando uma info direto da sessão
    // mas tb não faz mal passar pelo prepare para manter o padrão
    $stmt = $pdo->prepare($getAnunciosUsuario);
    $stmt->execute([$idUsuarioLogado]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
}
catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(new GenericResponse(false, $e->getMessage()));
    exit('ERRO: ' . $e->getMessage());
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(new GenericResponse(true, $result));
exit();

?>