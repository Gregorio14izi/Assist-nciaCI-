<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/');
}

// Importa a conexão com o banco de dados
require_once __DIR__ . '/../database/connect.php';

// Garante o acesso global à variável $pdo
global $pdo;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function sanitizarEntrada($data) {
    return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
}

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function usuarioEstaLogado() {
    return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
}

function protegerPagina() {
    if (!usuarioEstaLogado()) {
        redirecionar(BASE_URL . 'login/login.php');
    }
}

function redirecionar($url) {
    header("Location: " . $url);
    exit();
}

function renderizarAlerta($mensagem, $tipo = 'success') {
    if (empty($mensagem)) return '';
    return '
    <div class="alert alert-' . $tipo . ' alert-dismissible fade show" role="alert">
        ' . $mensagem . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}