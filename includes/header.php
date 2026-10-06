<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Clientes - Assistência Técnica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/style/style.css">
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS Personalizado Único -->
<?php
  // Detecta o caminho correto caso a página esteja na raiz ou dentro da pasta /app/
  $cssPath = file_exists(__DIR__ . '/../assets/css/style.css') ? '../assets/css/style.css' : 'assets/css/style.css';
?>
<link rel="stylesheet" href="<?= $cssPath; ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/index.php">Sistema Clientes</a>
    
    <div class="d-flex align-items-center">
      <a class="nav-link text-white me-3" href="/index.php">Início</a>
      <a class="nav-link text-white me-3" href="/app/select.php">Clientes</a>
      <a href="/login/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
    </div>
  </div>
</nav>