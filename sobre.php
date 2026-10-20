<?php
session_start();
include_once __DIR__ . '/includes/header.php';
?>

<main class="container my-5">
    <!-- Seção Principal com a História de Origem -->
    <section class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="fw-bold mb-3 text-primary">Sobre a AssistênciaCi</h1>
            <p class="lead text-dark fw-semibold">
                Uma história que começou entre risadas, amizade e paixão pela tecnologia.
            </p>
            <p>
                A <strong>AssistênciaCi</strong> nasceu de uma forma totalmente espontânea e especial: a partir de uma brincadeira descontraída entre amigos apaixonados por abrir, entender e consertar aparelhos eletrónicos. O que inicialmente era apenas um momento de lazer e boas conversas acabou por se transformar numa grande ideia.
            </p>
            <p>
                Para eternizar esse capítulo marcante e celebrar a união do nosso grupo, decidimos transformar essa brincadeira num marco oficial na história da empresa. Criar a AssistênciaCi foi a nossa maneira de registrar para sempre esse momento leve e divertido da nossa vida, transformando a cumplicidade de amigos numa assistência técnica séria e de alta qualidade.
            </p>
            <p>
                Hoje, trazemos para cada bancada e para cada atendimento esse mesmo espírito de parceria: um ambiente humano, transparente e focado em resolver problemas com o máximo de cuidado e dedicação.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/img/oficina.svg" alt="Ilustração da bancada de trabalho da assistência técnica AssistênciaCi" class="img-fluid rounded shadow-sm">
        </div>
    </section>

    <hr class="my-5">

    <!-- Seção de Missão, Visão e Valores -->
    <section class="row g-4 text-center">
        <article class="col-md-4">
            <div class="card h-100 p-3 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h2 class="h4 text-primary fw-bold">🎯 Missão</h2>
                    <p class="card-text">Oferecer soluções tecnológicas eficientes com a mesma dedicação e honestidade com que ajudamos os nossos melhores amigos.</p>
                </div>
            </div>
        </article>

        <article class="col-md-4">
            <div class="card h-100 p-3 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h2 class="h4 text-primary fw-bold">👁️ Visão</h2>
                    <p class="card-text">Ser reconhecida como uma assistência técnica de excelência que nunca perdeu a sua essência humana, leve e acolhedora.</p>
                </div>
            </div>
        </article>

        <article class="col-md-4">
            <div class="card h-100 p-3 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h2 class="h4 text-primary fw-bold">💎 Valores</h2>
                    <p class="card-text">Amizade, transparência total no orçamento, responsabilidade técnica, respeito ao cliente e paixão por Inovação.</p>
                </div>
            </div>
        </article>
    </section>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>