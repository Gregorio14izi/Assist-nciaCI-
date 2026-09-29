<?php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Integrador</title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Local -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>style/style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= BASE_URL; ?>index.php">Sistema Clientes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL; ?>index.php">Início</a>
                    </li>
                    <?php if (usuarioEstaLogado()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL; ?>app/select.php">Painel Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="<?= BASE_URL; ?>login/login.php?action=logout">Sair</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL; ?>login/login.php">Área Restrita</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container flex-grow-1">