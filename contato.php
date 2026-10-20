<?php
session_start();
include_once __DIR__ . '/includes/header.php';
?>

<main class="container my-5">
    <section class="row g-4">
        <article class="col-md-7">
            <div class="card shadow-sm p-4">
                <h1 class="h3 mb-3">Fale Conosco</h1>
                <p class="text-muted">Preencha o formulário abaixo para tirar dúvidas ou solicitar um orçamento prévio.</p>

                <form action="#" method="POST" onsubmit="alert('Mensagem enviada com sucesso!'); return false;">
                    <div class="mb-3">
                        <label for="nome_contato" class="form-label fw-bold">Nome Completo *</label>
                        <input type="text" id="nome_contato" name="nome" class="form-control" placeholder="Digite seu nome completo" required>
                    </div>

                    <div class="mb-3">
                        <label for="email_contato" class="form-label fw-bold">E-mail *</label>
                        <input type="email" id="email_contato" name="email" class="form-control" placeholder="exemplo@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefone_contato" class="form-label fw-bold">Telefone / WhatsApp</label>
                        <input type="tel" id="telefone_contato" name="telefone" class="form-control" placeholder="(11) 99999-9999">
                    </div>

                    <div class="mb-3">
                        <label for="mensagem_contato" class="form-label fw-bold">Mensagem *</label>
                        <textarea id="mensagem_contato" name="mensagem" class="form-control" rows="4" placeholder="Descreva sua dúvida ou o equipamento com problema..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold w-100">Enviar Mensagem</button>
                </form>
            </div>
        </article>

        <aside class="col-md-5">
            <div class="card shadow-sm p-4 mb-4 bg-light border-0">
                <h2 class="h4 mb-3">📍 Dados da Loja</h2>
                <ul class="list-unstyled">
                    <li class="mb-2"><strong>Endereço:</strong> Av. Principal, nº 1000 - Centro</li>
                    <li class="mb-2"><strong>Telefone:</strong> (11) 3333-4444</li>
                    <li class="mb-2"><strong>WhatsApp:</strong> (11) 98888-7777</li>
                    <li class="mb-2"><strong>E-mail:</strong> contato@techfix.com.br</li>
                </ul>
                <hr>
                <h3 class="h5 mb-2">⏰ Horário de Atendimento</h3>
                <p class="mb-1"><strong>Segunda a Sexta:</strong> 08:00 às 18:00</p>
                <p class="mb-0"><strong>Sábado:</strong> 08:00 às 12:00</p>
            </div>

            <div class="text-center">
                <img src="assets/img/atendimento.svg" alt="Atendimento ao cliente e recepção da loja TechFix" class="img-fluid rounded shadow-sm">
            </div>
        </aside>
    </section>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>