<?php
require_once __DIR__ . '/../includes/functions.php';

global $pdo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = sanitizarEntrada($_POST['nome'] ?? '');
    $email = sanitizarEntrada($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        try {
            // Criptografa a senha para verificação segura no login.php
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash]);

            // Redireciona para a tela de login após cadastrar com sucesso
            redirecionar(BASE_URL . 'login/login.php?cadastrado=1');
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                die("Este e-mail já está cadastrado.");
            } else {
                die("Erro ao salvar usuário no banco de dados: " . $e->getMessage());
            }
        }
    } else {
        die("Preencha todos os campos obrigatórios (Nome, E-mail e Senha).");
    }
} else {
    redirecionar(BASE_URL . 'index.php');
}