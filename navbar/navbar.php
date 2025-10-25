<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once('../BD/conexao.php');

$fotoPerfil = 'ImagemUser.png'; // padrão
$idUsuario = $_SESSION['id_usuario'] ?? null;

if ($idUsuario) {
  $query = "SELECT foto FROM usuario WHERE id = ?";
  $stmt = mysqli_prepare($conexao, $query);
  mysqli_stmt_bind_param($stmt, "i", $idUsuario);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($user = mysqli_fetch_assoc($result)) {
    $fotoPerfil = !empty($user['foto']) ? $user['foto'] : 'ImagemUser.png';
  }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../navbar/navbar.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">

  <!-- Adicionado: estilo para o hamburger-menu ficar em coluna -->
  <style>
    /* Esconder por padrão; script alterna display block/none */
    .hamburger-menu {
      display: none;
      position: absolute;
      top: 60px; /* ajuste conforme a altura da navbar */
      right: 20px;
      background: #ffffff;
      color: #000;
      border-radius: 6px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      z-index: 1000;
      padding: 8px 0;
      /* coluna para os itens ficarem um abaixo do outro */
      display: flex;
      flex-direction: column;
      gap: 0;
      min-width: 160px;
    }

    .hamburger-menu a {
      display: block;
      padding: 10px 16px;
      color: inherit;
      text-decoration: none;
      white-space: nowrap;
    }
    .hamburger-menu a:hover {
      background: #f2f2f2;
    }

    /* Garante que o contêiner .profile esteja posicionado relativamente para o absolute do menu */
    .profile {
      position: relative;
    }

    /* Ajuste ícone do usuário para indicar clique */
    .hamburger-icon {
      cursor: pointer;
      user-select: none;
    }
  </style>
</head>
<body>
  
  <nav class="navbar">
    <div class="logo">
      <img src="../images/Logo_VestibuLhama.jpeg" alt="Logo">
      <a href="../HomePage/index.php">Vestibulhama</a>
    </div>

    <div class="menu">
      <a href="../HomePage/index.php#sobre-nos">Sobre</a>
      <a href="../HomePage/index.php#propagandas">Notícias</a>
      <a href="../HomePage/index.php#recursos-servicos">Recursos Serviços</a>
    </div>

    <div class="profile">
      <?php if (isset($_SESSION['tipo'])): ?>
        <?php if ($_SESSION['tipo'] === 'adm'): ?>
          <!-- Menu para administrador -->
         <img src="../images_perfil/<?= htmlspecialchars($fotoPerfil) ?>" alt="Perfil" class="hamburger-icon" onclick="toggleMenu()" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
          <div class="hamburger-menu" id="hamburgerMenu">
            <a href="../Perfil/perfil.php">Meu Perfil</a>
            <a href="../admin/dashboard.php">Cadastrar Questão</a>
            <a href="../navbar/logout.php">Sair</a>
          </div>
        <?php elseif ($_SESSION['tipo'] === 'user'): ?>
          <!-- Menu para usuário comum -->
          <img src="../images_perfil/<?= htmlspecialchars($fotoPerfil) ?>" alt="Perfil" class="hamburger-icon" onclick="toggleMenu()" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
          <div class="hamburger-menu" id="hamburgerMenu">
            <a href="../Perfil/perfil.php">Meu Perfil</a>
            <a href="../navbar/logout.php">Sair</a>
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div>
          <a href="../cadastroUsuario/cadastro.php">Cadastrar-se</a>
          <a href="../loginUsuario/login.php">Login</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <script>
    function toggleMenu() {
      const menu = document.getElementById('hamburgerMenu');
      if (menu) {
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
      }
    }

    // Fecha o menu se clicar fora
    window.addEventListener('click', function(e) {
      const menu = document.getElementById('hamburgerMenu');
      const icon = document.querySelector('.hamburger-icon');

      if (menu && icon && !menu.contains(e.target) && !icon.contains(e.target)) {
        menu.style.display = 'none';
      }
    });
  </script>
</body>
</html>