<?php

echo ("
<div>
  <h1> Resultado das eleições</h1>
");

// Desenha a tabela de vereadores
tabelaVereadores();

// Desenha a tabela de prefeitos e vice-prefeitos
tabelaPrefeitos();

// Insere o botão que reinicia a eleição
botaoReiniciar();

echo("</div>");

/**
 * Desenha na tela uma tabela contendo todos os vereadores na eleição ordenados
 * por número de votos. O(s) vereador(es) com maior número de votos é(são) marcado(s)
 * em verde para indicar o vencedor ou vencedores no caso de empate.
 */
function tabelaVereadores() {

  // Conecta com o banco de dados
  include ('connect.php');
  
  // Executa a query para obter os resultados das eleições para vereador
  $vereadores = $conn->query("
  SELECT * 
  FROM candidato
  WHERE titulo = 'vereador'
  ORDER BY votos DESC, nome ASC;
  ");
  
  // Retorna erro em caso de falha na query
  if(!$vereadores) {
    http_response_code(500);
    die("Erro ao obter vereadores.");
  }
  
  // Executa a query para obter o número de votos do vereador mais votado
  $max_votos_vereador = $conn->query("
  SELECT max(votos)
  FROM candidato
  WHERE titulo = 'vereador';
  ");
  
  // Retorna erro em caso de falha na query
  if(!$max_votos_vereador) {
    http_response_code(500);
    die("Erro ao obter número de votos do vereador mais votado.");
  }
  
  // Número de votos do vereador mais votado
  $max_votos_vereador = intval($max_votos_vereador->fetch_row()[0]);
  
  // Cabeçalho da tabela
  echo ("
  <table>
    <tr>
      <th colspan=\"4\">Vereador</th>
    </tr>
    <tr>
      <th>Numero</th><th>Nome</th><th>Partido</th><th>Votos</th>
    </tr>
  ");
  
  $row = $vereadores->fetch_assoc();
  
  // Insere os vereadores na tabela
  do {
    if (intval($row['votos']) == $max_votos_vereador and $max_votos_vereador != 0) {
      $tr = "<tr class=\"vencedor\">";
    } else {
      $tr = "<tr>";
    }
    
    $tr .= sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td> </tr>",
      $row['numero'], $row['nome'], $row['partido'], $row['votos']);
    echo($tr);
    $row = $vereadores->fetch_assoc();
  } while ( $row != null);
  
  echo("</table>");

}


/**
 * Desenha na tela uma tabela contendo todos os prefeitos e vice-prefeitos na eleição
 * ordenados por número de votos. O(s) prefeito(s) com maior número de votos
 * é(são) marcado(s) em verde para indicar o vencedor ou vencedores no caso de empate.
 */
function tabelaPrefeitos() {
  
  // Conecta com o banco de dados
  include ('connect.php');
  
  // Executa a query para obter os resultados das eleições para prefeito
  $prefeitos = $conn->query("
  SELECT *
  FROM candidato INNER JOIN vice USING (numero)
  WHERE titulo = 'prefeito'
  ORDER BY votos DESC, candidato.nome ASC;
  ");
  
  // Retorna erro em caso de falha na query
  if(!$prefeitos) {
    http_response_code(500);
    die("Erro ao obter prefeitos.");
  }
  
  // Executa a query para obter o número de votos do prefeito mais votado
  $max_votos_prefeito = $conn->query("
  SELECT max(votos)
  FROM candidato
  WHERE titulo = 'prefeito';
  ");
  
  // Retorna erro em caso de falha na query
  if(!$max_votos_prefeito) {
    http_response_code(500);
    die("Erro ao obter número de votos do prefeito mais votado.");
  }

  // Número de votos do prefeito mais votado
  $max_votos_prefeito = intval($max_votos_prefeito->fetch_row()[0]);
  
  // Cabeçalho da tabela
  echo ("
  <table>
    <tr>
      <th colspan=\"3\">Prefeito</th><th colspan=\"2\">vice-prefeito</th>
    </tr>
    <tr>
      <th>Numero</th><th>Nome</th><th>Partido</th><th>Nome</th><th>Partido</th><th>Votos</th>
    </tr>
  ");
  
  $row = $prefeitos->fetch_row();
  
  // Insere os vereadores na tabela
  do {
    if (intval($row[5]) == $max_votos_prefeito and $max_votos_prefeito != 0) {
      $tr = "<tr class=\"vencedor\">";
    } else {
      $tr = "<tr>";
    }
    
    $tr .= sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td> </tr>",
      $row[0], $row[1], $row[3], $row[6], $row[7], $row[5]);
    echo($tr);
    $row = $prefeitos->fetch_row();
  } while ( $row != null);
  
  echo("</table>");
  }

/**
 * Insere na tela um botão que reinicia a contagem dos votos de todos os candidatos
 */
function botaoReiniciar() {
  
  echo("
  <a href=\"./reiniciar.php\">
     <button>Reiniciar Eleição</button>
  </a>
  ");
}

?>

<style>

body {
  background-color: lightgray;
}

h1 {
  text-align: center;
}

div {
  margin-left: auto;
  margin-right: auto;
  width: fit-content;
}

table {
  margin-left: auto;
  margin-right: auto;
  margin-top: 40px;
  width: 100%;
}

table, th, td {
  border: 1px solid;
}

.vencedor {
  background-color: lightgreen;
}

a {
  margin-left: auto;
  margin-right: auto;
  display: table;
}

button {
  margin-top: 40px;
  font-size: 18px; 
}
</style>
