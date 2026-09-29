<?php
require_once __DIR__ . '../database/connect.php';
require_once __DIR__ . '../includes/header.php';

$id = $_GET['id'] ?? null;
$cliente = null;

if ($id) {
    // Pesquisa um cliente específico utilizando o ID recebido via URL
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    $cliente = $stmt->fetch();
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <a href="javascript:history.back()" class="btn btn-outline-secondary mb-3">&laquo; Voltar</a>
        
        <?php if ($cliente): ?>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="m-0">Cliente #<?= $cliente['id']; ?> - Detalhes</h5>
                </div>
                <div class="card-body">
                    <p class="fs-5"><strong>Nome:</strong> <?= htmlspecialchars($cliente['nome']); ?></p>
                    <p class="fs-5"><strong>E-mail:</strong> <?= htmlspecialchars($cliente['email']); ?></p>
                    <p class="fs-5"><strong>Telefone:</strong> <?= htmlspecialchars($cliente['telefone']); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Nenhum cliente encontrado com o ID especificado.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>