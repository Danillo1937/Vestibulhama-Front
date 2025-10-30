<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once(__DIR__ . '/../BD/conexao.php');

$fotoPerfil = 'ImagemUser.png';
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

<nav class="navbar">
  <div class="logo">
    <img class="logo" src="/Vestibulhama-Front/images/Logo_VestibuLhama.jpeg" alt="Logo">
    <a href="/Vestibulhama-Front/index.php">Vestibulhama</a>
  </div>

  <div class="menu" id="mainMenu" role="navigation" aria-label="Menu principal">
    <a href="/Vestibulhama-Front/index.php#sobre">Sobre</a>
    <a href="/Vestibulhama-Front/index.php#propaganda">Notícias</a>
    <a href="/Vestibulhama-Front/index.php#servicos">Recursos Serviços</a>
  </div>

  <button id="hamburgerBtn" class="hamburger" aria-label="Abrir menu" aria-controls="mainMenu" aria-expanded="false">☰</button>

  <div class="profile">
    <?php if (isset($_SESSION['tipo'])): ?>
      <?php if ($_SESSION['tipo'] === 'adm'): ?>
        <img src="/Vestibulhama-Front/images_perfil/<?= htmlspecialchars($fotoPerfil) ?>" alt="Perfil" class="hamburger-icon" onclick="toggleMenu()" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
        <div class="hamburger-menu" id="hamburgerMenu">
          <a href="/Vestibulhama-Front/Perfil/perfil.php">Meu Perfil</a>
          <a href="/Vestibulhama-Front/cadastroQuestao/cadastroQuestao.php">Cadastrar Questão</a>
          <a href="/Vestibulhama-Front/navbar/logout.php">Sair</a>
        </div>
      <?php elseif ($_SESSION['tipo'] === 'user'): ?>
        <img src="/Vestibulhama-Front/images_perfil/<?= htmlspecialchars($fotoPerfil) ?>" alt="Perfil" class="hamburger-icon" onclick="toggleMenu()" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
        <div class="hamburger-menu" id="hamburgerMenu">
          <a href="/Vestibulhama-Front/Perfil/perfil.php">Meu Perfil</a>
          <a href="/Vestibulhama-Front/navbar/logout.php">Sair</a>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <div>
        <a href="/Vestibulhama-Front/cadastroUsuario/cadastro.php">Cadastrar-se</a>
        <a href="/Vestibulhama-Front/loginUsuario/login.php">Login</a>
      </div>
    <?php endif; ?>
  </div>
</nav>

<script>
  // alterna o menu principal (hamburger) com acessibilidade e animação
  function closeOnEscape(e) {
    if (e.key === 'Escape') closeMainMenu();
  }

  function openMainMenu() {
    const btn = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mainMenu');
    if (!menu || !btn) return;
    menu.style.display = 'flex';
    // pequena espera para ativar transição
    setTimeout(() => menu.classList.add('visible'), 10);
    btn.setAttribute('aria-expanded', 'true');
    document.addEventListener('keydown', closeOnEscape);
    // foca o primeiro link para navegação por teclado
    const firstLink = menu.querySelector('a');
    if (firstLink) firstLink.focus();
  }

  function closeMainMenu() {
    const btn = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mainMenu');
    if (!menu || !btn) return;
    menu.classList.remove('visible');
    btn.setAttribute('aria-expanded', 'false');
    document.removeEventListener('keydown', closeOnEscape);
    // espera a transição terminar antes de esconder
    setTimeout(() => { menu.style.display = ''; }, 300);
  }

  function toggleMainMenu() {
    const menu = document.getElementById('mainMenu');
    const isOpen = menu && menu.classList.contains('visible');
    if (isOpen) closeMainMenu(); else openMainMenu();
  }

  document.getElementById('hamburgerBtn')?.addEventListener('click', function(e) {
    e.stopPropagation();
    toggleMainMenu();
  });

  // fecha o menu principal ao clicar fora
  window.addEventListener('click', function(e) {
    const menu = document.getElementById('mainMenu');
    const btn = document.getElementById('hamburgerBtn');
    if (menu && btn && menu.classList.contains('visible') && !menu.contains(e.target) && !btn.contains(e.target)) {
      closeMainMenu();
    }
  });

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