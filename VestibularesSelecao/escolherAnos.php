<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../VestibularesSelecao/vestibularesEscolha.css">
    <title>Escolher Anos</title>
</head>
<body>
    <?php
session_start();
include_once('../navbar/navbar.php');
include_once('../BD/conexao.php');

// Se o formulário foi enviado, salva os anos na sessão e redireciona
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['anos'] = $_POST['anos'] ?? [];
    header("Location: escolherMaterias.php");
    exit;
}

// Recupera os vestibulares já escolhidos
$vestibulares = $_SESSION['vestibulares'] ?? [];

if (empty($vestibulares)) {
    echo "<p style='text-align:center; color:white;'>Nenhum vestibular selecionado.</p>";
    exit;
}

// Buscar nome dos vestibulares
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

// Buscar anos disponíveis para os vestibulares selecionados
$anoQuery = "SELECT DISTINCT ano FROM questao WHERE id_vestibular IN ($vestStr) ORDER BY ano DESC";
$anoResult = mysqli_query($conexao, $anoQuery);

while ($row = mysqli_fetch_assoc($anoResult)) {
    $ano = $row['ano'];
    echo "<div class='card card-container'>"; // Adicionada a classe card-container
    echo "<label>";
    echo "<input type='checkbox' name='anos[]' value='$ano'>"; // Checkbox visível
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
include_once('../footer/footer.html');
?>
</body>
</html>


