<?php
session_start();

// Se o usuário já estiver logado, vai para a página principal
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ao Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Sistema Clientes</a>
  </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h3 class="card-title text-center mb-4">Acesso ao Sistema</h3>

        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'dados_invalidos'): ?>
            <div class="alert alert-danger text-center p-2 mb-3">
                E-mail ou senha incorretos!
            </div>
        <?php endif; ?>

        <form action="verifica_user.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" required placeholder="Digite seu e-mail">
            </div>
            
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required placeholder="Digite sua senha">
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Entrar</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>