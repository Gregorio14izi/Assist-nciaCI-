<?php
// Garante que só utilizadores logados podem apagar registos
require_once __DIR__ . '../login/verifica_user.php';
require_once __DIR__ . '../database/connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // Executa a exclusão do cliente especificado no PostgreSQL
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        die("Erro ao excluir o cliente: " . $e->getMessage());
    }
}

// Redireciona para a lista geral atualizada
header("Location: select.php");
exit();
?>