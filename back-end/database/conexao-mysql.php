<?php

function mysqlConnect()
{
  $db_host = "sql313.infinityfree.com";
  $db_username = "if0_37661396";
  $db_password = "rCgDExYne4Ty";
  $db_name = "if0_37661396_db_trabalho_final";

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