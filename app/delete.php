<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';

$id = $_GET['id'] ?? null;

if ($id && isset($conn)) {
    try {
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        // Trata erro de exclusão se houver chave estrangeira vinculada
    }
}

header("Location: select.php");
exit();
?>