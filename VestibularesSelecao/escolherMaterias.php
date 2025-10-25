<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--CSS-->

  <link rel="stylesheet" href="../VestibularesSelecao/vestibularesEscolha.css">
  <!--Fim CSS-->
  <title>Vestibulhama</title>
</head>

<!DOCTYPE html>

<body>
  <?php
session_start();
include_once('../navbar/navbar.php');
include_once('../BD/conexao.php');

// Se o formulário foi enviado, salva as matérias na sessão e redireciona
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['materias'] = $_POST['materias'] ?? [];
    header("Location: provaMontada.php");
    exit;
}
?>

  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../VestibulharesSeleção/vestibularesEscolha.css">
    <title>Vestibulhama - Escolha de Matérias</title>
  </head>

  <body>
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

</body>

</html>