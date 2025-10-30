<?php
session_start();
include_once('../BD/conexao.php');
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $query = "SELECT * FROM usuario WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['nome'];
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['tipo'] = $user['tipo_usuario'];
            header("Location: ../HomePage/index.php");
            exit;
        } else {
           $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}

$pageTitle = 'Login - Vestibulhama';
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo '<link rel="stylesheet" href="/Vestibulhama-Front/loginUsuario/loginUsu.css">';
include_once('../navbar/navbar.php');
?>
  <div class="pai">
    <div class="login-logo-wrapper">
      <img src="../images/logo nova sla to cansado.png" alt="Logo">
      <h1 class="titulo">Vestibulhama</h1>
    </div>
    <div class="container">
      <h2>LOGIN</h2>
      <form class="form" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">FAZER LOGIN</button>
      </form>
      <?php if ($erro): ?>
        <p style="color:red; text-align:center; margin-top:10px;"><?= htmlspecialchars($erro) ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php include_once('../footer/footer.html'); ?>