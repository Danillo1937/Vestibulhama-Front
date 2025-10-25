<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Perfil - Universidade</title>
  <link rel="stylesheet" href="../Perfil/perfil.css">
<style>
    html, body { height: 100%; }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }

    .pai {
      flex: 1;
    }
</style>
</head>
<body>
<?php
include_once('../BD/conexao.php');
include_once('../navbar/navbar.php');

// Verifica se o usuário está logado
$idUsuario = $_SESSION['id_usuario'] ?? null;
if (!$idUsuario) {
  echo "<p style='text-align:center; color:red;'>Você precisa estar logado para acessar o perfil.</p>";
  exit;
}

// Busca dados atuais
$query = "SELECT nome, foto FROM usuario WHERE id = ?";
$stmt = mysqli_prepare($conexao, $query);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

// Processa alterações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $novoNome = $_POST['novo_nome'] ?? $usuario['nome'];
  $fotoNome = $usuario['foto'];

  // Se enviou nova foto
  if (!empty($_FILES['nova_foto']['name'])) {
    $ext = pathinfo($_FILES['nova_foto']['name'], PATHINFO_EXTENSION);
    $fotoNome = 'perfil_' . $idUsuario . '.' . $ext;
    move_uploaded_file($_FILES['nova_foto']['tmp_name'], "../imagesQ/$fotoNome");
  }

  // Atualiza no banco
  $update = "UPDATE usuario SET nome = ?, foto = ? WHERE id = ?";
  $stmtUpdate = mysqli_prepare($conexao, $update);
  mysqli_stmt_bind_param($stmtUpdate, "ssi", $novoNome, $fotoNome, $idUsuario);
  mysqli_stmt_execute($stmtUpdate);

  echo "<script>alert('Perfil atualizado com sucesso!'); </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Perfil - Universidade</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class = "pai" style = "display: flex; justify-content: center; align-items: center;">
  <div class="container" style="margin-top:50px;">
    <form method="post" enctype="multipart/form-data">
      <div class="profile-photo">
        <?php if (!empty($usuario['foto'])): ?>
          <img id="previewFoto" src="../images_perfil/<?= htmlspecialchars($usuario['foto']) ?>" style="width:150px; border-radius:50%;">
        <?php else: ?>
          <img id="previewFoto" src="../images_perfil/ImagemUser.png" alt="Foto padrão" style="width:150px; border-radius:50%;">
        <?php endif; ?>
      </div>

      <label class="btn-photo">
        Alterar Foto
        <input id="inputFoto" type="file" name="nova_foto" accept="image/*" style="display:none;">
      </label>

      <input type="text" name="novo_nome" value="<?= htmlspecialchars($usuario['nome']) ?>" placeholder="Nome completo" required>

      <button type="submit" class="btn-save">Salvar Alterações</button>
    </form>
  </div>
</div>
  <script>
  const inputFoto = document.getElementById('inputFoto');
  const previewFoto = document.getElementById('previewFoto');

  inputFoto.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewFoto.src = e.target.result; // Update the image preview
      };
      reader.readAsDataURL(file);
    }
  });
</script>

</body>
</html>

<?php
  include_once('../footer/footer.html');
?>