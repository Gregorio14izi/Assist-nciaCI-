<?php
session_start();
include_once __DIR__ . '/includes/header.php';
?>

<main class="container my-5">
    <section class="text-center mb-5">
        <h1 class="fw-bold">Nossos Serviços e Tabela de Preços</h1>
        <p class="lead text-muted">Confira os principais serviços prestados por nossa equipe técnica especializada.</p>
    </section>

    <section class="row g-4 mb-5">
        <article class="col-md-6">
            <div class="card shadow-sm h-100">
                <img src="assets/img/reparo-celular.svg" alt="Serviço de reparo em smartphones e tablets" class="card-img-top" style="height: 220px; object-fit: cover;">
                <div class="card-body">
                    <h2 class="h5 card-title">Manutenção de Smartphones & Tablets</h2>
                    <p class="card-text">Troca de telas, baterias, conectores de carga, desoxidação e reparos avançados em placa mãe.</p>
                </div>
            </div>
        </article>

        <article class="col-md-6">
            <div class="card shadow-sm h-100">
                <img src="assets/img/reparo-notebook.svg" alt="Serviço de manutenção em notebooks e computadores" class="card-img-top" style="height: 220px; object-fit: cover;">
                <div class="card-body">
                    <h2 class="h5 card-title">Notebooks & Desktops</h2>
                    <p class="card-text">Formatação, instalação de SSD, limpeza técnica preventiva com troca de pasta térmica e upgrade de memória.</p>
                </div>
            </div>
        </article>
    </section>

    <section class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h2 class="h5 mb-0">📊 Tabela Transparente de Serviços</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Serviço</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th class="text-end">Preço Base</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">Formatação Completa</td>
                            <td><span class="badge bg-info text-dark">Software</span></td>
                            <td>Instalação de S.O., drivers e softwares básicos</td>
                            <td class="text-end fw-bold">R$ 120,00</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Limpeza Preventiva + Pasta Térmica</td>
                            <td><span class="badge bg-warning text-dark">Hardware</span></td>
                            <td>Desmontagem, eliminação de poeira e troca de pasta</td>
                            <td class="text-end fw-bold">R$ 150,00</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Troca de Bateria de Smartphone</td>
                            <td><span class="badge bg-primary">Celulares</span></td>
                            <td>Substituição por componente novo com garantia</td>
                            <td class="text-end fw-bold">R$ 180,00</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diagnóstico e Reparo de Placa</td>
                            <td><span class="badge bg-danger">Eletrônica</span></td>
                            <td>Análise microscópica e troca de microcomponentes</td>
                            <td class="text-end fw-bold">R$ 250,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>