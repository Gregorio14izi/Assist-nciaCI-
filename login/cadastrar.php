<?php
require_once __DIR__ . '/../includes/functions.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = sanitizarEntrada($_POST['nome'] ?? '');
    $email = sanitizarEntrada($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        try {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash]);

            redirecionar(BASE_URL . 'login/login.php?cadastrado=1');
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                $erro = "Este e-mail já está em uso.";
            } else {
                $erro = "Erro ao cadastrar: " . $e->getMessage();
            }
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center my-4">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Novo Técnico</h3>

                <?php if (!empty($erro)): ?>
                    <?= renderizarAlerta($erro, 'danger'); ?>
                <?php endif; ?>

                <form action="cadastrar.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Criar Conta</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?= BASE_URL; ?>login/login.php">Já possui conta? Faça Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>