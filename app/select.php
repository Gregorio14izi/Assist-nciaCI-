<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteção de acesso: redireciona se o utilizador não estiver autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Conexão à base de dados
require_once __DIR__ . '/../database/connect.php';

// Compatibilidade de nome de variável da conexão
if (!isset($conn) && isset($pdo)) {
    $conn = $pdo;
} elseif (!isset($conn) && isset($conexao)) {
    $conn = $conexao;
}

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
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($conn) && $conn !== null) {
                        try {
                            $sql = "SELECT * FROM clientes";
                            $stmt = $conn->query($sql);
                            
                            if ($stmt && $stmt->rowCount() > 0) {
                                while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($cliente['id']); ?></td>
                                        <td><?= htmlspecialchars($cliente['nome']); ?></td>
                                        <td><?= htmlspecialchars($cliente['email']); ?></td>
                                        <td><?= htmlspecialchars($cliente['telefone']); ?></td>
                                        <td class="text-center">
                                            <a href="select_where.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-info text-white">Ver</a>
                                            <a href="update.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-warning text-white">Editar</a>
                                            <a href="delete.php?id=<?= $cliente['id']; ?>" class="btn btn-sm btn-danger">Excluir</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center p-3">Nenhum cliente cadastrado.</td></tr>';
                            }
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="5" class="text-center text-danger p-3">Erro ao carregar clientes: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center text-danger p-3">Erro: Variável de conexão ($conn) não foi encontrada em database/connect.php. Verifique o arquivo connect.php.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>