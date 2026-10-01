<?php
// 1. Inicia a sessão atual para que o PHP saiba qual sessão encerrar
session_start();

// 2. Limpa todas as variáveis de sessão armazenadas em memória
$_SESSION = array();

// 3. Apaga o cookie da sessão no navegador do usuário (boa prática de segurança)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destrói a sessão no servidor
session_destroy();

// 5. Redireciona o usuário de volta para a tela de login
header("Location: login.php");
exit();
?>