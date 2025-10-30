<?php
$pageTitle = 'Escolher Anos';
session_start();
// process POST before any output/includes so header() can redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['anos'] = $_POST['anos'] ?? [];
    header("Location: escolherMaterias.php");
    exit;
}

$vestibulares = $_SESSION['vestibulares'] ?? [];

include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/VestibularesSelecao/vestibularesEscolha.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/BD/conexao.php');

if (empty($vestibulares)) {
    echo "<p style='text-align:center; color:white;'>Nenhum vestibular selecionado.</p>";
    exit;
}

$vestStr = implode(',', array_map('intval', $vestibulares));
$vestQuery = "SELECT id, nome FROM vestibular WHERE id IN ($vestStr)";
$vestResult = mysqli_query($conexao, $vestQuery);

$nomes = [];
while ($row = mysqli_fetch_assoc($vestResult)) {
    $nomes[] = $row['nome'];
}

echo "<h2 style='text-align:center; color:white;'>Selecione os anos de <span style='color:violet;'>" . implode(', ', $nomes) . "</span></h2>";
echo "<form method='post'>";
echo "<div class='cards-wrapper'>"; 

$anoQuery = "SELECT DISTINCT ano FROM questao WHERE id_vestibular IN ($vestStr) ORDER BY ano DESC";
$anoResult = mysqli_query($conexao, $anoQuery);

while ($row = mysqli_fetch_assoc($anoResult)) {
    $ano = $row['ano'];
    echo "<div class='card card-container'>";
    echo "<label>";
    echo "<input type='checkbox' name='anos[]' value='$ano'>";
    echo "<img src='../images/$ano.png' alt='Ano $ano'>";
    echo "<p>$ano</p>";
    echo "</label>";
    echo "</div>";
}

echo "</div>";
echo "<button type='submit' class='botao'>Próximo</button>";
echo "</div>";
echo "</form>";

mysqli_close($conexao);
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/footer/footer.html');
?>
</body>
</html>


