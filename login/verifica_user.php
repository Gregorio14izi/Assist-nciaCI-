<?php
session_start();
require_once __DIR__ . '/../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && (password_verify($senha, $user['senha']) || $senha === $user['senha'])) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'] ?? $user['email'];

                header("Location: ../index.php");
                exit();
            }
        } catch (PDOException $e) {
            // Em caso de exceção na busca do usuário
        }
    }

    // Redireciona de volta para a tela de login na mesma pasta
    header("Location: login.php?erro=dados_invalidos");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>