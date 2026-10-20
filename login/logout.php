<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa e destrói a sessão do utilizador
$_SESSION = array();
session_destroy();

// Redireciona de forma relativa para a página inicial do site
header("Location: ../index.php");
exit();
?>