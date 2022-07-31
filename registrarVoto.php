<?php

// Conecta com o banco de dados
include ('connect.php');

/** Objeto com os votos do usuário */
$votos = json_decode(file_get_contents('php://input'))->votos;

// Registra  os votos no banco de dados
foreach( $votos as $v) {
  $query = sprintf("
  UPDATE Candidato
  SET votos = votos + 1
  WHERE titulo = '%s' and numero = '%s';
  ",
  mysqli_real_escape_string($conn, $v->etapa),
  mysqli_real_escape_string($conn, $v->numero),
  );

  // Retorna erro em caso de falha na query
  if(!$conn->query($query)) {
    http_response_code(207);
    echo ("Erro ao registrar voto de " . $v->etapa . "<br>");
  };
}
?>
