<?php
session_start();
require_once "../database/connect.php"; //

// Exemplo da lógica após consultar o banco:
if ($usuario_encontrado) {
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario_nome'] = $user['nome'];
    
    // Redireciona para o painel principal
    header("Location: ../index.php");
    exit();
} else {
    header("Location: login.php?erro=dados_invalidos");
    exit();
}