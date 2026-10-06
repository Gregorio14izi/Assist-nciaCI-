<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';

// Busca dados do Mural
$mural = ['aviso' => '', 'lembrete' => '', 'urgente' => ''];
try {
    $stmtMural = $conn->query("SELECT * FROM mural WHERE id = 1");
    if ($row = $stmtMural->fetch(PDO::FETCH_ASSOC)) {
        $mural = $row;
    }
} catch (PDOException $e) {}

// Busca os 5 clientes com retirada mais próxima
$proximosClientes = [];
try {
    $stmtProximos = $conn->query("
        SELECT * FROM clientes 
        WHERE data_retirada IS NOT NULL AND data_retirada >= CURRENT_DATE 
        ORDER BY data_retirada ASC 
        LIMIT 5
    ");
    $proximosClientes = $stmtProximos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

include_once __DIR__ . '/../includes/header.php';
?>

<div class="container my-4">

    <!-- 📌 MURAL DE AVISOS EDITÁVEL -->
    <div class="card mb-4 border-warning shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
            <span>📌 Mural de Avisos da Assistência</span>
            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalEditarMural">
                ✏️ Editar Mural
            </button>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                <li><strong>Aviso:</strong> <?= htmlspecialchars($mural['aviso'] ?: 'Nenhum aviso no momento.'); ?></li>
                <li><strong>Lembrete:</strong> <?= htmlspecialchars($mural['lembrete'] ?: 'Nenhum lembrete.'); ?></li>
                <li><strong>Entrega urgente:</strong> <?= htmlspecialchars($mural['urgente'] ?: 'Nenhuma entrega urgente.'); ?></li>
            </ul>
        </div>
    </div>

    <!-- ⏰ PRÓXIMAS 5 RETIRADAS -->
    <div class="card mb-4 border-info shadow-sm">
        <div class="card-header bg-info text-dark fw-bold">
            ⏰ Próximas 5 Retiradas Agendadas
        </div>
        <div class="card-body p-0">
            <?php if (!empty($proximosClientes)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Cliente</th>
                                <th>Telefone</th>
                                <th>Serviço / Problema</th>
                                <th class="text-center">📅 Data de Retirada</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proximosClientes as $c): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($c['nome']); ?></td>
                                    <td><?= htmlspecialchars($c['telefone'] ?? 'Sem fone'); ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($c['servico'] ?? 'N/A'); ?></span></td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark fs-6">
                                            <?= date('d/m/Y', strtotime($c['data_retirada'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="select_where.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="p-3 mb-0 text-muted">Nenhuma retirada pendente agendada para os próximos dias.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- TÍTULO E BOTÃO DE NOVO CLIENTE -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Painel Geral de Clientes</h2>
        <a href="create.php" class="btn btn-success">+ Novo Cliente</a>
    </div>

    <!-- TABELA DE CLIENTES -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Serviço / Problema</th>
                        <th class="text-center">📅 Retirada</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($conn) && $conn !== null) {
                        try {
                            $stmt = $conn->query("SELECT * FROM clientes ORDER BY id ASC");
                            if ($stmt && $stmt->rowCount() > 0) {
                                while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $dataFmt = !empty($cliente['data_retirada']) ? date('d/m/Y', strtotime($cliente['data_retirada'])) : 'A definir';
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($cliente['id']); ?></td>
                                        <td><?= htmlspecialchars($cliente['nome']); ?></td>
                                        <td><?= htmlspecialchars($cliente['email']); ?></td>
                                        <td><?= htmlspecialchars($cliente['telefone'] ?? ''); ?></td>
                                        <td>
                                            <span class="badge bg-secondary text-wrap text-start">
                                                <?= htmlspecialchars($cliente['servico'] ?? 'Não informado'); ?>
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-info text-dark">
                                                <?= $dataFmt; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="select_where.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-info text-white">Ver</a>
                                            <a href="update.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-warning text-white">Editar</a>
                                            <a href="delete.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-danger">Excluir</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center p-3">Nenhum cliente cadastrado.</td></tr>';
                            }
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="7" class="text-center text-danger p-3">Erro ao buscar clientes: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-center text-danger p-3">Conexão com o banco de dados indisponível.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL PARA EDITAR O MURAL -->
<div class="modal fade" id="modalEditarMural" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="salvar_mural.php" method="POST">
        <div class="modal-header bg-warning">
          <h5 class="modal-title fw-bold">Editar Mural de Avisos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Aviso:</label>
            <textarea class="form-control" name="aviso" rows="2"><?= htmlspecialchars($mural['aviso']); ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Lembrete:</label>
            <textarea class="form-control" name="lembrete" rows="2"><?= htmlspecialchars($mural['lembrete']); ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Entrega urgente:</label>
            <textarea class="form-control" name="urgente" rows="2"><?= htmlspecialchars($mural['urgente']); ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success fw-bold">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>