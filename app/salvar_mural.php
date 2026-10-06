<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aviso = $_POST['aviso'] ?? '';
    $lembrete = $_POST['lembrete'] ?? '';
    $urgente = $_POST['urgente'] ?? '';

    try {
        $stmt = $conn->prepare("
            INSERT INTO mural (id, aviso, lembrete, urgente) 
            VALUES (1, :aviso, :lembrete, :urgente)
            ON CONFLICT (id) DO UPDATE 
            SET aviso = EXCLUDED.aviso, lembrete = EXCLUDED.lembrete, urgente = EXCLUDED.urgente
        ");
        $stmt->bindParam(':aviso', $aviso);
        $stmt->bindParam(':lembrete', $lembrete);
        $stmt->bindParam(':urgente', $urgente);
        $stmt->execute();
    } catch (PDOException $e) {
        // Trata eventual exceção
    }
}

// Redireciona de volta para a página anterior
$referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
header("Location: " . $referer);
exit();
?>