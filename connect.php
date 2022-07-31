<?php
/** Nome do servidor do banco de dados */
$servername = "us-cdbr-east-06.cleardb.net";

/** Nome do banco de dados */
$database = "heroku_c7d7d965670dc52";

/** Nome do usuário */
$username = "bcad87153000c8";

/** Senha do usuário */
$password = "30015693";

/** Conexão com o banco de dados */
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

if($_GET and boolVal($_GET["teste"])) {
  echo("Conexão bem sucedida.");
}

?>
