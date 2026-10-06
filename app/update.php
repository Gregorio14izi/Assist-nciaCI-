<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';

$id = $_GET['id'] ?? null;
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_retirada = !empty($_POST['data_retirada']) ? $_POST['data_retirada'] : null;
    $servico = $_POST['servico'] ?? '';

    if ($servico === 'Outro') {
        $descricao_outro = trim($_POST['descricao_outro'] ?? '');
        $servico = "Outro: " . $descricao_outro;
    }

    if ($id && !empty($nome) && !empty($email) && !empty($servico)) {
        try {
            $stmt = $conn->prepare("UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone, data_retirada = :data_retirada, servico = :servico WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':data_retirada', $data_retirada);
            $stmt->bindParam(':servico', $servico);
            $stmt->execute();

            header("Location: select.php");
            exit();
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar cliente: " . $e->getMessage();
        }
    }
}

$cliente = null;
if ($id && isset($conn)) {
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
}

include_once __DIR__ . '/../includes/header.php';

$categorias = [
    '🔧 1. Manutenção' => [
        'Manutenção preventiva', 'Manutenção corretiva', 'Limpeza do equipamento',
        'Revisão geral', 'Diagnóstico de problemas', 'Testes de funcionamento'
    ],
    '💻 2. Computadores' => [
        'Manutenção de computadores', 'Formatação', 'Instalação de sistema operacional',
        'Atualização de componentes', 'Montagem de computador', 'Configuração do computador'
    ],
    '📱 3. Celulares e Tablets' => [
        'Manutenção de celulares', 'Manutenção de tablets', 'Troca de componentes',
        'Troca de tela', 'Troca de bateria', 'Atualização e configuração'
    ],
    '🖥️ 4. Periféricos' => [
        'Manutenção de teclado', 'Manutenção de mouse', 'Manutenção de webcam',
        'Manutenção de headset', 'Manutenção de controles', 'Configuração de periféricos'
    ],
    '🖨️ 5. Impressoras' => [
        'Manutenção de impressoras', 'Limpeza', 'Troca de componentes',
        'Configuração', 'Instalação', 'Diagnóstico de problemas'
    ],
    '🎮 6. Videogames' => [
        'Manutenção de consoles', 'Limpeza interna', 'Reparo de componentes',
        'Atualização do sistema', 'Configuração', 'Testes de funcionamento'
    ],
    '🌐 7. Redes e Internet' => [
        'Configuração de Wi-Fi', 'Configuração de roteadores', 'Instalação de rede',
        'Configuração de dispositivos', 'Diagnóstico de conexão', 'Manutenção de rede'
    ],
    '💾 8. Dados e Software' => [
        'Backup de dados', 'Recuperação de dados', 'Instalação de programas',
        'Atualização de programas', 'Configuração de softwares', 'Remoção de vírus'
    ],
    '🔌 9. Eletrônicos' => [
        'Diagnóstico de equipamentos', 'Reparo eletrônico', 'Troca de componentes',
        'Manutenção preventiva', 'Manutenção corretiva', 'Teste de funcionamento'
    ],
    '📦 10. Serviços Gerais' => [
        'Avaliação técnica', 'Orçamento', 'Instalação', 'Configuração',
        'Reparo', 'Troca de peças', 'Garantia de serviço', 'Devolução do equipamento'
    ]
];

$servicoAtual = $cliente['servico'] ?? '';
$isOutro = str_starts_with($servicoAtual, 'Outro:');
$textoOutro = $isOutro ? trim(substr($servicoAtual, 6)) : '';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Editar Cliente</h2>
        <a href="select.php" class="btn btn-secondary">Voltar</a>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-danger mb-3"><?= htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <?php if ($cliente): ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?= $cliente['id']; ?>">
                    
                    <h5 class="mb-3 text-primary">Dados do Cliente</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($cliente['email']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="telefone" class="form-label">Telefone / WhatsApp</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="data_retirada" class="form-label">📅 Previsão de Retirada</label>
                            <input type="date" class="form-control" id="data_retirada" name="data_retirada" value="<?= htmlspecialchars($cliente['data_retirada'] ?? ''); ?>">
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3 text-primary">Selecione o Serviço / Problema *</h5>

                    <div class="accordion mb-3" id="accordionServicos">
                        <?php $index = 0; foreach ($categorias as $catNome => $itens): $index++; ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $index; ?>">
                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index; ?>">
                                        <strong><?= $catNome; ?></strong>
                                    </button>
                                </h2>
                                <div id="collapse<?= $index; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionServicos">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            <?php foreach ($itens as $item): 
                                                $valItem = $catNome . ' - ' . $item;
                                                $idItem = 'serv_' . md5($catNome . $item);
                                                $checked = ($servicoAtual === $valItem) ? 'checked' : '';
                                            ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input radio-servico" type="radio" name="servico" id="<?= $idItem; ?>" value="<?= htmlspecialchars($valItem); ?>" <?= $checked; ?> required>
                                                        <label class="form-check-label" for="<?= $idItem; ?>">
                                                            <?= htmlspecialchars($item); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- OPÇÃO OUTRO -->
                    <div class="card bg-light border-secondary mb-3 p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input radio-servico" type="radio" name="servico" id="serv_outro" value="Outro" <?= $isOutro ? 'checked' : ''; ?>>
                            <label class="form-check-label fw-bold" for="serv_outro">
                                ❓ Outro (especificar abaixo)
                            </label>
                        </div>
                        <div id="campo_outro" style="display: <?= $isOutro ? 'block' : 'none'; ?>;">
                            <input type="text" class="form-control mt-2" id="descricao_outro" name="descricao_outro" value="<?= htmlspecialchars($textoOutro); ?>" placeholder="Digite a especificação do problema...">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning text-white fw-bold w-100 py-2">Atualizar Cliente e Serviço</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Cliente não encontrado.</div>
    <?php endif; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('.radio-servico');
    const campoOutro = document.getElementById('campo_outro');
    const inputOutro = document.getElementById('descricao_outro');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'Outro') {
                campoOutro.style.display = 'block';
                inputOutro.required = true;
                inputOutro.focus();
            } else {
                campoOutro.style.display = 'none';
                inputOutro.required = false;
            }
        });
    });
});
</script>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>