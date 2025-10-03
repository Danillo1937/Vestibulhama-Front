<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Ano</title>
    <link rel="stylesheet" href="../Vestibulares/vestibulares.css">
</head>
<body>

<?php
include_once('../navbar/navbar.html');
include_once('../BD/conexao.php');

if (isset($_GET['vestibular'])) {
    $vestibularId = $_GET['vestibular'];

    // Buscar nome do vestibular para exibir no título
    $nomeVestibular = "";
    $vestQuery = "SELECT nome FROM vestibular WHERE id = ?";
    $vestStmt = mysqli_prepare($conexao, $vestQuery);
    mysqli_stmt_bind_param($vestStmt, "i", $vestibularId);
    mysqli_stmt_execute($vestStmt);
    $vestResult = mysqli_stmt_get_result($vestStmt);
    if ($vestRow = mysqli_fetch_assoc($vestResult)) {
        $nomeVestibular = $vestRow['nome'];
    }

    echo "<h2 style='text-align:center; color:white;'>Selecione o Ano de <span style='color:violet;'>$nomeVestibular</span></h2>";
    echo "<div class='container'>";

    // Buscar anos disponíveis para esse vestibular
    $query = "SELECT DISTINCT ano FROM questao WHERE id_vestibular = ? ORDER BY ano DESC";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "i", $vestibularId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

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
    echo "<p style='text-align:center; color:white;'>Nenhum vestibular selecionado.</p>";
}

mysqli_close($conexao);
include_once('../footer/footer.html');
?>

</body>
</html>