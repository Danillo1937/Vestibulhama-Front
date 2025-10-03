<?php
include_once('../BD/conexao.php');

if (isset($_GET['vestibular'])) {
    $vestibularId = $_GET['vestibular'];

    // Buscar os anos disponíveis para esse vestibular
    $query = "SELECT DISTINCT ano FROM questao WHERE id_vestibular = ? ORDER BY ano DESC";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "i", $vestibularId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    echo "<h2>Selecione o Ano</h2>";
    echo "<div class='container'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $ano = $row['ano'];
        echo "<div class='card'>";
        echo "<a href='questoes.php?vestibular=$vestibularId&ano=$ano'>";
        echo "<img src='../images/$ano.png' alt='Ano $ano'>";
        echo "<p>Questões $ano</p>";
        echo "</a>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "<p>Nenhum vestibular selecionado.</p>";
}

mysqli_close($conexao);
?>
