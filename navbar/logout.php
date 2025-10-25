<?php
session_start();
session_unset();     // Remove todas as variáveis de sessão
session_destroy();   // Encerra a sessão

header("Location: ../HomePage/index.php"); // Redireciona para a página inicial
exit;

?>