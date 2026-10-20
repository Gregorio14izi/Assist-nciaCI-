<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if ($email && !empty($senha)) {
        try {
            // Consulta o utilizador no PostgreSQL
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a palavra-passe (suporta hash seguro ou verificação direta)
            if ($usuario && (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'] ?? 'Administrador';

                // Redireciona para o painel de gestão na pasta app/
                header("Location: ../app/select.php");
                exit();
            }
        } catch (PDOException $e) {
            // Caso aconteça algum erro de banco de dados
            header("Location: login.php?erro=dados_invalidos");
            exit();
        }
    }
}

// Se os dados estiverem incorretos, volta para o ecrã de login
header("Location: login.php?erro=dados_invalidos");
exit();
?>