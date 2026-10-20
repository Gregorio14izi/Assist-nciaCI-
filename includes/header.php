<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssistênciaCi - Assistência Técnica Especializada</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Personalizado -->
    <?php
      $cssPath = file_exists(__DIR__ . '/../assets/css/style.css') ? '../assets/css/style.css' : 'assets/css/style.css';
    ?>
    <link rel="stylesheet" href="<?= $cssPath; ?>">
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center" href="/index.php">
        <img src="/assets/img/logo.svg" alt="Logotipo AssistênciaCi" height="38">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="/index.php">Início</a></li>
          <li class="nav-item"><a class="nav-link" href="/sobre.php">Sobre</a></li>
          <li class="nav-item"><a class="nav-link" href="/servicos.php">Serviços & Preços</a></li>
          <li class="nav-item"><a class="nav-link" href="/contato.php">Contato</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="/app/select.php" class="btn btn-outline-info btn-sm me-2">Painel Admin</a>
            <a href="/login/logout.php" class="btn btn-danger btn-sm">Sair</a>
          <?php else: ?>
            <a href="/login/login.php" class="btn btn-warning btn-sm fw-bold text-dark">Área Restrita / Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
</header>