<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';
include_once __DIR__ . '/../includes/header.php';

$id = $_GET['id'] ?? null;
$cliente = null;

if ($id && isset($conn) && $conn !== null) {
    try {
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $erro = $e->getMessage();
    }
}
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detalhes do Cliente</h2>
        <a href="select.php" class="btn btn-secondary">Voltar</a>
    </div>

    <?php if ($cliente): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Cliente #<?= htmlspecialchars($cliente['id']); ?> - <?= htmlspecialchars($cliente['nome']); ?></h5>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> <?= htmlspecialchars($cliente['id']); ?></p>
                <p><strong>Nome:</strong> <?= htmlspecialchars($cliente['nome']); ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($cliente['email']); ?></p>
                <p><strong>Telefone:</strong> <?= htmlspecialchars($cliente['telefone'] ?? 'Não informado'); ?></p>
                <p><strong>📅 Previsão de Retirada:</strong> 
                    <span class="badge bg-info text-dark fs-6">
                        <?= !empty($cliente['data_retirada']) ? date('d/m/Y', strtotime($cliente['data_retirada'])) : 'A definir'; ?>
                    </span>
                </p>
                <p><strong>Serviço / Problema:</strong> 
                    <span class="badge bg-secondary fs-6">
                        <?= htmlspecialchars($cliente['servico'] ?? 'Não informado'); ?>
                    </span>
                </p>
            </div>
            <div class="card-footer">
                <a href="update.php?id=<?= $cliente['id']; ?>" class="btn btn-warning text-white">Editar</a>
                <a href="delete.php?id=<?= $cliente['id']; ?>" class="btn btn-danger">Excluir</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning shadow-sm">
            Cliente não encontrado ou ID inválido.
        </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>