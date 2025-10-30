<?php
$pageTitle = 'Simulado';
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
?>
<style>
.page-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.page-content {
    flex: 1 0 auto;
    padding-bottom: 40px;
}
</style>
<?php
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/Vestibulares/vestibulares.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
?>
<div class="page-wrapper">
    <div class="page-content">
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/BD/conexao.php');

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

    echo "<form class='form' method='post'>";
    echo "<input type='hidden' name='vestibular' value='$vestibularId'>";
    echo "<input type='hidden' name='ano' value='$ano'>";
    echo "<div class='questoes-container'>";

    $respostas = $_POST['resposta'] ?? [];
    $acertos = 0;

    foreach ($questoes as $i => $q) {
        echo "<div class='questao'>";
        echo "<p class='questao-enunciado'>Enunciado: " . $q['enunciado'] . "</p>";
        echo "<img src='../imagesQ/" . $q['foto'] . "' alt='Imagem da questão' style='max-width:300px;'><br>";

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

        // botão usa a mesma aparência dos formulários de cadastro (classe .form button)
        echo "<button type='submit' class='botao' style='margin:20px auto; display:block;'>Enviar Respostas</button>";
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
    $nomeUsuario = "Visitante";  
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
?>
    </div>
    <?php include_once('../footer/footer.html'); ?>
</div>
