<?php
// Proteção de acesso restrito
require_once __DIR__ .  '../login/verifica_user.php';
require_once __DIR__ .  '../database/connect.php';
require_once __DIR__ .  '../includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: select.php");
    exit();
}

// Busca os dados atuais do cliente para preencher o formulário
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    header("Location: select.php");
    exit();
}

// Processa as alterações enviadas no formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    if (!empty($nome) && !empty($email) && !empty($telefone)) {
        // Executa a atualização do registo no PostgreSQL
        $update = $pdo->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id = ?");
        $update->execute([$nome, $email, $telefone, $id]);

        header("Location: select.php");
        exit();
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="card-title mb-3">Editar Cliente #<?= $cliente['id']; ?></h3>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefone / WhatsApp</label>
                        <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']); ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="select.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>