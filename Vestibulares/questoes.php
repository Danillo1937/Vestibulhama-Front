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
    </style>
</head>
<body>

<?php
include_once('../navbar/navbar.html');
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
        echo "<p class='questao-enunciado'><strong>Enunciado:</strong> " . $q['enunciado'] . "</p>";
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
                echo "<p style='color:lime;'><strong>✔ Você acertou!</strong></p>";
                $acertos++;
            } else {
                echo "<p style='color:red;'><strong✘ Você errou.</strong> Resposta correta: $correta</p>";
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

session_start();
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
