<?php
session_start();

// Proteção de acesso
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once __DIR__ . '/../database/connect.php';
include_once __DIR__ . '/../includes/header.php';
?>

<div class="container my-4">

    <!-- 📌 MURAL DE AVISOS DA ASSISTÊNCIA -->
    <div class="card mb-4 border-warning shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold">
            📌 Mural de Avisos da Assistência
        </div>
        <div class="card-body">
            <ul class="mb-0">
                <li><strong>Aviso:</strong> Multímetro de bancada #02 está em manutenção.</li>
                <li><strong>Lembrete:</strong> Verificar estoque de conectores de carga Tipo-C.</li>
                <li><strong>Entrega urgente:</strong> Notebook Dell do cliente João deve ser testado até às 17h.</li>
            </ul>
        </div>
    </div>

    <!-- TÍTULO E BOTAO NOVO CLIENTE -->
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
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM clientes";
                    $stmt = $conn->query($sql);
                    while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?= $cliente['id']; ?></td>
                        <td><?= $cliente['nome']; ?></td>
                        <td><?= $cliente['email']; ?></td>
                        <td><?= $cliente['telefone']; ?></td>
                        <td>
                            <a href="select_where.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-info text-white">Ver</a>
                            <a href="update.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-warning text-white">Editar</a>
                            <a href="delete.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-danger">Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include_once __DIR__ . '/../includes/footer.php';
 ?>  