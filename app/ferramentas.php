<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';

$mensagem = '';
$tipoMensagem = 'danger';

// TRATAMENTO DAS AÇÕES (ADICIONAR, EDITAR, ELIMINAR, ALTERAR QUANTIDADE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // 1. ADICIONAR FERRAMENTA
    if ($acao === 'adicionar') {
        $nome = trim($_POST['nome'] ?? '');
        $categoria = trim($_POST['categoria'] ?? 'Geral');
        $quantidade = (int)($_POST['quantidade'] ?? 1);
        $estado = $_POST['estado'] ?? 'Bom Estado';

        if (!empty($nome)) {
            try {
                $stmt = $conn->prepare("INSERT INTO ferramentas (nome, categoria, quantidade, estado) VALUES (:nome, :categoria, :quantidade, :estado)");
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':quantidade', $quantidade);
                $stmt->bindParam(':estado', $estado);
                $stmt->execute();
                $mensagem = "Ferramenta adicionada com sucesso!";
                $tipoMensagem = "success";
            } catch (PDOException $e) {
                $mensagem = "Erro ao adicionar: " . $e->getMessage();
            }
        }
    }

    // 2. EDITAR FERRAMENTA
    elseif ($acao === 'editar') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $quantidade = (int)($_POST['quantidade'] ?? 0);
        $estado = $_POST['estado'] ?? 'Bom Estado';

        if ($id > 0 && !empty($nome)) {
            try {
                $stmt = $conn->prepare("UPDATE ferramentas SET nome = :nome, categoria = :categoria, quantidade = :quantidade, estado = :estado WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':quantidade', $quantidade);
                $stmt->bindParam(':estado', $estado);
                $stmt->execute();
                $mensagem = "Ferramenta atualizada com sucesso!";
                $tipoMensagem = "success";
            } catch (PDOException $e) {
                $mensagem = "Erro ao atualizar: " . $e->getMessage();
            }
        }
    }

    // 3. ALTERAR QUANTIDADE (+ / -)
    elseif ($acao === 'alterar_qtd') {
        $id = (int)($_POST['id'] ?? 0);
        $delta = (int)($_POST['delta'] ?? 0);

        if ($id > 0 && $delta !== 0) {
            try {
                $stmt = $conn->prepare("UPDATE ferramentas SET quantidade = GREATEST(0, quantidade + :delta) WHERE id = :id");
                $stmt->bindParam(':delta', $delta, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {}
        }
    }

    // 4. ELIMINAR FERRAMENTA
    elseif ($acao === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $conn->prepare("DELETE FROM ferramentas WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $mensagem = "Ferramenta eliminada com sucesso!";
                $tipoMensagem = "warning";
            } catch (PDOException $e) {
                $mensagem = "Erro ao eliminar: " . $e->getMessage();
            }
        }
    }
}

// BUSCA TODAS AS FERRAMENTAS
$ferramentas = [];
try {
    $stmt = $conn->query("SELECT * FROM ferramentas ORDER BY id ASC");
    $ferramentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

include_once __DIR__ . '/../includes/header.php';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🧰 Inventário de Ferramentas de Bancada</h2>
        <div>
            <a href="../index.php" class="btn btn-secondary me-2">Voltar</a>
            <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddFerramenta">
                + Nova Ferramenta
            </button>
        </div>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem; ?> alert-dismissible fade show mb-3" role="alert">
            <?= htmlspecialchars($mensagem); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- TABELA DE FERRAMENTAS -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nome da Ferramenta</th>
                            <th>Categoria</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ferramentas)): ?>
                            <?php foreach ($ferramentas as $f): ?>
                                <tr>
                                    <td class="text-center"><?= $f['id']; ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($f['nome']); ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($f['categoria']); ?></span></td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <form action="ferramentas.php" method="POST" class="d-inline">
                                                <input type="hidden" name="acao" value="alterar_qtd">
                                                <input type="hidden" name="id" value="<?= $f['id']; ?>">
                                                <input type="hidden" name="delta" value="-1">
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-0 fw-bold">-</button>
                                            </form>

                                            <span class="badge <?= $f['quantidade'] > 0 ? 'bg-primary' : 'bg-danger'; ?> fs-6 mx-1">
                                                <?= $f['quantidade']; ?>
                                            </span>

                                            <form action="ferramentas.php" method="POST" class="d-inline">
                                                <input type="hidden" name="acao" value="alterar_qtd">
                                                <input type="hidden" name="id" value="<?= $f['id']; ?>">
                                                <input type="hidden" name="delta" value="1">
                                                <button type="submit" class="btn btn-sm btn-outline-success px-2 py-0 fw-bold">+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $f['estado'] === 'Bom Estado' ? 'bg-success' : ($f['estado'] === 'Necessita Manutenção' ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                            <?= htmlspecialchars($f['estado']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning text-white me-1" 
                                                onclick="preencherEditModal(<?= htmlspecialchars(json_encode($f)); ?>)" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditFerramenta">
                                            Editar
                                        </button>
                                        <form action="ferramentas.php" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja eliminar esta ferramenta?');">
                                            <input type="hidden" name="acao" value="eliminar">
                                            <input type="hidden" name="id" value="<?= $f['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center p-3">Nenhuma ferramenta registada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADICIONAR FERRAMENTA -->
<div class="modal fade" id="modalAddFerramenta" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="ferramentas.php" method="POST">
        <input type="hidden" name="acao" value="adicionar">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title fw-bold">Adicionar Nova Ferramenta</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Nome da Ferramenta *</label>
            <input type="text" class="form-control" name="nome" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Categoria</label>
            <input type="text" class="form-control" name="categoria" placeholder="Ex: Soldadura, Diagnóstico, Manuais">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Quantidade Inicial</label>
            <input type="number" class="form-control" name="quantidade" value="1" min="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Estado</label>
            <select class="form-select" name="estado">
              <option value="Bom Estado">Bom Estado</option>
              <option value="Necessita Manutenção">Necessita Manutenção</option>
              <option value="Danificada / Inoperacional">Danificada / Inoperacional</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success fw-bold">Guardar Ferramenta</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDITAR FERRAMENTA -->
<div class="modal fade" id="modalEditFerramenta" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="ferramentas.php" method="POST">
        <input type="hidden" name="acao" value="editar">
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-header bg-warning">
          <h5 class="modal-title fw-bold">Editar Ferramenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Nome da Ferramenta *</label>
            <input type="text" class="form-control" id="edit_nome" name="nome" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Categoria</label>
            <input type="text" class="form-control" id="edit_categoria" name="categoria">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Quantidade</label>
            <input type="number" class="form-control" id="edit_quantidade" name="quantidade" min="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Estado</label>
            <select class="form-select" id="edit_estado" name="estado">
              <option value="Bom Estado">Bom Estado</option>
              <option value="Necessita Manutenção">Necessita Manutenção</option>
              <option value="Danificada / Inoperacional">Danificada / Inoperacional</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning text-white fw-bold">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function preencherEditModal(ferramenta) {
    document.getElementById('edit_id').value = ferramenta.id;
    document.getElementById('edit_nome').value = ferramenta.nome;
    document.getElementById('edit_categoria').value = ferramenta.categoria;
    document.getElementById('edit_quantidade').value = ferramenta.quantidade;
    document.getElementById('edit_estado').value = ferramenta.estado;
}
</script>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>