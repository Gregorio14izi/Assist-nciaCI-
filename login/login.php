<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ao Sistema - AssistêciaCi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<header>
  <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="../index.php">🛠️ AssistênciaCi - A melhor assitência técnica da Ilha de Marajó</a>
    </div>
  </nav>
</header>

<main class="container d-flex justify-content-center align-items-center flex-grow-1">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h1 class="h3 card-title text-center mb-4">Acesso do lojista ao Sistema</h1>

        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'dados_invalidos'): ?>
            <div class="alert alert-danger text-center p-2 mb-3" role="alert">
                E-mail ou senha incorretos!
            </div>
        <?php endif; ?>

        <form action="verifica_user.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu e-mail">
            </div>
            
            <div class="mb-3">
                <label for="senha" class="form-label fw-bold">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required placeholder="Digite sua senha">
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Entrar</button>
        </form>
    </div>
</main>

<footer class="bg-dark text-light py-3 border-top mt-auto text-center">
    <small>&copy; <?= date('Y'); ?> TechFix - Todos os direitos reservados.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>