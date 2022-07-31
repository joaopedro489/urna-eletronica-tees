<?php

// Conecta com o banco de dados
include ('connect.php');

/** Requisição que reinicia a contagem de votos no banco de dados */
$r = $conn->query("
  UPDATE Candidato
  SET votos = 0
");

// Retorna erro em caso de falha na query.
// Caso contrário, redireciona de volta para a página de resultados.
if(!$r) {
  http_response_code(500);
  die("Erro ao reiniciar votos.");
}
else {
  header("Location: ./resultado.php");
  die();
}

?>
