<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';

// CRIAÇÃO AUTOMÁTICA DA COLUNA STATUS SE NÃO EXISTIR
try {
    $conn->exec("ALTER TABLE clientes ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'Em Análise'");
} catch (PDOException $e) {}

$mensagem = '';
$tipoMensagem = 'danger';

// Data mínima permitida: amanhã (1 dia de espera no mínimo)
$dataMinima = date('Y-m-d', strtotime('+1 day'));

// 1. TRATAMENTO DE AÇÕES (CADASTRAR O.S. / ATUALIZAR STATUS)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // CADASTRAR NOVA ORDEM DE SERVIÇO
    if ($acao === 'cadastrar') {
        $cliente_id_existente = $_POST['cliente_id_existente'] ?? '';
        $servico = trim($_POST['servico'] ?? '');
        $data_retirada = !empty($_POST['data_retirada']) ? $_POST['data_retirada'] : null;
        $status = $_POST['status'] ?? 'Em Análise';

        // Validação no servidor: impede salvar datas anteriores ou do próprio dia
        if (!empty($data_retirada) && $data_retirada < $dataMinima) {
            $mensagem = "A data de retirada deve ter no mínimo 1 dia de espera (a partir de amanhã).";
            $tipoMensagem = "danger";
        } else {
            // Caso 1: Escolheu cliente existente
            if (!empty($cliente_id_existente)) {
                try {
                    $stmt = $conn->prepare("UPDATE clientes SET servico = :servico, data_retirada = :data_retirada, status = :status WHERE id = :id");
                    $stmt->execute([
                        ':servico' => $servico,
                        ':data_retirada' => $data_retirada,
                        ':status' => $status,
                        ':id' => $cliente_id_existente
                    ]);
                    $mensagem = "Ordem de Serviço vinculada ao cliente com sucesso!";
                    $tipoMensagem = "success";
                } catch (PDOException $e) {
                    $mensagem = "Erro ao vincular O.S.: " . $e->getMessage();
                }
            } 
            // Caso 2: Cliente novo
            else {
                $nome = trim($_POST['nome'] ?? '');
                $telefone = trim($_POST['telefone'] ?? '');

                if (!empty($nome) && !empty($servico)) {
                    try {
                        $stmt = $conn->prepare("INSERT INTO clientes (nome, telefone, servico, data_retirada, status) VALUES (:nome, :telefone, :servico, :data_retirada, :status)");
                        $stmt->execute([
                            ':nome' => $nome,
                            ':telefone' => $telefone,
                            ':servico' => $servico,
                            ':data_retirada' => $data_retirada,
                            ':status' => $status
                        ]);
                        $mensagem = "Novo cliente e Ordem de Serviço cadastrados com sucesso!";
                        $tipoMensagem = "success";
                    } catch (PDOException $e) {
                        $mensagem = "Erro ao cadastrar O.S.: " . $e->getMessage();
                    }
                } else {
                    $mensagem = "Selecione um cliente existente ou preencha o Nome e o Serviço do novo cliente.";
                }
            }
        }
    }

    // ATUALIZAR STATUS DA O.S.
    elseif ($acao === 'atualizar_status' && isset($_POST['cliente_id'], $_POST['novo_status'])) {
        try {
            $stmt = $conn->prepare("UPDATE clientes SET status = :status WHERE id = :id");
            $stmt->execute([
                ':status' => $_POST['novo_status'],
                ':id' => (int)$_POST['cliente_id']
            ]);
            $mensagem = "Status da O.S. atualizado!";
            $tipoMensagem = "success";
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar status: " . $e->getMessage();
        }
    }
}

// 2. BUSCAR TODOS OS CLIENTES
$todosClientes = [];
try {
    $stmt = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
    $todosClientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

include_once __DIR__ . '/../includes/header.php';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🛠️ Gestão de Ordens de Serviço (Bancada)</h2>
        <div>
            <a href="../index.php" class="btn btn-secondary me-2">Voltar</a>
            <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovaOS">
                + Nova Ordem de Serviço
            </button>
        </div>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem; ?> alert-dismissible fade show mb-3" role="alert">
            <?= htmlspecialchars($mensagem); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">O.S. nº</th>
                            <th>Cliente</th>
                            <th>Telefone</th>
                            <th>Aparelho / Serviço</th>
                            <th class="text-center">📅 Previsão</th>
                            <th class="text-center">Status na Bancada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($todosClientes)): ?>
                            <?php foreach ($todosClientes as $o): ?>
                                <tr>
                                    <td class="text-center fw-bold">#<?= $o['id']; ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($o['nome']); ?></td>
                                    <td><?= htmlspecialchars($o['telefone'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge bg-secondary fs-6">
                                            <?= htmlspecialchars($o['servico'] ?? 'Sem serviço informado'); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($o['data_retirada']) ? date('d/m/Y', strtotime($o['data_retirada'])) : 'Sem data'; ?>
                                    </td>
                                    <td class="text-center">
                                        <form action="ordens_servico.php" method="POST" class="d-inline-block">
                                            <input type="hidden" name="acao" value="atualizar_status">
                                            <input type="hidden" name="cliente_id" value="<?= $o['id']; ?>">
                                            <select name="novo_status" class="form-select form-select-sm fw-bold" onchange="this.form.submit()">
                                                <option value="Em Análise" <?= ($o['status'] ?? '') === 'Em Análise' ? 'selected' : ''; ?>>🔍 Em Análise</option>
                                                <option value="Aguardando Peça" <?= ($o['status'] ?? '') === 'Aguardando Peça' ? 'selected' : ''; ?>>📦 Aguardando Peça</option>
                                                <option value="Em Manutenção" <?= ($o['status'] ?? '') === 'Em Manutenção' ? 'selected' : ''; ?>>🛠️ Em Manutenção</option>
                                                <option value="Pronto para Retirada" <?= ($o['status'] ?? '') === 'Pronto para Retirada' ? 'selected' : ''; ?>>✅ Pronto para Retirada</option>
                                                <option value="Entregue" <?= ($o['status'] ?? '') === 'Entregue' ? 'selected' : ''; ?>>🎉 Entregue</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center p-3">Nenhuma ordem de serviço cadastrada.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CADASTRAR / VINCULAR O.S. -->
<div class="modal fade" id="modalNovaOS" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="ordens_servico.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title fw-bold">➕ Nova Ordem de Serviço</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">

          <!-- OPÇÃO 1: SELECIONAR CLIENTE EXISTENTE -->
          <div class="mb-3 p-2 bg-light border rounded">
            <label class="form-label fw-bold text-primary">👤 Selecionar Cliente Já Cadastrado:</label>
            <select class="form-select" name="cliente_id_existente" id="selectClienteExistente">
              <option value="">-- Escolha um cliente ou cadastre um novo abaixo --</option>
              <?php foreach ($todosClientes as $c): ?>
                <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['nome']); ?> (<?= htmlspecialchars($c['telefone'] ?? 'Sem tel'); ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="text-center my-2 text-muted fw-bold">OU CADASTRAR NOVO CLIENTE</div>

          <!-- OPÇÃO 2: DADOS DO CLIENTE NOVO -->
          <div class="mb-3">
            <label class="form-label fw-bold">Nome do Novo Cliente</label>
            <input type="text" class="form-control" name="nome" placeholder="Ex: Maria Souza">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Telefone / WhatsApp</label>
            <input type="text" class="form-control" name="telefone" placeholder="Ex: (11) 98888-7777">
          </div>

          <hr>

          <!-- DADOS DA O.S. -->
          <div class="mb-3">
            <label class="form-label fw-bold">Aparelho e Serviço a realizar *</label>
            <textarea class="form-control" name="servico" rows="3" placeholder="Ex: Notebook Dell - Formatação e limpeza interna" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Previsão de Retirada (Mínimo 1 dia de espera) *</label>
            <!-- O atributo min bloqueia no calendário do navegador qualquer dia anterior a amanhã -->
            <input 
              type="date" 
              class="form-control" 
              name="data_retirada" 
              min="<?= date('Y-m-d', strtotime('+1 day')); ?>"
              required
            >
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Status Inicial</label>
            <select class="form-select" name="status">
              <option value="Em Análise">🔍 Em Análise</option>
              <option value="Aguardando Peça">📦 Aguardando Peça</option>
              <option value="Em Manutenção">🛠️ Em Manutenção</option>
              <option value="Pronto para Retirada">✅ Pronto para Retirada</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success fw-bold">Salvar Ordem de Serviço</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>