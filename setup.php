<?php
require_once 'database/connect.php';

$nome  = 'administrador';
$email = 'adm@adm.com';
$senha = password_hash('adm123', PASSWORD_DEFAULT);

try {
    // 1. Verifica se o e-mail já existe no banco
    $check = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $check->execute([$email]);

    if ($check->fetchColumn() > 0) {
        echo "O usuário <b>$email</b> já está cadastrado! Você já pode fazer login.";
    } else {
        // 2. Se não existir, insere o novo administrador
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        echo "Administrador cadastrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro de conexão ou banco: " . $e->getMessage();
}
?>