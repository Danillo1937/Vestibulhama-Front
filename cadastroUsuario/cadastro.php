
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestibulhama - Cadastro</title>
  <link rel="stylesheet" href="cadastro.css">
</head>
<body>

  
  <div class="pai">
<div class="logo">
    <!-- Ícone de lhama (troque a URL pela sua logo se quiser) -->
    <img src="../images/logo nova sla to cansado.png" alt="Logo">
    Vestibulhama
  </div>
  <div class="container">
    

    <h2>CRIAR USUÁRIO</h2>
<form class="form" method="post" action="cadastro.php">
  <input type="text" name="nome" placeholder="Nome" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="senha" placeholder="Senha" required>
  <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required>
  <button type="submit">CRIAR CONTA</button>
</form>

<?php
include_once('../BD/conexao.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'] ?? '';
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';
  $confirmar = $_POST['confirmar_senha'] ?? '';

  // Verifica se as senhas coincidem
  if ($senha !== $confirmar) {
    echo "<p style='color:red; text-align:center;'>As senhas não coincidem.</p>";
    exit;
  }

  // Verifica se o email já existe
  $verifica = "SELECT id FROM usuario WHERE email = ?";
  $stmtVerifica = mysqli_prepare($conexao, $verifica);
  mysqli_stmt_bind_param($stmtVerifica, "s", $email);
  mysqli_stmt_execute($stmtVerifica);
  $resultado = mysqli_stmt_get_result($stmtVerifica);

  if (mysqli_num_rows($resultado) > 0) {
    echo "<p style='color:red; text-align:center; margin-top:10px;'>Email já cadastrado.</p>";
  } else {
    // Criptografa a senha
    $senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

    // Insere no banco
    $query = "INSERT INTO usuario (nome, email, tipo_usuario, senha) VALUES (?, ?, 'user', ?)";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senhaSegura);

    if (mysqli_stmt_execute($stmt)) {
      echo "<p style='color:lime; text-align:center;'>Cadastro realizado com sucesso!</p>";
      header("refresh:2;url=../HomePage/index.php");
      exit;
    } else {
      echo "<p style='color:red; text-align:center;'>Erro ao cadastrar.</p>";
    }
  }
}
?>
    <div class="login-link">
      Já tem conta? <a href="login.html">Logar</a>
    </div>
  </div>
</div>
   <?php
include_once('../footer/footer.html');
   ?>

</body>
</html>
