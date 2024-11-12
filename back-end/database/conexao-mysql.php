<?php

function mysqlConnect()
{
  $db_host = "localhost";
  $db_username = "rodrigo";
  $db_password = "logarNoMysql";
  $db_name = "TRABALHO_FINAL_PPI";

  $conn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

  $options = [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ];

  try {
    $pdo = new PDO($conn, $db_username, $db_password, $options);
    return $pdo;
  } 
  catch (Exception $e) {
    exit('Erro: ' . $e->getMessage());
  }
}

?>