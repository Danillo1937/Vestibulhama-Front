

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestibulhama - Login</title>
  <link rel="stylesheet" href="../loginUsuario/login.css">
</head>
<body>
  <div class="pai">
    <div class="logo">
      <img src="../images/logo nova sla to cansado.png" alt="Logo">
      Vestibulhama
    </div>
    <div class="container">
      <h2>LOGIN</h2>
      <form class="form" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">FAZER LOGIN</button>
      </form>
        <?php
  include_once('../BD/conexao.php');
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
        header("Location: ../HomePage/home.php");
        exit;
        
    } else {
        $erro = "Senha incorreta.";
        if ($erro): 
        echo '<p style="color:red; text-align:center; margin-top:10px;"><?php echo $erro; ?></p>';
        endif;
  
    }
    
}
  ?>  


</body>
</html>