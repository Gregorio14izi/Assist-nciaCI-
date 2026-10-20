<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/includes/header.php';
?>

<main class="container my-5">
    <section class="text-center mb-5">
        <h1 class="fw-bold text-dark mb-3">Nossos Serviços & Tabela de Preços</h1>
        <p class="lead text-muted">Transparência do orçamento à entrega do seu equipamento na bancada da AssistênciaCi.</p>
    </section>

    <!-- Catálogo Visual de Serviços -->
    <section class="row g-4 mb-5">
        <article class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <img src="<?= $baseUrl; ?>assets/img/reparo-celular.svg" alt="Serviço de reparo em smartphones e tablets" class="card-img-top" style="height: 240px; object-fit: cover;">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold card-title">📱 Smartphones & Tablets</h2>
                    <p class="card-text text-muted">Substituição de ecrãs/telas partidas, troca de baterias viciadas, reparação de conetores de carga e recuperação de aparelhos com danos por água.</p>
                </div>
            </div>
        </article>

        <article class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <img src="<?= $baseUrl; ?>assets/img/reparo-notebook.svg" alt="Serviço de manutenção em notebooks e computadores" class="card-img-top" style="height: 240px; object-fit: cover;">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold card-title">💻 Notebooks & Computadores</h2>
                    <p class="card-text text-muted">Formatação com backup, limpeza interna com troca de pasta térmica, upgrades de SSD/RAM e reparação avançada de placas-mãe.</p>
                </div>
            </div>
        </article>
    </section>

    <!-- Tabela Transparente de Preços (LIMA) -->
    <section class="card shadow-sm border-0 p-4 mb-5">
        <h2 class="h3 fw-bold mb-4 text-dark">📋 Tabela Comparativa de Preços Estimados</h2>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Serviço / Manutenção</th>
                        <th scope="col">Prazo Médio</th>
                        <th scope="col">Garantia</th>
                        <th scope="col" class="text-end">Valor Estimado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Troca de Tela / Ecrã (Smartphone)</strong></td>
                        <td>1 a 2 dias úteis</td>
                        <td>90 dias</td>
                        <td class="text-end fw-bold text-success">A partir de R$ 150,00</td>
                    </tr>
                    <tr>
                        <td><strong>Troca de Bateria</strong></td>
                        <td>Mesmo dia</td>
                        <td>90 dias</td>
                        <td class="text-end fw-bold text-success">A partir de R$ 100,00</td>
                    </tr>
                    <tr>
                        <td><strong>Formatação e Instalação de Sistema</strong></td>
                        <td>1 dia útil</td>
                        <td>30 dias</td>
                        <td class="text-end fw-bold text-success">R$ 120,00</td>
                    </tr>
                    <tr>
                        <td><strong>Limpeza Preventiva + Pasta Térmica</strong></td>
                        <td>1 dia útil</td>
                        <td>60 dias</td>
                        <td class="text-end fw-bold text-success">R$ 140,00</td>
                    </tr>
                    <tr>
                        <td><strong>Upgrade de SSD / Memória RAM</strong></td>
                        <td>1 a 2 dias úteis</td>
                        <td>1 ano (peça)</td>
                        <td class="text-end fw-bold text-success">Sob consulta (peça + R$ 80 M.O.)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <small class="text-muted mt-2">* Os valores e prazos podem variar consoante o modelo do equipamento e a disponibilidade de componentes em estoque.</small>
    </section>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>