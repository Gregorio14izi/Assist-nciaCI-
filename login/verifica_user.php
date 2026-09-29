<?php
// Inicia a sessão se necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o ID do utilizador está presente na sessão
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona o utilizador não autenticado para a página de login
    header("Location: /projeto_integrador/login/login.php");
    exit();
}
?>