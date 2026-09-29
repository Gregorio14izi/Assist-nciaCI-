<?php
require_once __DIR__ . '/../includes/functions.php';

// Trata o Logout se acionado
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    redirecionar(BASE_URL . 'login/login.php');
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizarEntrada($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            redirecionar(BASE_URL . 'app/select.php');
        } else {
            $erro = "E-mail ou senha incorretos.";
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
                <h3 class="card-title text-center mb-4">Acesso ao Sistema</h3>

                <?php if (isset($_GET['cadastrado'])): ?>
                    <?= renderizarAlerta('Cadastro realizado com sucesso! Faça login abaixo.', 'success'); ?>
                <?php endif; ?>

                <?php if (!empty($erro)): ?>
                    <?= renderizarAlerta($erro, 'danger'); ?>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?= BASE_URL; ?>login/cadastrar.php">Novo por aqui? Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>