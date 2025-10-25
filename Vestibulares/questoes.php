<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulado</title>
    <link rel="stylesheet" href="../Vestibulares/vestibulares.css">
    <style>
        .questao-enunciado, .questao-alternativas {
            color: white;
        }

        body {
  background-color: #121212;
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
  color: #f0f0f0;
}

h2 {
  font-family: 'Jersey 10', sans-serif;
  font-size: 32px;
  margin-top: 40px;
  text-align: center;
  color: #fff;
}

.questoes-container {
  width: 90%;
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
  background-color: #1e1e1e;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0,0,0,0.5);
}

.questao {
  margin-bottom: 30px;
  padding: 15px;
  background-color: #2a2a2a;
  border-radius: 6px;
}

.questao-enunciado {
  margin: 10px 0;
  line-height: 1.5;
    font-size: 20px;
}

.questao img {
  max-width: 100%;
  height: auto;
  margin: 10px auto;
  display: block;
  border-radius: 4px;
}

.questao-alternativas label {
  display: block;
  margin: 8px 0;
  padding: 8px 12px;
  background-color: #3a3a3a;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.questao-alternativas label:hover {
  background-color: #4a4a4a;
}

input[type="radio"] {
  margin-right: 10px;
  accent-color: #531f91;
}

button[type="submit"] {
  background-color: #531f91;
  color: white;
  border: none;
  padding: 12px 24px;
  font-size: 20px;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  display: block;
  margin: 20px auto;
  font-family:"jersey 10", sans-serif;
}

button[type="submit"]:hover {
  background-color: #6b2bbd;
  
}

hr {
  border: none;
  border-top: 1px solid #444;
  margin: 20px 0;
}
    </style>
</head>
<body>

<?php
include_once('../navbar/navbar.php');
include_once('../BD/conexao.php');

$vestibularId = $_GET['vestibular'] ?? $_POST['vestibular'] ?? null;
$ano = $_GET['ano'] ?? $_POST['ano'] ?? null;

if ($vestibularId && $ano) {
    echo "<h2 style='text-align:center; color:white;'>Simulado - $ano</h2>";

    // Recarrega as questões do banco
    $query = "SELECT * FROM questao WHERE id_vestibular = ? AND ano = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "ii", $vestibularId, $ano);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $questoes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $questoes[] = $row;
    }

    echo "<form method='post'>";
    echo "<input type='hidden' name='vestibular' value='$vestibularId'>";
    echo "<input type='hidden' name='ano' value='$ano'>";
    echo "<div class='questoes-container'>";

    $respostas = $_POST['resposta'] ?? [];
    $acertos = 0;

    foreach ($questoes as $i => $q) {
        echo "<div class='questao'>";
        echo "<p class='questao-enunciado'>Enunciado: " . $q['enunciado'] . "</p>";
        echo "<img src='../images_U/" . $q['foto'] . "' alt='Imagem da questão' style='max-width:300px;'><br>";

        $correta = strtoupper(trim($q['alt_correta'])); // Letra correta (A–E)
        $respostaUsuario = $respostas[$i] ?? null;

        echo "<div class='questao-alternativas'>";
        foreach (['a','b','c','d','e'] as $j => $alt) {
            $letra = chr(65 + $j); // A, B, C, D, E
            $checked = ($respostaUsuario === $letra) ? "checked" : "";
            echo "<label>";
            echo "<input type='radio' name='resposta[$i]' value='$letra' $checked> $letra) " . $q[$alt];
            echo "</label><br>";
        }
        echo "</div>";

        // Feedback por questão
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($respostaUsuario === $correta) {
                echo "<p style='color:lime;'> ✔ Você acertou!</p>";
                $acertos++;
            } else {
                echo "<p style='color:red;'> ✘ Você errou. Resposta correta: $correta</p>";
            }
        }

        echo "</div><hr>";
    }

    echo "<button type='submit' style='margin:20px auto; display:block;'>Enviar Respostas</button>";
    echo "</div>";
    echo "</form>";

    // Resultado final
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<div style='text-align:center; color:white; margin-top:30px;'>";
        echo "<h3>Você acertou <span style='color:lime;'>$acertos</span> de " . count($questoes) . " questões!</h3>";
        echo "</div>";
    }
} else {
    echo "<p style='text-align:center; color:white;'>Selecione um vestibular e um ano para visualizar as questões.</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeUsuario = "Visitante"; // Você pode substituir por login futuramente   
    $total = count($questoes);

    $insert = "INSERT INTO ranking (nome_usuario, vestibular_id, ano, acertos, total_questoes) 
               VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = mysqli_prepare($conexao, $insert);
    mysqli_stmt_bind_param($stmtInsert, "siiii", $nomeUsuario, $vestibularId, $ano, $acertos, $total);
    mysqli_stmt_execute($stmtInsert);
}

$nomeUsuario = $_SESSION['usuario'] ?? 'Visitante';
$idUsuario = $_SESSION['id_usuario'] ?? null;

$insert = "INSERT INTO ranking (nome_usuario, vestibular_id, ano, acertos, total_questoes) 
           VALUES (?, ?, ?, ?, ?)";
$stmtInsert = mysqli_prepare($conexao, $insert);
mysqli_stmt_bind_param($stmtInsert, "siiii", $nomeUsuario, $vestibularId, $ano, $acertos, $total);
mysqli_stmt_execute($stmtInsert);

mysqli_close($conexao);
include_once('../footer/footer.html');
?>
</body>
</html>
