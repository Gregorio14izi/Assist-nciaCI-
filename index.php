<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login/login.php"); 
    exit();
}

include_once "includes/header.php"; 
?>

<div class="container my-4">
   
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Painel do Administrador</h2>
        <div>
            <span>Bem-vindo, <strong><?= $_SESSION['usuario_nome'] ?? 'Admin'; ?></strong></span>
            <a href="login/logout.php" class="btn btn-outline-danger btn-sm ms-3">Sair</a>
        </div>
    </div>


    <div class="card mb-4 border-warning">
        <div class="card-header bg-warning text-dark fw-bold">
            📌 Mural de Avisos da Assistência
        </div>
        <div class="card-body">
            <ul>
                <li><strong>Aviso:</strong> Multímetro de bancada #02 está em manutenção.</li>
                <li><strong>Lembrete:</strong> Verificar estoque de conectores de carga Tipo-C.</li>
                <li><strong>Entrega urgente:</strong> Notebook Dell do cliente João deve ser testado até às 17h.</li>
            </ul>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
       
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">👤 Clientes</h5>
                    <p class="card-text">Gerencie os cadastros dos seus clientes e históricos.</p>
                    <a href="app/select.php?tipo=clientes" class="btn btn-primary">Gerenciar Clientes</a> 
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🛠️ Serviços / O.S.</h5>
                    <p class="card-text">Acompanhe os eletrônicos em bancada e serviços a fazer.</p>
                    <a href="app/select.php?tipo=servicos" class="btn btn-success">Ver Ordens de Serviço</a> 
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🧰 Ferramentas</h5>
                    <p class="card-text">Controle o inventário de ferramentas de bancada.</p>
                    <a href="app/select.php?tipo=ferramentas" class="btn btn-dark">Ver Ferramentas</a> 
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            ⚡ Serviços Pendentes / Em Andamento
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th># OS</th>
                        <th>Cliente</th>
                        <th>Equipamento</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>Carlos Silva</td>
                        <td>Placa Mãe Asus (Sem Ligar)</td>
                        <td><span class="badge bg-warning text-dark">Em Análise</span></td>
                        <td>
                            <a href="app/select_where.php?id=101" class="btn btn-sm btn-info">Detalhes</a> 
                            <a href="app/update.php?id=101" class="btn btn-sm btn-secondary">Editar</a> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?> 