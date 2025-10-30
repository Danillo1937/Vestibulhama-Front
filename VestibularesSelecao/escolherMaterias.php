<?php
$pageTitle = 'Escolha de Matérias';
session_start();

// process POST before any output/includes so header() can redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['materias'] = $_POST['materias'] ?? [];
    header("Location: provaMontada.php");
    exit;
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/VestibularesSelecao/vestibularesEscolha.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/BD/conexao.php');
?>

<form method="post">
  <h2 style="text-align:center; color:white;">Selecione as matérias</h2>
  <div class="cards-wrapper">
    <?php
    // Busca todas as matérias cadastradas
    $query = "SELECT id, nome FROM materia ORDER BY nome ASC";
    $result = mysqli_query($conexao, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $nome = ucfirst($row['nome']); // primeira letra maiúscula
        $img = strtolower($row['nome']); // para bater com o nome do arquivo de imagem

        echo "<div class='card card-container'>";
        echo "  <label for='materia$id'>";
        echo "    <input type='checkbox' name='materias[]' value='$id' id='materia$id'>";
        echo "    <img src='../images/$img.png' alt='$nome' class='card-image'>";
        echo "    <div class='checkmark'></div>";
        echo "    <div class='card-title'>$nome</div>";
        echo "  </label>";
        echo "</div>";
    }
    ?>
  </div>

  <div style="text-align:center; margin-top:20px;">
    <button type="submit" class="botao">Montar Prova</button>
  </div>
</form>

<?php include_once('../footer/footer.html'); ?>
</body>
</html>