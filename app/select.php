<?php
require_once __DIR__ . '/../includes/functions.php';

// Exige autenticação
protegerPagina();

// Busca os clientes no PostgreSQL
$stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
$clientes = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Painel Geral de Clientes</h2>
    <a href="<?= BASE_URL; ?>index.php" class="btn btn-success">+ Novo Cliente</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><?= e($c['id']); ?></td>
                                <td><?= e($c['nome']); ?></td>
                                <td><?= e($c['email']); ?></td>
                                <td><?= e($c['telefone']); ?></td>
                                <td class="text-center">
                                    <a href="<?= BASE_URL; ?>app/select_where.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-info text-white">Ver</a>
                                    <a href="<?= BASE_URL; ?>app/update.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="<?= BASE_URL; ?>app/delete.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum cliente cadastrado no banco de dados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>